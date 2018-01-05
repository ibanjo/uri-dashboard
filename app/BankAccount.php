<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\BankAccount
 *
 * @property mixed id
 * @property integer user_id
 * @property string iban
 * @property string holder_name
 * @property string holder_middle_name
 * @property string holder_surname
 * @property string bank_name
 * @property-read \App\User $user
 * @mixin \Eloquent
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property string $bank_name
 * @property string $holder_name
 * @property string|null $holder_middle_name
 * @property string $holder_surname
 * @property int $user_id
 * @property string $iban
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BankAccount whereBankName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BankAccount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BankAccount whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BankAccount whereHolderMiddleName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BankAccount whereHolderName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BankAccount whereHolderSurname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BankAccount whereIban($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BankAccount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BankAccount whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BankAccount whereUserId($value)
 */
class BankAccount extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'iban', 'holder_name', 'holder_middle_name', 'holder_surname', 'user_id'
    ];

    /**
     * Returns the User this BankAccount belongs to
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        // TODO this should become a many-to-many relationship
        return $this->belongsTo(User::class);
    }
}
