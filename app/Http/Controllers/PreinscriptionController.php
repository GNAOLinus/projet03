<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PreinscriptionController extends Controller
{
    public function index()
    {
        return view('student.ajouteretudiant');
    }


public function store(Request $request)
{
    $request->validate([
        'fichier' => 'required|mimes:xlsx,xls,csv,ods',
        'role'=> 'required|integer',
    ]);

    // récupérer le type MIME du fichier
    $mimeType = File::mimeType($request->file('fichier'));

    // vérifier que le fichier est bien un fichier Excel
    if ($mimeType !== 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' &&
        $mimeType !== 'application/vnd.ms-excel' &&
        $mimeType !== 'text/csv' &&
        $mimeType !== 'application/vnd.oasis.opendocument.spreadsheet') {
        // renvoyer une erreur si le fichier n'est pas un fichier Excel
        return back()->withErrors('Le fichier téléchargé n\'est pas un fichier Excel valide.');
    }
    //pour les admins
    if ($request->role == "1") {
        if (File::exists(public_path('preinscriptionexcel/PreInscriptionsaAdmin.xlsx'))) {
            // Supprimer le fichier existant
            File::delete(public_path('preinscriptionexcel/PreInscriptionsaAdmin.xlsx'));
        }
        // déplacer le fichier dans le dossier public/preinscriptionexcel et le renommer en "preinscriptions"
        $request->file('fichier')->move(public_path('preinscriptionexcel'), 'PreInscriptionsaAdmin.xlsx');
        // renvoyer un message de succès
        return back()->with('success', 'Fichier de pré-inscription des Admin téléchargé avec success');
       //enseignant
    } elseif ($request->role == "3") {
        if (File::exists(public_path('preinscriptionexcel/PreInscriptionsEnseignant.xlsx'))) {
            // Supprimer le fichier existant
            File::delete(public_path('preinscriptionexcel/PreInscriptionsEnseignant.xlsx'));
        }
        // déplacer le fichier dans le dossier public/preinscriptionexcel et le renommer en "preinscriptions"
        $request->file('fichier')->move(public_path('preinscriptionexcel'), 'PreInscriptionsEnseignant.xlsx');
        // renvoyer un message de succès
        return back()->with('success', 'Fichier de pré-inscription des enseigants téléchargé avec success');
        //etudiant
    }else {
        
        if (File::exists(public_path('preinscriptionexcel/PreInscriptionsEtudiant.xlsx'))) {
            // Supprimer le fichier existant
            File::delete(public_path('preinscriptionexcel/PreInscriptionsEtudiant.xlsx'));
        }
        // déplacer le fichier dans le dossier public/preinscriptionexcel et le renommer en "preinscriptions"
        $request->file('fichier')->move(public_path('preinscriptionexcel'), 'PreInscriptionsEtudiant.xlsx');
        // renvoyer un message de succès
        return back()->with('success', 'Fichier de pré-inscription des etudiants téléchargé avec success');
    }

    
}

    
}
