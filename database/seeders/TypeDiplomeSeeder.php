<?php

namespace Database\Seeders;

use App\Models\TypeDiplome;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeDiplomeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $diplomes = [
            ['diplome' => 'Licencs', 'description' => 'Description for Licencs'],
            ['diplome' => 'master', 'description' => 'Description for master'],
        ];

        foreach ($diplomes as $diplome) {
            TypeDiplome::create($diplome);
        }
    }
}
