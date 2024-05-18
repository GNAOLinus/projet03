<?php
namespace App\Http\Controllers;

use App\Models\Filiere;
use App\Models\Memoire;
use Illuminate\Http\Request;

class RechercheController extends Controller
{
    public function show()
    {
        $filieres = Filiere::all();
        $memoires = Memoire::orderBy('created_at', 'desc')->paginate(25);

        // Assuming you have a way to get distinct promotions from your memoires
        $promotions = Memoire::select('promotion')->distinct()->get()->pluck('promotion');

        return view('filtre', compact('memoires', 'filieres', 'promotions'));
    }

    public function filtre(Request $request)
    {
        // Récupérer les données du formulaire
        $titre = $request->input('titre');
        $auteur = $request->input('auteur');
        $promotion = $request->input('promotion');
        $filiere = $request->input('filiere');

        // Construire la requête en fonction des paramètres fournis
        $query = Memoire::query();

        if ($titre) {
            $query->where('titre', 'like', '%' . $titre . '%');
        }

        if ($auteur) {
            $query->where(function($query) use ($auteur) {
                $query->where('encadreur', 'like', '%' . $auteur . '%')
                    ->orWhereHas('binome.etudiant1', function($query) use ($auteur) {
                        $query->where('name', 'like', '%' . $auteur . '%');
                    })
                    ->orWhereHas('binome.etudiant2', function($query) use ($auteur) {
                        $query->where('name', 'like', '%' . $auteur . '%');
                    });
            });
        }

        if ($promotion) {
            $query->where('promotion', $promotion);
        }

        if ($filiere) {
            $query->where('filiere', $filiere);
        }

        // Exécuter la requête
        $memoires = $query->orderBy('created_at', 'desc')->paginate(25);
        $filieres = Filiere::all();
        $promotions = Memoire::select('promotion')->distinct()->get()->pluck('promotion');

        // Retourner la vue avec les résultats de la recherche
        return view('filtre', compact('memoires', 'filieres', 'promotions'));
    }
    public function search(Request $request)
    {
        $query = $request->input('query');

        $memoires = Memoire::query()
            ->where('titre', 'like', '%' . $query . '%')
            ->orWhere('encadreur', 'like', '%' . $query . '%')
            ->orWhereHas('binome.etudiant1', function($q) use ($query) {
                $q->where('name', 'like', '%' . $query . '%');
            })
            ->orWhereHas('binome.etudiant2', function($q) use ($query) {
                $q->where('name', 'like', '%' . $query . '%');
            })
            ->orWhere('promotion', 'like', '%' . $query . '%')
            ->orWhere('note', 'like', '%' . $query . '%')
            ->orderBy('created_at', 'desc')
            ->paginate(25);

        $filieres = Filiere::all();
        $promotions = Memoire::distinct()->pluck('promotion');

        return view('filtre', compact('memoires', 'filieres', 'promotions'));
    }
}

