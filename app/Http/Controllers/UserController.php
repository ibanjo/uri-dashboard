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

    public function viewCategory($category)
    {
        $role = Role::where('name', $category)->first();
        JavaScript::put([
            'users' => User::where('role_id', $role->id)
                ->with(['registers', 'department'])->get(),
            'subview' => ['name' => $category, 'title' => $role->description]
        ]);
        return View::make('view.all_users', ['vueVM' => 'vue-view-users']);
    }

    public function viewOne($id)
    {
        $user = User::find($id);
        $active_mobility = $user->active_mobilities()
            ->first();

        $mobilities = $user->mobilities()->with([
            'semester',
            'university_branch.country',
            'learning_agreement',
            'transcript',
            'mobility_acknowledgement',
            'attachments'])->get();

        is_null($active_mobility) ?
            $active_mobility_id = null :
            $active_mobility_id = $active_mobility->id;

        JavaScript::put([
            'user' => User::with([
                'department',
                'registers',
                'candidate_role',
                'role',
                'degree_course.degree_course_type',
                'bank_accounts'])->find($id),
            'mobilities' => $mobilities,
            'active_mobility_id' => $active_mobility_id,
            'mobility_statuses' => MobilityStatus::all(),
            'semesters' => Semester::all(),
            'university_branches' => UniversityBranch::all(),
            'countries' => Country::all()
        ]);
        return View::make('view.user', ['user_id' => $id, 'vueVM' => 'vue-view-user']);
    }

    public function changeActiveBankAccount(Request $request)
    {
        $data = $request->all();
        $user = User::find($data['user_id']);
        $user->active_bank_account_id = $data['active_bank_account_id'];
        $user->save();
        return (response(['status' => 'success', 'message' => 'Account principale correttamente modificato'], 200));
    }
}
