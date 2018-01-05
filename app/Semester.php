<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Semester
 *
 * @mixin \Eloquent
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property string $name_ita
 * @property string $name_eng
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Semester whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Semester whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Semester whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Semester whereNameEng($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Semester whereNameIta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Semester whereUpdatedAt($value)
 */
class Semester extends Model
{
    //
}
