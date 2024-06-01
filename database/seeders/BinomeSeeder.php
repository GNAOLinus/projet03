<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Binome;
use App\Models\User;
use App\Models\Filiere;
use Illuminate\Support\Facades\DB;

class BinomeSeeder extends Seeder
{
    public function run()
    {
        $filiere_ids = Filiere::pluck('id');

        foreach ($filiere_ids as $filiere_id) {
            // Récupérer tous les binômes existants pour cette filière
            $binomeexistant = Binome::where('id_filiere', $filiere_id)->get();

            // Récupérer les IDs des étudiants déjà dans un binôme
            $ids_etudiants_binome = $binomeexistant->pluck('id_etudiant1')->merge($binomeexistant->pluck('id_etudiant2'))->unique();

            // Récupérer les étudiants sans binôme dans la filière
            $etudiants = User::where('id_role', 2)
                                ->where('id_filiere', $filiere_id)
                                ->whereNotIn('id', $ids_etudiants_binome)
                                ->pluck('id')->toArray();

            while (count($etudiants) >= 2) {
                // Utiliser des transactions pour garantir l'intégrité des données
                DB::transaction(function () use (&$etudiants, $filiere_id) {
                    $id_etudiant1 = array_shift($etudiants);
                    $id_etudiant2 = array_shift($etudiants);

                    Binome::create([
                        'id_etudiant1' => $id_etudiant1,
                        'id_etudiant2' => $id_etudiant2,
                        'id_filiere' => $filiere_id,
                    ]);
                });
            }
        }
    }
}
