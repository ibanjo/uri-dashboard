<?php

namespace App;

use DB;
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
 * @property mixed iad_levels
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

    protected $exportables = [
        ['attribute' => 'name', 'as' => 'Università'],
        ['attribute' => 'erasmus_code', 'as' => 'Codice Erasmus']
    ];

    public function export($fields = null)
    {
        if (is_null($fields))
            $fields = collect($this->exportables);

        $exported = [];
        foreach ($fields as $field) {
            $exported = array_merge($exported, [$field['as'] => $this[$field['attribute']]]);
        }
        return $exported;
    }

    public function contact_person()
    {
        return $this->hasOne(User::class, 'id', 'contact_person_id');
    }

    public function accepted_levels()
    {
        // FIXME this does not work
        return DegreeCourseType::whereIn('id', $this->iad_levels);
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
