<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as FakerFactory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Site>
 */
class SiteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = FakerFactory::create('fr_FR'); 

        return [
            'site' => $faker->randomElement(['cotonou', 'calavi', 'port-novo', 'akpakpa', 'lokossa', 'djougou', 'parakou', 'natitingou']),
            'adresse' => $faker->streetAddress . ' ' . $faker->postcode,
        ];
    }
}


