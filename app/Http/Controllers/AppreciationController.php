<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appreciation; // Assurez-vous d'importer le modèle d'appréciation si ce n'est pas déjà fait

class AppreciationController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Valider la demande
        $request->validate([
            'id_memoire' => 'required', // Assurez-vous que l'ID de la mémoire est fourni
            'appreciation' => 'required|in:excellent,tres_bien,bien,moyen,insuffisant',
            'note' => 'required|integer|min:0|max:20', // Assurez-vous que la note est un nombre entier entre 0 et 20
        ]);

        // Créer une nouvelle appréciation
        $appreciation = new Appreciation();
        $appreciation->id_memoire = $request->id_memoire;
        $appreciation->appreciation = $request->appreciation;
        $appreciation->note = $request->note;
        $appreciation->save();

        // Redirection avec un message de succès
        return redirect()->back()->with('success', 'Appréciation enregistrée avec succès.');
    }
}
