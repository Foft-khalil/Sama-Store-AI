<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\Product;
use App\Models\Order;

class OrderController extends Controller
{
    public function store(Request $request, $slug, $productId)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'delivery_address' => 'required|string|max:500',
            'payment_provider' => 'required|in:wave,orange_money'
        ]);

        $store = Store::where('slug', $slug)->orWhere('whatsapp_number', $slug)->firstOrFail();
        $product = Product::where('store_id', $store->id)->findOrFail($productId);

        $phone = preg_replace('/[^0-9]/', '', $request->customer_phone);

        $order = Order::create([
            'store_id' => $store->id,
            'product_id' => $product->id,
            'customer_name' => $request->customer_name,
            'customer_phone' => $phone,
            'delivery_address' => $request->delivery_address,
            'status' => 'pending',
            'payment_provider' => $request->payment_provider,
            'total_amount' => $product->price ?? 0,
        ]);

        // Système de notification : Alerte automatique au vendeur via l'API WhatsApp
        $this->notifySeller($store, $order, $product);

        // Simuler la redirection vers l'API de paiement
        $message = "🛍️ *NOUVELLE COMMANDE*\n";
        $message .= "Produit: {$product->name}\n";
        $message .= "Prix: {$product->price} FCFA\n";
        $message .= "Client: {$order->customer_name}\n";
        $message .= "Tél: {$order->customer_phone}\n";
        $message .= "Livraison: {$order->delivery_address}\n";
        $message .= "Paiement: " . strtoupper($order->payment_provider) . " (À vérifier)";
        
        $whatsappUrl = "https://wa.me/{$store->whatsapp_number}?text=" . urlencode($message);
        
        return redirect()->away($whatsappUrl);
    }

    protected function notifySeller($store, $order, $product)
    {
        try {
            $token = env('WHATSAPP_TOKEN');
            $phoneNumberId = env('WHATSAPP_PHONE_NUMBER_ID'); // ID de l'expéditeur du Bot
            
            if (!$token || !$phoneNumberId) return;

            $message = "🔔 *Sama-Store AI : Nouvelle Commande !*\n\n";
            $message .= "🛒 *{$product->name}*\n";
            $message .= "💰 Prix : {$product->price} FCFA\n";
            $message .= "👤 Client : {$order->customer_name}\n";
            $message .= "📞 Tél : {$order->customer_phone}\n";
            $message .= "📍 Livraison : {$order->delivery_address}\n";
            $message .= "💳 Paiement : " . strtoupper($order->payment_provider) . "\n\n";
            $message .= "👉 Veuillez contacter le client pour finaliser la livraison.";

            \Illuminate\Support\Facades\Http::withToken($token)
                ->post("https://graph.facebook.com/v19.0/{$phoneNumberId}/messages", [
                    'messaging_product' => 'whatsapp',
                    'to' => $store->whatsapp_number,
                    'type' => 'text',
                    'text' => ['body' => $message],
                ]);

            \Illuminate\Support\Facades\Log::info("Notification envoyée au vendeur " . $store->whatsapp_number);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Erreur de notification WhatsApp: " . $e->getMessage());
        }
    }
}
