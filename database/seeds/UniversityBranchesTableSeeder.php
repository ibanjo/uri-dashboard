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
            'max_outgoing' => 6, // In this case only this means "incoming"
            'expiration_date' => Carbon::parse('2030-12-30'),
            'iad_levels' => json_encode([1, 2, 3]),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table($tab)->insert([
            'name' => 'Universidad Politécnica de Madrid',
            'name_eng' => 'Polytechnic University of Madrid',
            'erasmus_code' => 'E MADRID05',
            'country_id' => 2, // Spain
            'max_outgoing' => 6,
            'expiration_date' => Carbon::parse('2018-12-30'),
            'iad_levels' => json_encode([1, 2]),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table($tab)->insert([
            'name' => 'Universität des Saarlandes',
            'name_eng' => 'Saarland University',
            'erasmus_code' => 'D SAARBRU03',
            'country_id' => 3, // Germany
            'max_outgoing' => 6,
            'expiration_date' => Carbon::parse('2018-12-30'),
            'iad_levels' => json_encode([1]),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
