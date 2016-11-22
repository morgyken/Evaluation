<?php

namespace Ignite\Evaluation\Entities;

use Ignite\Reception\Entities\Appointments;
use Ignite\Reception\Entities\PatientInsurance;
use Ignite\Reception\Entities\Patients;
use Ignite\Settings\Entities\Clinics;
use Ignite\Users\Entities\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Ignite\Evaluation\Entities\Visit
 *
 * @property integer $id
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
 * @property-read mixed $unpaid_amount
 * @property-read mixed $visit_destination
 * @property-read mixed $signed_out
 * @property-read mixed $mode
 * @property-read mixed $total_bill
 * @property-read \Ignite\Settings\Entities\Clinics $clinics
 * @property-read \Ignite\Reception\Entities\Patients $patients
 * @property-read \Ignite\Evaluation\Entities\Vitals $vitals
 * @property-read \Ignite\Evaluation\Entities\DoctorNotes $notes
 * @property-read \Ignite\Evaluation\Entities\Drawings $drawings
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Evaluation\Entities\Prescriptions[] $prescriptions
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Evaluation\Entities\Investigations[] $investigations
 * @property-read \Ignite\Evaluation\Entities\OpNotes $opnotes
 * @property-read \Ignite\Reception\Entities\Appointments $appointments
 * @property-read \Ignite\Users\Entities\User $doctors
 * @property-read \Ignite\Reception\Entities\PatientInsurance $patient_scheme
 * @property-read \Ignite\Evaluation\Entities\VisitMeta $meta
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Visit whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Visit whereClinic($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Visit wherePatient($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Visit wherePurpose($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Visit whereDestination($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Visit whereNurse($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Visit whereNurseOut($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Visit whereTheatre($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Visit whereTheatreOut($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Visit whereDiagnostics($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Visit whereDiagnosticsOut($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Visit whereEvaluation($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Visit whereEvaluationOut($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Visit whereLaboratory($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Visit whereLaboratoryOut($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Visit whereRadiology($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Visit whereRadiologyOut($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Visit wherePharmacy($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Visit wherePharmacyOut($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Visit whereOptical($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Visit whereOpticalOut($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Visit whereUser($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Visit wherePaymentMode($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Visit whereScheme($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Visit whereNextAppointment($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Visit whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Visit whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Visit whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Visit checkedAt($destination)
 * @mixin \Eloquent
 */
class Visit extends Model {

    use SoftDeletes;

    public $table = 'evaluation_visits';

    public function getUnpaidAmountAttribute() {
        $amount = 0;
        $amount+= $this->dispensing->where('payment_status', 0)->sum('amount');
        $amount+= $this->investigations->where('is_paid', 0)->sum('price');
        return $amount;
    }

    public function getVisitDestinationAttribute() {
        return implode(' | ', visit_destination($this));
    }

    public function getSignedOutAttribute() {
        return empty($this->visit_destination);
    }

    public function scopeCheckedAt($query, $destination) {
        $out_build = $destination . '_out';
        return $query->where($destination, true)->whereNull($out_build);
    }

    public function getModeAttribute() {
        if ($this->payment_mode == 'insurance') {
            return ucfirst($this->payment_mode) . " | " .
                    $this->patient_scheme->schemes->companies->name . " | " .
                    $this->patient_scheme->schemes->name;
        }
        return ucfirst($this->payment_mode);
    }

    public function getTotalBillAttribute() {
        return $this->investigations->sum('price');
    }

    public function clinics() {
        return $this->belongsTo(Clinics::class, 'clinic');
    }

    public function patients() {
        return $this->belongsTo(Patients::class, 'patient');
    }

    public function vitals() {
        return $this->hasOne(Vitals::class, 'visit');
    }

    public function notes() {
        return $this->hasOne(DoctorNotes::class, 'visit');
    }

    public function drawings() {
        return $this->hasOne(Drawings::class, 'visit');
    }

    public function prescriptions() {
        return $this->hasMany(Prescriptions::class, 'visit');
    }

    public function investigations() {
        return $this->hasMany(Investigations::class, 'visit');
    }

    public function dispensing() {
        return $this->hasMany(Dispensing::class, 'visit');
    }

    public function opnotes() {
        return $this->hasOne(OpNotes::class, 'visit');
    }

    public function appointments() {
        return $this->belongsTo(Appointments::class);
    }

    public function doctors() {
        return $this->belongsTo(User::class, 'user');
    }

    public function patient_scheme() {
        return $this->belongsTo(PatientInsurance::class, 'scheme');
    }

    public function meta() {
        return $this->hasOne(VisitMeta::class, 'visit');
    }

}
