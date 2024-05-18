<?php

namespace App\Http\Controllers;

use App\Models\Filiere;
use App\Models\Jury;
use App\Models\Memoire;
use App\Models\Site;
use App\Models\Soutenance;
use Illuminate\Http\Request;

class SoutenaceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $memoires= Memoire::all();
        $filieres=Filiere::all();
        $jurys=Jury::all();
        $sites=Site::all();
        return view('soutenance.index',compact('memoires','filieres','jurys','sites'));
    }

    /**
     * Show the form for creating a new resource.
     */

    public function getMemoiresByFiliere($id_filiere)
    {
        $memoires = Memoire::where('id_filiere', $id_filiere)->get();
    
        return response()->json($memoires);
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Valider les données de la requête
        $request->validate([
            'id_memoire' => 'required|exists:memoires,id',
            'id_site' => 'required|exists:sites,id',
            'date_soutenance' => 'required|date',
            'heurs_soutenace' => 'required',
        ]);
    
        // Créer une nouvelle soutenance
        $soutenance = new Soutenance([
            'id_memoire' => $request->get('id_memoire'),
            'id_site' => $request->get('id_site'),
            'date_soutenance' => $request->get('date_soutenance'),
            'heurs_soutenace' => $request->get('heurs_soutenace'),
        ]);
    
        // Enregistrer la soutenance dans la base de données
        $soutenance->save();
    
        // Rediriger vers la page de liste des soutenances avec un message de succès
        return redirect()->route('soutenances.index')->with('success', 'Soutenance créée avec succès.');
    }

    public function agenda()
        {
            $filieres = Filiere::all();
            $soutenances = Soutenance::all();

            return view('soutenance.agenda', compact('filieres', 'soutenances'));
        }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
