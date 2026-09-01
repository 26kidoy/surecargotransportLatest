<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    private $freeModels = [
        'openai/gpt-4o-mini',
        'meta-llama/llama-3.1-8b-instruct',
        'mistralai/mistral-nemo',
        'google/gemma-3-12b-it',
        'qwen/qwen-2.5-7b-instruct',
    ];

    public function index()
    {
        return view('chatbot');
    }

    public function chat(Request $request)
    {
        try {
            $userMessage = $request->input('message');
            
            if (empty($userMessage)) {
                return response()->json(['error' => 'Message is required'], 400);
            }

            // READ FROM ENV - SECURE! NOT HARDCODED!
            $apiKey = env('OPENROUTER_API_KEY');
            
            if (empty($apiKey)) {
                Log::warning('OpenRouter API key not configured, using fallback');
                return response()->json([
                    'reply' => $this->getLocalFallback($userMessage)
                ]);
            }

            $systemPrompt = "You are SureCargo AI, an expert assistant for the SureCargo egg tray transport system. " .
                "SureCargo Transport is an egg cargo service from Bantayan Island to Bacolod City. " .
                "Location: Mohon, Santa Fe, Cebu. Maintenance location: Sungko, Bantayan, Cebu. " .
                "Owner: Atty. Ray Lambert Menchavez. Developer: Rogelio Tradio Jr. " .
                "Booking days: Saturday-Sunday 9:00 AM onwards. " .
                "Respond in the same language as the user (English, Tagalog, Bisaya). " .
                "Keep answers concise, friendly, and under 200 words.";

            $lastError = null;

            foreach ($this->freeModels as $model) {
                try {
                    $response = Http::timeout(30)
                        ->withOptions(['verify' => false])
                        ->withHeaders([
                            'Authorization' => 'Bearer ' . $apiKey,
                            'Content-Type' => 'application/json',
                            'HTTP-Referer' => env('APP_URL', 'https://surecargotransport.com'),
                            'X-Title' => 'SureCargo AI Chatbot',
                        ])
                        ->post('https://openrouter.ai/api/v1/chat/completions', [
                            'model' => $model,
                            'messages' => [
                                ['role' => 'system', 'content' => $systemPrompt],
                                ['role' => 'user', 'content' => $userMessage]
                            ],
                            'temperature' => 0.7,
                            'max_tokens' => 500,
                        ]);

                    if ($response->successful()) {
                        $reply = $response->json('choices.0.message.content');
                        Log::info('AI Model used successfully', ['model' => $model]);
                        return response()->json(['reply' => $reply]);
                    }
                    
                    $lastError = $response->body();
                    Log::warning('Model failed', ['model' => $model, 'status' => $response->status()]);
                    
                } catch (\Exception $e) {
                    $lastError = $e->getMessage();
                    Log::warning('Model exception', ['model' => $model, 'error' => $e->getMessage()]);
                }
            }

            Log::error('All models failed', ['last_error' => $lastError]);
            return response()->json([
                'reply' => $this->getLocalFallback($userMessage)
            ]);

        } catch (\Exception $e) {
            Log::error('Chatbot Exception: ' . $e->getMessage());
            return response()->json([
                'reply' => $this->getLocalFallback($request->input('message') ?? 'Hello')
            ]);
        }
    }

    private function getLocalFallback($message)
    {
        $msg = strtolower($message);
        $isTagalog = preg_match('/paano|ano|saan|kailan|bakit|sino|magkano|pwede|po|opo|oo|hindi|ako|ikaw|siya|tayo|kayo|sila|ko|mo|niya|natin|ninyo|nila|sa|ng|ang|mga|ay|na|pa|ba|daw|raw|din|rin|naman|kasi|dahil|kung|kapag|pag|tapos|bago|habang|kahit|maski|may|meron|wala|walang|mayroon|marami|kaunti|lahat|ilan|ilang|bawat|gawin|gumawa|kumuha|magbigay|pumunta|dumating|umalis|tanong|sagot|tulong|suporta|salamat|maayong|kumusta|unsaon|unsa|gi|na|ang|sa|ug|kay|ni|mga|apan|aron|pag|pinaagi/', $msg);
        
        if ($isTagalog) {
            // BOOKING
            if (preg_match('/book|booking|paano mag book|paano magpabook|paano mag reserve|reservation|reserve|unsaon pag book/', $msg)) {
                return "📋 <strong>Paano mag-book sa SureCargo:</strong><br><br>1️⃣ Pumunta sa Dashboard → pumili ng AVAILABLE na truck<br>2️⃣ Ilagay ang quantity (egg trays), pickup address, receiver name/phone, drop-off location<br>3️⃣ I-submit → maghintay ng admin approval (within 24 oras)<br>4️⃣ Kapag 'confirmed' na → lalabas ang payment button<br>5️⃣ Kapag 'in_transit' na → lalabas ang Track button<br><br>⏰ Araw ng booking: <strong>Sabado - Linggo, 9:00 AM onwards.</strong>";
            }
            
            // REGISTRATION
            if (preg_match('/register|paano mag register|sign up|create account|new account|otp|registration/', $msg)) {
                return "📝 <strong>Paano mag-register:</strong><br><br>• Pumunta sa Register page<br>• Ilagay ang First Name at Last Name<br>• Pumili ng City (Bantayan o Bacolod)<br>• Gumawa ng malakas na password (minimum 8 characters)<br>• Magbigay ng valid na 11-digit mobile number<br>• Click Register → makakatanggap ng 6-digit OTP via SMS<br>• I-enter ang OTP para makumpleto ang registration";
            }
            
            // TRACKING
            if (preg_match('/track|live|gps|location|real-time|tracking|driver|map/', $msg)) {
                return "📍 <strong>Live Tracking:</strong><br><br>Kapag naging 'in_transit' na ang booking status, lalabas ang 'Track' button sa My Bookings.<br><br>📱 Nagse-send ng location ang mga driver gamit ang phone GPS.";
            }
            
            // PAYMENTS
            if (preg_match('/pay|gcash|payment|qr code|cod|bayad|advance/', $msg)) {
                return "💳 <strong>SureCargo Payment Methods:</strong><br><br>• <strong>GCash</strong> - Upload reference number after payment<br>• <strong>COD (Cash on Delivery)</strong> - Pay exact cash upon delivery<br><br>📌 Payment button appears after booking is 'confirmed'.";
            }
            
            // TRUCK INFO
            if (preg_match('/capacity|max trays|limit|truck|helper|driver|personel|personnel/', $msg)) {
                return "🚛 <strong>Impormasyon sa Truck:</strong><br><br>• Ang bawat truck ay kayang mag-hold ng <strong>12,000 egg trays</strong><br>• Personnel: <strong>1 driver</strong> at <strong>3 truck helpers</strong>";
            }
            
            // ROUTES
            if (preg_match('/route|routes|way|path|city|bantayan|bacolod|escalante|sagay|cadiz|manapla|victorias|silay|bata|libertad/', $msg)) {
                return "🛣️ <strong>Mga Ruta:</strong><br><br>📍 Bantayan → Escalante → Sagay → Cadiz → Manapla → Victorias → Silay → Bata → Bacolod<br>🔄 Return: Bacolod → Bata → Silay → Victorias → Manapla → Cadiz → Sagay → Escalante → Bantayan";
            }
            
            // ABOUT
            if (preg_match('/about|ano ang surecargo|platform|company|owner|founder|atty|ray|lambert|menchavez|tradio/', $msg)) {
                return "🚚 <strong>Tungkol sa SureCargo:</strong><br><br>• Logistics platform para sa <strong>egg tray transportation</strong> mula Bantayan Island papuntang Bacolod City<br>• Itinatag ni <strong>Atty. Ray Lambert Menchavez</strong><br>• Developer: <strong>Rogelio Tradio Jr.</strong>";
            }
            
            // GREETINGS
            if (preg_match('/hello|hi|hey|maayong|kumusta|good morning|good afternoon|good evening|musta|oy|hoy/', $msg)) {
                return "👋 <strong>Maayong adlaw!</strong> Ako si <strong>SureCargo AI</strong>.<br><br>Maaari akong tumulong sa:<br>• Bookings (Sabado-Linggo 9AM)<br>• Registration at OTP verification<br>• Live tracking (GPS + mapa)<br>• GCash/COD payments<br>• Truck capacity at personnel info<br>• Routes mula Bantayan papuntang Bacolod<br><br>Magtanong ka lang! 😊";
            }
            
            // SUPPORT
            if (preg_match('/support|help|contact|email|hotline|phone|number/', $msg)) {
                return "📞 <strong>Support:</strong><br><br>📧 Email: <strong>tradiorogelio@gmail.com</strong><br>📱 Hotline: <strong>09945828601</strong><br>💬 In-app chat with admin";
            }
            
            // DEFAULT TAGALOG
            return "🤖 <strong>Maaari akong tumulong sa:</strong><br><br>• Registration at OTP verification<br>• Booking steps (Sabado-Linggo 9AM)<br>• Live tracking (GPS + mapa)<br>• GCash/COD payments<br>• Truck capacity at personnel info<br>• Routes mula Bantayan papuntang Bacolod<br><br>📝 Pakiusap, i-rephrase ang iyong tanong.";
        }
        
        // ---- ENGLISH RESPONSES ----
        if (preg_match('/book|booking|how to book|reserve|schedule/', $msg)) {
            return "📋 <strong>Booking Steps:</strong><br><br>1️⃣ Dashboard → select AVAILABLE truck<br>2️⃣ Enter quantity, pickup address, receiver info<br>3️⃣ Submit → wait admin approval (24h)<br>4️⃣ Once 'confirmed' → Payment button appears<br>5️⃣ When 'in_transit' → Track button shows<br><br>⏰ Booking days: Saturday - Sunday, 9:00 AM onwards.";
        }
        
        if (preg_match('/register|sign up|create account|registration|how to join|new account|otp/', $msg)) {
            return "📝 <strong>How to register:</strong><br><br>• Visit Register page<br>• Enter First Name & Last Name<br>• Select City and User Type<br>• Create strong password<br>• Provide valid 11-digit mobile number<br>• Click Register → receive 6-digit OTP via SMS<br>• Enter OTP to complete registration";
        }
        
        if (preg_match('/track|live|gps|location|real-time|tracking|driver|map/', $msg)) {
            return "📍 <strong>Live Tracking:</strong><br><br>When booking status becomes 'in_transit', a 'Track' button appears in My Bookings.<br><br>📱 Drivers send location through phone GPS.";
        }
        
        if (preg_match('/pay|gcash|payment|qr code|cod|bayad|advance/', $msg)) {
            return "💳 <strong>SureCargo Payment Methods:</strong><br><br>• <strong>GCash</strong> - Upload reference number after payment<br>• <strong>COD (Cash on Delivery)</strong> - Pay exact cash upon delivery";
        }
        
        if (preg_match('/capacity|max trays|limit|truck|helper|driver|personel|personnel/', $msg)) {
            return "🚛 <strong>Truck Information:</strong><br><br>• Each truck holds <strong>12,000 egg trays</strong><br>• Personnel: <strong>1 driver</strong> and <strong>3 truck helpers</strong>";
        }
        
        if (preg_match('/route|routes|way|path|city|bantayan|bacolod|escalante|sagay|cadiz|manapla|victorias|silay|bata|libertad/', $msg)) {
            return "🛣️ <strong>Routes:</strong><br><br>📍 Bantayan → Escalante → Sagay → Cadiz → Manapla → Victorias → Silay → Bata → Bacolod<br>🔄 Return: Bacolod → Bata → Silay → Victorias → Manapla → Cadiz → Sagay → Escalante → Bantayan";
        }
        
        if (preg_match('/about|what is surecargo|platform|company|owner|founder|atty|ray|lambert|menchavez|tradio/', $msg)) {
            return "🚚 <strong>About SureCargo:</strong><br><br>• Logistics platform for egg tray transportation from Bantayan Island to Bacolod City<br>• Founded by Atty. Ray Lambert Menchavez<br>• Developer: Rogelio Tradio Jr.";
        }
        
        if (preg_match('/hello|hi|hey|maayong|kumusta|good morning|good afternoon|good evening/', $msg)) {
            return "👋 <strong>Hello!</strong> I'm <strong>SureCargo AI</strong>.<br><br>I can help with:<br>• Bookings (Sat-Sun 9AM)<br>• Registration & OTP verification<br>• Live tracking (GPS + map)<br>• GCash/COD payments<br>• Truck capacity & personnel info<br>• Routes from Bantayan to Bacolod<br><br>Ask me anything! 😊";
        }
        
        if (preg_match('/support|help|contact|email|hotline|phone|number/', $msg)) {
            return "📞 <strong>Support:</strong><br><br>📧 Email: tradiorogelio@gmail.com<br>📱 Hotline: 09945828601<br>💬 In-app chat with admin";
        }
        
        if (preg_match('/thank|salamat|thanks/', $msg)) {
            return "😊 <strong>You're welcome!</strong> Safe shipping and happy tracking! 🚚";
        }
        
        // DEFAULT ENGLISH
        return "🤖 <strong>I can help with:</strong><br><br>• Registration & OTP verification<br>• Booking steps (Sat-Sun 9AM)<br>• Live tracking (GPS + map)<br>• GCash/COD payments<br>• Truck capacity & personnel info<br>• Routes from Bantayan to Bacolod<br><br>📝 Please rephrase your question.";
    }
}
