<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Country
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\UniversityBranch[] $universityBranches
 * @mixin \Eloquent
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property string $name_ita
 * @property string $name_eng
 * @property int $monthly_grant
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Country whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Country whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Country whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Country whereMonthlyGrant($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Country whereNameEng($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Country whereNameIta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Country whereUpdatedAt($value)
 */
class Country extends Model
{
    /**
     * Queries the UniversityBranches belonging to this Country
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function universityBranches() {
        return $this->hasMany(UniversityBranch::class);
    }
}
