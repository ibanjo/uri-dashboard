<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Exam
 *
 * @property-read \App\Mobility $mobility
 * @mixin \Eloquent
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property string $name
 * @property string $description
 * @property int $mobility_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Exam whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Exam whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Exam whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Exam whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Exam whereMobilityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Exam whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Exam whereUpdatedAt($value)
 */
class Exam extends Model
{
    /**
     * Queries the Mobility this Exam belongs to
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mobility() {
        return $this->belongsTo(Mobility::class);
    }
}
