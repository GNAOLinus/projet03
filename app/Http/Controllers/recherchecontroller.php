<?php
namespace App\Http\Controllers;

use App\Models\Filiere;
use App\Models\Memoire;
use App\Models\promotion;
use App\Models\Site;
use App\Models\TypeDiplome;
use Illuminate\Http\Request;

class RechercheController extends Controller
{
    public function show()
    {
        $filieres = Filiere::all();
        $memoires = Memoire::orderBy('created_at', 'desc')->paginate(25);
        $promotions = promotion::all();
        $diplomes= TypeDiplome::all();
        return view('filtre', compact('memoires', 'filieres', 'promotions','diplomes'));
    }

    public function filtre(Request $request)
    {
        // Récupérer les données du formulaire
        $titre = $request->input('titre');
        $auteur = $request->input('auteur');
        $promotion = $request->input('id_promotion');
        $filiere = $request->input('filiere');
        $diplome= $request->input('diplome');
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
            $query->where('id_promotion', $promotion);
        }

        if ($filiere) {
            $query->where('id_filiere', $filiere);
        }
        if ($diplome) {
            $query->where('id_diplome', $diplome);
        }

        // Exécuter la requête
        $memoires = $query->orderBy('created_at', 'desc')->paginate(25);
        $filieres = Filiere::all();
        $promotions = promotion::all();
        $diplomes= TypeDiplome::all();
        // Retourner la vue avec les résultats de la recherche
        return view('filtre', compact('memoires', 'filieres', 'promotions','diplomes'));
    }
    public function search(Request $request)
    {
        $query = $request->input('query');
        $filiere = Filiere::where('filiere','like', '%' . $query . '%')->pluck('id');
        $site = Site::where('site','like', '%' . $query . '%')->orWhere('addresse', 'like', '%' . $query . '%')->pluck('id');

        $memoires = Memoire::query()
            ->where('titre', 'like', '%' . $query . '%')
            ->orWhere('encadreur', 'like', '%' . $query . '%')
            ->orWhereHas('binome.etudiant1', function($q) use ($query) {
                $q->where('name', 'like', '%' . $query . '%');
            })
            ->orWhereHas('binome.etudiant2', function($q) use ($query) {
                $q->where('name', 'like', '%' . $query . '%');
            })
            ->orWhere('id_promotion', 'like', '%' . $query . '%')
            ->orWhere('note', 'like', '%' . $query . '%')
            //->orwhere('id_filiere', $filiere)
            //->orwhere('id_site', $site)
            ->orderBy('created_at', 'desc')
            ->paginate(24);

        $filieres = Filiere::all();
        $promotions = promotion::all();
        $diplomes= TypeDiplome::all();

        return view('filtre', compact('memoires', 'filieres', 'promotions','diplomes'));
    }
}

