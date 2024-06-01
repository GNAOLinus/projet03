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
use App\Models\Filiere;
use App\Models\InfoEtudiant;
use App\Models\Site;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class RegisteredUserController extends Controller
{
    /**
     * Affiche la vue d'enregistrement.
     */
    public function create($encryptedData)
    {
        try {
            // Décrypter les données
            $data = Crypt::decrypt($encryptedData);

            // Valider les données décryptées
            if (!isset($data['role']) || !isset($data['promotion'])) {
                abort(404, 'Données d\'enregistrement invalides.');
            }

            // Récupérer les informations nécessaires
            $role = $data['role'];
            $promotion = $data['promotion'];
            $filieres = Filiere::all();
            $sites = Site::all();

            // Retourner la vue d'enregistrement avec les données nécessaires
            return view('auth.register', compact('encryptedData', 'role', 'filieres', 'sites', 'promotion'));
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            Log::error('Échec du décryptage des données d\'enregistrement', ['error' => $e->getMessage()]);
            abort(404); // Gérez l'erreur comme vous le souhaitez
        }
    }

    /**
     * Traite une demande d'inscription entrante.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
{
    // Validation des données du formulaire
    $validatedData = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
        'id_role' => ['required', 'integer', 'exists:roles,id'],
        'id_site' => ['required', 'integer', 'exists:sites,id'],
        'id_filiere' => ['required', 'integer', 'exists:filieres,id'],
        'id_promotion' => ['required', 'integer', 'exists:promotions,id'],
        'matricule' => ['sometimes', 'integer'],
        'phone' => ['sometimes', 'string'],
        'encryptedData' => ['required', 'string'],
    ]);

    // Récupérer les données chiffrées
    $encryptedData = $request->input('encryptedData');

    // Vérifier si le rôle de l'utilisateur est 'étudiant' (id rôle = 2)
    if ($request->id_role == 2) {
        $userMatricule = InfoEtudiant::where('matricule', $request->matricule)->first();

        // Vérifier les informations de l'étudiant
        if ($userMatricule &&
            $userMatricule->name == $request->name &&
            $userMatricule->id_site == $request->id_site &&
            $userMatricule->id_filiere == $request->id_filiere) {

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'id_role' => $request->id_role,
                'id_site' => $request->id_site,
                'id_filiere' => $request->id_filiere,
                'id_promotion' => $request->id_promotion,
                'phone' => $request->phone,
            ]);

            event(new Registered($user));
            Auth::login($user);

            return redirect()->route('dashboard');

        } else {
            // Redirection vers la vue d'enregistrement avec les erreurs
            return redirect()->to('http://localhost:8000/register/eyJpdiI6IjBBZ1NKQ0dNZklQd3I1dUNaY3lJbWc9PSIsInZhbHVlIjoiZDIyWlZGRGlLOE43UGV3SkhXcytlZVdGcG9mYlRtTXFsanllQzZQL2VqZEgrNG5aQWZhS2I2d3c3Z0FQSnlUYkxYTkd6NUlYdlhVRXFEMituSkxqeFE9PSIsIm1hYyI6IjJhOTliZTNhNGFiNTBkOTY0YTc3ZDBlNjE5ZWRiZjAwYmFlYmEyNjQ1NDJjMDExYzc1YzUwOTdhMTZjZjc2N2YiLCJ0YWciOiIifQ==')
                    ->withErrors(['message' => 'Informations incorrectes de l\'étudiant.']);
        }

    } else {
        // Création de l'utilisateur pour les rôles autres qu'étudiant
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'id_role' => $request->id_role,
            'id_site' => $request->id_site,
            'id_filiere' => $request->id_filiere,
            'id_promotion' => $request->id_promotion,
        ]);

        event(new Registered($user));
        Auth::login($user);

        return redirect()->route('dashboard');
    }
}

}
