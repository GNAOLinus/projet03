<?php

namespace App\Http\Controllers;

use Gemini\Laravel\Facades\Gemini;
use Gemini\Data\Content;
use Gemini\Data\Role;
use Gemini\Enums\Role as EnumsRole;
use Illuminate\Http\Request;

class GeminiController extends Controller
{
    // Méthode pour comparer deux mémoires en utilisant le service Gemini
    public function comparerMemoires($titre1, $resume1, $titre2, $resume2)
    {
        // Combiner le titre et le résumé pour former les textes complets
        $texte_a = $titre1 . " " . $resume1;
        $texte_b = $titre2 . " " . $resume2;

        // Créer un tableau avec les textes
        $donnees = [
            'texte_a' => $texte_a,
            'texte_b' => $texte_b,
        ];

        // Initialiser une conversation avec Gemini avec un contexte historique
        $chat = Gemini::chat()->startChat(history: [
            Content::parse(part: 'Compare these two texts based on their titles and summaries.'),
            Content::parse(part: 'Sure, please provide the texts.', role: EnumsRole::MODEL)
        ]);

        // Envoyer un message pour comparer les deux textes
        $response = $chat->sendMessage("Compare the following texts:\n\nText A: $texte_a\n\nText B: $texte_b");
        
        // Afficher ou retourner la réponse
        $result = $response->text(); 
        return $result;
    }
}
