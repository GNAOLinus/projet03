<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Models\Filiere; // Assurez-vous d'importer le modèle Filiere
use App\Models\Site;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create($role,$promotion)
    {
        $filieres = Filiere::all(); // Récupérer toutes les filières depuis la base de données
        $sites = Site::all(); // Récupérer toutes les sites depuis la base de données
        return view('auth.register', ['role' => $role, 'filieres' => $filieres, 'sites' => $sites, 'promotion'=> $promotion, ]); 
    }
    
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'id_role' => ['integer', 'exists:roles,id'],
            'id_site' => ['integer', 'exists:sites,id'],
            'id_filiere' => ['integer', 'exists:filieres,id'], // Validation de la filière
            'id_promotion' => ['integer', 'exists:promotions,id'], // Validation de la promotion
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'id_role' => $request->id_role,
            'id_site' => $request->id_site,
            'id_filiere' => $request->id_filiere, // Utilisation de la filière sélectionnée
            'id_promotion' => $request->id_promotion, // Utilisation de la promotion sélectionnée
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
