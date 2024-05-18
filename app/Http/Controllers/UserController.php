<?php

namespace App\Http\Controllers;

use App\Models\User;
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
