<?php

namespace Database\Seeders;

use App\Models\Binome;
use App\Models\Memoire;
use App\Models\TypeDiplome;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class MemoireSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $binomes = Binome::all();
        
        foreach ($binomes as $binome) {
            Memoire::create([ 
                'titre' => $faker->sentence,
                'resume' => $faker->paragraphs(asText: true),
                'fichier' => $faker->randomElement(['2-memoireFinal_090828.pdf', 'avent_fifa.pdf', 'mémoireGLORY.pdf']),
                'statut' => $faker->randomElement([null, 'public']),
                'appreciation' => $faker->randomElement(['Excellent', 'Très bien', 'Bien', 'Moyen']),
                'note' => $faker->numberBetween(10, 20),
                'id_filiere' => $binome->id_filiere,
                'id_binome' => $binome->id,
                'id_binome' => $binome->id,
                'encadreur' => $faker->name,
                'id_diplome'=> TypeDiplome::all()->random()->id,
                'id_promotion'=>$faker->randomElement(['14', '15']),
            ]);
        }
    }
}
