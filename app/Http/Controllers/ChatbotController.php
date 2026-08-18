<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    // CONFIRMED WORKING MODELS
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

            $systemPrompt = "You are SureCargo AI, an expert assistant for the SureCargo egg tray transport system. " .
                "SureCargo Transport is an egg cargo service from Bantayan Island to Bacolod City. " .
                "Location: Mohon, Santa Fe, Cebu. Maintenance location: Sungko, Bantayan, Cebu. " .
                "Owner: Atty. Ray Lambert Menchavez, a son of past generation trucking businessmen. " .
                "Developer: Rogelio Tradio Jr. " .
                "Booking days: Saturday-Sunday 9:00 AM onwards. " .
                "Users can book through this website. After booking, admin accepts the booking. " .
                "When status changes to 'confirmed', users cannot edit anymore and the payment button appears for advance payments. " .
                "When status changes to 'in_transit', the track button shows where users can track truck location in real-time. " .
                "Receiver from Bacolod can also track using notifications sent by admin from sender's booking. " .
                "Personnel per truck: 1 driver and 3 truck helpers. Eggs shipment is handled with care by hardworking helpers. " .
                "Routes: One-way from Bantayan to Bacolod via Escalante, Sagay, Cadiz, Manapla, Victorias, Silay, Bata, Bacolod, and Libertad cities. " .
                "Return route is the same way back. " .
                "Drivers send location through phone GPS. " .
                "Users can send damage requests. " .
                "Message feature allows user-to-user communication for business purposes. " .
                "Users can view daily, weekly, and monthly announcements. " .
                "Registration requires OTP verification. Forgot password also uses OTP. " .
                "All credentials are secured. " .
                "This company is just beginning and expanding. " .
                "Respond in the same language as the user (English, Tagalog, Bisaya). " .
                "Keep answers concise, friendly, and under 200 words. Use bullet points for steps. " .
                "Never make up features; if unsure, say 'I will connect you with support'.";

            $lastError = null;

            // Try each model until one works
            foreach ($this->freeModels as $model) {
                try {
                    $response = Http::timeout(30)
                        ->withOptions(['verify' => false])
                        ->withHeaders([
                            'Authorization' => 'Bearer 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',
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
                        
                        Log::info('AI Model used successfully', [
                            'model' => $model,
                            'tokens' => $response->json('usage.total_tokens') ?? 'N/A'
                        ]);
                        
                        return response()->json(['reply' => $reply]);
                    }
                    
                    $lastError = $response->body();
                    Log::warning('Model failed', [
                        'model' => $model,
                        'status' => $response->status(),
                        'response' => $lastError
                    ]);
                    
                } catch (\Exception $e) {
                    $lastError = $e->getMessage();
                    Log::warning('Model exception', [
                        'model' => $model,
                        'error' => $e->getMessage()
                    ]);
                }
            }

            // If ALL models failed, use local fallback
            Log::error('All models failed, using fallback', ['last_error' => $lastError]);
            return response()->json([
                'reply' => $this->getLocalFallback($userMessage)
            ]);

        } catch (\Exception $e) {
            Log::error('Chatbot Exception: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            // Always return a fallback response even on exception
            return response()->json([
                'reply' => $this->getLocalFallback($request->input('message') ?? 'Hello')
            ]);
        }
    }

    /**
     * Local fallback responses - Complete SureCargo Knowledge Base
     */
    private function getLocalFallback($message)
    {
        $msg = strtolower($message);
        
        // Tagalog/Bisaya detection
        $isTagalog = preg_match('/paano|ano|saan|kailan|bakit|sino|magkano|pwede|po|opo|oo|hindi|ako|ikaw|siya|tayo|kayo|sila|ko|mo|niya|natin|ninyo|nila|sa|ng|ang|mga|ay|na|pa|ba|daw|raw|din|rin|naman|kasi|dahil|kung|kapag|pag|tapos|bago|habang|kahit|maski|may|meron|wala|walang|mayroon|marami|kaunti|lahat|ilan|ilang|bawat|gawin|gumawa|kumuha|magbigay|pumunta|dumating|umalis|tanong|sagot|tulong|suporta|salamat|maayong|kumusta|unsaon|unsa|gi|na|ang|sa|ug|kay|ni|mga|apan|aron|pag|pinaagi/', $msg);
        
        // ---- TAGALOG/BISAYA RESPONSES ----
        if ($isTagalog) {
            // Booking
            if (preg_match('/book|booking|paano mag book|paano magpabook|paano mag reserve|reservation|reserve|unsaon pag book/', $msg)) {
                return "📋 <strong>Paano mag-book sa SureCargo:</strong><br><br>1️⃣ Pumunta sa Dashboard → pumili ng AVAILABLE na truck<br>2️⃣ Ilagay ang quantity (egg trays), pickup address, receiver name/phone, drop-off location<br>3️⃣ I-submit → maghintay ng admin approval (within 24 oras)<br>4️⃣ Kapag 'confirmed' na → lalabas ang payment button para sa advance payment<br>5️⃣ Kapag 'in_transit' na ang status → lalabas ang Track button para sa live tracking<br><br>⏰ Araw ng booking: <strong>Sabado - Linggo, 9:00 AM onwards.</strong><br><br>📍 Location: Mohon, Santa Fe, Cebu<br>🏢 Maintenance: Sungko, Bantayan, Cebu";
            }
            
            // Registration
            if (preg_match('/register|paano mag register|sign up|create account|new account|otp|registration/', $msg)) {
                return "📝 <strong>Paano mag-register sa SureCargo:</strong><br><br>• Pumunta sa Register page<br>• Ilagay ang First Name at Last Name<br>• Pumili ng City (Bantayan o Bacolod) at User Type (Poultry Owner o Customer)<br>• Gumawa ng malakas na password (minimum 8 characters)<br>• Magbigay ng valid na 11-digit mobile number (nagsisimula sa 09)<br>• Click Register → makakatanggap ng 6-digit OTP via SMS<br>• I-enter ang OTP para makumpleto ang registration<br>• Para sa forgot password, magsesend din ng OTP<br><br>🔐 Secure ang lahat ng credentials!";
            }
            
            // Tracking
            if (preg_match('/track|live|gps|location|real-time|tracking|driver|map/', $msg)) {
                return "📍 <strong>Live Tracking:</strong><br><br>Kapag naging 'in_transit' na ang booking status, lalabas ang 'Track' button sa My Bookings.<br><br>📱 Nagse-send ng location ang mga driver gamit ang phone GPS.<br><br>👥 Ang receiver mula sa Bacolod ay maaari ring mag-track gamit ang notifications na ipinapadala ng admin mula sa booking ng sender.";
            }
            
            // Payments
            if (preg_match('/pay|gcash|payment|qr code|cod|bayad|advance/', $msg)) {
                if (strpos($msg, 'gcash') !== false) {
                    return "💚 <strong>GCash Payment:</strong><br><br>Pagkatapos ng confirmation, pumunta sa My Bookings → Pay → piliin ang GCash.<br>• I-scan ang QR code<br>• Ipadala ang exact na halaga<br>• I-upload ang reference number<br>• Ive-verify ng admin within 24 oras";
                }
                if (strpos($msg, 'cod') !== false) {
                    return "🚚 <strong>COD (Cash on Delivery):</strong><br><br>Piliin ang COD sa checkout.<br>• Ibigay ang buong pangalan ng receiver<br>• Magbayad ng exact cash kapag nag-deliver ang driver";
                }
                return "💳 <strong>SureCargo Payment Methods:</strong><br><br>• <strong>GCash</strong> - Upload reference number after payment<br>• <strong>COD (Cash on Delivery)</strong> - Pay exact cash upon delivery<br><br>📌 Payment button appears after booking is 'confirmed'.";
            }
            
            // Truck & Personnel
            if (preg_match('/capacity|max trays|limit|truck|helper|driver|personel|personnel/', $msg)) {
                return "🚛 <strong>Impormasyon sa Truck:</strong><br><br>• Ang bawat truck ay kayang mag-hold ng <strong>12,000 egg trays</strong><br>• Personnel: <strong>1 driver</strong> at <strong>3 truck helpers</strong><br>• Ang mga helper ay masipag at maingat sa paghawak ng itlog<br><br>👨‍✈️ Driver: Nagse-send ng location through phone GPS";
            }
            
            // Routes
            if (preg_match('/route|routes|way|path|city|bantayan|bacolod|escalante|sagay|cadiz|manapla|victorias|silay|bata|libertad/', $msg)) {
                return "🛣️ <strong>Mga Ruta ng SureCargo:</strong><br><br>📍 <strong>From Bantayan Island → Bacolod City</strong><br>• One-way: Bantayan → Escalante → Sagay → Cadiz → Manapla → Victorias → Silay → Bata → Bacolod<br>• Kasama rin ang Libertad cities<br><br>🔄 <strong>Return Route:</strong><br>• Bacolod → Bata → Silay → Victorias → Manapla → Cadiz → Sagay → Escalante → Bantayan<br><br>🏢 Base: <strong>Sungko, Bantayan, Cebu</strong><br>📍 Location: <strong>Mohon, Santa Fe, Cebu</strong>";
            }
            
            // About / Company
            if (preg_match('/about|ano ang surecargo|platform|company|owner|founder|atty|ray|lambert|menchavez|tradio/', $msg)) {
                return "🚚 <strong>Tungkol sa SureCargo:</strong><br><br>• Logistics platform para sa <strong>egg tray transportation</strong> mula Bantayan Island papuntang Bacolod City<br>• Itinatag ni <strong>Atty. Ray Lambert Menchavez</strong>, anak ng mga dating negosyante sa trucking<br>• Ang kompanya ay nagsisimula pa lamang at patuloy na lumalaki<br><br>🏢 Base: <strong>Sungko, Bantayan, Cebu</strong><br>📍 Location: <strong>Mohon, Santa Fe, Cebu</strong><br>👨‍💻 Developer: <strong>Rogelio Tradio Jr.</strong>";
            }
            
            // Greetings
            if (preg_match('/hello|hi|hey|maayong|kumusta|good morning|good afternoon|good evening|musta|oy|hoy/', $msg)) {
                return "👋 <strong>Maayong adlaw!</strong> Ako si <strong>SureCargo AI</strong>.<br><br>Maaari akong tumulong sa:<br>• Bookings (Sabado-Linggo 9AM)<br>• Registration at OTP verification<br>• Live tracking (GPS + mapa)<br>• GCash/COD payments<br>• Truck capacity at personnel info<br>• Routes mula Bantayan papuntang Bacolod<br>• Profile at password updates<br>• User-to-user messaging<br>• Announcements (daily/weekly/monthly)<br>• Damage requests<br><br>📍 Location: Mohon, Santa Fe, Cebu<br>🏢 Maintenance: Sungko, Bantayan, Cebu<br>👨‍💼 Owner: Atty. Ray Lambert Menchavez<br><br>Magtanong ka lang! 😊";
            }
            
            // Thank you
            if (preg_match('/thank|salamat|thanks|salamat po|maraming salamat/', $msg)) {
                return "😊 <strong>Walang anuman!</strong> Safe shipping at happy tracking! 🚚<br><br>May iba pa ba akong matutulong?";
            }
            
            // Messages/Chat
            if (preg_match('/message|chat|communicate|user to user/', $msg)) {
                return "💬 <strong>User-to-User Messaging:</strong><br><br>Ang message feature ay para sa <strong>user-to-user communication</strong> para sa business purposes.<br><br>Pumunta sa 'Messages' sa sidebar para makipag-chat sa ibang users, drivers, o admin.";
            }
            
            // Announcements
            if (preg_match('/announcement|news|daily|weekly|monthly|update/', $msg)) {
                return "📢 <strong>Announcements:</strong><br><br>Pwedeng makita ng users ang:<br>• Daily announcements<br>• Weekly announcements<br>• Monthly announcements<br><br>I-check ang Announcements section para sa mga updates!";
            }
            
            // Damage Requests
            if (preg_match('/damage|damage request|claim|broken|issue/', $msg)) {
                return "🔧 <strong>Damage Requests:</strong><br><br>Pwedeng mag-submit ng <strong>damage requests</strong> ang users sa pamamagitan ng platform.<br><br>📌 Pumunta sa iyong booking at i-click ang 'Report Damage'.<br>• Susuriin ng admin ang iyong claim";
            }
            
            // Support
            if (preg_match('/support|help|contact|email|hotline|phone|number/', $msg)) {
                return "📞 <strong>Support:</strong><br><br>📧 Email: <strong>tradiorogelio@gmail.com</strong><br>📱 Hotline: <strong>09945828601</strong><br>💬 In-app chat with admin<br><br>👨‍💻 Developer: <strong>Rogelio Tradio Jr.</strong><br>👨‍💼 Owner: <strong>Atty. Ray Lambert Menchavez</strong>";
            }
            
            // Edit booking
            if (preg_match('/edit|modify|update booking/', $msg)) {
                return "✏️ <strong>Edit Booking:</strong><br><br>Pwede mong i-edit ang booking habang ang status ay <strong>'pending'</strong>.<br><br>❌ Kapag <strong>'confirmed'</strong> na, HINDI na pwede i-edit at lalabas na ang payment button.";
            }
            
            // Cancel
            if (preg_match('/cancel|refund/', $msg)) {
                return "❌ <strong>Cancel Booking:</strong><br><br>• Pending bookings - pwedeng i-cancel mula sa My Bookings<br>• Confirmed bookings - kailangan kontakin ang support<br>• GCash refunds - tumatagal ng <strong>3-5 business days</strong>";
            }
            
            // Profile
            if (preg_match('/profile|update profile|change password/', $msg)) {
                return "👤 <strong>Profile Update:</strong><br><br>I-click ang <strong>Profile</strong> sa sidebar para i-update ang:<br>• Photo<br>• Mobile number<br>• City<br>• User type<br>• Password<br><br>🔐 All credentials secured with <strong>OTP verification</strong>";
            }
            
            // Default Tagalog response
            return "🤖 <strong>Maaari akong tumulong sa:</strong><br><br>• Registration at OTP verification<br>• Booking steps (Sabado-Linggo 9AM)<br>• Live tracking (GPS + mapa)<br>• GCash/COD payments<br>• Truck capacity at personnel info<br>• Routes mula Bantayan papuntang Bacolod<br>• Profile at password updates<br>• User-to-user messaging<br>• Announcements (daily/weekly/monthly)<br>• Damage requests<br>• Support contact<br><br>📍 Location: Mohon, Santa Fe, Cebu<br>🏢 Maintenance: Sungko, Bantayan, Cebu<br>👨‍💼 Owner: Atty. Ray Lambert Menchavez<br><br>📝 <em>Pakiusap, i-rephrase ang iyong tanong o i-click ang quick question sa sidebar.</em>";
        }
        
        // ---- ENGLISH RESPONSES ----
        // Booking
        if (preg_match('/book|booking|how to book|reserve|schedule/', $msg)) {
            if (strpos($msg, 'step') !== false || strpos($msg, 'process') !== false || strpos($msg, 'how') !== false) {
                return "📋 <strong>Booking Steps:</strong><br><br>1️⃣ Dashboard → select <strong>AVAILABLE</strong> truck<br>2️⃣ Enter quantity (egg trays), pickup address, receiver name/phone, drop-off location<br>3️⃣ Submit → wait admin approval (24h)<br>4️⃣ Once <strong>'confirmed'</strong> → Payment button appears for advance payment<br>5️⃣ When status is <strong>'in_transit'</strong> → Track button shows for live tracking<br><br>⏰ Booking days: <strong>Saturday - Sunday, 9:00 AM onwards.</strong><br><br>📍 Location: Mohon, Santa Fe, Cebu<br>🏢 Maintenance: Sungko, Bantayan, Cebu";
            }
            return "To book, go to Dashboard, pick a truck with available capacity, fill the form, and submit. Admin confirms within 24h. Booking days: <strong>Saturday-Sunday 9 AM</strong>.";
        }
        
        // Registration
        if (preg_match('/register|sign up|create account|registration|how to join|new account|otp/', $msg)) {
            return "📝 <strong>How to register on SureCargo:</strong><br><br>• Visit the Register page<br>• Enter <strong>First Name</strong> & <strong>Last Name</strong><br>• Select your <strong>City</strong> (Bantayan or Bacolod) and <strong>User Type</strong> (Poultry Owner or Customer)<br>• Create a strong password (minimum 8 characters)<br>• Provide a valid <strong>11-digit mobile number</strong> starting with 09<br>• Click Register → you'll receive a <strong>6-digit OTP</strong> via SMS<br>• Enter OTP to complete registration<br>• Forgot password also uses OTP verification<br><br>🔐 All credentials are secured!";
        }
        
        // Tracking
        if (preg_match('/track|live|gps|location|real-time|tracking|driver|map/', $msg)) {
            return "📍 <strong>Live Tracking:</strong><br><br>When booking status becomes <strong>'in_transit'</strong>, a 'Track' button appears in My Bookings.<br><br>📱 Drivers send location through phone GPS.<br><br>👥 The receiver from Bacolod can also track using notifications sent by admin from the sender's booking.";
        }
        
        // Payments
        if (preg_match('/pay|gcash|payment|qr code|cod|bayad|advance/', $msg)) {
            if (strpos($msg, 'gcash') !== false) {
                return "💚 <strong>GCash Payment:</strong><br><br>After confirmation, go to My Bookings → Pay → choose GCash.<br>• Scan QR code<br>• Send exact amount<br>• Upload reference number<br>• Admin verifies within 24h";
            }
            if (strpos($msg, 'cod') !== false) {
                return "🚚 <strong>COD (Cash on Delivery):</strong><br><br>Select COD at checkout.<br>• Provide receiver's full name<br>• Pay exact cash when driver delivers";
            }
            return "💳 <strong>SureCargo Payment Methods:</strong><br><br>• <strong>GCash</strong> - Upload reference number after payment<br>• <strong>COD (Cash on Delivery)</strong> - Pay exact cash upon delivery<br><br>📌 Payment button appears after booking is 'confirmed'.";
        }
        
        // Truck & Personnel
        if (preg_match('/capacity|max trays|limit|truck|helper|driver|personel|personnel/', $msg)) {
            return "🚛 <strong>Truck Information:</strong><br><br>• Each truck holds <strong>12,000 egg trays</strong><br>• Personnel: <strong>1 driver</strong> and <strong>3 truck helpers</strong><br>• Helpers handle eggs with care and hard work<br><br>👨‍✈️ Driver: Sends location through phone GPS";
        }
        
        // Routes
        if (preg_match('/route|routes|way|path|city|bantayan|bacolod|escalante|sagay|cadiz|manapla|victorias|silay|bata|libertad/', $msg)) {
            return "🛣️ <strong>SureCargo Routes:</strong><br><br>📍 <strong>From Bantayan Island → Bacolod City</strong><br>• One-way: Bantayan → Escalante → Sagay → Cadiz → Manapla → Victorias → Silay → Bata → Bacolod<br>• Includes Libertad cities<br><br>🔄 <strong>Return Route:</strong><br>• Bacolod → Bata → Silay → Victorias → Manapla → Cadiz → Sagay → Escalante → Bantayan<br><br>🏢 Base: <strong>Sungko, Bantayan, Cebu</strong><br>📍 Location: <strong>Mohon, Santa Fe, Cebu</strong>";
        }
        
        // About / Company
        if (preg_match('/about|what is surecargo|platform|company|owner|founder|atty|ray|lambert|menchavez|tradio/', $msg)) {
            return "🚚 <strong>About SureCargo:</strong><br><br>• Logistics platform for <strong>egg tray transportation</strong> from Bantayan Island to Bacolod City<br>• Founded by <strong>Atty. Ray Lambert Menchavez</strong>, a son of past generation trucking businessmen<br>• The company is just beginning and expanding<br><br>🏢 Base: <strong>Sungko, Bantayan, Cebu</strong><br>📍 Location: <strong>Mohon, Santa Fe, Cebu</strong><br>👨‍💻 Developer: <strong>Rogelio Tradio Jr.</strong>";
        }
        
        // Greetings
        if (preg_match('/hello|hi|hey|maayong|kumusta|good morning|good afternoon|good evening/', $msg)) {
            return "👋 <strong>Maayong adlaw!</strong> I'm <strong>SureCargo AI</strong>.<br><br>I can help with:<br>• Bookings (Sat-Sun 9AM)<br>• Registration & OTP verification<br>• Live tracking (GPS + map)<br>• GCash/COD payments<br>• Truck capacity & personnel info<br>• Routes from Bantayan to Bacolod<br>• Profile & password updates<br>• User-to-user messaging<br>• Announcements (daily/weekly/monthly)<br>• Damage requests<br><br>📍 Location: Mohon, Santa Fe, Cebu<br>🏢 Maintenance: Sungko, Bantayan, Cebu<br>👨‍💼 Owner: Atty. Ray Lambert Menchavez<br><br>Ask me anything! 😊";
        }
        
        // Thank you
        if (preg_match('/thank|salamat|thanks/', $msg)) {
            return "😊 <strong>You're welcome!</strong> Safe shipping and happy tracking! 🚚<br><br>Anything else I can help with?";
        }
        
        // Messages/Chat
        if (preg_match('/message|chat|communicate|user to user/', $msg)) {
            return "💬 <strong>User-to-User Messaging:</strong><br><br>The message feature allows <strong>user-to-user communication</strong> for business purposes.<br><br>Go to 'Messages' in sidebar to chat with other users, drivers, or admin.";
        }
        
        // Announcements
        if (preg_match('/announcement|news|daily|weekly|monthly|update/', $msg)) {
            return "📢 <strong>Announcements:</strong><br><br>Users can view:<br>• Daily announcements<br>• Weekly announcements<br>• Monthly announcements<br><br>Check the Announcements section for updates!";
        }
        
        // Damage Requests
        if (preg_match('/damage|damage request|claim|broken|issue/', $msg)) {
            return "🔧 <strong>Damage Requests:</strong><br><br>Users can submit <strong>damage requests</strong> through the platform.<br><br>📌 Go to your booking and click 'Report Damage'.<br>• Admin will review your claim";
        }
        
        // Support
        if (preg_match('/support|help|contact|email|hotline|phone|number/', $msg)) {
            return "📞 <strong>Support:</strong><br><br>📧 Email: <strong>tradiorogelio@gmail.com</strong><br>📱 Hotline: <strong>09945828601</strong><br>💬 In-app chat with admin<br><br>👨‍💻 Developer: <strong>Rogelio Tradio Jr.</strong><br>👨‍💼 Owner: <strong>Atty. Ray Lambert Menchavez</strong>";
        }
        
        // Edit booking
        if (preg_match('/edit|modify|update booking/', $msg)) {
            return "✏️ <strong>Edit Booking:</strong><br><br>You can edit a booking only while status is <strong>'pending'</strong>.<br><br>❌ Once <strong>'confirmed'</strong>, you CANNOT edit anymore and the payment button appears.";
        }
        
        // Cancel
        if (preg_match('/cancel|refund/', $msg)) {
            return "❌ <strong>Cancel Booking:</strong><br><br>• Pending bookings - can be cancelled from My Bookings<br>• Confirmed bookings - contact support<br>• GCash refunds take <strong>3-5 business days</strong>";
        }
        
        // Profile
        if (preg_match('/profile|update profile|change password/', $msg)) {
            return "👤 <strong>Profile Update:</strong><br><br>Click <strong>Profile</strong> in sidebar to update:<br>• Photo<br>• Mobile number<br>• City<br>• User type<br>• Password<br><br>🔐 All credentials secured with <strong>OTP verification</strong>";
        }
        
        // Default English response
        return "🤖 <strong>I can help with:</strong><br><br>• Registration & OTP verification<br>• Booking steps (Sat-Sun 9AM)<br>• Live tracking (GPS + map)<br>• GCash/COD payments<br>• Truck capacity & personnel info<br>• Routes from Bantayan to Bacolod<br>• Profile & password updates<br>• User-to-user messaging<br>• Announcements (daily/weekly/monthly)<br>• Damage requests<br>• Support contact<br><br>📍 Location: Mohon, Santa Fe, Cebu<br>🏢 Maintenance: Sungko, Bantayan, Cebu<br>👨‍💼 Owner: Atty. Ray Lambert Menchavez<br><br>📝 <em>Please rephrase your question or click a quick question from the sidebar.</em>";
    }
}
