<?php

namespace App\Http\Controllers;

use App\Models\Binome;
use App\Models\evaluation;
use App\Models\Filiere;
use App\Models\Memoire;
use App\Models\promotion;
use App\Models\Soutenance;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

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
        // Appeler la fonction compare avec le mémoire nouvellement créé
        $this->compare($memoire);
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

    function compareMemoires($titre1, $resume1, $titre2, $resume2) {
        $apiKey = 'YOUR_OPENAI_API_KEY'; // Remplacez par votre clé API OpenAI
        $client = new Client();
    
        $query = "Compare these two theses based on their titles and summaries. Score their similarity on a scale from 0 to 10, where 0 means completely different and 10 means almost identical. Consider the following aspects: semantic meaning, main themes, concepts and ideas, vocabulary and terminology, and structure and organization. Provide a brief explanation for the score.
        Thesis 1:
        Title: $titre1
        Summary: $resume1
    
        Thesis 2:
        Title: $titre2
        Summary: $resume2";
    
        $response = $client->post('https://api.openai.com/v1/engines/davinci-codex/completions', [
            'headers' => [
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'prompt' => $query,
                'max_tokens' => 150,
                'temperature' => 0.5,
            ],
        ]);
    
        $body = $response->getBody();
        $data = json_decode($body, true);
    
        $resultText = $data['choices'][0]['text'];
    
        // Analyser le texte pour extraire la note et la justification
        preg_match('/Similarity Score: (\d+)\/10/', $resultText, $matches);
        $score = $matches[1];
        $justification = trim(str_replace('Similarity Score: ' . $score . '/10', '', $resultText));
    
        return [
            'score' => $score,
            'justification' => $justification,
        ];
    }
    
    public function compare($memoire1) {
        // Récupérer tous les mémoires de la même filière pour la comparaison
        $memoires = Memoire::where('id_filere', $memoire1->id_filiere)->get();
        $results = [];
    
        // Vérifier si des mémoires de la même filière ont été trouvés
        if ($memoires->isNotEmpty()) {
            $titre1 = $memoire1->titre;
            $resume1 = $memoire1->resume;
    
            foreach ($memoires as $memoire2) {
                // Extraire le titre et le résumé du deuxième mémoire
                $titre2 = $memoire2->titre;
                $resume2 = $memoire2->resume;
    
                // Comparer les deux mémoires
                $similarityScore = $this->compareMemoires($titre1, $resume1, $titre2, $resume2);
    
                // Stocker le résultat de la comparaison
                $results[] = [
                    'memoire1' => $memoire1,
                    'memoire2' => $memoire2,
                    'similarity_score' => $similarityScore,
                ];
            }
    
            // Trier les résultats par score de similarité en ordre décroissant
        usort($results, function ($a, $b) {
            return $b['similarity_score']['score'] <=> $a['similarity_score']['score'];
        });

        // Récupérer les 5 premières meilleures évaluations
        $topResults = array_slice($results, 0, 5);
        $evaluation = new evaluation();
        $evaluation->id_memoire = $memoire1->id;
        $i=1;
        // Enregistrer les 5 meilleures évaluations dans la base de données
        foreach ($topResults as $result) {
            $evaluation->id_rapport = $result['memoire2']->id;
            $evaluation->setAttribute('note_rapport' . $i, $result['similarity_score']['score']); // Utilisation de setAttribute pour définir dynamiquement le nom du champ
            $evaluation->setAttribute('justification_rapport' . $i, $result['similarity_score']['justification']); // Utilisation de setAttribute pour définir dynamiquement le nom du champ
            $i++;
        }
        $evaluation->save();

        // Redirection ou autre logique ici si nécessaire

    } else {
        // Si aucun mémoire de la même filière n'est trouvé, retourner une erreur ou un message approprié
        return back()->withErrors(['message' => 'Aucun mémoire de la même filière trouvé pour la comparaison.']);
    }
}
}
