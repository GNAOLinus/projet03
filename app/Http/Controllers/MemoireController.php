<?php

namespace App\Http\Controllers;

use App\Models\Binome;
use App\Models\Memoire;
use App\Models\Soutenance;
use Illuminate\Http\Request;

class MemoireController extends Controller
{
    public function index()
    {
        // Récupérer le binôme de l'utilisateur s'il en a un
        $binome = Binome::where('id_etudiant1', auth()->user()->id)
                        ->orWhere('id_etudiant2', auth()->user()->id)
                        ->first();
        
        // Vérifier si un binôme a été trouvé
        if ($binome) {
            // Récupérer le mémoire du binôme s'il existe
            $memoire = Memoire::where('id_binome', $binome->id)->first();
        } else {
            // Si aucun binôme n'a été trouvé, définir le mémoire sur null
            $memoire = null;
        }
        
        return view('student.dashboard', compact('memoire', 'binome'));
    }
    

    public function create()
    {
        // Récupérer le binôme de l'utilisateur
        $binome = Binome::where('id_etudiant1', auth()->user()->id)
                        ->orWhere('id_etudiant2', auth()->user()->id)
                        ->firstOrFail();
        
        // Passer le binôme à la vue avec un mémoire vide
        $memoire = null;
        
        return view('student.envoimemoire', compact('memoire', 'binome'));
    }

    public function store(Request $request)
    {
        $this->validateMemoire($request);

        $memoire = new Memoire();
        $this->fillMemoireFromRequest($memoire, $request);
        $this->uploadMemoireFile($memoire, $request);

        $memoire->save();

        return redirect()->route('memoire.index')->with('success', 'Memoire created successfully.');
    }

    public function edit(Memoire $memoire)
    {
        $binome = Binome::where('id_etudiant1', auth()->user()->id)
                        ->orWhere('id_etudiant2', auth()->user()->id)
                        ->firstOrFail();
        return view('student.envoimemoire', compact('memoire', 'binome'));
    }
    

    public function update(Request $request, Memoire $memoire)
    {
        $this->validateMemoire($request);

        $this->fillMemoireFromRequest($memoire, $request);
        $this->uploadMemoireFile($memoire, $request);

        $memoire->save();

        return redirect()->route('memoire.index')->with('success', 'Memoire updated successfully.');
    }

    public function destroy(Memoire $memoire)
    {
        $memoire->delete();
        return redirect()->route('memoire.index')->with('success', 'Memoire deleted successfully.');
    }

    public function updateAppreciation(Request $request, $id)
    {
        $memoire = Memoire::findOrFail($id);
        $request->validate([
            'appreciation' => 'required|in:excellent,tres_bien,bien,moyen,insuffisant',
            'note' => 'required|integer|min:0|max:20',
        ]);

        $memoire->update($request->only('appreciation', 'note'));

        return redirect()->back()->with('success', 'Appréciation enregistrée avec succès.');
    }

    public function previsualiser($memoire)
    {
        $memoire = Memoire::findOrFail($memoire);
        $soutenance = Soutenance::where('id_memoire', $memoire->id)->first();
        $memoire->soutenance = $soutenance;
        return view('student.previsualisation', compact('memoire'));
    }

    public function download($id)
    {
        $memoire = Memoire::findOrFail($id);
        $filePath = public_path('memoires/' . $memoire->fichier);

        if (!file_exists($filePath)) {
            abort(404);
        }

        return response()->download($filePath, $memoire->fichier);
    }

    protected function validateMemoire(Request $request)
    {
        $request->validate([
            'titre' => 'required|string',
            'resume' => 'required|string',
            'fichier' => 'required|file|max:10240', // Max file size is 10 MB
            'encadreur' => 'required|string',
            'promotion' => 'required|string',
            'id_filiere'=> 'required|int',
            'id_binome'=> 'int',
            'statut'=>'string',
        ]);
    }
    public function publication(Request $request)
    {
        // Vérifier si le formulaire a été soumis
        if ($request->isMethod('post')) {
            // Récupérer les IDs des mémoires à publier depuis le formulaire
            $memoireIds = $request->input('memoire', []);

            // Mettre à jour le statut des mémoires sélectionnées en public
            Memoire::whereIn('id', $memoireIds)->update(['statut' => 'public']);
            
            // Rediriger avec un message de succès ou afficher une vue de succès
            return redirect()->route('memoire.allmemoire')->with('success', 'Les mémoires ont été publiés avec succès.');
        } else {
            // Rediriger avec un message d'erreur ou afficher une vue d'erreur si le formulaire n'est pas soumis
            return redirect()->back()->with('error', 'Une erreur s\'est produite. Veuillez réessayer.');
        }
    }
    public function show(Request $request)
    {
        $memoires=Memoire::all();
        return view('student.indexmemoire', compact('memoires'));
    }


    protected function fillMemoireFromRequest(Memoire $memoire, Request $request)
    {
        $memoire->titre = $request->titre;
        $memoire->resume = $request->resume;
        $memoire->encadreur = $request->encadreur;
        $memoire->promotion = $request->promotion;
        $memoire->id_filiere = $request->id_filiere;
        $memoire->id_binome = $request->id_binome;
    }

    protected function uploadMemoireFile(Memoire $memoire, Request $request)
    {
        if ($request->hasFile('fichier')) {
            $file = $request->file('fichier');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('memoires/'), $filename);
            $memoire->fichier = $filename;
        }
    }
    
}
