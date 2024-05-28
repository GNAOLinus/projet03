<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InfoEtudiant;

class InfoEtudiantSeeder extends Seeder
{
    public function run()
    {
        InfoEtudiant::factory()->count(10)->create();
    }
}

