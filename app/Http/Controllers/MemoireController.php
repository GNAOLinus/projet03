<?php

namespace App\Http\Controllers;

use App\Models\Binome;
use App\Models\Filiere;
use App\Models\Memoire;
use App\Models\promotion;
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
        $promotions = promotion::OrderBy('created_at','desc')->get();
        return view('student.envoimemoire', compact('memoire', 'binome','promotions'));
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
                        $promotions = promotion::OrderBy('created_at','desc')->get();
        return view('student.envoimemoire', compact('memoire', 'binome','promotions'));
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
        // Trouver le mémoire correspondant
        $memoire = Memoire::findOrFail($id);
    
        // Validation des données reçues
        $request->validate([
            'appreciation' => 'required|in:excellent,tres_bien,bien,moyen,insuffisant',
            'note' => 'required|integer|min:0|max:20',
        ]);
    
        // Mise à jour du mémoire avec les nouvelles valeurs d'appréciation et de note
        $memoire->update($request->only('appreciation', 'note'));
    
        // Redirection vers la page précédente avec un message de succès
        return redirect()->back()->with('success', 'Appréciation enregistrée avec succès.');
    }
    

    public function previsualiser($memoire)
    {
        $memoire = Memoire::findOrFail($memoire);
        $soutenance = Soutenance::where('id_memoire', $memoire->id)->first();
        return view('student.previsualisation', compact('memoire','soutenance'));
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
            'id_promotion' => 'required|int',
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
            return redirect()->route('memoire.allmemoire',['page'=> 'yes'])->with('success', 'Les mémoires ont été publiés avec succès.');
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
    public function voire($page)
    {
        $memoires=Memoire::all();
        
        return view('student.indexmemoire', compact('memoires','page'));
    }

    public function MemoirePublier()
    {
        $memoires = Memoire::where('statut', 'public')->get();
        $filieres= Filiere::all();
        return view('admin.gestionmemoire', compact('memoires','filieres'));
    }
    

    protected function fillMemoireFromRequest(Memoire $memoire, Request $request)
    {
        $memoire->titre = $request->titre;
        $memoire->resume = $request->resume;
        $memoire->encadreur = $request->encadreur;
        $memoire->id_promotion = $request->id_promotion;
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
