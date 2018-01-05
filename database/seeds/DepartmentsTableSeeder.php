<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DepartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tab = 'departments';
        DB::table($tab)->insert(['name' => 'DEI', 'name_full' => 'Dipartimento di Ingegneria Elettrica e dell\'informazione', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table($tab)->insert(['name' => 'DICATECH', 'name_full' => 'Dipartimento di Ingegneria Civile, Ambientale, del Territorio, Edile e di Chimica', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table($tab)->insert(['name' => 'DMMM', 'name_full' => 'Dipartimento di Meccanica, Matematica e Management', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table($tab)->insert(['name' => 'DICAR', 'name_full' => 'Dipartimento di Scienze dell\'Ingegneria Civile e dell\'Architettura', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
    }
}
