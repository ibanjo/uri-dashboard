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
    protected $exportables = [
        ['attribute' => 'name_ita', 'as' => 'Semestre']
    ];

    public function export($fields = null)
    {
        if (is_null($fields))
            $fields = collect($this->exportables);
        $exported = [];
        foreach ($fields as $field) {
            if (in_array($field['attribute'], $this->dates))
                // FIXME formatting dates does not work
                $value = $this[$field['attribute']]->format('d/m/Y');
            else
                $value = $this[$field['attribute']];
            $exported = array_merge($exported, [$field['as'] => $value]);
        }
        return $exported;
    }
}
