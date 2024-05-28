<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Promotion;

class PromotionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $promotions = [
            '2007-2008', '2008-2009', '2009-2010', '2011-2012', '2012-2013', 
            '2013-2014', '2014-2015', '2015-2016', '2016-2017', '2017-2018', 
            '2018-2019', '2019-2020', '2020-2021', '2021-2022', '2022-2023'
        ];

        foreach ($promotions as $promotion) {
            Promotion::create(['promotion' => $promotion]);
        }
    }
}

