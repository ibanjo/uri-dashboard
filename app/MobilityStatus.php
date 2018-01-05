<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\MobilityStatus
 *
 * @mixin \Eloquent
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property string $name
 * @property string|null $description
 * @method static Builder|\App\MobilityStatus whereCreatedAt($value)
 * @method static Builder|\App\MobilityStatus whereDeletedAt($value)
 * @method static Builder|\App\MobilityStatus whereDescription($value)
 * @method static Builder|\App\MobilityStatus whereId($value)
 * @method static Builder|\App\MobilityStatus whereName($value)
 * @method static Builder|\App\MobilityStatus whereUpdatedAt($value)
 */
class MobilityStatus extends Model
{
    //
}
