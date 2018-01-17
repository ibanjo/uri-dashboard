<?php

namespace App\Http\Controllers;

use App\Attachment;
use App\BankAccount;
use App\Country;
use App\LearningAgreement;
use App\Transcript;
use App\MobilityAcknowledgement;
use App\Register;
use App\Role;
use App\UniversityBranch;
use App\User;
use Auth;
use Carbon\Carbon;

trait CreatesModels
{

    public function newCountry($data)
    {
        $country = new Country;
        $country->name_eng = $data['name_eng'];
        $country->name_ita = $data['name_ita'];
        $country->monthly_grant = $data['monthly_grant'];
        $country->travel_grant = $data['travel_grant'];
        $country->save();
        return $country;
    }

    public function newUniversityBranch($data)
    {
        $university = new UniversityBranch;
        foreach (array_keys($data) as $key) {
            if (in_array($key, ['first_semester_deadline', 'second_semester_deadline', 'expiration_date']))
                $university[$key] = Carbon::createFromFormat('d-m-Y', $data[$key]);
            else
                $university[$key] = $data[$key];
        }
        $university->save();
        return $university;
    }

    /**
     * @param $data
     * @param User $user
     * @return BankAccount
     */
    public function newBankAccount($data, User $user)
    {
        $account = new BankAccount;
        $account->user_id = $user->id;
        $account->bank_name = $data['bank_name'];
        $account->iban = $data['iban'];
        if ($data['user_is_holder']) {
            $account->holder_name = $user->name;
            $account->holder_middle_name = $user->middle_name;
            $account->holder_surname = $user->surname;
        } else {
            $account->holder_name = $data['holder_name'];
            $account->holder_middle_name = $data['holder_middle_name'];
            $account->holder_surname = $data['holder_surname'];
        }
        $account->save();
        return $account;
    }

    /**
     * @param $data
     * @param User $user
     * @return Register
     */
    public function newRegister($data, User $user)
    {
        $register = new Register;
        $register->number = $data['number'];
        $register->description = $data['description'];
        $register->user_id = $user->id;
        $register->save();
        return $register;
    }

    /**
     * @param $data
     * @return User
     */
    public function newUser($data)
    {
        $user = new User;

        // Registry information
        $user->name = $data['name'];
        $user->middle_name = $data['middle_name'];
        $user->surname = $data['surname'];
        $user->fiscal_code = $data['fiscal_code'];
        $user->telephone = $data['telephone'];
        $user->email = $data['email'];
        $user->password = bcrypt($data['password']);

        // Academic info
        $user->department_id = $data['department_id'];
        $user->degree_course_id = $data['degree_course_id'];

        // Account must be approved by an administrator if registered externally
        if (Auth::check()) {
            $user->candidate_role_id = $data['candidate_role_id'];
            $user->role_id = $data['candidate_role_id'];
        } else {
            $user->role_id = Role::where('name', 'suspended')->first()->id;
            $user->candidate_role_id = $data['candidate_role_id'];
        }

        $user->save();

        return $user;
    }

    public function newAttachment($data)
    {
        $attachment = new Attachment;

        $attachment->mobility_id = $data['mobility_id'];
        $attachment->name = $data['name'];
        $attachment->path = $data['path'];
        $attachment->type = $data['type'];
        $attachment->description = $data['description'];

        $attachment->save();

        return $attachment;
    }

    public function newMobilityDocument($data)
    {
        $class_name = 'App\\' . studly_case($data['document_type']);
        $document = new $class_name();

        $document->name = $data['name'];
        $document->path = $data['path'];
        $document->type = $data['type'];
        $document->save();

        return $document;
    }
}