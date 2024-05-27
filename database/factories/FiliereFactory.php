<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Filiere>
 */
class FiliereFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
       
         return [
            'filiere' => ['SIL (Systeme Informatique et Logiciel)',
            'TL (Transport et Logistique)',
            'MCC (Marketing, Communication et Commerce)',
            'FCA (Finance, Comptabilité et Audit)'], 
        ];
        
    }
}
