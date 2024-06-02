<?php

namespace App\Http\Controllers;

use App\Models\Binome;
use App\Models\Invitations;
use App\Models\User;
use App\Notifications\ConfirmationInvitationNotification;
use App\Notifications\InvitationReçuNotification;
use Illuminate\Http\Request;

class InvitationController extends Controller
{
    public function sendInvitation(Request $request)
{
    // Valider la requête
    $request->validate([
        'etudiant_id' => 'required|integer|exists:users,id',
    ]);

    // Vérifier si l'utilisateur actuel est déjà dans un binôme
    $senderBinome = Binome::where(function ($query) {
        $query->where('id_etudiant1', auth()->id())
              ->orWhere('id_etudiant2', auth()->id());
    })->exists();

    if ($senderBinome) {
        return back()->with('error', 'Vous êtes déjà dans un binôme.');
    }

    // Vérifier si le destinataire est déjà dans un binôme
    $recipientBinome = Binome::where(function ($query) use ($request) {
        $query->where('id_etudiant1', $request->input('etudiant_id'))
              ->orWhere('id_etudiant2', $request->input('etudiant_id'));
    })->exists();

    if ($recipientBinome) {
        return back()->with('error', 'L\'étudiant destinataire est déjà dans un binôme.');
    }

    // Vérifier si l'expéditeur a déjà envoyé une invitation au destinataire
    $existingInvitation = Invitations::where('sender_id', auth()->id())
        ->where('receiver_id', $request->input('etudiant_id'))
        ->exists();

    if ($existingInvitation) {
        return back()->with('error', 'Vous avez déjà envoyé une invitation à cet étudiant.');
    }

    // Créer une nouvelle invitation
    Invitations::create([
        'sender_id' => auth()->id(),
        'receiver_id' => $request->input('etudiant_id'),
        'status' => 'en_attente',
    ]);

    // Trouver l'utilisateur destinataire et envoyer une notification
    $recipient = User::findOrFail($request->input('etudiant_id'));
    $sender = auth()->user(); // Récupère l'utilisateur actuellement authentifié
    $recipient->notify(new InvitationReçuNotification($sender));

    // Rediriger avec un message de succès
    return redirect()->route('etudiants.index')->with('success', 'Invitation envoyée avec succès.');
}


    public function confirmInvitation(Request $request)
    {
        // Récupérer l'identifiant de l'invitation à partir de la requête
        $invitationId = $request->input('invitation_id');
        
        // Trouver l'invitation correspondante dans la base de données
        $invitation = Invitations::findOrFail($invitationId);
       
        // Mettre à jour le statut de l'invitation
        $invitation->update(['status' => 'confirme']);

        // Créer un enregistrement binôme
        $filiere = auth()->user()->id_filiere;
        Binome::create([
            'id_etudiant1' => $invitation->sender_id,
            'id_etudiant2' => $invitation->receiver_id,
            'id_filiere' => $filiere,
        ]);
        // Trouver l'utilisateur destinataire et envoyer une notification
        $recipient = User::findOrFail($invitation->sender_id); // Récupère l'utilisateur correspondant à l'ID de l'expéditeur
        $sender = auth()->user(); // Récupère l'utilisateur actuellement authentifié
        $recipient->notify(new ConfirmationInvitationNotification($sender));
        // Rediriger avec un message de succès
        return redirect()->route('student.dashboard');
    }

    public function destroy(Invitations $invitation)
    {
        //$invitation->delete();
    return response()->json($invitation);
        //return redirect()->route('etudiants.index')->with('success', 'filiere supprimé avec succès');
    }
    
}
