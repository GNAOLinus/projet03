<?php

namespace App\Http\Controllers;

use App\Models\Evaluations;
use App\Models\Memoire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EvaluationContoller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Récupérer toutes les évaluations
        $evaluations = Evaluations::all();

        // Charger la vue et passer les données
        return view('evaluation.index', ['evaluations' => $evaluations]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function document(Request $request)
    {
        $memoire = Memoire::findOrFail($request->id);
        $filePath = public_path('memoires/' . $memoire->fichier);

        if (!file_exists($filePath)) {
            abort(404);
        }

        return response()->download($filePath, $memoire->fichier);
    }
    
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
