<?php

namespace App\Http\Controllers;

use App\Attachment;
use App\MobilityStatus;
use App\Role;
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
        return View::make('view.all_users');
    }

    public function viewStudents()
    {
        $student_role = Role::where('name', 'student')->first();
        JavaScript::put([
            'users' => User::where('role_id', $student_role->id)
                ->with(['registers', 'department'])->get(),
            'subview' => ['name' => 'students', 'title' => 'Studenti']
        ]);
        return View::make('view.all_users');
    }

    public function viewOne($id)
    {
        $user = User::find($id);
        $active_mobility = $user->mobilities()->where('mobility_status_id', '<', 6)->first();
        JavaScript::put([
            'user' => User::with([
                'department',
                'registers',
                'role',
                'degree_course.degree_course_type',
                'mobilities.semester',
                'mobilities.universityBranch.country',
                'bank_accounts'])->find($id),
            'attachments' => is_null($active_mobility) ? null : Attachment::where('mobility_id', $active_mobility->id)->get(),
            'mobilityStatuses' => MobilityStatus::all()
        ]);
        return View::make('view.user', ['user_id' => $id]);
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
