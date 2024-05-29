<?php

namespace App\Services;

use OpenAI;
use OpenAI\Client;

class OpenAIService
{
    protected $client;

    public function __construct()
    {
        $apiKey = env('OPENAI_API_KEY');
        $this->client = OpenAI::client($apiKey);
    }

    public function compareMemoires($titre1, $resume1, $titre2, $resume2)
    {
        $query = "Compare these two theses based on their titles and summaries. Score their similarity on a scale from 0 to 10, where 0 means completely different and 10 means almost identical. Consider the following aspects: semantic meaning, main themes, concepts and ideas, vocabulary and terminology, and structure and organization. Provide a brief explanation for the score.
        Thesis 1:
        Title: $titre1
        Summary: $resume1
    
        Thesis 2:
        Title: $titre2
        Summary: $resume2";

        $response = $this->client->chat()->create([
            'model' => 'gpt-3.5-turbo-instruct',
            'messages' => [
                ['role' => 'user', 'content' => $query],
            ],
            'max_tokens' => 100,
            'temperature' => 0.5,
        ]);

        $resultText = $response['choices'][0]['message']['content'];

        // Analyser le texte pour extraire la note et la justification
        preg_match('/Similarity Score: (\d+)\/10/', $resultText, $matches);
        $score = isset($matches[1]) ? $matches[1] : 'N/A';
        $justification = trim(str_replace("Similarity Score: $score/10", '', $resultText));

        return [
            'score' => $score,
            'justification' => $justification,
        ];
    }
}
