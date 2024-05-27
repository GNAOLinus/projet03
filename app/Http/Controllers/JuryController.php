<?php

namespace App\Http\Controllers;

use App\Models\Filiere;
use App\Models\Jury;
use App\Models\User;
use Illuminate\Http\Request;

class JuryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $juries = Jury::all();
        $filieres = Filiere::all();
        return view('teacher.jurys', compact('juries','filieres'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $filieres =Filiere::all();
        $enseignants = User::where('id_role', '3')->get();
        return view('teacher.createjury', compact('enseignants','filieres'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation des données du formulaire
        $request->validate([
            'id_enseignant1' => 'required|exists:users,id',
            'id_enseignant2' => 'required|exists:users,id',
            'id_enseignant3' => 'required|exists:users,id',
            'id_filiere' => 'required|exists:filieres,id',
        ]);

        // Création d'un nouveau jury
        $jury = new Jury();
        $jury->id_enseignant1 = $request->id_enseignant1;
        $jury->id_enseignant2 = $request->id_enseignant2;
        $jury->id_enseignant3 = $request->id_enseignant3;
        $jury->id_filiere= $request->id_filiere;
        $jury->save();

        return redirect()->route('juries.index')->with('success', 'Jury créé avec succès');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $jury = Jury::findOrFail($id);
        $filieres = Filiere::all();
        $enseignants = User::where('id_role', '3')->get();
        return view('teacher.createjury', compact('jury', 'filieres', 'enseignants'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validation des données du formulaire
        $request->validate([
            'id_enseignant1' => 'required|exists:users,id',
            'id_enseignant2' => 'required|exists:users,id',
            'id_enseignant3' => 'required|exists:users,id',
            'id_filiere' => 'required|exists:filieres,id',
        ]);

        // Mise à jour des informations du jury
        $jury = Jury::findOrFail($id);
        $jury->id_enseignant1 = $request->id_enseignant1;
        $jury->id_enseignant2 = $request->id_enseignant2;
        $jury->id_enseignant3 = $request->id_enseignant3;
        $jury->id_filiere = $request->id_filiere;
        $jury->save();

        return redirect()->route('juries.index')->with('success', 'Jury mis à jour avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jury $jury)
    {
        $jury->delete();
        return redirect()->route('juries.index')->with('success', 'Jury supprimé avec succès');
    }
}
