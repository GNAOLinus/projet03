<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Filiere;

class FiliereSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $filieres = [
            'SIL (Système Informatique et Logiciel)',
            'TL (Transport et Logistique)',
            'MCC (Marketing, Communication et Commerce)',
            'FCA (Finance, Comptabilité et Audit)'
        ];

        foreach ($filieres as $filiere) {
            Filiere::create(['filiere' => $filiere]);
        }
    }
}

