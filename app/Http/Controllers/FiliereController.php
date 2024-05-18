<?php

namespace App\Http\Controllers;

use App\Models\Filiere;
use Illuminate\Http\Request;

class FiliereController extends Controller
{
    public function index()
    {
        $filieres = Filiere::all();
        return view('admin.filieres', compact('filieres'));
    }
    
    public function create()
    {
        $filiere = new filiere();
        return view('admin.createfilieres', compact('filiere'));
    }
    
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'filiere' => 'required',
        ]);
    
        $filiere = filiere::create($validatedData);
    
        return redirect()->route('filieres.index')->with('success', 'filiere créé avec succès');
    }
    
    public function edit(filiere $filiere)
    {
        return view('admin.createfilieres', compact('filiere'));
    }
    
    public function update(Request $request, filiere $filiere)
    {
        $validatedData = $request->validate([
            'filiere' => 'required',
            'addresse' => 'required',
        ]);
    
        $filiere->update($validatedData);
    
        return to_route('filieres.index')->with('success', 'filiere mis à jour avec succès');
    }
    
    public function destroy(filiere $filiere)
    {
        $filiere->delete();
    
        return to_route('filieres.index')->with('success', 'filiere supprimé avec succès');
    }
}
