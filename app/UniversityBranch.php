<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\UniversityBranch
 *
 * @property-read \App\Country $country
 * @mixin \Eloquent
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property string $name
 * @property string|null $name_eng
 * @property string $erasmus_code
 * @property int $country_id
 * @property int $max_outgoing
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UniversityBranch whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UniversityBranch whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UniversityBranch whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UniversityBranch whereErasmusCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UniversityBranch whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UniversityBranch whereMaxOutgoing($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UniversityBranch whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UniversityBranch whereNameEng($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UniversityBranch whereUpdatedAt($value)
 */
class UniversityBranch extends Model
{
    protected $casts = [
        'country_id' => 'integer',
        'iad_levels' => 'array'
    ];

    protected $dates = [
        'first_semester_deadline', 'second_semester_deadline', 'expiration_date'
    ];

    public function contact_person()
    {
        return User::where('id', $this->contact_person_id);
    }

    /**
     * Queries the Country this UniversityBranch belongs to
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
