<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Ignite\Evaluation\Entities\PatientVisits
 *
 * @property integer $visit_id
 * @property integer $clinic
 * @property integer $patient
 * @property integer $purpose
 * @property integer $destination
 * @property boolean $nurse
 * @property string $nurse_out
 * @property boolean $theatre
 * @property string $theatre_out
 * @property boolean $diagnostics
 * @property string $diagnostics_out
 * @property boolean $evaluation
 * @property string $evaluation_out
 * @property boolean $laboratory
 * @property string $laboratory_out
 * @property boolean $radiology
 * @property string $radiology_out
 * @property boolean $pharmacy
 * @property string $pharmacy_out
 * @property boolean $optical
 * @property string $optical_out
 * @property integer $user
 * @property string $payment_mode
 * @property integer $scheme
 * @property integer $next_appointment
 * @property string $deleted_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Ignite\Setup\Entities\Clinics $clinics
 * @property-read \Ignite\Reception\Entities\Patients $patients
 * @property-read \Ignite\Evaluation\Entities\PatientVitals $vitals
 * @property-read \Ignite\Evaluation\Entities\PatientDoctorNotes $notes
 * @property-read \Ignite\Evaluation\Entities\PatientDrawings $drawings
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Evaluation\Entities\PatientPrescriptions[] $prescriptions
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Evaluation\Entities\PatientDiagnosis[] $investigations
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Evaluation\Entities\PatientTreatment[] $treatments
 * @property-read \Ignite\Evaluation\Entities\OP $opnotes
 * @property-read \Ignite\Reception\Entities\Appointments $appointments
 * @property-read \Ignite\Core\Entities\UserProfile $doctors
 * @property-read \Ignite\Setup\Entities\Schemes $schemes
 * @property-read \Ignite\Evaluation\Entities\VisitMeta $meta
 * @property-read mixed $settled
 * @property-read mixed $unpaid_amount
 * @property-read mixed $visit_destination
 * @property-read mixed $signed_out
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientVisits whereVisitId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientVisits whereClinic($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientVisits wherePatient($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientVisits wherePurpose($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientVisits whereDestination($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientVisits whereNurse($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientVisits whereNurseOut($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientVisits whereTheatre($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientVisits whereTheatreOut($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientVisits whereDiagnostics($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientVisits whereDiagnosticsOut($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientVisits whereEvaluation($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientVisits whereEvaluationOut($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientVisits whereLaboratory($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientVisits whereLaboratoryOut($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientVisits whereRadiology($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientVisits whereRadiologyOut($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientVisits wherePharmacy($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientVisits wherePharmacyOut($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientVisits whereOptical($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientVisits whereOpticalOut($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientVisits whereUser($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientVisits wherePaymentMode($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientVisits whereScheme($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientVisits whereNextAppointment($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientVisits whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientVisits whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientVisits whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientVisits checkedAt($destination)
 * @mixin \Eloquent
 */
class PatientVisits extends Model {

    use SoftDeletes;

    public $primaryKey = 'visit_id';

    public function clinics() {
        return $this->belongsTo(\Ignite\Setup\Entities\Clinics::class, 'clinic');
    }

    public function patients() {
        return $this->belongsTo(\Ignite\Reception\Entities\Patients::class, 'patient');
    }

    public function vitals() {
        return $this->hasOne(PatientVitals::class, 'visit', 'visit_id');
    }

    public function notes() {
        return $this->hasOne(PatientDoctorNotes::class, 'visit', 'visit_id');
    }

    public function drawings() {
        return $this->hasOne(PatientDrawings::class, 'visit', 'visit_id');
    }

    public function prescriptions() {
        return $this->hasMany(PatientPrescriptions::class, 'visit', 'visit_id');
    }

    public function investigations() {
        return $this->hasMany(PatientDiagnosis::class, 'visit');
    }

    public function treatments() {
        return $this->hasMany(PatientTreatment::class, 'visit', 'visit_id');
    }

    public function opnotes() {
        return $this->hasOne(OP::class, 'visit', 'visit_id');
    }

    public function appointments() {
        return $this->belongsTo(\Ignite\Reception\Entities\Appointments::class, 'visit_id');
    }

    public function doctors() {
        return $this->belongsTo(\Ignite\Core\Entities\UserProfile::class, 'destination', 'user_id');
    }

    public function schemes() {
        return $this->belongsTo(\Ignite\Setup\Entities\Schemes::class, 'scheme', 'scheme_id');
    }

    public function meta() {
        return $this->hasOne(VisitMeta::class, 'visit', 'visit_id');
    }

    public function amount() {
        return $this->treatments->sum('price');
    }

    public function getSettledAttribute() {
        return !(bool) ($this->treatments->where('is_paid', 0)->count());
    }

    public function getUnpaidAmountAttribute() {
        return $this->treatments->where('is_paid', 0)->sum('price*no_performed');
    }

    public function getVisitDestinationAttribute() {
        $build = [];
        if (!empty($this->destination) and $this->evaluation) {
            $build[] = 'Doctor: ' . $this->doctors->full_name;
        }
        if ($this->nurse) {
            $build[] = 'Nurse';
        }
        if ($this->theatre) {
            $build[] = 'Theatre';
        }
        if ($this->diagnostics) {
            $build[] = 'Diagnostics';
        }
        if ($this->laboratory) {
            $build[] = 'Laboratory';
        }
        if ($this->radiology) {
            $build[] = 'Radiology';
        }
        if ($this->pharmacy) {
            $build[] = 'Parmacy';
        }
        return implode(' | ', $build);
    }

    public function getSignedOutAttribute() {
        return empty($this->visit_destination);
    }

    public function scopeCheckedAt($query, $destination) {
        $out_build = $destination . '_out';
        return $query->where($destination, true)->whereNull($out_build);
    }

}
