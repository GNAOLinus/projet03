<?php

namespace App\Http\Controllers;

use App\Models\Binome;
use App\Models\Filiere;
use App\Models\Invitations;
use App\Models\Site;
use App\Models\User;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Afficher une liste des utilisateurs.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Récupérer tous les utilisateurs
        $users = User::all();

        // Passer les utilisateurs à la vue
        return view('admin.user', compact('users'));
    }
    public function profile(Request $Request)
    {
        $user = auth()->user();
        $etudiant=User::findorfail($Request->id);
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
        //return response()->json( $etudiant);
    return view('profile', compact('etudiant'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $user = auth()->user();
    
        $filieres = Filiere::where('filiere', 'like', '%' . $query . '%')->get();
    
        $sites = Site::where('site', 'like', '%' . $query . '%')
            ->orWhere('addresse', 'like', '%' . $query . '%')
            ->get();
    
        $etudiants = User::query()
            ->where('id_role', 2)
            ->with(['filiere', 'site'])
            ->where(function ($subQuery) use ($query, $filieres, $sites) {
                $subQuery->where('name', 'like', '%' . $query . '%');
    
                if ($filieres->count()) {
                    $subQuery->orWhereHas('filiere', function ($filiereQuery) use ($filieres) {
                        $filiereQuery->whereIn('id', $filieres->pluck('id'));
                    });
                }
    
                if ($sites->count()) {
                    $subQuery->orWhereHas('site', function ($siteQuery) use ($sites) {
                        $siteQuery->whereIn('id', $sites->pluck('id'));
                    });
                }
            })
            ->orderBy('created_at', 'desc')
            ->get(); // Récupérer tous les étudiants correspondants
    
        $etudiants_avec_binome = Binome::pluck('id_etudiant1')
            ->merge(Binome::pluck('id_etudiant2'));
    
        $etudiants_sans_binomev = $etudiants->reject(function ($etudiant) use ($etudiants_avec_binome) {
            return $etudiants_avec_binome->contains($etudiant->id);
        });
    
        $etudiants_sans_binomev->each(function ($etudiant) use ($user) {
            $invitationEnvoyee = Invitations::where('sender_id', $user->id)
                ->where('receiver_id', $etudiant->id)
                ->exists();
    
            $invitationRecue = Invitations::where('sender_id', $etudiant->id)
                ->where('receiver_id', $user->id)
                ->exists();
    
            if ($invitationEnvoyee) {
                $etudiant->invitation = 'envoyée';
                $invitation = null;
            } elseif ($invitationRecue) {
                $etudiant->invitation = 'en_attente';
                $invitation = Invitations::where('sender_id', $etudiant->id)
                    ->where('receiver_id', $user->id)
                    ->first();
            } else {
                $etudiant->invitation = 'inviter';
                $invitation = null;
            }
    
            $etudiant->invitation_id = $invitation ? $invitation->id : null;
        });
    
        // Convertir la collection en une pagination manuelle
        $page = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 10;
        $offset = ($page * $perPage) - $perPage;
    
        $etudiants_sans_binome= new LengthAwarePaginator(
            $etudiants_sans_binomev->slice($offset, $perPage),
            $etudiants_sans_binomev->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );
    
        return view('student.invitation', compact('etudiants_sans_binome'));
    }
    
    public function searchuser(Request $request)
    {
        // Récupère la chaîne de recherche de la requête
        $query = $request->input('query');
        $user = auth()->user(); // Récupère l'utilisateur authentifié
        
        // Récupère les filières dont le nom contient la chaîne de recherche
        $filieres = Filiere::where('filiere', 'like', '%' . $query . '%')->get();
        
        // Récupère les sites dont le nom ou l'adresse contiennent la chaîne de recherche
        $sites = Site::where('site', 'like', '%' . $query . '%')
            ->orWhere('addresse', 'like', '%' . $query . '%')
            ->get();
        
        // Requête pour récupérer les utilisteur
        $users = User::query()
            ->with(['filiere', 'site']) // Charge les relations 'filiere' et 'site'
            ->where(function ($subQuery) use ($query, $filieres, $sites) {
                // Filtre les utilisateurs dont le nom contient la chaîne de recherche
                $subQuery->where('name', 'like', '%' . $query . '%');
            
                // Si des filières sont sélectionnées, ajoute un filtre sur les filières
                if ($filieres->count()) {
                    $subQuery->orWhereHas('filiere', function ($filiereQuery) use ($filieres) {
                        $filiereQuery->whereIn('id', $filieres->pluck('id'));
                    });
                }
            
                // Si des sites sont sélectionnés, ajoute un filtre sur les sites
                if ($sites->count()) {
                    $subQuery->orWhereHas('site', function ($siteQuery) use ($sites) {
                        $siteQuery->whereIn('id', $sites->pluck('id'));
                    });
                }
            })
            ->orderBy('created_at', 'desc') // Trie les résultats par date de création décroissante
            ->get(); 
        
    
        return view('admin.user', compact('users'));
    }

      /**
     * Supprimer un utilisateur.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        // Récupérer l'utilisateur à supprimer
        $user = User::findOrFail($id);

        // Supprimer l'utilisateur de la base de données
        $user->delete();

        // Rediriger avec un message de succès
        return redirect()->route('admin.user')->with('success', 'Utilisateur supprimé avec succès.');
    }
}
