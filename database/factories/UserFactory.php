<?php

namespace Database\Factories;

use App\Models\Filiere;
use App\Models\promotion;
use App\Models\Site;
use App\Models\TypeDiplome;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Etudiant>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $date=fake()->dateTimeBetween('-1 year');
        return [
            'name'=> $this->faker->unique()->name,
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('123456789'),
            'phone' => fake()->unique()->phoneNumber(),
            'created_at'=>$date,
            'updated_at'=>$date,
        // activé ou ajuster pour les etudiants

            'id_filiere' => Filiere::all()->random()->id, // Utilisation d'une filière aléatoire existante
            //'id_filiere'=> fake()->randomElement(['1','2','3']),
            'id_site' => Site::all()->random()->id,       // Utilisation d'un site aléatoire existant
            //'id_site'=>'1',
            'id_role'=>'2',
            //'id_promotion'=>promotion::all()->random()->id,
            'id_promotion'=> fake()->randomElement(['11','12','13','14', '15']),
            'id_diplome'=> TypeDiplome::all()->random()->id,

        ];
    }
}
