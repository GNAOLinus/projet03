<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Denonciation;
use App\Notifications\DenonciationSubmitted;
use App\Models\User;

class DenonciationController extends Controller
{
    public function index()
    {
        return view('denonciation');
    }
    public function store(Request $request)
    {
        // Validation des données du formulaire
        $validatedData = $request->validate([
            'email' => 'required|email',
            'name' => 'required|string|max:255',
            'denonciation' => 'required|string|in:plagiat,bugue,autre',
            'plainte' => 'required|string',
            'titre_memoire' => 'required_if:denonciation,plagiat|string|max:255',
            'preuve1' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'preuve2' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'preuve3' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Gestion des fichiers téléchargés $file = $request->file('preuve1');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $preuve1Path= $file->move(public_path('preuves/'), $validatedData['name'].preuve1);

            $file = $request->file('preuve2');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $preuve1Path= $file->move(public_path('preuves/'), $validatedData['name'].preuve2);
            
            $file = $request->file('preuve3');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $preuve1Path= $file->move(public_path('preuves/'), $validatedData['name'].preuve3);
            
     

        // Création d'une nouvelle dénonciation
        $denonciation = Denonciation::create([
            'email' => $validatedData['email'],
            'name' => $validatedData['name'],
            'denonciation' => $validatedData['denonciation'],
            'plainte' => $validatedData['plainte'],
            'titre_memoire' => $validatedData['denonciation'] == 'plagiat' ? $validatedData['titre_memoire'] : null,
            'preuve1' => $preuve1Path,
            'preuve2' => $preuve2Path,
            'preuve3' => $preuve3Path,
        ]);

        // Envoi de la notification
       /* $admin = User::wherein('id_role',[1,4])->get();
        $denonciation->email->notify(new DenonciationSubmitted($denonciation));
        $admin->notify(new Denonciation($denonciation));
        // Redirection après la soumission du formulaire*/
        return redirect()->back()->with('success', 'Votre dénonciation a été soumise avec succès.');
    }
}
