<?php

namespace App\Http\Controllers;

use App\Models\TypeDiplome;
use App\Http\Requests\StoreTypeDiplomeRequest;
use App\Http\Requests\UpdateTypeDiplomeRequest;

class TypeDiplomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $diplomes= TypeDiplome::all();
        return view('admin.diplome',compact('diplome'));
    }

  

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTypeDiplomeRequest $request)
    {
        $validatedData = $request->validate([
            'diplome' => 'required',
        ]);
    
        $filiere = TypeDiplome::create($validatedData);
    
        return redirect()->route('diplome.index')->with('success', 'filiere créé avec succès');
    }

    /**
     * Display the specified resource.
     */
    public function show(TypeDiplome $typeDiplome)
    {
        return view('admin.diplome',compact('diplome'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TypeDiplome $typeDiplome)
    {
        return view('admin.diplome',compact('diplome'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTypeDiplomeRequest $request, TypeDiplome $typeDiplome)
    {
        $validatedData = $request->validate([
            'filiere' => 'required',
        ]);
    
        $typeDiplome->update($validatedData);
    
        return to_route('diplome.index')->with('success', 'filiere mis à jour avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TypeDiplome $typeDiplome)
    {
        $typeDiplome->delete();
    
        return to_route('filieres.index')->with('success', 'filiere supprimé avec succès');
    }
}
