<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * App\User
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\BankAccount[] $active_bank_account
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\BankAccount[] $bank_accounts
 * @property-read \App\Role $candidate_role
 * @property-read \App\DegreeCourse $degree_course
 * @property-read \App\Department $department
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Mobility[] $mobilities
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Register[] $registers
 * @property-read \App\Role $role
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\User onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\User withoutTrashed()
 * @mixin \Eloquent
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property string $email
 * @property string $telephone
 * @property string $password
 * @property string|null $remember_token
 * @property string $name
 * @property string|null $middle_name
 * @property string $surname
 * @property string $fiscal_code
 * @property string|null $profile_picture
 * @property int $department_id
 * @property int $role_id
 * @property int $candidate_role_id
 * @property int $degree_course_id
 * @property int $active_bank_account_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereActiveBankAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCandidateRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereDegreeCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereFiscalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereMiddleName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereProfilePicture($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereSurname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereTelephone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 */
class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'approved' => 'boolean',
        'active_bank_account_id' => 'integer',
        'candidate_role_id' => 'integer',
        'degree_course_id' => 'integer',
        'department_id' => 'integer',
        'role_id' => 'integer',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function active_mobilities()
    {
        return $this->mobilities()
            ->where('mobility_status_id', '<>', 6)
            ->where('mobility_status_id', '<>', 7);
    }

    public function full_name()
    {
        return $this->name.' '.$this->middle_name.' '.$this->surname;
    }

    public function registers()
    {
        return $this->hasMany(Register::class);
    }

    public function degree_course()
    {
        return $this->belongsTo(DegreeCourse::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Queries the bank account belonging to the User
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bank_accounts()
    {
        return $this->hasMany(BankAccount::class);
    }

    public function active_bank_account()
    {
        return $this->hasMany(BankAccount::class, 'id', 'active_bank_account_id');
    }

    /**
     * Queries the Role of the User
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Queries the Candidate Role of the new User
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function candidate_role()
    {
        return $this->belongsTo(Role::class, 'candidate_role_id', 'id');
    }

    /**
     * Queries all the Mobilities belonging to the User
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mobilities()
    {
        return $this->hasMany(Mobility::class);
    }
}
