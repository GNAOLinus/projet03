<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function notification()
    {
        // Récupérer l'utilisateur actuellement authentifié
        $user = Auth::user();
    
        // Récupérer les notifications non lues pour l'utilisateur
        $notificationsNonLu = $user->unreadNotifications;
    
        // Récupérer les notifications lues pour l'utilisateur
        $notificationsLu = $user->readNotifications;
    
        // Passer les notifications à la vue
        return view('notification', compact('notificationsNonLu', 'notificationsLu'));
    }
    

}
