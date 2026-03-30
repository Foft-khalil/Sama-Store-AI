<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\WhatsAppWebhookController;
use App\Http\Controllers\WaveController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// WhatsApp Webhook Routes
Route::get('/whatsapp/webhook', [WhatsAppWebhookController::class, 'verifyWebhook']);
Route::post('/whatsapp/webhook', [WhatsAppWebhookController::class, 'handleWebhook']);

// Wave Webhook Routes
Route::post('/wave/webhook', [WaveController::class, 'handleWebhook']);
