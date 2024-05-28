<?php

namespace App\Http\Controllers;

use App\Models\InfoEtudiant;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

class PreinscriptionController extends Controller
{
    public function index()
    {
        return view('student.ajouteretudiant');
    }

    public function store(Request $request)
    {
        

        return back()->with('success', 'Fichier téléchargé et données sauvegardées');
    }
    
}
