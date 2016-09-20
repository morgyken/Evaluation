<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Evaluation\Entities\PatientDoctorNotes
 *
 * @property integer $id
 * @property integer $visit
 * @property string $presenting_complaints
 * @property string $past_medical_history
 * @property string $examination
 * @property string $diagnosis
 * @property string $treatment_plan
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $user
 * @property-read \Ignite\Evaluation\Entities\PatientVisits $visits
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientDoctorNotes whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientDoctorNotes whereVisit($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientDoctorNotes wherePresentingComplaints($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientDoctorNotes wherePastMedicalHistory($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientDoctorNotes whereExamination($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientDoctorNotes whereDiagnosis($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientDoctorNotes whereTreatmentPlan($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientDoctorNotes whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientDoctorNotes whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientDoctorNotes whereUser($value)
 * @mixin \Eloquent
 */
class PatientDoctorNotes extends Model {

    public $primaryKey = 'visit';
    public $incrementing = false;

    public function visits() {
        return $this->belongsTo(PatientVisits::class, 'visit', 'visit_id');
    }

}
