<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DegreeCourseTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tab = 'degree_course_types';

        DB::table($tab)->insert([
            'name_ita' => 'Laurea Magistrale',
            'name_eng' => 'Master\'s degree',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table($tab)->insert([
            'name_ita' => 'Laurea Triennale',
            'name_eng' => 'Bachelor\'s degree',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table($tab)->insert([
            'name_ita' => 'Laurea Magistrale C. U.',
            'name_eng' => 'Master\'s degree (single cycle)',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
