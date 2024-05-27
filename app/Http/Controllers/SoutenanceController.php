<?php

namespace App\Http\Controllers;

use App\Models\Binome;
use App\Models\Filiere;
use App\Models\Jury;
use App\Models\Memoire;
use App\Models\Site;
use App\Models\Soutenance;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SoutenanceController extends Controller
{
    public function index()
    {
        $filieres = Filiere::all();
        $jurys = Jury::all();
        $sites = Site::all();
        $memoires = Memoire::all();

        return view('soutenance.index', compact('memoires', 'filieres', 'jurys', 'sites'));
    }

    public function getMemoiresByFiliere($id_filiere)
    {
        $memoires_programmer = Soutenance::pluck('id_memoire');
        $memoires = Memoire::where('id_filiere', $id_filiere)
                          ->whereNotIn('id', $memoires_programmer)
                          ->get();
        return response()->json($memoires);
    }

    public function getBinomesByMemoire($id_binome)
    {
        $binome = Binome::with('etudiant1', 'etudiant2')->find($id_binome);
        if (!$binome) {
            return response()->json(['error' => 'Binôme non trouvé'], 404);
        }
        return response()->json($binome);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_filiere' => 'required|exists:filieres,id',
            'id_jury' => 'required|exists:juries,id',
            'id_site' => 'required|exists:sites,id',
            'date_soutenance' => 'required|date',
            'heurs_soutenance' => 'required|date_format:H:i', // Format "HH:mm"
            'id_memoire' => 'required|exists:memoires,id',
        ]);
    
        try {
            // Création d'une nouvelle instance de Soutenance
            $soutenance = new Soutenance();
            $soutenance->id_memoire = $validated['id_memoire'];
            $soutenance->id_site = $validated['id_site'];
            $soutenance->id_jury = $validated['id_jury'];
            $soutenance->id_filiere = $validated['id_filiere'];
            $soutenance->date_soutenance = $validated['date_soutenance'];
            $soutenance->heurs_soutenance = $validated['heurs_soutenance'];
            $soutenance->save(); // Enregistrement de la soutenance
    
            return response()->json(['message' => 'Soutenance programmée avec succès!']);
        } catch (Exception $e) {
            // En cas d'erreur, enregistrement de l'erreur dans le fichier de logs et retour d'une réponse JSON avec le message d'erreur
            Log::error('Erreur lors de la programmation de la soutenance: ' . $e->getMessage());
            return response()->json(['error' => 'Une erreur est survenue. Veuillez réessayer plus tard.'.$e], 500);
        }
    }


    public function agenda()
    {
        $filieres = Filiere::all();
        $soutenances = Soutenance::all();

        return view('soutenance.agenda', compact('filieres', 'soutenances'));
    }
}
