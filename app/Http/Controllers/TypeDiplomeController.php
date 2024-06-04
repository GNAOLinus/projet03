<?php

namespace App\Http\Controllers;

use App\Models\TypeDiplome;
use App\Http\Requests\StoreTypeDiplomeRequest;
use App\Http\Requests\UpdateTypeDiplomeRequest;
use Illuminate\Http\Request;

class TypeDiplomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $diplome='no';
        $diplomes= TypeDiplome::all();
        return view('admin.diplome',compact('diplomes','diplome'));
    }

  

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'diplome' => 'required',
            'description' => 'required',
        ]);
    
         TypeDiplome::create($validatedData);
    
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
    public function edit(TypeDiplome $diplome)
    {
        $diplomes= TypeDiplome::all();
        return view('admin.diplome',compact('diplome','diplomes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TypeDiplome $diplome)
    {
        $validatedData = $request->validate([
            'diplome' => 'required',
            'description' => 'required',
        ]);
    
        $diplome->update($validatedData);
    
        return to_route('diplome.index')->with('success', 'filiere mis à jour avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TypeDiplome $diplome)
    {
        $diplome->delete();
    
        return to_route('diplome.index')->with('success', 'filiere supprimé avec succès');
    }
}
