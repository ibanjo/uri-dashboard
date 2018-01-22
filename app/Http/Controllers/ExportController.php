<?php

namespace App\Http\Controllers;

use App\User;
use DB;
use Excel;
use function foo\func;
use Illuminate\Http\Request;
use View;

class ExportController extends Controller
{
    public function showExportMobilitiesForm()
    {
        return View::make('query.mobilities', ['vueVM' => 'vue-query']);
    }

    public function mobilitiesToExcel(Request $request)
    {
        $data = $request->all();
        $fields = $data['query'];
        $flags = $data['flags'];
        $mobilities = DB::table('mobilities')
            ->when(!$flags['disable_incoming'], function ($query) use ($fields) {
                if ($fields['incoming'])
                    return $query->where('university_branch_id', 1);
                else
                    return $query->where('university_branch_id', '<>', 1);
            })
            ->when(!$flags['disable_academic_year'], function ($query) use ($fields) {
                return $query->where('academic_year', $fields['academic_year']);
            })->get();


        $mobilities = json_decode(json_encode($mobilities), true);

        $filename = str_random(10);
        $excel = Excel::create($filename, function ($file) use ($mobilities) {
            $file->setTitle('Dati esportati');
            $file->sheet('Mobility', function ($sheet) use ($mobilities) {
                $sheet->fromModel($mobilities);
            });
        })->store('xlsx');

        return response([
            'status' => 'success',
            'message' => 'Download in corso',
            'identifier' => $filename.'.xlsx'
        ], 200);
    }

    public function downloadExportedFile($identifier, $name)
    {
        return response()->download(storage_path('app/exports/'.$identifier), $name);
    }
}
