<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Factories\AdminFactory;
use Database\Factories\AdminfactoryFactory;
use Database\Factories\FiliereFactory;
use Database\Factories\PromotionFactory;
use Database\Factories\RoleFactory;
use Database\Factories\SiteFactory;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            FiliereSeeder::class,
            PromotionSeeder::class,
            SiteSeeder::class,
            AdminSeeder::class,
            InfoEtudiantSeeder::class,
            UserSeeder::class,
            BinomeSeeder::class,
            MemoireSeeder::class,
        ]);
       
    }
}
