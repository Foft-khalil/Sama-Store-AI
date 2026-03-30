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
    protected function processMessage(array $message): void
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
            $textBody = trim(strtolower($message['text']['body'] ?? ''));
            Log::info("Text message from {$from}: {$textBody}");
            
            $store = \App\Models\Store::where('whatsapp_number', $from)->first();
            $token = env('WHATSAPP_TOKEN');
            $phoneNumberId = env('WHATSAPP_PHONE_NUMBER_ID');

            if ($store && $token && $phoneNumberId) {
                if ($textBody === 'catalogue' || $textBody === 'lien' || $textBody === 'boutique') {
                    $storeUrl = url("/s/" . ($store->slug ?? $store->whatsapp_number));
                    $this->sendWhatsAppMessage($from, "🛒 *Votre Boutique est prête !*\n\n👉 Voici le lien exclusif de votre catalogue : {$storeUrl}\n\n*Partagez ce lien à vos clients sur Instagram, WhatsApp, ou Facebook pour recevoir des commandes directes !*", $token, $phoneNumberId);
                } 
                elseif ($textBody === 'commandes' || $textBody === 'dashboard') {
                    $dashboardUrl = route('login');
                    $this->sendWhatsAppMessage($from, "📊 *Sama-Store Backoffice*\n\nPour gérer vos commandes et vérifier vos statistiques, accédez à votre espace sécurisé ici :\n👉 {$dashboardUrl}\n\n(_Identifiant : {$from}_)", $token, $phoneNumberId);
                }
                elseif ($textBody === 'salut' || $textBody === 'bonjour') {
                    $this->sendWelcomeMessage($from, $token, $phoneNumberId);
                }
                else {
                    $this->sendWhatsAppMessage($from, "👋 Bonjour ! Je suis l'IA de Sama-Store.\n\n📸 *Pour ajouter un produit :* Envoyez-moi simplement une photo de votre article.\n\n⚙️ *Commandes Menu :*\n- Écrivez *Catalogue* : Pour obtenir le lien de votre boutique\n- Écrivez *Commandes* : Pour accéder à votre tableau de bord", $token, $phoneNumberId);
                }
            } else {
                // If it's a new user texting without creating a store via image first
                if ($token && $phoneNumberId) {
                    if ($textBody === 'salut' || $textBody === 'bonjour') {
                        $this->sendWelcomeMessage($from, $token, $phoneNumberId);
                    } else {
                        $this->sendWhatsAppMessage($from, "👋 Bienvenue sur Sama-Store AI, votre créateur de e-boutique !\n\n📸 Pour commencer, envoyez-moi une photo d'un produit que vous vendez. Mon intelligence artificielle va l'analyser et créer votre site e-commerce instantanément ! 🚀", $token, $phoneNumberId);
                    }
                }
            }
        }
    }

    /**
     * Fetch the image from WhatsApp, convert to base64, and send to OpenAI
     */
    protected function analyzeProductImage(string $imageId, string $from): void
    {
        Log::info("Step 1: Starting image analysis for ID: {$imageId}");
        try {
            $token = env('WHATSAPP_TOKEN'); 
            $mediaEndpoint = "https://graph.facebook.com/v19.0/{$imageId}";

            Log::info("Step 2: Fetching media URL from Meta API...");
            $response = \Illuminate\Support\Facades\Http::withToken($token)->get($mediaEndpoint);

            if (!$response->successful()) {
                Log::error("Step 2 ERROR: Meta API rejected media ID. Status: " . $response->status() . " Response: " . $response->body());
                return;
            }

            $mediaUrl = $response->json('url');
            Log::info("Step 3: Media URL found: {$mediaUrl}. Downloading...");

            $imageResponse = \Illuminate\Support\Facades\Http::withToken($token)->get($mediaUrl);
            if (!$imageResponse->successful()) {
                Log::error("Step 3 ERROR: Failed to download binary from Meta URL.");
                return;
            }

            $imageBytes = $imageResponse->body();
            $base64Image = base64_encode($imageBytes);
            Log::info("Step 4: Image converted to Base64 (Size: " . strlen($base64Image) . " chars)");

            $this->extractProductDetailsWithOpenAI($base64Image, $from);

        } catch (\Exception $e) {
            Log::error("analyzeProductImage CRITICAL ERROR: " . $e->getMessage());
        }
    }

    /**
     * Calls Groq API (Llama 3.2 90B Vision) to extract structured JSON data from product image
     * This provides a 100% free, blazingly fast alternative that works everywhere.
     */
    protected function extractProductDetailsWithOpenAI(string $base64Image, string $from): void
    {
        Log::info("Step 5: Sending request to Groq API (Llama 3.2 Vision)...");
        try {
            $apiKey = env('GROQ_API_KEY');
            if (!$apiKey) {
                throw new \Exception("Clé GROQ_API_KEY absente du fichier .env");
            }

            // Target Groq's OpenAI-compatible endpoint
            $url = "https://api.groq.com/openai/v1/chat/completions";

            $response = \Illuminate\Support\Facades\Http::withToken($apiKey)->post($url, [
                "model" => "meta-llama/llama-4-scout-17b-16e-instruct",
                "messages" => [
                    [
                        "role" => "user",
                        "content" => [
                            [
                                "type" => "text",
                                "text" => "Tu es un expert en e-commerce. Analyse cette image de produit. Extrait le nom du produit, une catégorie, une description courte et vendeuse en français, et le prix (nombre entier uniquement). Retourne UNIQUEMENT du JSON valide : {\"name\": \"...\", \"category\": \"...\", \"description\": \"...\", \"price\": 5000}"
                            ],
                            [
                                "type" => "image_url",
                                "image_url" => [
                                    "url" => "data:image/jpeg;base64,{$base64Image}"
                                ]
                            ]
                        ]
                    ]
                ],
                "response_format" => ["type" => "json_object"],
                "max_tokens" => 800,
                "temperature" => 0.5
            ]);

            if (!$response->successful()) {
                throw new \Exception("Groq API Error: " . $response->body());
            }

            $result = $response->json();
            $jsonString = $result['choices'][0]['message']['content'] ?? '{}';
            Log::info("Step 6: Groq Response received: " . $jsonString);
            
            $productData = json_decode(trim($jsonString), true);
            
            if (is_array($productData)) {
                $store = \App\Models\Store::firstOrCreate(
                    ['whatsapp_number' => $from],
                    ['name' => "Boutique de {$from}", 'trial_ends_at' => now()->addDays(7)]
                );

                $product = $store->products()->create([
                    'name' => $productData['name'] ?? 'Produit',
                    'category' => $productData['category'] ?? null,
                    'description' => $productData['description'] ?? null,
                    'price' => isset($productData['price']) && is_numeric($productData['price']) ? (int) $productData['price'] : null,
                ]);

                Log::info("Step 7: SUCCESS! Product saved ID: {$product->id}");

                $token = env('WHATSAPP_TOKEN');
                $phoneNumberId = env('WHATSAPP_PHONE_NUMBER_ID');
                $storeUrl = url("/s/" . ($store->slug ?? $store->whatsapp_number));

                if ($token && $phoneNumberId) {
                    $confirmMsg = "✅ *Produit Ajouté avec Succès !*\n\n";
                    $confirmMsg .= "📦 *Nom :* " . ($product->name ?? 'Produit') . "\n";
                    if ($product->price) $confirmMsg .= "💰 *Prix :* {$product->price} FCFA\n";
                    $confirmMsg .= "\n✨ *Votre boutique est en ligne !* :\n👉 {$storeUrl}\n\n📸 _Envoyez une autre photo !_";
                    
                    $this->sendWhatsAppMessage($from, $confirmMsg, $token, $phoneNumberId);
                }
            }

        } catch (\Exception $e) {
            Log::error("Step 5/6 ERROR: Groq API failed: " . $e->getMessage());
            $token = env('WHATSAPP_TOKEN');
            $phoneNumberId = env('WHATSAPP_PHONE_NUMBER_ID');
            if ($token && $phoneNumberId) {
                $errorMsg = "⚠️ *Erreur d'Analyse (DEBUG)*\n\nErreur exacte : " . $e->getMessage() . "\n\n(Envoie ça à ton développeur)";
                $this->sendWhatsAppMessage($from, $errorMsg, $token, $phoneNumberId);
            }
        }
    }

    /**
     * Wrapper to send text messages via WhatsApp Graph API
     */
    protected function sendWhatsAppMessage(string $to, string $text, string $token, string $phoneNumberId): void
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
            Log::error("WhatsApp API Request Failed: " . $e->getMessage());
        }
    }

    /**
     * Send the standard welcome message.
     */
    protected function sendWelcomeMessage(string $to, string $token, string $phoneNumberId): void
    {
        $this->sendWhatsAppMessage($to, "👋 Bienvenue sur Sama-Store AI, votre créateur de e-boutique !\n\n📸 Pour commencer, envoyez-moi une photo d'un produit que vous vendez. Mon intelligence artificielle va l'analyser et créer votre site e-commerce instantanément ! 🚀", $token, $phoneNumberId);
    }
}
