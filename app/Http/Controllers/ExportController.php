<?php

namespace App\Http\Controllers;

use App\Mobility;
use App\MobilityStatus;
use Carbon\Carbon;
use Excel;
use Illuminate\Http\Request;
use JavaScript;
use View;

class ExportController extends Controller
{
    public function showExportMobilitiesForm()
    {
        $available_filters = Mobility::$filters;
        $available_filters[1]['options'] = MobilityStatus::all(); // FIXME ugly: find 'status' filter by name
        JavaScript::put([
            'available_filters' => $available_filters
        ]);
        return View::make('query.mobilities', ['vueVM' => 'vue-query']);
    }

    public function mobilitiesToExcel(Request $request)
    {
        $filters = $request->all();
        $query = Mobility::query();
        foreach ($filters as $filter) {
            switch ($filter['type']) {
                case 'BooleanFilter':
                    if (!$filter['queryScope'])
                        $query = $query->where($filter['name'], $filter['value']);
                    else {
                        $scope = $filter['name'];
                        $query = $query->$scope($filter['value']);
                    }
                    break;
                case 'TextFilter':
                    if (!$filter['queryScope'])
                        $query = $query->where($filter['name'], $filter['value']);
                    else {
                        $scope = $filter['name'];
                        $query = $query->$scope($filter['value']);
                    }
                    break;
                case 'DateFilter':
                    if (!$filter['disable_min'] && !$filter['disable_max'])
                        $query = $query
                            ->where($filter['name'], '>', Carbon::createFromFormat('d-m-Y', $filter['date_min']))
                            ->where($filter['name'], '<', Carbon::createFromFormat('d-m-Y', $filter['date_max']));
                    else if ($filter['disable_min'])
                        $query = $query
                            ->where($filter['name'], '<', Carbon::createFromFormat('d-m-Y', $filter['date_max']));
                    else if ($filter['disable_max'])
                        $query = $query
                            ->where($filter['name'], '>', Carbon::createFromFormat('d-m-Y', $filter['date_min']));
                    break;

                case 'MultipleOptionsFilter':
                    $scope = $filter['name'];
                    $query = $query->$scope($filter['value']); // TODO test the status filter
                    break;

                default:
                    // TODO raise an exception or return a warning
                    break;
            }
        }
        $mobilities = $query->with(['user', 'university_branch'])->get();

        $exported = [];
        foreach ($mobilities as $mobility) {
            $user = $mobility->user->export();
            $branch = $mobility->university_branch->export();
            $semester = $mobility->semester->export();
            $mob = $mobility->export();
            array_push($exported, array_merge($semester, $mob, $branch, $user));
        }

        //$mobilities = json_decode(json_encode($mobilities), true);
        $filename = str_random(10);
        $excel = Excel::create($filename, function ($file) use ($exported) {
            $file->setTitle('Dati esportati');
            $file->sheet('Mobility', function ($sheet) use ($exported) {
                $sheet->fromModel($exported);
            });
        })->store('xlsx');

        return response([
            'status' => 'success',
            'message' => 'Download in corso',
            'identifier' => $filename . '.xlsx'
        ], 200);
    }

    public function downloadExportedFile($identifier, $name)
    {
        return response()->download(storage_path('app/exports/' . $identifier), $name);
    }
}
