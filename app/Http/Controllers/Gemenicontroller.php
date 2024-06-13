<?php

namespace App\Http\Controllers;

use App\Models\Memoire;
use Gemini\Laravel\Facades\Gemini;
use Gemini\Data\Content;
use Gemini\Enums\Role as EnumsRole;
use Illuminate\Http\Request;

class GeminiController extends Controller
{
    // Méthode pour comparer deux mémoires en utilisant le service Gemini
    public function comparerMemoires($id)
    {
        // Trouver le premier Memoire par son ID
        $memoire1 = Memoire::findOrFail($id);
        
        // Combinaison du titre et du résumé pour former des textes complets
        $texte_a = $memoire1->titre1 . " " . $memoire1->resume1;

        // Trouver tous les Memoires avec le même 'id_filiere' que $memoire1
        $memoires = Memoire::where('id_filiere', $memoire1->id_filiere)->get();

        $results = [];

        foreach ($memoires as $memoire2) {
            // Combinaison du titre et du résumé de chaque Memoire
            $texte_b = $memoire2->titre2 . " " . $memoire2->resume2;

            // Initialisation d'une conversation avec Gemini avec un contexte historique
            $chat = Gemini::chat()->startChat([
                Content::parse('Comparer ces deux textes en fonction de leurs titres et résumés.'),
                Content::parse('D\'accord, veuillez fournir les textes.', EnumsRole::MODEL)
            ]);

            // Envoyer un message pour comparer les deux textes
            $response = $chat->sendMessage("Comparer les textes suivants :\n\nTexte A : $texte_a\n\nTexte B : $texte_b");

            // Obtenir le texte de réponse et le stocker dans le tableau de résultats
            $results[] = $response->text();
        }

        // Retourner le tableau de résultats (ou vous pouvez choisir de retourner un résultat spécifique en fonction de votre logique)
        return $results;
    }
}
