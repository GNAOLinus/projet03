<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\InfoEtudiant;
use App\Models\Filiere;
use App\Models\Site;

class InfoEtudiantFactory extends Factory
{
    protected $model = InfoEtudiant::class;

    public function definition()
    {
        return [
            'name' => $this->faker->unique()->name,
            'matricule' => $this->faker->unique()->randomNumber(8),
            'id_filiere' => Filiere::all()->random()->id, // Utilisation d'une filière aléatoire existante
            'id_site' => Site::all()->random()->id,       // Utilisation d'un site aléatoire existant
        ];
    }
}


