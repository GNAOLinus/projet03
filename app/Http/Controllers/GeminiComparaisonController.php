<?php

namespace App\Http\Controllers;

use App\Models\Memoire;
use Gemini\Laravel\Facades\Gemini;
use Gemini\Data\Content;
use Gemini\Enums\Role as EnumsRole;
use Illuminate\Http\Request;

class GeminiComparaisonController extends Controller
{
   // Méthode pour comparer deux mémoires en utilisant le service Gemini
   public function comparerMemoires($id)
   {
       try {
           // Trouver le premier Memoire par son ID
           $memoire1 = Memoire::findOrFail($id);
           
           // Combinaison du titre et du résumé pour former des textes complets
           $texte_a = $memoire1->titre . " " . $memoire1->resume;

           // Trouver tous les Memoires avec le même 'id_filiere' que $memoire1
           //$memoires = Memoire::where('id_filiere', $memoire1->id_filiere)->get();
                   // Trouver les 10 mémoires les plus récents avec le même 'id_filiere' que $memoire1
        $memoires = Memoire::where('id_filiere', $memoire1->id_filiere)
        ->where('id', '<>', $id) // Exclure le mémoire initial
        ->latest() // Trier par date de création décroissante
        ->limit(10) // Limiter à 10 mémoires les plus récents
        ->get();

           $results = [];

           foreach ($memoires as $memoire2) {
               if ($memoire2->id !== $memoire1->id) {
                   // Combinaison du titre et du résumé de chaque Memoire
                   $texte_b = $memoire2->titre . " " . $memoire2->resume;

                   // Initialisation d'une conversation avec Gemini avec un contexte historique
                   $chat = Gemini::chat()->startChat([
                       Content::parse("Utilise tes capacités de machine learning pour comparer les textes suivants et donner un pourcentage de similarité :

                       Texte A : $texte_a
                       
                       Texte B : $texte_b" ),
                   ]);

                   // Envoyer un message pour comparer les deux textes
                   $response = $chat->sendMessage("Comparer les textes suivants :\n\nTexte A : $texte_a\n\nTexte B : $texte_b");

                   // Vérifier si la réponse est valide avant de l'ajouter aux résultats
                   if ($response ) {
                       // Extraire le pourcentage de ressemblance de la réponse si possible
                       $similarity = $this->extractSimilarityPercentage($response);
                       $results[] = [
                           'memoire_id' => $memoire2->id,
                           'similarity' => intval($similarity) ,
                           'comparison_text' => $response
                       ];
                   } else {
                       $results[] = [
                           'memoire_id' => $memoire2->id,
                           'similarity' => 'N/A',
                           'comparison_text' => "Aucune réponse valide obtenue pour la comparaison avec le mémoire ID: {$memoire2->id}."
                       ];
                   }
               }
           }

           // Retourner le tableau de résultats

           return $results;
       } catch (\Exception $e) {
           // Gérer les exceptions et retourner un message d'erreur
           return response()->json(['error' => $e->getMessage()], 500);
       }
   }

    // Méthode pour extraire le pourcentage de ressemblance de la réponse de Gemini
    private function extractSimilarityPercentage($text)
    {
        // Vérifier si $text est de type chaîne
        if (!is_string($text)) {
            // Gérer le cas où $text n'est pas une chaîne
            // Par exemple, si $text est un objet, vous pourriez vouloir le convertir en chaîne
            if (is_object($text) && method_exists($text, '__toString')) {
                $text = (string) $text;
            } else {
                // Si $text ne peut pas être converti en chaîne, gérer l'erreur en conséquence
                return 'N/A';
            }
        }
    
        // Continuer avec la correspondance d'expression régulière
        if (preg_match('/\b(\d+)%\b/', $text, $matches)) {
            return (int)$matches[1];
        }
    
        // Retourner 'N/A' si aucun pourcentage n'est trouvé
        return 'N/A';
    }
}
