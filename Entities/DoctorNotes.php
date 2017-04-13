<?php

namespace Ignite\Evaluation\Entities;

use Ignite\Evaluation\Entities\DiagnosisCodes;
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
 * @property string $investigations
 * @property string $treatment_plan
 * @property integer $user
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Ignite\Evaluation\Entities\Visit $visits
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\DoctorNotes whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\DoctorNotes whereVisit($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\DoctorNotes wherePresentingComplaints($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\DoctorNotes wherePastMedicalHistory($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\DoctorNotes whereExamination($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\DoctorNotes whereDiagnosis($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\DoctorNotes whereInvestigations($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\DoctorNotes whereTreatmentPlan($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\DoctorNotes whereUser($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\DoctorNotes whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\DoctorNotes whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class DoctorNotes extends Model {

    //use SoftDeletes;

    public $primaryKey = 'visit';
    public $incrementing = false;
    protected $guarded = [];
    public $table = 'evaluation_doctor_notes';

    public function visits() {
        return $this->belongsTo(Visit::class, 'visit');
    }

    public function getCodesAttribute() {
        $_code = '';
        if (isset($this->diagnosis)) {
            try {
                foreach (json_decode($this->diagnosis) as $key => $value) {
                    $dcode = DiagnosisCodes::find($value);
                    $_code.='<span class="label label-default">' . $dcode->name . '</span> ';
                }
                echo "Initial diagnoses:-<br/>" . $_code;
            } catch (\Exception $e) {
                return 'Invalid format';
            }
        } else {
            'None selected';
        }
    }

}
