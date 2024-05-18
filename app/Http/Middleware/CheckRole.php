<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle($request, Closure $next, ...$roles)
    {
        // Vérifie si l'utilisateur est authentifié
        if (!Auth::check()) {
            return redirect()->route('login'); // Redirige l'utilisateur vers la page de connexion s'il n'est pas authentifié
        }

        // Récupère le rôle de l'utilisateur
        $userRole = Auth::user()->role;

        // Vérifie si le rôle de l'utilisateur est autorisé
        if (!in_array($userRole, $roles)) {
            abort(403); // Redirection vers une erreur 403 si l'utilisateur n'a pas le bon rôle
        }

        // Redirection conditionnelle en fonction du rôle de l'utilisateur
        switch ($userRole) {
            case '1':
                return redirect()->route('admin.dashboard');
                break;
            case '2':
                return redirect()->route('student.dashboard');
                break;
            case 'teacher':
                return redirect()->route('teacher.dashboard');
                break;
            default:
                abort(403); // Gérer d'autres rôles ou erreurs ici si nécessaire
                break;
        }
    }
}
