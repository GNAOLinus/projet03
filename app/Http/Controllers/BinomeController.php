<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Binome;
use App\Models\User;
use App\Models\Filiere;

class BinomeController extends Controller
{
    public function index()
    {
        $binomes = Binome::all();
        return view('student.binomes', compact('binomes'));
    }

    public function create()
    {
        $etudiants = User::all();
        $filieres = Filiere::all();
        return view('student.createbinome', compact('etudiants', 'filieres'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_etudiant1' => 'required|exists:users,id',
            'id_etudiant2' => 'required|exists:users,id',
            'id_filiere' => 'required|exists:filieres,id',
        ]);

        Binome::create([
            'id_etudiant1' => $request->id_etudiant1,
            'id_etudiant2' => $request->id_etudiant2,
            'id_filiere' => $request->id_filiere,
        ]);

        return redirect()->route('binomes.index')->with('success', 'Binôme créé avec succès.');
    }

    public function edit($id)
    {
        $binome = Binome::findOrFail($id);
        $etudiants = User::all();
        $filieres = Filiere::all();
        return view('student.editbinome', compact('binome', 'etudiants', 'filieres'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_etudiant1' => 'required|exists:users,id',
            'id_etudiant2' => 'required|exists:users,id',
            'id_filiere' => 'required|exists:filieres,id',
        ]);

        $binome = Binome::findOrFail($id);
        $binome->update([
            'id_etudiant1' => $request->id_etudiant1,
            'id_etudiant2' => $request->id_etudiant2,
            'id_filiere' => $request->id_filiere,
        ]);

        return redirect()->route('binomes.index')->with('success', 'Binôme mis à jour avec succès.');
    }

    public function destroy($id)
    {
        $binome = Binome::findOrFail($id);
        $binome->delete();

        return redirect()->route('binomes.index')->with('success', 'Binôme supprimé avec succès.');
    }
    public function getBinomes(Request $request)
{
    // Valider la requête
    $request->validate([
        'name' => 'required|string|max:255',
    ]);

    // Rechercher l'utilisateur
    $user = User::where('name', 'like', '%' . $request->name . '%')->first();

    if ($user) {
        // Rechercher les binômes
        $binomes = Binome::where('id_etudiant1', $user->id)
            ->orWhere('id_etudiant2', $user->id)
            ->get();

        if ($binomes->isEmpty()) {
            // Aucun binôme trouvé
            return redirect()->route('binomes.index')->withErrors(['Aucun binôme trouvé pour cet étudiant.']);
        }

        // Retourner la vue avec les binômes
        return view('student.binomes', compact('binomes'));
    } else {
        // Aucun utilisateur trouvé
        return redirect()->route('binomes.index')->withErrors(['Aucun étudiant trouvé avec ce nom.']);
    }
}

    
}
