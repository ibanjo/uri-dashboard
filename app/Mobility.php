<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Mobility
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Attachment[] $attachments
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Exam[] $exams
 * @property-read \App\MobilityStatus $mobilityStatus
 * @property-read \App\Semester $semester
 * @property-read \App\UniversityBranch $universityBranch
 * @property-read \App\User $user
 * @mixin \Eloquent
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int $user_id
 * @property int $mobility_status_id
 * @property int $university_branch_id
 * @property int $semester_id
 * @property string $estimated_in
 * @property string $estimated_out
 * @property int $estimated_cfu_exams
 * @property int $estimated_cfu_thesis
 * @property boolean $granted
 * @property int|null $transcript_cfu_exams
 * @property int|null $transcript_cfu_thesis
 * @property string|null $acknowledged_in
 * @property string|null $acknowledged_out
 * @property int|null $acknowledged_cfu_exams
 * @property int|null $acknowledged_cfu_thesis
 * @property int|null $eu_grant
 * @property int|null $eu_grant_spent
 * @property int|null $extension
 * @property int|null $co_funding
 * @property int|null $other_funding
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Mobility whereAcknowledgedCfuExams($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Mobility whereAcknowledgedCfuThesis($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Mobility whereAcknowledgedIn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Mobility whereAcknowledgedOut($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Mobility whereCoFunding($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Mobility whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Mobility whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Mobility whereEstimatedCfuExams($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Mobility whereEstimatedCfuThesis($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Mobility whereEstimatedIn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Mobility whereEstimatedOut($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Mobility whereEuGrant($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Mobility whereEuGrantSpent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Mobility whereExtension($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Mobility whereGranted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Mobility whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Mobility whereMobilityStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Mobility whereOtherFunding($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Mobility whereSemesterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Mobility whereTranscriptCfuExams($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Mobility whereTranscriptCfuThesis($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Mobility whereUniversityBranchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Mobility whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Mobility whereUserId($value)
 */
class Mobility extends Model
{
    public static $filters = [
        [
            'name' => 'outgoing',
            'queryScope' => true, // Determines if the filter is a scope or directly an attribute
            'label' => 'Incoming/Outgoing',
            'type' => 'BooleanFilter',
            'activeText' => 'Outgoing',
            'inactiveText' => 'Incoming'
        ],
        [
            'name' => 'status',
            'queryScope' => true,
            'label' => 'Stato mobilità',
            'type' => 'MultipleOptionsFilter',
            'options' => [], // MobilityStatus data grabbed by the controller
            'titles' => ['Stati mobilità', 'Stati scelti'],
            'optionKey' => 'id',
            'optionLabel' => 'name'
        ],
        [
            'name' => 'granted',
            'queryScope' => false,
            'label' => 'Assegnatario/Idoneo',
            'type' => 'BooleanFilter',
            'activeText' => 'Assegnatario',
            'inactiveText' => 'Idoneo'
        ],
        [
            'name' => 'academic_year',
            'queryScope' => false,
            'label' => 'Anno accademico',
            'type' => 'TextFilter',
            'placeholder' => 'Formato: AAAA/AA'
        ],
        [
            'name' => 'programme_name',
            'queryScope' => false,
            'label' => 'Progetto',
            'type' => 'TextFilter',
            'placeholder' => 'Progetto di afferenza'
        ],
        [
            'name' => 'estimated_in',
            'queryScope' => false,
            'label' => 'Inizio (Learning Agreement)',
            'type' => 'DateFilter'
        ],
        [
            'name' => 'estimated_out',
            'queryScope' => false,
            'label' => 'Fine (Learning Agreement)',
            'type' => 'DateFilter'
        ],
        [
            'name' => 'acknowledged_in',
            'queryScope' => false,
            'label' => 'Inizio (Transcript)',
            'type' => 'DateFilter'
        ],
        [
            'name' => 'acknowledged_out',
            'queryScope' => false,
            'label' => 'Fine (Transcript)',
            'type' => 'DateFilter'
        ]
    ];

    protected $casts = [
        'mobility_status_id' => 'integer',
        'granted' => 'boolean',
        'other_funding' => 'array'
    ];

    protected $dates = [
        'created_at', 'updated_at', 'deleted_at', 'first_semester_deadline',
        'second_semester_deadline', 'expiration_date'
    ];

    protected $exportables = [
        ['attribute' => 'programme_name', 'as' => 'Progetto'],
        ['attribute' => 'academic_year', 'as' => 'Anno accademico'],
        ['attribute' => 'estimated_in', 'as' => 'Inizio (LA)'],
        ['attribute' => 'estimated_out', 'as' => 'Fine (LA)'],
        ['attribute' => 'acknowledged_in', 'as' => 'Inizio (ToR)'],
        ['attribute' => 'acknowledged_out', 'as' => 'Fine (ToR)'],
        ['attribute' => 'extension', 'as' => 'Estensione mobilità (gg)'],
        ['attribute' => 'estimated_cfu_exams', 'as' => 'CFU esami (LA)'],
        ['attribute' => 'estimated_cfu_thesis', 'as' => 'CFU tesi (LA)'],
        ['attribute' => 'transcript_cfu_exams', 'as' => 'CFU esami (ToR)'],
        ['attribute' => 'transcript_cfu_thesis', 'as' => 'CFU tesi (ToR)'],
        ['attribute' => 'acknowledged_cfu_exams', 'as' => 'CFU esami (MRC)'],
        ['attribute' => 'acknowledged_cfu_thesis', 'as' => 'CFU tesi (MRC)'],
        ['attribute' => 'acknowledged_cfu_supernumerary', 'as' => 'CFU sovrannumerari (MRC)'],
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

    public function scopeOutgoing($query, $value)
    {
        if ($value)
            $operator = '<>';
        else
            $operator = '=';

        return $query->where('university_branch_id', $operator, 1);
    }

    public function scopeIncoming($query, $value)
    {
        if ($value)
            $operator = '=';
        else
            $operator = '<>';

        return $query->where('university_branch_id', $operator, 1);
    }

    public function scopeStatus($query, $value)
    {
        return $query->whereIn('mobility_status_id', $value);
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    /**
     * Queries all the Exams related to the Mobility
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function exams()
    {
        return $this->hasMany(Exam::class);
    }

    /**
     * Query the MobilityStatus of the Mobility
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mobilityStatus()
    {
        return $this->belongsTo(MobilityStatus::class);
    }

    /**
     * Query the destination (UniversityBranch) of the Mobility
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function university_branch()
    {
        return $this->belongsTo(UniversityBranch::class);
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }

    /**
     * Query the person (User) involved in the Mobility
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function learning_agreement()
    {
        return $this->hasOne(LearningAgreement::class);
    }

    public function transcript()
    {
        return $this->hasOne(Transcript::class);
    }

    public function mobility_acknowledgement()
    {
        return $this->hasOne(MobilityAcknowledgement::class);
    }
}
