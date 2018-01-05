<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DegreeCoursesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tab = 'degree_courses';
        DB::table($tab)->insert([
            'code' => 'LM01',
            'name_ita' => 'Ingegneria Civile',
            'name_eng' => 'Civil Engineering',
            'is_international' => false,
            'university_branch_id' => 1, // Politecnico di Bari
            'degree_course_type_id' => 1, // Master's degree
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table($tab)->insert([
            'code' => 'LM02',
            'name_ita' => 'Ingegneria dei Sistemi Edilizi',
            'name_eng' => 'Building Systems Engineering',
            'is_international' => false,
            'university_branch_id' => 1, // Politecnico di Bari
            'degree_course_type_id' => 1, // Master's degree
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table($tab)->insert([
            'code' => 'LM04',
            'name_ita' => 'Ingegneria Elettronica',
            'name_eng' => 'Electronic Engineering',
            'is_international' => false,
            'university_branch_id' => 1, // Politecnico di Bari
            'degree_course_type_id' => 1, // Master's degree
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table($tab)->insert([
            'code' => 'LM05',
            'name_ita' => 'Ingegneria Elettrica',
            'name_eng' => 'Electrical Engineering',
            'is_international' => false,
            'university_branch_id' => 1, // Politecnico di Bari
            'degree_course_type_id' => 1, // Master's degree
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table($tab)->insert([
            'code' => 'LM06',
            'name_ita' => 'Ingegneria dell\'Automazione',
            'name_eng' => 'Automation Engineering',
            'is_international' => false,
            'university_branch_id' => 1, // Politecnico di Bari
            'degree_course_type_id' => 1, // Master's degree
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table($tab)->insert([
            'code' => 'LM13',
            'name_ita' => 'Ingegneria Gestionale',
            'name_eng' => 'Management Engineering',
            'is_international' => false,
            'university_branch_id' => 1, // Politecnico di Bari
            'degree_course_type_id' => 1, // Master's degree
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table($tab)->insert([
            'code' => 'LM14',
            'name_ita' => 'Ingegneria delle Telecomunicazioni',
            'name_eng' => 'Telecommunication Engineering',
            'is_international' => true,
            'university_branch_id' => 1, // Politecnico di Bari
            'degree_course_type_id' => 1, // Master's degree
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table($tab)->insert([
            'code' => 'LM17',
            'name_ita' => 'Ingegneria Informatica',
            'name_eng' => 'Computer Science Engineering',
            'is_international' => true,
            'university_branch_id' => 1, // Politecnico di Bari
            'degree_course_type_id' => 1, // Master's degree
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table($tab)->insert([
            'code' => 'LM30',
            'name_ita' => 'Ingegneria Meccanica',
            'name_eng' => 'Mechanical Engineering',
            'is_international' => false,
            'university_branch_id' => 1, // Politecnico di Bari
            'degree_course_type_id' => 1, // Master's degree
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table($tab)->insert([
            'code' => 'LM50',
            'name_ita' => 'Industrial Design',
            'name_eng' => 'Industrial Design',
            'is_international' => true,
            'university_branch_id' => 1, // Politecnico di Bari
            'degree_course_type_id' => 1, // Master's degree
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table($tab)->insert([
            'code' => 'LM51CU',
            'name_ita' => 'Architettura',
            'name_eng' => 'Architecture',
            'is_international' => false,
            'university_branch_id' => 1, // Politecnico di Bari
            'degree_course_type_id' => 3, // Master's degree (single cycle)
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table($tab)->insert([
            'code' => 'LM53CU',
            'name_ita' => 'Ingegneria Edile Architettura',
            'name_eng' => 'Building-Architectural Engineering',
            'is_international' => false,
            'university_branch_id' => 1, // Politecnico di Bari
            'degree_course_type_id' => 3, // Master's degree (single cycle)
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table($tab)->insert([
            'code' => 'LM63',
            'name_ita' => 'Ingegneria per l\'Ambiente e il Territorio',
            'name_eng' => 'Environmental Engineering',
            'is_international' => false,
            'university_branch_id' => 1, // Politecnico di Bari
            'degree_course_type_id' => 1, // Master's degree
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table($tab)->insert([
            'code' => 'LT02',
            'name_ita' => 'Ingegneria Edile',
            'name_eng' => 'Building Engineering',
            'is_international' => false,
            'university_branch_id' => 1, // Politecnico di Bari
            'degree_course_type_id' => 2, // Bachelor's degree
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table($tab)->insert([
            'code' => 'LT03',
            'name_ita' => 'Ingegneria Gestionale',
            'name_eng' => 'Management Engineering',
            'is_international' => false,
            'university_branch_id' => 1, // Politecnico di Bari
            'degree_course_type_id' => 2, // Bachelor's degree
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table($tab)->insert([
            'code' => 'LT04',
            'name_ita' => 'Ingegneria Elettronica e delle Telecomunicazioni',
            'name_eng' => 'Electronic and Telecommunication Engineering',
            'is_international' => false,
            'university_branch_id' => 1, // Politecnico di Bari
            'degree_course_type_id' => 2, // Bachelor's degree
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table($tab)->insert([
            'code' => 'LT05',
            'name_ita' => 'Ingegneria Elettrica',
            'name_eng' => 'Electrical Engineering',
            'is_international' => false,
            'university_branch_id' => 1, // Politecnico di Bari
            'degree_course_type_id' => 2, // Bachelor's degree
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table($tab)->insert([
            'code' => 'LT16',
            'name_ita' => 'Ingegneria Civile e Ambientale',
            'name_eng' => 'Civil and Environmental Engineering',
            'is_international' => false,
            'university_branch_id' => 1, // Politecnico di Bari
            'degree_course_type_id' => 2, // Bachelor's degree
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table($tab)->insert([
            'code' => 'LT17',
            'name_ita' => 'Ingegneria Informatica e dell\'Automazione',
            'name_eng' => 'Computer Science and Automation Engineering',
            'is_international' => false,
            'university_branch_id' => 1, // Politecnico di Bari
            'degree_course_type_id' => 2, // Bachelor's degree
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table($tab)->insert([
            'code' => 'LT31',
            'name_ita' => 'Ingegneria Meccanica',
            'name_eng' => 'Mechanical Engineering',
            'is_international' => false,
            'university_branch_id' => 1, // Politecnico di Bari
            'degree_course_type_id' => 2, // Bachelor's degree
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table($tab)->insert([
            'code' => 'LT39',
            'name_ita' => 'Ingegneria dell\'Ambiente',
            'name_eng' => 'Environmental Engineering',
            'is_international' => false,
            'university_branch_id' => 1, // Politecnico di Bari
            'degree_course_type_id' => 2, // Bachelor's degree
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table($tab)->insert([
            'code' => 'LT40',
            'name_ita' => 'Ingegneria dei Sistemi Aerospaziali',
            'name_eng' => 'Aerospace Systems Engineering',
            'is_international' => false,
            'university_branch_id' => 1, // Politecnico di Bari
            'degree_course_type_id' => 2, // Bachelor's degree
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table($tab)->insert([
            'code' => 'LT41',
            'name_ita' => 'Ingegneria dei Sistemi Aerospaziali',
            'name_eng' => 'Aerospace Systems Engineering',
            'is_international' => false,
            'university_branch_id' => 1, // Politecnico di Bari
            'degree_course_type_id' => 2, // Bachelor's degree
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table($tab)->insert([
            'code' => 'LT50',
            'name_ita' => 'Disegno Industriale',
            'name_eng' => 'Industrial Design',
            'is_international' => false,
            'university_branch_id' => 1, // Politecnico di Bari
            'degree_course_type_id' => 2, // Bachelor's degree
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table($tab)->insert([
            'code' => 'LT60',
            'name_ita' => 'Ingegneria dei Sistemi Medicali',
            'name_eng' => 'Medical Systems Engineering',
            'is_international' => false,
            'university_branch_id' => 1, // Politecnico di Bari
            'degree_course_type_id' => 2, // Bachelor's degree
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
