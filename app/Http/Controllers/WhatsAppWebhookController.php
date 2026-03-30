<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use OpenAI\Laravel\Facades\OpenAI;

class WhatsAppWebhookController extends Controller
{
    /**
     * Handle the GET request for WhatsApp Webhook Verification
     */
    public function verifyWebhook(Request $request)
    {
        // WhatsApp standard verification parameters
        $mode = $request->query('hub_mode');
        $token = $request->query('hub_verify_token');
        $challenge = $request->query('hub_challenge');

        $verifyToken = env('WHATSAPP_VERIFY_TOKEN', 'sama_store_secret_token');
        
        Log::info("WhatsApp Webhook Verification Request", [
            'mode' => $mode,
            'token' => $token,
            'challenge' => $challenge,
        ]);

        if ($mode && $token) {
            if ($mode === 'subscribe' && $token === $verifyToken) {
                return response($challenge, 200);
            }
            return response()->json(['error' => 'Verification failed'], 403);
        }

        return response()->json(['error' => 'Invalid request'], 400);
    }

    /**
     * Handle the POST request containing messages/events
     */
    public function handleWebhook(Request $request)
    {
        try {
            $payload = $request->all();
            Log::info('WhatsApp Webhook Payload Received: ', $payload);
            
            // Basic structure checking
            if (isset($payload['object']) && $payload['object'] === 'whatsapp_business_account') {
                foreach ($payload['entry'] as $entry) {
                    foreach ($entry['changes'] as $change) {
                        if ($change['value'] && isset($change['value']['messages'])) {
                            foreach ($change['value']['messages'] as $message) {
                                $this->processMessage($message);
                            }
                        }
                    }
                }
            }
            
            return response('EVENT_RECEIVED', 200); // Always return 200 OK
        } catch (\Exception $e) {
            Log::error('WhatsApp Webhook Error: ' . $e->getMessage());
            return response('EVENT_RECEIVED', 200);
        }
    }

    /**
     * Process an individual message (e.g. image or text)
     */
    protected function processMessage($message)
    {
        $messageType = $message['type'] ?? 'unknown';
        $from = $message['from'] ?? 'unknown';
        
        Log::info("Processing message from {$from} of type {$messageType}");

        if ($messageType === 'image') {
            $imageId = $message['image']['id'] ?? null;
            Log::info("Image received with ID: {$imageId} from {$from}");
            
            if ($imageId) {
                // Analyse de l'image via OpenAI
                $this->analyzeProductImage($imageId, $from);
            }
        } elseif ($messageType === 'text') {
            $text = trim(strtolower($message['text']['body'] ?? ''));
            Log::info("Text message from {$from}: {$text}");
            
            $store = \App\Models\Store::where('whatsapp_number', $from)->first();
            $token = env('WHATSAPP_TOKEN');
            $phoneNumberId = env('WHATSAPP_PHONE_NUMBER_ID');

            if ($store && $token && $phoneNumberId) {
                if ($text === 'catalogue' || $text === 'lien' || $text === 'boutique') {
                    $storeUrl = url("/s/" . ($store->slug ?? $store->whatsapp_number));
                    $this->sendWhatsAppMessage($from, "🛒 *Votre Boutique est prête !*\n\n👉 Voici le lien exclusif de votre catalogue : {$storeUrl}\n\n*Partagez ce lien à vos clients sur Instagram, WhatsApp, ou Facebook pour recevoir des commandes directes !*", $token, $phoneNumberId);
                } 
                elseif ($text === 'commandes' || $text === 'dashboard') {
                    $dashboardUrl = route('login');
                    $this->sendWhatsAppMessage($from, "📊 *Sama-Store Backoffice*\n\nPour gérer vos commandes et vérifier vos statistiques, accédez à votre espace sécurisé ici :\n👉 {$dashboardUrl}\n\n(_Identifiant : {$from}_)", $token, $phoneNumberId);
                }
                else {
                    $this->sendWhatsAppMessage($from, "👋 Bonjour ! Je suis l'IA de Sama-Store.\n\n📸 *Pour ajouter un produit :* Envoyez-moi simplement une photo de votre article.\n\n⚙️ *Commandes Menu :*\n- Écrivez *Catalogue* : Pour obtenir le lien de votre boutique\n- Écrivez *Commandes* : Pour accéder à votre tableau de bord", $token, $phoneNumberId);
                }
            } else {
                // If it's a new user texting without creating a store via image first
                if ($token && $phoneNumberId) {
                    $this->sendWhatsAppMessage($from, "👋 Bienvenue sur Sama-Store AI, votre créateur de e-boutique !\n\n📸 Pour commencer, envoyez-moi une photo d'un produit que vous vendez. Mon intelligence artificielle va l'analyser et créer votre site e-commerce instantanément ! 🚀", $token, $phoneNumberId);
                }
            }
        }
    }

    /**
     * Fetch the image from WhatsApp, convert to base64, and send to OpenAI
     */
    protected function analyzeProductImage($imageId, $from)
    {
        try {
            // 1. Get Image URL from WhatsApp Media API
            $token = env('WHATSAPP_TOKEN', 'your_whatsapp_bearer_token'); 
            $mediaEndpoint = "https://graph.facebook.com/v19.0/{$imageId}";

            /** @var \Illuminate\Http\Client\Response $response */
            $response = \Illuminate\Support\Facades\Http::withToken($token)->get($mediaEndpoint);

            if (!$response->successful()) {
                Log::error("Failed to get media URL from WhatsApp: " . $response->body());
                return;
            }

            $mediaUrl = $response->json('url');

            // 2. Download Image File Content
            /** @var \Illuminate\Http\Client\Response $imageResponse */
            $imageResponse = \Illuminate\Support\Facades\Http::withToken($token)->get($mediaUrl);
            if (!$imageResponse->successful()) {
                Log::error("Failed to download image from WhatsApp.");
                return;
            }

            $imageBytes = $imageResponse->body();
            $base64Image = base64_encode($imageBytes);

            // 3. Send to OpenAI Vision to Extract Product Details
            $this->extractProductDetailsWithOpenAI($base64Image, $from);

        } catch (\Exception $e) {
            Log::error("Error analyzing product image: " . $e->getMessage());
        }
    }

    /**
     * Calls GPT-4o Vision to extract structured JSON data from product image
     */
    protected function extractProductDetailsWithOpenAI($base64Image, $from)
    {
        Log::info("Sending Base64 Image to OpenAI for user {$from}...");
        try {
            $response = \OpenAI\Laravel\Facades\OpenAI::chat()->create([
                'model' => 'gpt-4o',
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => [
                            [
                                'type' => 'text',
                                'text' => "Tu es un expert en e-commerce. Analyse cette image de produit photographiée par un vendeur informel. Extrait le nom du produit, une catégorie approximative, génère une description très vendeuse en français, et extrait le prix s'il est visible sur l'image (sinon met null). Retourne UNIQUEMENT une structure JSON stricte : {\"name\": \"...\", \"category\": \"...\", \"description\": \"...\", \"price\": null}"
                            ],
                            [
                                'type' => 'image_url',
                                'image_url' => [
                                    'url' => "data:image/jpeg;base64,{$base64Image}",
                                ]
                            ]
                        ]
                    ]
                ],
                // Increase token limit for comprehensive descriptions
                'max_tokens' => 800,
            ]);

            $jsonString = $response->choices[0]->message->content;
            
            // Clean potential markdown tags from response
            $jsonString = str_replace(['```json', '```'], '', $jsonString);
            
            $productData = json_decode(trim($jsonString), true);
            
            Log::info("AI Product Analysis Result for {$from}: ", $productData ?? []);

            if (is_array($productData)) {
                $store = \App\Models\Store::firstOrCreate(
                    ['whatsapp_number' => $from],
                    [
                        'name' => "Boutique de {$from}",
                        'trial_ends_at' => now()->addDays(7)
                    ]
                );

                $product = $store->products()->create([
                    'name' => $productData['name'] ?? 'Produit',
                    'category' => $productData['category'] ?? null,
                    'description' => $productData['description'] ?? null,
                    'price' => isset($productData['price']) && is_numeric($productData['price']) ? (int) $productData['price'] : null,
                ]);

                Log::info("Produit sauvegardé : Boutique {$store->id} - Produit ID: {$product->id}");
            }

        } catch (\Exception $e) {
            Log::error("OpenAI Error: " . $e->getMessage());
        }
    }

    /**
     * Helper to send outbound WhatsApp text messages
     */
    protected function sendWhatsAppMessage($to, $text, $token, $phoneNumberId)
    {
        try {
            $response = \Illuminate\Support\Facades\Http::withToken($token)
                ->post("https://graph.facebook.com/v19.0/{$phoneNumberId}/messages", [
                    'messaging_product' => 'whatsapp',
                    'to' => $to,
                    'type' => 'text',
                    'text' => ['body' => $text],
                ]);
            
            if ($response->successful()) {
                Log::info("WhatsApp message sent successfully to {$to}");
            } else {
                Log::error("Failed to send WhatsApp message to {$to}. Meta Response: " . $response->body());
            }
        } catch (\Exception $e) {
            Log::error("Failed to send WhatsApp message: " . $e->getMessage());
        }
    }
}
