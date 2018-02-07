<?php

namespace Ignite\Evaluation\Entities;

use Ignite\Core\Foundation\Remember;
use Ignite\Finance\Entities\ChangeInsurance;
use Ignite\Finance\Entities\Copay;
use Ignite\Reception\Entities\Appointments;
use Ignite\Reception\Entities\PatientInsurance;
use Ignite\Reception\Entities\Patients;
use Ignite\Settings\Entities\Clinics;
use Ignite\Users\Entities\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ignite\Finance\Entities\InsuranceInvoice;
use Ignite\Inpatient\Entities\AdmissionRequest;
use Ignite\Inpatient\Entities\Admission;
use Ignite\Inpatient\Entities\ChargeSheet;
use Ignite\Inpatient\Entities\DischargeRequest;


/**
 * Ignite\Evaluation\Entities\Visit
 *
 * @property int $id
 * @property int $clinic
 * @property int $patient
 * @property int|null $purpose
 * @property int|null $external_doctor
 * @property int $user
 * @property string $payment_mode
 * @property int|null $scheme
 * @property int|null $next_appointment
 * @property string|null $status
 * @property string|null $deleted_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property int|null $external_order
 * @property int $admission_request_id
 * @property-read \Ignite\Inpatient\Entities\Admission $admission
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Inpatient\Entities\AdmissionRequest[] $admissionRequest
 * @property-read \Ignite\Reception\Entities\Appointments $appointments
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Inpatient\Entities\ChargeSheet[] $chargeSheet
 * @property-read \Ignite\Settings\Entities\Clinics $clinics
 * @property-read \Ignite\Finance\Entities\Copay $copay
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Evaluation\Entities\VisitDestinations[] $destinations
 * @property-read \Ignite\Inpatient\Entities\DischargeRequest $discharge
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Evaluation\Entities\Dispensing[] $dispensing
 * @property-read \Ignite\Users\Entities\User $doctors
 * @property-read \Ignite\Evaluation\Entities\Drawings $drawings
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Inventory\Entities\InventoryBatchProductSales[] $drug_purchases
 * @property-read \Ignite\Users\Entities\User|null $external_doctors
 * @property-read mixed $doctor
 * @property-read mixed $doctor_i_d
 * @property-read mixed $is_cash
 * @property-read mixed $mode
 * @property-read mixed $place
 * @property-read mixed $signed_out
 * @property-read mixed $total_bill
 * @property-read mixed $unpaid_amount
 * @property-read mixed $unpaid_cash
 * @property-read mixed $unpaid_insurance
 * @property-read mixed $visit_destination
 * @property-read \Ignite\Finance\Entities\InsuranceInvoice $insurance_invoices
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Evaluation\Entities\Investigations[] $investigations
 * @property-read \Ignite\Evaluation\Entities\VisitMeta $metas
 * @property-read \Ignite\Evaluation\Entities\DoctorNotes $notes
 * @property-read \Ignite\Evaluation\Entities\OpNotes $opnotes
 * @property-read \Ignite\Reception\Entities\PatientInsurance|null $patient_scheme
 * @property-read \Ignite\Reception\Entities\Patients $patients
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Evaluation\Entities\Prescriptions[] $prescriptions
 * @property-read \Ignite\Evaluation\Entities\PartnerInstitution $requesting_institutions
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Finance\Entities\ChangeInsurance[] $to_cash
 * @property-read \Ignite\Evaluation\Entities\Vitals $vitals
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Visit checkedAt($destination)
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Visit onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Visit whereAdmissionRequestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Visit whereClinic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Visit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Visit whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Visit whereExternalDoctor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Visit whereExternalOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Visit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Visit whereNextAppointment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Visit wherePatient($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Visit wherePaymentMode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Visit wherePurpose($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Visit whereScheme($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Visit whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Visit whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Visit whereUser($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Visit withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Visit withoutTrashed()
 * @mixin \Eloquent
 */
class Visit extends Model
{

    use SoftDeletes;

    public $table = 'evaluation_visits';
    protected $fillable = ['inpatient', 'clinic', 'patient', 'purpose', 'external_doctor', 'user',
        'payment_mode', 'scheme', 'next_appointment', 'status'];

    protected $with = ['admissionRequest'];

    public function getUnpaidAmountAttribute()
    {
        return get_unpaid_amount($this);
    }

    public function getUnpaidCashAttribute()
    {
        return get_unpaid_amount_for($this, 'cash');
    }

    public function getUnpaidInsuranceAttribute()
    {
        return get_unpaid_amount_for($this, 'insurance');
    }

    public function getVisitDestinationAttribute()
    {
        return implode(' | ', $this->destinations->pluck('department')->toArray());
    }

    public function to_cash()
    {
        return $this->hasMany(ChangeInsurance::class, 'visit_id');
    }

    public function getSignedOutAttribute()
    {
        return empty($this->visit_destination);
    }

    public function scopeCheckedAt($query, $destination)
    {
        return $query->whereHas('destinations', function ($query) use ($destination) {
            $query->whereDepartment($destination);
            $query->whereCheckout(false);
        })->where('status', '<>', '!!');
    }

    public function getModeAttribute()
    {
        if ($this->payment_mode === 'insurance') {
            try {
                return ucfirst($this->payment_mode) . ' | ' .
                    $this->patient_scheme->desc;
            } catch (\Exception $exc) {
                return $this->payment_mode;
            }

        }
        return ucfirst($this->payment_mode);
    }

    public function getTotalBillAttribute()
    {
        return $this->investigations->sum('price');
    }

    public function clinics()
    {
        return $this->belongsTo(Clinics::class, 'clinic');
    }

    public function patients()
    {
        return $this->belongsTo(Patients::class, 'patient');
    }

    public function vitals()
    {
        return $this->hasOne(Vitals::class, 'visit');
    }

    public function notes()
    {
        return $this->hasOne(DoctorNotes::class, 'visit');
    }

    public function drawings()
    {
        return $this->hasOne(Drawings::class, 'visit');
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescriptions::class, 'visit');
    }

    public function investigations()
    {
        return $this->hasMany(Investigations::class, 'visit');
    }

    public function dispensing()
    {
        return $this->hasMany(Dispensing::class, 'visit');
    }

    public function opnotes()
    {
        return $this->hasOne(OpNotes::class, 'visit');
    }

    public function appointments()
    {
        return $this->belongsTo(Appointments::class);
    }

    public function doctors()
    {
        return $this->belongsTo(User::class, 'destination');
    }

    public function getDoctorAttribute()
    {
        foreach ($this->destinations as $d) {
            if ($d->destination > 0) {
                return $d->medics->profile->name;
            }
        }
        return null;
    }

    public function getDoctorIDAttribute()
    {
        foreach ($this->destinations as $d) {
            if ($d->destination > 0) {
                return $d->medics->id;
            }
        }
        return null;
    }

    public function patient_scheme()
    {
        return $this->belongsTo(PatientInsurance::class, 'scheme');
    }

    public function requesting_institutions()
    {
        return $this->belongsTo(PartnerInstitution::class, 'requesting_institution');
    }

    public function copay()
    {
        return $this->hasOne(Copay::class, 'visit_id');
    }

    public function metas()
    {
        return $this->hasOne(VisitMeta::class, 'visit');
    }

    public function destinations()
    {
        return $this->hasMany(VisitDestinations::class, 'visit');
    }

    public function drug_purchases()
    {
        return $this->hasMany(\Ignite\Inventory\Entities\InventoryBatchProductSales::class, 'id', 'visit');
    }

    public function external_doctors()
    {
        return $this->belongsTo(User::class, 'external_doctor');
    }

    public function insurance_invoices()
    {
        return $this->hasOne(InsuranceInvoice::class, 'visit');
    }

    public function admission()
    {
        return $this->hasOne(Admission::class);
    }

    public function getPlaceAttribute()
    {
        $p = [];
        foreach ($this->destinations as $d) {
            if ($d->destination > 0) {
                $p[] = $d->department;
//                    $d->medics->profile->name;
            }
            if ($d->room) {
                $p[] = $d->room->name;
            }
        }
        return implode(' , ', $p);
    }


    public function admissionRequest()
    {
        return $this->hasMany(AdmissionRequest::class, 'visit_id')->withTrashed();
    }


    public function chargeSheet()
    {
        return $this->hasMany(ChargeSheet::class);
    }

    /*
    * Relationship between a visit and a discharge request
    */
    public function discharge()
    {
        return $this->hasOne(DischargeRequest::class);
    }

    public function getIsCashAttribute()
    {
        return $this->payment_mode === 'cash';
    }
}
