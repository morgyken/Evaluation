<?php

namespace Ignite\Evaluation\Entities;

use Ignite\Evaluation\Entities\DiagnosisCodes;
use Ignite\Users\Entities\Sentinel;
use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Evaluation\Entities\DoctorNotes
 *
 * @property int $id
 * @property int $visit
 * @property string|null $presenting_complaints
 * @property string|null $past_medical_history
 * @property string|null $examination
 * @property string|null $diagnosis
 * @property string|null $investigations
 * @property string|null $treatment_plan
 * @property int|null $user
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Ignite\Users\Entities\Sentinel|null $doctor
 * @property-read mixed $codes
 * @property-read \Ignite\Evaluation\Entities\Visit $visits
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\DoctorNotes whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\DoctorNotes whereDiagnosis($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\DoctorNotes whereExamination($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\DoctorNotes whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\DoctorNotes whereInvestigations($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\DoctorNotes wherePastMedicalHistory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\DoctorNotes wherePresentingComplaints($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\DoctorNotes whereTreatmentPlan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\DoctorNotes whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\DoctorNotes whereUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\DoctorNotes whereVisit($value)
 * @mixin \Eloquent
 */
class DoctorNotes extends Model
{

    //use SoftDeletes;

    public $primaryKey = 'visit';
    public $incrementing = false;
    protected $guarded = [];
    public $table = 'evaluation_doctor_notes';

    public function visits()
    {
        return $this->belongsTo(Visit::class, 'visit');
    }

    public function doctor()
    {
        return $this->belongsTo(Sentinel::class, 'user');
    }

    public function getVisitTypeAttribute()
    {
        $type = (bool)Visit::where('id', '<>', $this->visit)->count();
        return $type ? 'Revisit' : 'New';
    }

    public function getCodesAttribute()
    {
        $_code = '';
        if (isset($this->diagnosis)) {
            try {
                foreach (json_decode($this->diagnosis) as $key => $value) {
                    $dcode = DiagnosisCodes::find($value);
                    $_code .= '<span class="label label-default">' . $dcode->name . '</span> ';
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
