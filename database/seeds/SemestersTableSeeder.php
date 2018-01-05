<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SemestersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tab = 'semesters';

        DB::table($tab)->insert([
            'name_ita' => 'Primo',
            'name_eng' => 'First',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table($tab)->insert([
            'name_ita' => 'Secondo',
            'name_eng' => 'Second',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table($tab)->insert([
            'name_ita' => 'Annuale',
            'name_eng' => 'Annual',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
