<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Ignite\Evaluation\Entities\Visits
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
 * @property-read mixed $settled
 * @property-read mixed $unpaid_amount
 * @property-read mixed $visit_destination
 * @property-read mixed $signed_out
 * @property-read \Ignite\Settings\Entities\Clinics $clinics
 * @property-read \Ignite\Reception\Entities\Patients $patients
 * @property-read \Ignite\Evaluation\Entities\Vitals $vitals
 * @property-read \Ignite\Evaluation\Entities\DoctorNotes $notes
 * @property-read \Ignite\Evaluation\Entities\Drawings $drawings
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Evaluation\Entities\Prescriptions[] $prescriptions
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Evaluation\Entities\Investigations[] $investigations
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Evaluation\Entities\Treatment[] $treatments
 * @property-read \Ignite\Evaluation\Entities\OpNotes $opnotes
 * @property-read \Ignite\Reception\Entities\Appointments $appointments
 * @property-read \Ignite\Users\Entities\UserProfile $doctors
 * @property-read \Ignite\Settings\Entities\Schemes $schemes
 * @property-read \Ignite\Evaluation\Entities\VisitMeta $meta
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Visits whereVisitId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Visits whereClinic($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Visits wherePatient($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Visits wherePurpose($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Visits whereDestination($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Visits whereNurse($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Visits whereNurseOut($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Visits whereTheatre($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Visits whereTheatreOut($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Visits whereDiagnostics($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Visits whereDiagnosticsOut($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Visits whereEvaluation($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Visits whereEvaluationOut($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Visits whereLaboratory($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Visits whereLaboratoryOut($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Visits whereRadiology($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Visits whereRadiologyOut($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Visits wherePharmacy($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Visits wherePharmacyOut($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Visits whereOptical($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Visits whereOpticalOut($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Visits whereUser($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Visits wherePaymentMode($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Visits whereScheme($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Visits whereNextAppointment($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Visits whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Visits whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Visits whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Visits checkedAt($destination)
 * @mixin \Eloquent
 */
class Visits extends Model {

    use SoftDeletes;

    public $primaryKey = 'visit_id';
    public $table = 'evaluation_visits';

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

    public function clinics() {
        return $this->belongsTo(\Ignite\Settings\Entities\Clinics::class, 'clinic');
    }

    public function patients() {
        return $this->belongsTo(\Ignite\Reception\Entities\Patients::class, 'patient');
    }

    public function vitals() {
        return $this->hasOne(Vitals::class, 'visit', 'visit_id');
    }

    public function notes() {
        return $this->hasOne(DoctorNotes::class, 'visit', 'visit_id');
    }

    public function drawings() {
        return $this->hasOne(Drawings::class, 'visit', 'visit_id');
    }

    public function prescriptions() {
        return $this->hasMany(Prescriptions::class, 'visit', 'visit_id');
    }

    public function investigations() {
        return $this->hasMany(Investigations::class, 'visit');
    }

    public function treatments() {
        return $this->hasMany(Treatment::class, 'visit', 'visit_id');
    }

    public function opnotes() {
        return $this->hasOne(OpNotes::class, 'visit', 'visit_id');
    }

    public function appointments() {
        return $this->belongsTo(\Ignite\Reception\Entities\Appointments::class, 'visit_id');
    }

    public function doctors() {
        return $this->belongsTo(\Ignite\Users\Entities\UserProfile::class, 'destination', 'user_id');
    }

    public function schemes() {
        return $this->belongsTo(\Ignite\Settings\Entities\Schemes::class, 'scheme', 'scheme_id');
    }

    public function meta() {
        return $this->hasOne(VisitMeta::class, 'visit', 'visit_id');
    }

}
