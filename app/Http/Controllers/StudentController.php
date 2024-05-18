<?php

namespace App\Http\Controllers;

class StudentController extends Controller
{
    public function index()
    {
        // Votre logique pour afficher le tableau de bord de l'étudiant
        return to_route('memoire.index');
    }
}
