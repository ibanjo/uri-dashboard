<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tab = 'countries';
        DB::table($tab)->insert([
            'name_ita' => 'Italia',
            'name_eng' => 'Italy',
            'monthly_grant' => 200, // FIXME check the monthly grant for Italy
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table($tab)->insert([
            'name_ita' => 'Spagna',
            'name_eng' => 'Spain',
            'monthly_grant' => 200, // FIXME check the monthly grant for Spain
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table($tab)->insert([
            'name_ita' => 'Germania',
            'name_eng' => 'Germany',
            'monthly_grant' => 200, // FIXME check the monthly grant for Germany
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
