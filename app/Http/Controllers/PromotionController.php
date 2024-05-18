<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Promotion; // Assurez-vous d'importer le modèle Promotion

class PromotionController extends Controller
{
    public function store(Request $request)
    {
        // Valider les données de la requête
        $validatedData = $request->validate([
            'promotion' => 'required',
        ]);

        // Créer une nouvelle promotion avec les données validées
        $promotion = Promotion::create($validatedData);

        // Rediriger avec un message de succès
        return redirect()->route('admin.dashboard')->with('success', 'Promotion créée avec succès');
    }
}
