<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Giuseppe',
            'middle_name' => 'Maria',
            'surname' => 'D\'Aucelli',
            'fiscal_code' => 'DCLGPP89P21A662S',
            'role_id' => 1,
            'degree_course_id' => 3,
            'email' => 'giuseppe.daucelli@gmail.com',
            'telephone' => '+39.347.62.56.266',
            'password' => bcrypt('password'),
            'department_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('users')->insert([
            'name' => 'Paolino',
            'middle_name' => 'Polletto',
            'surname' => 'Polli',
            'fiscal_code' => 'PLLPLL90P20AP62P',
            'role_id' => 5,
            'degree_course_id' => 3,
            'email' => 'paolo.pollo@polli.com',
            'telephone' => '+39.012.34.56.789',
            'password' => bcrypt('password'),
            'department_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('users')->insert([
            'name' => 'Studente',
            'middle_name' => 'Da',
            'surname' => 'Approvare',
            'fiscal_code' => 'STDNPR21P98A756F',
            'role_id' => 6,
            'candidate_role_id' => 5,
            'degree_course_id' => 3,
            'email' => 'stud.uno@studenti.it',
            'telephone' => '+39.012.34.56.789',
            'password' => bcrypt('password'),
            'department_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('users')->insert([
            'name' => 'Docente',
            'middle_name' => 'Da',
            'surname' => 'Approvare',
            'fiscal_code' => 'DCTNPR21P98A756F',
            'role_id' => 6,
            'candidate_role_id' => 4,
            'degree_course_id' => 3,
            'email' => 'doc.uno@docenti.it',
            'telephone' => '+39.012.34.56.789',
            'password' => bcrypt('password'),
            'department_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
