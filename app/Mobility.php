<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Mobility
 *
 * @property int user_id
 * @property int mobility_status_id
 * @property int university_branch_id
 * @property int semester_id
 * @property string estimated_in
 * @property string estimated_out
 * @property int estimated_cfu_exams
 * @property int estimated_cfu_thesis
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
 * @property int|null $granted
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
    protected $casts = [
        'mobility_status_id' => 'integer'
    ];

    public function semester() {
        return $this->belongsTo(Semester::class);
    }

    /**
     * Queries all the Exams related to the Mobility
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function exams() {
        return $this->hasMany(Exam::class);
    }

    /**
     * Query the MobilityStatus of the Mobility
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mobilityStatus() {
        return $this->belongsTo(MobilityStatus::class);
    }

    /**
     * Query the destination (UniversityBranch) of the Mobility
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function universityBranch() {
        return $this->belongsTo(UniversityBranch::class);
    }

    public function attachments() {
        return $this->hasMany(Attachment::class);
    }

    /**
     * Query the person (User) involved in the Mobility
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo(User::class);
    }
}
