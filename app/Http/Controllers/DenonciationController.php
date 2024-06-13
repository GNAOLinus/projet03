<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Denonciation;
use App\Notifications\DenonciationSubmitted;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\DenonciationTraitee;
use App\Notifications\DenonciationTraiteeNotification;

class DenonciationController extends Controller
{
   

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $denonciations = Denonciation::all();

        return view('plainte.allplainte', compact('denonciations'));
    }
    public function create()
    {
        return view('plainte.index');
    }

 

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    // Validation des données du formulaire
    $validatedData = $request->validate([
        'email' => 'required|email',
        'name' => 'required|string|max:255',
        'denonciation' => 'required|string|in:plagiat,bugue,autre',
        'plainte' => 'required|string',
        'titre_memoire' => 'nullable|required_if:denonciation,plagiat|string|max:255',
        'preuve1' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        'preuve2' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        'preuve3' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
    ]);
    

    // Gestion des fichiers téléchargés
    $preuve1Path = null;
    $preuve2Path = null;
    $preuve3Path = null;

    if ($request->hasFile('preuve1')) {
        $file = $request->file('preuve1');
        $filename = time() . '_preuve1.' . $file->getClientOriginalExtension();
        $preuve1Path = $file->move(public_path('preuves/'), $filename);
    }

    if ($request->hasFile('preuve2')) {
        $file = $request->file('preuve2');
        $filename = time() . '_preuve2.' . $file->getClientOriginalExtension();
        $preuve2Path = $file->move(public_path('preuves/'), $filename);
    }

    if ($request->hasFile('preuve3')) {
        $file = $request->file('preuve3');
        $filename = time() . '_preuve3.' . $file->getClientOriginalExtension();
        $preuve3Path = $file->move(public_path('preuves/'), $filename);
    }

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
    $adminUsers = User::whereIn('id_role', [1, 4])->get();
    foreach ($adminUsers as $admin) {
        $admin->notify(new DenonciationSubmitted($denonciation));
    }


    // Redirection après la soumission du formulaire
    return redirect()->back()->with('success', 'Votre dénonciation a été soumise avec succès.');
}


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $denonciation=Denonciation::findorfail($id);

        return view('plainte.show', compact('denonciation'));
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
    public function update(Request $request, $id)
    {
        $denonciation = Denonciation::findOrFail($id);
        
        // Validate the request
        $request->validate([
            'statut' => 'required|in:en_attente,traitee',
        ]);
        
        // Update the status
        $denonciation->statut = $request->statut;
        $denonciation->save();
    
        // Send email notification if the status is 'traitee'
        if ($request->statut == 'traitee') {
            //$denonciation->email->notify(new DenonciationTraiteeNotification($denonciation));
        }
        
        return redirect()->back()->with('success', 'Statut de la dénonciation mis à jour avec succès.');

    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
