<?php

namespace App\Http\Controllers;

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
        return view('teacher.jurys', compact('juries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $enseignants = User::where('id_role', '3')->get();
        return view('teacher.createjury', compact('enseignants'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation des données du formulaire
        $request->validate([
            'enseignant1' => 'required|exists:users,id',
            'enseignant2' => 'required|exists:users,id',
            'enseignant3' => 'required|exists:users,id',
        ]);

        // Création d'un nouveau jury
        $jury = new Jury();
        $jury->id_enseignant1 = $request->enseignant1;
        $jury->id_enseignant2 = $request->enseignant2;
        $jury->id_enseignant3 = $request->enseignant3;
        $jury->save();

        return redirect()->route('juries.index')->with('success', 'Jury créé avec succès');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Jury $jury)
    {
        $enseignants = User::where('role', 'enseignant')->get();
        return view('teacher.createjury', compact('jury', 'enseignants'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Jury $jury)
    {
        // Validation des données du formulaire
        $request->validate([
            'enseignant1' => 'required|exists:users,id',
            'enseignant2' => 'required|exists:users,id',
            'enseignant3' => 'required|exists:users,id',
        ]);

        // Mise à jour des informations du jury
        $jury->id_enseignant1 = $request->enseignant1;
        $jury->id_enseignant2 = $request->enseignant2;
        $jury->id_enseignant3 = $request->enseignant3;
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
