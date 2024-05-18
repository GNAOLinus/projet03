<?php

namespace App\Http\Controllers;

use App\Models\Binome;
use App\Models\Invitations;
use App\Models\User;

class EtudiantController extends Controller
{
    public function index()
    {
        // Récupérer l'utilisateur connecté
        $user = auth()->user();

        // Récupérer la liste des étudiants avec l'ID du rôle égal à 2
        $etudiants = User::where('id_role', 2)->get();
        
        // Récupérer les IDs des étudiants avec un binôme
        $etudiants_avec_binome = Binome::pluck('id_etudiant1')->merge(Binome::pluck('id_etudiant2'));
        
        // Filtrer les étudiants pour obtenir ceux sans binôme
        $etudiants_sans_binome = $etudiants->reject(function ($etudiant) use ($etudiants_avec_binome) {
            return $etudiants_avec_binome->contains($etudiant->id);
        });
        
        // Parcourir chaque étudiant sans binôme
        $etudiants_sans_binome->each(function ($etudiant) use ($user) {
            // Vérifier si l'utilisateur a envoyé une invitation à cet étudiant
            $invitationEnvoyee = Invitations::where('sender_id', $user->id)
                ->where('receiver_id', $etudiant->id)
                ->exists();
            
            // Vérifier si l'utilisateur a reçu une invitation de cet étudiant
            $invitationRecue = Invitations::where('sender_id', $etudiant->id)
                ->where('receiver_id', $user->id)
                ->exists();

            // Marquer l'étudiant en fonction de l'état de leurs invitations
            if ($invitationEnvoyee) {
                $etudiant->invitation = 'envoyée'; // Invitation envoyée et reçue
                $invitation = null; // Pas besoin de passer l'ID de l'invitation car elle a déjà été envoyée
            } elseif ($invitationRecue) {
                $etudiant->invitation = 'en_attente'; // Invitation envoyée mais pas encore reçue
                $invitation = Invitations::where('sender_id', $etudiant->id)
                    ->where('receiver_id', $user->id)
                    ->first(); // Récupérer l'ID de l'invitation reçue
            } else {
                $etudiant->invitation = 'inviter'; // Pas d'invitation envoyée ni reçue
                $invitation = null; // Pas besoin de passer l'ID de l'invitation car elle n'existe pas
            }

            // Passer l'ID de l'invitation à la vue
            $etudiant->invitation_id = $invitation ? $invitation->id : null;
        });

        return view('student.invitation', compact('etudiants_sans_binome'));
    }
    public function getEtudiantsByFiliere($id_filiere)
    {
        $etudiants = User::where('id_filiere', $id_filiere)->get();
    
        return response()->json($etudiants);
    }
}
