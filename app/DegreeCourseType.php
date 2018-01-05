<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\DegreeCourseType
 *
 * @mixin \Eloquent
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property string $name_ita
 * @property string $name_eng
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DegreeCourseType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DegreeCourseType whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DegreeCourseType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DegreeCourseType whereNameEng($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DegreeCourseType whereNameIta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DegreeCourseType whereUpdatedAt($value)
 */
class DegreeCourseType extends Model
{
    //
}
