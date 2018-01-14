<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UniversityBranchesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tab = 'university_branches';

        DB::table($tab)->insert([
            'name' => 'Politecnico di Bari',
            'name_eng' => 'Polytechnic University of Bari',
            'erasmus_code' => 'I BARI05',
            'country_id' => 1, // Italy
            'max_outgoing' => 6, // FIXME only in this case this means "incoming"
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table($tab)->insert([ // FIXME just an example
            'name' => 'Politecnico di Milano',
            'name_eng' => 'Polytechnic University of Milan',
            'erasmus_code' => 'I MILANO02',
            'country_id' => 1, // Italy
            'max_outgoing' => 6,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table($tab)->insert([
            'name' => 'Universidad Politécnica de Madrid',
            'name_eng' => 'Polytechnic University of Madrid',
            'erasmus_code' => 'E MADRID05',
            'country_id' => 2, // Spain
            'max_outgoing' => 6,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table($tab)->insert([
            'name' => 'Universität des Saarlandes',
            'name_eng' => 'Saarland University',
            'erasmus_code' => 'D SAARBRU03',
            'country_id' => 3, // Germany
            'max_outgoing' => 6,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
