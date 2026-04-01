<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLogin()
    {
        // If already logged in, redirect to dashboard
        if (Session::has('is_super_admin') && Session::get('is_super_admin') === true) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    /**
     * Handle the login request securely.
     */
    public function login(Request $request)
    {
        $request->validate([
            'password' => 'required',
        ]);

        $adminPassword = env('ADMIN_PASSWORD', 'samastoresupersecret');

        if ($request->password === $adminPassword) {
            Session::put('is_super_admin', true);
            return redirect()->route('admin.dashboard')->with('success', 'Bienvenue, Administrateur.');
        }

        return back()->with('error', 'Mot de passe incorrect.');
    }

    /**
     * Handle logout.
     */
    public function logout()
    {
        Session::forget('is_super_admin');
        return redirect()->route('admin.login')->with('success', 'Déconnexion réussie.');
    }

    /**
     * Show the central dashboard with all stores.
     */
    public function dashboard()
    {
        $this->checkAuth();

        // Fetch stores with their product and order counts
        $stores = Store::withCount(['products', 'orders'])->orderBy('created_at', 'desc')->get();

        $metrics = [
            'total_stores' => $stores->count(),
            'total_products' => $stores->sum('products_count'),
            'total_orders' => $stores->sum('orders_count'),
        ];

        return view('admin.dashboard', compact('stores', 'metrics'));
    }

    /**
     * Delete a store and all its relationships securely.
     */
    public function deleteStore($id)
    {
        $this->checkAuth();

        $store = Store::findOrFail($id);
        
        // Cascade deletion natively or manually
        $store->products()->delete();
        $store->orders()->delete();
        $store->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Boutique (et ses produits/commandes) supprimée avec succès !');
    }

    /**
     * Helper to enforce auth since we are avoiding complex middleware setups for speed.
     */
    private function checkAuth()
    {
        if (!Session::has('is_super_admin') || Session::get('is_super_admin') !== true) {
            abort(403, 'Accès Refusé. Vous devez être administrateur.');
        }
    }
}
