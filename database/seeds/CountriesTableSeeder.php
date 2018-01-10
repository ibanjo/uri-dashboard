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
        // FIXME check travel and monthly grants
        $tab = 'countries';
        DB::table($tab)->insert([
            'name_ita' => 'Italia',
            'name_eng' => 'Italy',
            'monthly_grant' => 200,
            'travel_grant' => 1000,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table($tab)->insert([
            'name_ita' => 'Spagna',
            'name_eng' => 'Spain',
            'monthly_grant' => 200,
            'travel_grant' => 1000,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table($tab)->insert([
            'name_ita' => 'Germania',
            'name_eng' => 'Germany',
            'monthly_grant' => 200,
            'travel_grant' => 1000,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
