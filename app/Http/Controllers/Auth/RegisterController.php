<?php

namespace App\Http\Controllers\Auth;

use App\DegreeCourse;
use App\Department;
use App\Http\Controllers\CreatesModels;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Database\QueryException;
use App\Role as Role;
use JavaScript;
use Mockery\Exception;
use View;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;
    use CreatesModels;

    /**
     * Redirect directives (for Vue VMs) after user registration
     * @return array
     */
    protected function redirectPath()
    {
        if (Auth::guest())
            return ['redirect' => route('login')];
        else
            return ['redirect' => route('home')];
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('guest');
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        JavaScript::put([
            'roles' => Role::where('hidden', false)->get(),
            'departments' => Department::all(),
            'degreeCourses' => DegreeCourse::with('degree_course_type')->get(),
            'userLoggedIn' => Auth::check()
        ]);
        return View::make('entry.user', ['vueVM' => 'vue-entry-user']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        // FIXME review or delete this (redundant) validator
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        $user_creation = $this->create($request->all());
        event(new Registered($user_creation['user']));

        return response([
            'user' => $user_creation['user'],
            'status' => $user_creation['status'],
            'message' => $user_creation['message'],
            'redirect' => Auth::guest() ? '/login' : '/home'
        ], 200);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return array
     */
    protected function create(array $data)
    {
        $user = $this->newUser($data);

        if ($data['has_bank_account']) {
            try {
                $account = $this->newBankAccount($data, $user);
                $user->active_bank_account_id = $account->id;
                $status = 'success';
                $message = 'Utente registrato correttamente';
            } catch (QueryException $e) {
                // TODO although rare, more Users may share the same BankAccount
                $status = 'warning';
                $message = 'IBAN già presente';
            } finally {
                if(!isset($status, $message)) {
                    $status = 'success';
                    $message = 'Utente registrato correttamente';
                }
            }
        } else {
            $status = 'success';
            $message = 'Utente registrato correttamente';
        }

        // Create a register record and associate the new user
        $this->newRegister($data, $user);

        return ['user' => $user, 'status' => $status, 'message' => $message];
    }
}
