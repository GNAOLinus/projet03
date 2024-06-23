<?php

namespace App\Jobs;

use App\Http\Controllers\GeminiComparaisonController;
use App\Http\Controllers\MemoireController;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CompareMemoireJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $memoireId;

    /**
     * Create a new job instance.
     *
     * @param int $memoireId
     * @return void
     */
    public function __construct($memoireId)
    {
        $this->memoireId = $memoireId;
    }

    /**
     * Execute the job.
     *
     * @return array
     */
    public function handle()
    {
        // Instancier le contrôleur de comparaison Gemini
        $geminiController = new MemoireController();

        // Appeler la fonction comparerMemoires() et récupérer les résultats
        $results = $geminiController->compare($this->memoireId);

        // Retourner les résultats pour traitement ultérieur
        return $results;
    }
}
