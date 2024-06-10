<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Google\Auth\ApplicationDefaultCredentials;
use Google\Auth\OAuth2;
use GuzzleHttp\HandlerStack;

class OpenAIService
{
    protected $client;
    protected $projectId;
    protected $location;
    protected $modelName;

    public function __construct($projectId, $location, $modelName)
    {
        $this->client = new Client();
        $this->projectId = $projectId;
        $this->location = $location;
        $this->modelName = $modelName;
    }

    public function comparerMemoires($titre1, $resume1, $titre2, $resume2)
    {
        // Préparer les données textuelles pour Vertex AI
        $texte_a = $titre1 . " " . $resume1;
        $texte_b = $titre2 . " " . $resume2;

        $données = [
            'texte_a' => $texte_a,
            'texte_b' => $texte_b,
        ];

        try {
            // Envoyer une requête à l'API Vertex AI
            $response = $this->client->post("https://{$this->location}-ai.googleapis.com/v1/projects/{$this->projectId}/locations/{$this->location}/models/{$this->modelName}:predict", [
                'json' => $données,
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->getAccessToken(),
                    'Content-Type' => 'application/json',
                ],
            ]);

            // Extraire le corps de la réponse JSON
            $responseData = json_decode($response->getBody(), true);

            // Extraire le score de similarité et la justification de la réponse
            $score = $responseData['similarity_score'] ?? null;
            $justification = $responseData['justification'] ?? null;

            return [
                'score' => $score,
                'justification' => $justification,
            ];
        } catch (RequestException $e) {
            // Gérer les erreurs de requête, y compris les erreurs HTTP
            $message = "Une erreur s'est produite lors de la requête à l'API Vertex AI : " . $e->getMessage();
            return [
                'erreur' => $message,
            ];
        }
    }

    // Fonction pour obtenir le jeton d'accès OAuth2
    private function getAccessToken()
    {
        // Utilisez la bibliothèque Google\Auth pour obtenir le jeton d'accès
        $credentials = ApplicationDefaultCredentials::getCredentials();
        $authToken = $credentials->fetchAuthToken();

        return $authToken['access_token'];
    }
}
