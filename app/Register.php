<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Register
 *
 * @property mixed number
 * @property mixed description
 * @property int user_id
 * @property-read \App\User $user
 * @mixin \Eloquent
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property string $number
 * @property string $description
 * @property int $user_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Register whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Register whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Register whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Register whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Register whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Register whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Register whereUserId($value)
 */
class Register extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
