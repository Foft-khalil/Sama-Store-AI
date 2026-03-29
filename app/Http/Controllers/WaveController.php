<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class WaveController extends Controller
{
    /**
     * Initie une session de paiement Wave Checkout
     */
    public function initiatePayment(Request $request)
    {
        $storeId = Session::get('store_id');
        if (!$storeId) return redirect()->route('login');

        $store = Store::findOrFail($storeId);
        
        // Configuration de l'abonnement Premium (Ex: 5000 FCFA)
        $amount = 5000; 
        $currency = 'XOF';
        
        /** @var \Illuminate\Http\Client\Response $response */
        $response = Http::withToken(config('services.wave.api_key'))
            ->post('https://api.wave.com/v1/checkout/sessions', [
                'amount' => $amount,
                'currency' => $currency,
                'error_url' => route('dashboard.pricing'),
                'success_url' => route('dashboard'),
                'client_reference' => 'store_' . $store->id, // Pour identifier la boutique plus tard
            ]);

        if ($response->successful()) {
            $waveLaunchUrl = $response->json()['wave_launch_url'];
            return redirect($waveLaunchUrl);
        }

        Log::error('Wave Payment Initiation Failed', ['response' => $response->body()]);
        return back()->with('error', 'Impossible d\'initier le paiement Wave. Veuillez réessayer.');
    }

    /**
     * Gère les notifications (webhooks) envoyées par Wave
     */
    public function handleWebhook(Request $request)
    {
        // On authentifie la requête si Wave propose une signature (Optionnel mais recommandé)
        // Ici on simplifie pour le tutoriel
        
        $payload = $request->all();
        
        if ($payload['type'] === 'checkout.session.completed') {
            $session = $payload['data'];
            $clientRef = $session['client_reference']; // ex: "store_1"
            
            $storeId = str_replace('store_', '', $clientRef);
            $store = Store::find($storeId);
            
            if ($store) {
                // Activation de l'abonnement pour 30 jours
                $store->update([
                    'is_subscribed' => true,
                    'trial_ends_at' => now()->addDays(30)
                ]);
                
                Log::info("Abonnement activé pour la boutique ID: $storeId via Wave.");
            }
        }

        return response()->json(['status' => 'success']);
    }
}
