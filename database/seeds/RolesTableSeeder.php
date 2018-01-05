<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tab = 'roles';
        DB::table($tab)->insert(['name' => 'root', 'description' => 'Utente radice', 'hidden' => true, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table($tab)->insert(['name' => 'admin', 'description' => 'Amministratore di sistema', 'hidden' => true, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table($tab)->insert(['name' => 'staff', 'description' => 'Personale amministrativo', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table($tab)->insert(['name' => 'professor', 'description' => 'Peronale docente (coordinatori Erasmus, ecc.)', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table($tab)->insert(['name' => 'student', 'description' => 'Studente', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table($tab)->insert(['name' => 'suspended', 'description' => 'Account in attesa di approvazione', 'hidden' => true, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
    }
}
