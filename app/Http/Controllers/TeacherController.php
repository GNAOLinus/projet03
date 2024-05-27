<?php

namespace App\Http\Controllers;

use App\Models\Jury;
use App\Models\Soutenance;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;

class TeacherController extends Controller
{
    public function index($id_edit)
    {
        $enseignant_id = Auth::id();

        // Trouver les jurys où l'enseignant est membre
        $jurys = Jury::where('id_enseignant1', $enseignant_id)
            ->orWhere('id_enseignant2', $enseignant_id)
            ->orWhere('id_enseignant3', $enseignant_id)
            ->get();

        if ($jurys->isNotEmpty()) {
            $filiere_ids = $jurys->pluck('id_filiere');
            $soutenances = Soutenance::whereIn('id_filiere', $filiere_ids)->get();
            $message = null;
        } else {
            $soutenances = collect();
            $message = "Pas de mémoire pour vous";
        }

        return view('teacher.dashboard', ['soutenances' => $soutenances, 'message' => $message, 'id_edit' => $id_edit]);
    }
    public function generateLink($role, $promotion)
    {
        $data = [
            'role' => $role,
            'promotion' => $promotion,
        ];
        $encryptedData = Crypt::encrypt($data);
        // Retourner une réponse JSON avec l'URL chiffrée
        return response()->json(['link' => url("http://localhost:8000/register/" . $encryptedData)]);
    }
    
}