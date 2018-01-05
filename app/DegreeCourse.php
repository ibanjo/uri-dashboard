<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\DegreeCourse
 *
 * @property-read \App\DegreeCourseType $degree_course_type
 * @mixin \Eloquent
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property string $code
 * @property string $name_ita
 * @property string $name_eng
 * @property int $is_international
 * @property int $university_branch_id
 * @property int $degree_course_type_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DegreeCourse whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DegreeCourse whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DegreeCourse whereDegreeCourseTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DegreeCourse whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DegreeCourse whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DegreeCourse whereIsInternational($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DegreeCourse whereNameEng($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DegreeCourse whereNameIta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DegreeCourse whereUniversityBranchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DegreeCourse whereUpdatedAt($value)
 */
class DegreeCourse extends Model
{
    public function degree_course_type()
    {
        return $this->belongsTo(DegreeCourseType::class);
    }
}
