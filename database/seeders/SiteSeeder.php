<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Site;
use Faker\Factory as FakerFactory;

class SiteSeeder extends Seeder
{
    public function run()
    {
        $faker = FakerFactory::create('fr_FR');
        $sites = [
            ['site' => 'cotonou', 'addresse' => $faker->streetAddress . ' ' . $faker->postcode],
            ['site' => 'calavi', 'addresse' => $faker->streetAddress . ' ' . $faker->postcode],
            ['site' => 'port-novo', 'addresse' => $faker->streetAddress . ' ' . $faker->postcode],
            ['site' => 'akpakpa', 'addresse' => $faker->streetAddress . ' ' . $faker->postcode],
            ['site' => 'lokossa', 'addresse' => $faker->streetAddress . ' ' . $faker->postcode],
            ['site' => 'djougou', 'addresse' => $faker->streetAddress . ' ' . $faker->postcode],
            ['site' => 'parakou', 'addresse' => $faker->streetAddress . ' ' . $faker->postcode],
            ['site' => 'natitingou', 'addresse' => $faker->streetAddress . ' ' . $faker->postcode],
        ];

        foreach ($sites as $site) {
            Site::create($site);
        }
    }
}

