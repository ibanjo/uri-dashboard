<?php

namespace App\Http\Controllers;

use App\Role;
use App\User as User;
use Illuminate\Http\Request;
use JavaScript;
use View;

class AdminController extends Controller
{
    public function checkUnapproved()
    {
        JavaScript::put([
            'users' => User::where('role_id', Role::where('name', 'suspended')->first()->id)
                ->with([
                    'department',
                    'registers',
                    'candidate_role',
                    'degree_course.degree_course_type',
                    'mobilities.semester',
                    'mobilities.universityBranch.country',
                    'bank_accounts'])->get(),
        ]);
        return View::make('admin.approve');
    }

    public function approveUser(Request $request)
    {
        $data = $request->all();
        $user = User::find($data['id']);
        $user->role_id = $user->candidate_role_id;
        $user->save();
        return(response(['status' => 'success', 'message' => 'Utente '.$user->full_name().' approvato con successo'], 200));
    }
}
