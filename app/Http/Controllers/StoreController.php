<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;

class StoreController extends Controller
{
    public function show($slug)
    {
        $store = Store::where('slug', $slug)
            ->orWhere('whatsapp_number', $slug)
            ->with(['products' => function($query) {
                $query->where('is_active', true)->latest();
            }])->firstOrFail();

        return view('store.show', [
            'store' => $store,
            'products' => $store->products
        ]);
    }
}
