<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function showLogin()
    {
        if (Session::has('store_id')) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    public function showRegister()
    {
        if (Session::has('store_id')) {
            return redirect()->route('dashboard');
        }
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'whatsapp_number' => 'required|string',
            'password'        => 'required|string|min:6|confirmed',
        ], [
            'password.confirmed' => 'Les mots de passe ne correspondent pas.',
            'password.min'       => 'Le mot de passe doit contenir au moins 6 caractères.',
        ]);

        $number = preg_replace('/[^0-9]/', '', $request->whatsapp_number);

        // Check if number already registered WITH a password (already claimed)
        $existing = Store::where('whatsapp_number', $number)->whereNotNull('password')->first();
        if ($existing) {
            return back()->with('error', 'Ce numéro est déjà enregistré. Connectez-vous avec votre mot de passe.');
        }

        // If store was auto-created by WhatsApp bot (no password yet), claim it
        $store = Store::where('whatsapp_number', $number)->whereNull('password')->first();

        if ($store) {
            // Claim the existing store
            $store->update(['password' => Hash::make($request->password)]);
        } else {
            // Brand new store
            $store = Store::create([
                'whatsapp_number' => $number,
                'name'            => 'Ma Boutique ' . substr($number, -4),
                'slug'            => 'store-' . $number,
                'password'        => Hash::make($request->password),
                'trial_ends_at'   => now()->addDays(7),
                'is_subscribed'   => false,
            ]);
        }

        Session::put('store_id', $store->id);
        return redirect()->route('dashboard')->with('success', 'Bienvenue ! Votre boutique sécurisée est prête.');
    }

    public function login(Request $request)
    {
        $request->validate([
            'whatsapp_number' => 'required|string',
            'password'        => 'required|string',
        ]);

        $number = preg_replace('/[^0-9]/', '', $request->whatsapp_number);

        $store = Store::where('whatsapp_number', $number)->whereNotNull('password')->first();

        if (!$store) {
            return back()->with('error', 'Aucun compte trouvé pour ce numéro. Veuillez vous inscrire d\'abord.');
        }

        if (!Hash::check($request->password, $store->password)) {
            return back()->with('error', 'Mot de passe incorrect. Réessayez.');
        }

        Session::put('store_id', $store->id);
        return redirect()->route('dashboard');
    }

    public function logout()
    {
        Session::forget('store_id');
        return redirect()->route('login');
    }

    public function index()
    {
        $storeId = Session::get('store_id');
        if (!$storeId) return redirect()->route('login');

        $store = Store::with(['products', 'orders' => function($q) {
            $q->orderBy('created_at', 'desc');
        }])->findOrFail($storeId);

        return view('dashboard.index', compact('store'));
    }

    public function updateOrderStatus(Request $request, $id)
    {
        $storeId = Session::get('store_id');
        if (!$storeId) return redirect()->route('login');

        $order = Order::where('store_id', $storeId)->findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:pending,paid,shipped,delivered,cancelled'
        ]);

        $order->update(['status' => $request->status]);

        // TODO: Notification automatique au client WhatsApp de son nouveau statut

        return back()->with('success', 'Statut de la commande mis à jour !');
    }

    public function pricing()
    {
        $storeId = Session::get('store_id');
        if (!$storeId) return redirect()->route('login');

        $store = Store::findOrFail($storeId);
        return view('dashboard.pricing', compact('store'));
    }

    public function upgrade(Request $request)
    {
        $storeId = Session::get('store_id');
        if (!$storeId) return redirect()->route('login');

        $store = Store::findOrFail($storeId);
        
        // Simulation de paiement réussi
        // Dans un vrai projet, on redirigerait vers Wave/Paystack ici
        $store->update([
            'is_subscribed' => true,
            'trial_ends_at' => now()->addDays(30) // Ajoute 30 jours d'abonnement
        ]);

        return redirect()->route('dashboard')->with('success', 'Félicitations ! Votre abonnement Premium est activé pour 30 jours.');
    }

    /* --- GESTION DES PRODUITS (WEB CMS) --- */

    public function editProduct($id)
    {
        $storeId = Session::get('store_id');
        $product = Product::where('store_id', $storeId)->findOrFail($id);
        
        return view('dashboard.products.edit', compact('product'));
    }

    public function updateProduct(Request $request, $id)
    {
        $storeId = Session::get('store_id');
        $product = Product::where('store_id', $storeId)->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'category' => 'nullable|string',
            'is_active' => 'nullable|boolean'
        ]);

        $product->update($request->only(['name', 'price', 'description', 'category', 'is_active']));

        return redirect()->route('dashboard')->with('success', 'Produit mis à jour avec succès !');
    }

    public function deleteProduct($id)
    {
        $storeId = Session::get('store_id');
        $product = Product::where('store_id', $storeId)->findOrFail($id);
        
        $product->delete();

        return redirect()->route('dashboard')->with('success', 'Produit supprimé du catalogue.');
    }

    /* --- PARAMÈTRES DE LA BOUTIQUE --- */

    public function settings()
    {
        $storeId = Session::get('store_id');
        $store = Store::findOrFail($storeId);
        return view('dashboard.settings', compact('store'));
    }

    public function updateSettings(Request $request)
    {
        $storeId = Session::get('store_id');
        $store = Store::findOrFail($storeId);

        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|alpha_dash|unique:stores,slug,' . $store->id
        ]);

        $store->update($request->only(['name', 'slug']));

        return back()->with('success', 'Paramètres de la boutique mis à jour !');
    }

    /* --- ANALYTICS VISUELS --- */

    public function stats()
    {
        $storeId = Session::get('store_id');
        $store = Store::with('orders')->findOrFail($storeId);

        // Données CA sur les 7 derniers jours
        $salesData = [];
        $labels = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $labels[] = now()->subDays($i)->format('d M');
            $salesData[] = $store->orders()
                ->whereDate('created_at', $date)
                ->whereIn('status', ['paid', 'delivered'])
                ->sum('total_amount');
        }

        // Répartition par mode de paiement
        $paymentMethods = [
            'Wave' => $store->orders()->where('payment_provider', 'Wave')->count(),
            'OM' => $store->orders()->where('payment_provider', 'Orange Money')->count(),
        ];

        // Top Produits
        $topProducts = Order::where('store_id', $storeId)
            ->select('product_id', \Illuminate\Support\Facades\DB::raw('count(*) as total'))
            ->groupBy('product_id')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->with('product')
            ->get();

        return view('dashboard.stats', compact('store', 'salesData', 'labels', 'paymentMethods', 'topProducts'));
    }

    public function storeProduct(Request $request)
    {
        $storeId = Session::get('store_id');
        if (!$storeId) return redirect()->route('login');

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:5120'
        ]);

        $imageUrl = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $imageUrl = asset('storage/' . $path);
        }

        Product::create([
            'store_id' => $storeId,
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'image_url' => $imageUrl
        ]);

        return back()->with('success', 'Produit ajouté avec succès !');
    }
}
