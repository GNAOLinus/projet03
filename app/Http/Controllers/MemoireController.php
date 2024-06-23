<?php

namespace App\Http\Controllers;

use App\Models\Binome;
use App\Http\Controllers\ComparaisonController;
use App\Models\Evaluations;
use App\Models\Filiere;
use App\Models\Memoire;
use App\Models\promotion;
use App\Models\Soutenance;
use App\Models\TypeDiplome;
use App\Models\User;
use App\Notifications\EnvoiMemoireNotification;
use App\Notifications\ModifMemoireNotification;
use Illuminate\Http\Request;
use App\Jobs\CompareMemoireJob;

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
        $porgrammer=Soutenance::where('binome',$binome);
        
        return view('student.dashboard', compact('memoire', 'binome','porgrammer'));
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
        //lance une comparaisont des memoire 
         CompareMemoireJob::dispatch($memoire->id);
        
       $binomeId = $request->input('id_binome');


       if ($binomeId) {
           $binome = Binome::findOrFail($binomeId);
       
           $etudiant1 = User::findOrFail($binome->id_etudiant1);
           $etudiant2 = User::findOrFail($binome->id_etudiant2);
       
           $sender = auth()->user();
       
           if ($etudiant1->id === $sender->id) {
               $etudiant2->notify(new EnvoiMemoireNotification($sender));
           } else {
               $etudiant1->notify(new EnvoiMemoireNotification($sender));
           }
       } else {
           return redirect()->route('memoire.index')->with('error', 'L\'étudiant destinataire n\'a pas été spécifié.');
       }
       
       
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
    
/* la fonction se base sur les fonction de validation des donnée , de liaison des donné au champ des table  
et a la fonction de sauvegarde des document */
    public function update(Request $request, Memoire $memoire)
    {
        $this->validateMemoire($request);

        $this->fillMemoireFromRequest($memoire, $request);
        $this->uploadMemoireFile($memoire, $request);

        $memoire->save();
        $binomeId = $request->input('id_binome');
        if ($binomeId) {
            $binome = Binome::findOrFail($binomeId);
        
            $etudiant1 = User::findOrFail($binome->id_etudiant1);
            $etudiant2 = User::findOrFail($binome->id_etudiant2);
        
            $sender = auth()->user();
        
            if ($etudiant1->id === $sender->id) {
                $etudiant2->notify(new ModifMemoireNotification($sender));
            } else {
                $etudiant1->notify(new ModifMemoireNotification($sender));
            }
        } else {
            return redirect()->route('memoire.index')->with('error', 'L\'étudiant destinataire n\'a pas été spécifié.');
        }

        return redirect()->route('memoire.index')->with('success', 'Memoire updated successfully.');
    }

    public function destroy(Memoire $memoire)
    {
        $memoire->delete();
        return redirect()->route('memoire.index')->with('success', 'Memoire deleted successfully.');
    }
    
//elle permet de mettre ajours les appréciation donner par les jury
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
        return redirect()->route('teacher.dashboard', ['id_edit' => 'null'])->with('success', 'Appréciation enregistrée avec succès.');
    }
    
//grace a cett fonction on peut voir les memoire et avoir plus de détail avant le télchagement
    public function previsualiser($memoire)
    {
        $memoire = Memoire::findOrFail($memoire);
        $soutenance = Soutenance::where('id_memoire', $memoire->id)->first();
        return view('student.previsualisation', compact('memoire','soutenance'));
    }

// c'est la fonction qui permet au visiteur de télécharger les documment
    public function download($id)
    {
        $memoire = Memoire::findOrFail($id);
        $filePath = public_path('memoires/' . $memoire->fichier);

        if (!file_exists($filePath)) {
            abort(404);
        }

        return response()->download($filePath, $memoire->fichier);
    }

// elle permet de valider les donnée envoyer depuis le formulaire
    protected function validateMemoire(Request $request)
    {
        $request->validate([
            'titre' => 'required|string',
            'resume' => 'required|string',
            'fichier' => 'required|file|max:10240', // Max file size is 10 MB
            'encadreur' => 'required|string',
            'id_promotion' => 'required|int',
            'id_filiere'=> 'required|int',
            'id_diplome'=> 'required|int',
            'id_binome'=> 'required|int',
            'statut'=>'string',
        ]);
    }
    // fonction pour la publication des memoire elle change le statu à public
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
    // fonction pour retirer le memoire de la baque de memoire
    public function retirer(Request $request)
    {
        // Vérifier si le formulaire a été soumis
        if ($request->isMethod('post')) {
            // Récupérer l'ID du mémoire à retirer depuis le formulaire
            $memoireId = $request->input('id');
    
            // Trouver le mémoire correspondant
            $memoire = Memoire::find($memoireId);
            if ($memoire) {
                // Mettre à jour le statut du mémoire en null
                $memoire->statut = null;
                $memoire->save();
    
                // Rediriger avec un message de succès ou afficher une vue de succès
                return redirect()->route('memoire.allmemoire', ['page' => 'yes'])->with('success', 'Le mémoire a été retiré avec succès.');
            } else {
                // Rediriger avec un message d'erreur ou afficher une vue d'erreur si le mémoire n'est pas trouvé
                return redirect()->back()->with('error', 'Mémoire non trouvé.');
            }
        } else {
            // Rediriger avec un message d'erreur ou afficher une vue d'erreur si le formulaire n'est pas soumis
            return redirect()->back()->with('error', 'Une erreur s\'est produite. Veuillez réessayer.');
        }
    }
    
    // elle permet de voir tous les memoire
    public function show(Request $request)
    {
        $memoires=Memoire::all();
        return view('student.indexmemoire', compact('memoires'));
    }


    public function voire($page)
    {
        $memoires=Memoire::all();
        $filieres=Filiere::all();
        $promotions=promotion::all();
        $diplomes=TypeDiplome::all();
        
        return view('student.indexmemoire', compact('memoires','page','promotions','filieres','diplomes'));
    }
//elle permet de voir les memoires publier c'est a dire ceux qui ont la champ statut a public
    public function MemoirePublier()
    {
        $memoires = Memoire::where('statut', 'public')->get();
        $filieres= Filiere::all();
        return view('admin.gestionmemoire', compact('memoires','filieres'));
    }
    
    // elle permet de relier les champs de la base deonner a champs du formulaire

    protected function fillMemoireFromRequest(Memoire $memoire, Request $request)
    {
        $memoire->titre = $request->titre;
        $memoire->resume = $request->resume;
        $memoire->encadreur = $request->encadreur;
        $memoire->id_promotion = $request->id_promotion;
        $memoire->id_diplome = $request->id_diplome;
        $memoire->id_filiere = $request->id_filiere;
        $memoire->id_binome = $request->id_binome;
    }
// elle permet de stocker les memoire dans le dossier public/memoires
    protected function uploadMemoireFile(Memoire $memoire, Request $request)
    {
        $noms= auth()->user()->name ;
        if ($request->hasFile('fichier')) {
            $file = $request->file('fichier');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('memoires/'), 'Memoire'.$noms);
            $memoire->fichier = $filename;
        }
    }

    public function compare($id)
{
    try {
        // Instancier le MemoireController
        $memoireController = new GeminiComparaisonController();

        // Appeler la méthode compare() du MemoireController
        $results = $memoireController->comparerMemoires($id);

        // Vérifier si les résultats sont vides
        if (empty($results)) {
            return response()->json(['message' => 'Aucun résultat trouvé pour la comparaison.'], 404);
        }

        // Calculer la moyenne des pourcentages de similarité
        $totalSimilarity = array_sum(array_column($results, 'similarity'));
        $averageSimilarity = $totalSimilarity / count($results);

        // Trier les résultats par pourcentage de similarité décroissant
        usort($results, function($a, $b) {
            return $b['similarity'] - $a['similarity'];
        });

        // Récupérer les ID des cinq mémoires ayant le pourcentage de similarité le plus élevé
        $topMemoires = array_slice($results, 0, 5);

        // Préparer un tableau pour stocker les informations d'ID et de pourcentage
        $memoireDetails = [];
        foreach ($topMemoires as $memoire) {
            $memoireDetails[] = $memoire['memoire_id'] . ' (' . round($memoire['similarity'], 2) . '%)';
        }

        // Enregistrer l'évaluation dans la base de données
        $evaluation = new Evaluations([
            'id_memoire' => $id,
            'data' => json_encode([
                'topSimilarities' => array_column($topMemoires, 'similarity'),
                'top_memoire_ids' => array_column($topMemoires, 'memoire_id'),
                'results' => $results
            ]),
        ]);
        $evaluation->save();

        // Retourner la réponse avec les résultats et la moyenne de similarité
        return response()->json([
            'message' => 'Comparaison réussie',
            'averageSimilarity' => round($averageSimilarity, 2),
            'topMemoires' => $memoireDetails
        ]);
        
    } catch (\Exception $e) {
        // Gérer les exceptions et afficher un message d'erreur
        return response()->json(['error' => 'Une erreur est survenue : ' . $e->getMessage()], 500);
    }
}
   
}
