<?php

namespace App\Http\Controllers;

use App\Country;
use App\DegreeCourseType;
use App\Role;
use App\UniversityBranch;
use App\User as User;
use Illuminate\Http\Request;
use JavaScript;
use View;

class AdminController extends Controller
{
    use CreatesModels;

    public function checkUnapproved()
    {
        JavaScript::put([
            'users' => User::where('role_id', Role::where('name', 'suspended')->first()->id)
                ->with([
                    'department',
                    'registers',
                    'candidate_role',
                    'role',
                    'degree_course.degree_course_type',
                    'mobilities.semester',
                    'mobilities.universityBranch.country',
                    'bank_accounts'])->get(),
        ]);
        return View::make('admin.approve', ['vueVM' => 'vue-approve-users']);
    }

    public function viewUniversities()
    {
        JavaScript::put([
            'countries' => Country::all(),
            'university_branches' => UniversityBranch::with(['country'])->get(),
            'degree_course_types' => DegreeCourseType::all()
        ]);
        return View::make('view.universities', ['vueVM' => 'vue-view-universities']);
    }

    public function saveNewCountry(Request $request)
    {
        $data = $request->all();
        $country = $this->newCountry($data);
        return response([
            'country' => $country,
            'status' => 'success',
            'message' => 'Paese correttamente inserito'
        ], 200);
    }

    public function saveNewUniversity(Request $request)
    {
        $data = $request->all();
        $university = $this->newUniversityBranch($data);
        return response([
            'university_branch' => $university,
            'status' => 'success',
            'message' => 'Sede correttamente inserita'
        ], 200);
    }

    public function approveUser(Request $request)
    {
        $data = $request->all();
        $user = User::find($data['id']);
        $user->role_id = $user->candidate_role_id;
        $user->save();
        return (response(['status' => 'success', 'message' => 'Utente ' . $user->full_name() . ' approvato con successo'], 200));
    }
}
