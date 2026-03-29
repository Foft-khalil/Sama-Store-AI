<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Store;
use Illuminate\Support\Facades\Session;

class CheckSubscription
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Check if we are on a Store Front route /s/{slug}
        $slug = $request->route('slug');
        if ($slug) {
            $store = Store::where('slug', $slug)->orWhere('whatsapp_number', $slug)->first();
            
            if ($store && !$store->is_subscribed && $store->trial_ends_at < now()) {
                return response()->view('store.expired', ['store' => $store], 403);
            }
        }

        // 2. Check if we are in the Dashboard
        if ($request->is('dashboard*')) {
            $storeId = Session::get('store_id');
            if ($storeId) {
                $store = Store::find($storeId);
                // If expired but trying to access something other than pricing/billing
                if ($store && !$store->is_subscribed && $store->trial_ends_at < now() && !$request->is('dashboard/pricing*')) {
                    return redirect()->route('dashboard.pricing')->with('warning', 'Votre période d\'essai a expiré. Veuillez choisir un forfait pour continuer.');
                }
            }
        }

        return $next($request);
    }
}
