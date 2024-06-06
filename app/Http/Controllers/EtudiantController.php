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

        // Récupérer les IDs des étudiants avec un binôme
        $etudiants_avec_binome = Binome::pluck('id_etudiant1')->merge(Binome::pluck('id_etudiant2'))->toArray();

        // Récupérer la liste des étudiants sans binôme avec l'ID du rôle égal à 2 et les paginer
        $etudiants_sans_binome = User::where('id_role', 2)
            ->whereNotIn('id', $etudiants_avec_binome)
            ->paginate(15);

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
            $invitation = null;

            if ($invitationEnvoyee) {
                // Si une invitation a été envoyée par l'utilisateur connecté
                $etudiant->invitation = 'envoyée'; // Marquer comme 'envoyée'
                $invitation = Invitations::where('sender_id', $user->id)
                    ->where('receiver_id', $etudiant->id)
                    ->first(); // Récupérer l'invitation envoyée par l'utilisateur connecté
            } elseif ($invitationRecue) {
                // Si une invitation a été reçue par l'utilisateur connecté
                $etudiant->invitation = 'en_attente'; // Marquer comme 'en attente'
                $invitation = Invitations::where('sender_id', $etudiant->id)
                    ->where('receiver_id', $user->id)
                    ->first(); // Récupérer l'invitation reçue par l'utilisateur connecté
            } else {
                // Si aucune invitation n'a été envoyée ni reçue
                $etudiant->invitation = 'inviter'; // Marquer comme 'inviter'
            }

            // Passer l'ID de l'invitation à la vue
            $etudiant->invitation_id = $invitation ? $invitation->id : null;
        });

        return view('student.invitation', compact('etudiants_sans_binome'));
    }

    

    public function getEtudiantsByFiliere($id_filiere)
    {
     // Récupérer les IDs des étudiants avec un binôme
        $etudiants_avec_binome = Binome::pluck('id_etudiant1')->merge(Binome::pluck('id_etudiant2'))->toArray();

     // Récupérer la liste des étudiants sans binôme avec l'ID du rôle égal à 2 et les paginer
        $etudiants = User::where('id_filiere', $id_filiere)->get()
        ->whereNotIn('id', $etudiants_avec_binome);
    
        return response()->json($etudiants);
    }   
}
