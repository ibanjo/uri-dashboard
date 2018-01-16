<?php

namespace App\Http\Controllers;

use App\Attachment;
use App\Country;
use App\MobilityStatus;
use App\Role;
use App\Semester;
use App\UniversityBranch;
use Illuminate\Http\Request;
use JavaScript;
use App\User;
use View;

class UserController extends Controller
{
    public function viewAll()
    {
        JavaScript::put([
            'users' => User::with(['role', 'department', 'registers'])->get(),
            'subview' => ['name' => 'all', 'title' => 'Tutti gli utenti']
        ]);
        return View::make('view.all_users', ['vueVM' => 'vue-view-users']);
    }

    public function viewStudents()
    {
        $student_role = Role::where('name', 'student')->first();
        JavaScript::put([
            'users' => User::where('role_id', $student_role->id)
                ->with(['registers', 'department'])->get(),
            'subview' => ['name' => 'students', 'title' => 'Studenti']
        ]);
        return View::make('view.all_users', ['vueVM' => 'vue-view-users']);
    }

    public function viewOne($id)
    {
        $user = User::find($id);
        $active_mobility = $user->mobilities()
            ->where('mobility_status_id', '<', 6)
            ->with([
                'semester',
                'university_branch.country',
                'learning_agreement',
                'transcript',
                'mobility_acknowledgement'])
            ->first();

        if(!is_null($active_mobility))
            $attachments = Attachment::where('mobility_id', $active_mobility->id)->get();
        else
            $attachments = null;

        JavaScript::put([
            'user' => User::with([
                'department',
                'registers',
                'candidate_role',
                'role',
                'degree_course.degree_course_type',
                'bank_accounts'])->find($id),
            'mobility' => $active_mobility,
            'attachments' => $attachments,
            'mobility_statuses' => MobilityStatus::all(),
            'semesters' => Semester::all(),
            'university_branches' => UniversityBranch::all(),
            'countries' => Country::all()
        ]);
        // FIXME attachments go under user.mobilities
        return View::make('view.user', ['user_id' => $id, 'vueVM' => 'vue-view-user']);
    }

    public function changeActiveBankAccount(Request $request)
    {
        $data = $request->all();
        $user = User::find($data['user_id']);
        $user->active_bank_account_id = $data['active_bank_account_id'];
        $user->save();
        return(response(['status' => 'success', 'message' => 'Account principale correttamente modificato'], 200));
    }
}
