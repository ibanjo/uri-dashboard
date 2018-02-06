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
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table($tab)->insert([
            'name_ita' => 'Spagna',
            'name_eng' => 'Spain',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table($tab)->insert([
            'name_ita' => 'Germania',
            'name_eng' => 'Germany',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
