<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Evaluation\Entities\DoctorNotes
 *
 * @property integer $id
 * @property integer $visit
 * @property string $presenting_complaints
 * @property string $past_medical_history
 * @property string $examination
 * @property string $diagnosis
 * @property string $treatment_plan
 * @property integer $user
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Ignite\Evaluation\Entities\Visits $visits
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\DoctorNotes whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\DoctorNotes whereVisit($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\DoctorNotes wherePresentingComplaints($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\DoctorNotes wherePastMedicalHistory($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\DoctorNotes whereExamination($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\DoctorNotes whereDiagnosis($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\DoctorNotes whereTreatmentPlan($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\DoctorNotes whereUser($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\DoctorNotes whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\DoctorNotes whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class DoctorNotes extends Model {

    public $primaryKey = 'visit';
    public $incrementing = false;
    public $table = 'evaluation_doctor_notes';

    public function visits() {
        return $this->belongsTo(Visits::class, 'visit', 'visit_id');
    }

}
