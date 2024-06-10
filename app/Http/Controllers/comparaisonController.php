<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use App\Models\Memoire;
use App\Services\OpenAIService;
use Illuminate\Http\Request;

class comparaisonController extends Controller
{
    protected $openAIService;

    public function __construct(OpenAIService $openAIService)
    {
        $this->openAIService = $openAIService;
    }

    public function compare($id)
    {
        $memoire1 = Memoire::findOrFail($id);
    
        // Récupérer tous les mémoires de la même filière pour la comparaison
        $memoires = Memoire::where('id_filiere', $memoire1->id_filiere)->get();
        $results = [];
    
        if ($memoires->isNotEmpty()) {
            $titre1 = $memoire1->titre;
            $resume1 = $memoire1->resume;
    
            foreach ($memoires as $memoire2) {
                if ($memoire1->id === $memoire2->id) {
                    continue;
                }
    
                $titre2 = $memoire2->titre;
                $resume2 = $memoire2->resume;
    
                $service = new \App\Services\OpenAIService('your-project-id', 'your-location', 'your-model-name');
                $result = $service->comparerMemoires($titre1, $resume1, $titre2, $resume2);
    
                if (isset($result['erreur'])) {
                    echo "Erreur : " . $result['erreur'];
                } else {
                    $results[] = [
                        'memoire2' => $memoire2,
                        'similarity_score' => $result,
                    ];
                }
            }
    
            // Trier les résultats par score de similarité
            usort($results, function ($a, $b) {
                return $b['similarity_score']['score'] <=> $a['similarity_score']['score'];
            });
    
            // Prendre les 5 meilleurs résultats
            $topResults = array_slice($results, 0, 5);
    
            // Sauvegarder les évaluations
            foreach ($topResults as $i => $result) {
                $evaluation = new Evaluation();
                $evaluation->id_memoire = $memoire1->id;
                $evaluation->id_rapport = $result['memoire2']->id;
                $evaluation->setAttribute('note_rapport' . ($i + 1), $result['similarity_score']['score']);
                $evaluation->setAttribute('justification_rapport' . ($i + 1), $result['similarity_score']['justification']);
                $evaluation->save();
            }
    
            return response()->json($topResults);
        } else {
            return response()->json(['error' => 'Aucun mémoire de la même filière trouvé pour la comparaison.'], 404);
        }
    }
    
}
