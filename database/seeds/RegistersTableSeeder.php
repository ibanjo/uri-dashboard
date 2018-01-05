<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class RegistersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('registers')->insert([
            'user_id' => 1,
            'number' => '000000',
            'description' => 'Root user',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('registers')->insert([
            'user_id' => 2,
            'number' => '555555',
            'description' => 'Laurea Triennale',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('registers')->insert([
            'user_id' => 3,
            'number' => '547852',
            'description' => 'Laurea Triennale',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('registers')->insert([
            'user_id' => 4,
            'number' => '134568',
            'description' => 'Professore Ordinario',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
