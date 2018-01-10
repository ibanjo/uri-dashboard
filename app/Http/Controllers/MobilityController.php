<?php

namespace App\Http\Controllers;

use App\Mobility as Mobility;
use App\UniversityBranch;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Country as Country;
use App\Semester as Semester;
use App\User as User;
use JavaScript;
use View;

class MobilityController extends Controller
{
    public function showNewMobilityForm($user_id)
    {
        JavaScript::put([
            'user' => User::with([
                'role',
                'bank_accounts',
                'registers',
                'degree_course.degree_course_type',
                'department'])->find($user_id),
            'countries' => Country::all(),
            'semesters' => Semester::all(),
            'university_branches' => UniversityBranch::with(['country'])->get()
        ]);
        return View::make('entry.mobility');
    }

    public function createNewMobility(Request $request)
    {
        $data = $request->all();
        $mob = new Mobility;
        $mob->user_id = $data['user_id'];
        $mob->mobility_status_id = 1;
        $mob->university_branch_id = $data['university_branch_id'];
        $mob->semester_id = $data['semester_id'];
        $mob->estimated_in = Carbon::parse($data['estimated_in']); // FIXME Carbon::parse gives the day before
        $mob->estimated_out = Carbon::parse($data['estimated_out']);
        $mob->estimated_cfu_exams = $data['estimated_cfu_exams'];
        $mob->estimated_cfu_thesis = $data['estimated_cfu_thesis'];
        $mob->granted = $data['granted'];

        $mob->save();

        return response([
            'status' => 'success',
            'message' => 'Mobilità registrata con successo! Stiamo tornando alla pagina dell\'utente',
            'redirect' => route('view.user', ['id' => $data['user_id']])
        ], 200);
    }

    public function changeMobilityStatus(Request $request)
    {
        $data = $request->all();
        $mobility = Mobility::find($data['id']);
        $mobility->mobility_status_id = $data['new_status_id'];
        $mobility->save();
        return response([
            'status' => 'success',
            'message' => 'Stato della mobilità correttamente aggiornato'
        ], 200);
    }

    public function editMobility(Request $request)
    {
        $data = $request->all();
        $mobility = Mobility::find($data['id']);
        foreach (array_keys($data) as $key) {
            if(in_array($key, ['estimated_in', 'estimated_out', 'acknowledged_in', 'acknowledged_out']))
                $mobility[$key] = Carbon::parse($data[$key]);
            else
                $mobility[$key] = $data[$key];
        }
        $mobility->save();
        return response([
            'status' => 'success',
            'message' => 'Mobilità aggiornata correttamente'
        ], 200);
    }
}
