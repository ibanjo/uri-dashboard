<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class MobilityStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tab = 'mobility_statuses';
        DB::table($tab)->insert([
            'name' => 'Richiesta',
            'description' => 'La richiesta è stata correttamente recepita ed è in fase di elaborazione',
            'created_at' => Carbon::now(), 'updated_at' => Carbon::now()
        ]);
        DB::table($tab)->insert([
            'name' => 'Vaglio sede estera',
            'description' => 'La mobilità è in fase di valutazione da parte della sede estera',
            'created_at' => Carbon::now(), 'updated_at' => Carbon::now()
        ]);
        DB::table($tab)->insert([
            'name' => 'Firma in attesa',
            'description' => 'In attesa della firma da parte di ...', // FIXME detail this one
            'created_at' => Carbon::now(), 'updated_at' => Carbon::now()
        ]);
        DB::table($tab)->insert([
            'name' => 'In corso',
            'description' => 'La mobilità in corso',
            'created_at' => Carbon::now(), 'updated_at' => Carbon::now()
        ]);
        DB::table($tab)->insert([
            'name' => 'Computo mobilità effettiva',
            'description' => 'In attesa delle valutazioni finali da parte dell\'amministrazione',
            'created_at' => Carbon::now(), 'updated_at' => Carbon::now()
        ]);
        DB::table($tab)->insert([
            'name' => 'Chiusa',
            'description' => 'La mobilità si è conclusa',
            'created_at' => Carbon::now(), 'updated_at' => Carbon::now()
        ]);
        DB::table($tab)->insert([
            'name' => 'Rifiutata',
            'description' => 'La richiesta di mobilità è stata rifiutata',
            'created_at' => Carbon::now(), 'updated_at' => Carbon::now()
        ]);
    }
}
