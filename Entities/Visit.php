<?php

namespace Ignite\Evaluation\Entities;

use Ignite\Reception\Entities\Appointments;
use Ignite\Reception\Entities\PatientInsurance;
use Ignite\Reception\Entities\Patients;
use Ignite\Settings\Entities\Clinics;
use Ignite\Users\Entities\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ignite\Finance\Entities\InsuranceInvoice;

/**
 * Ignite\Evaluation\Entities\Visit
 *
 * @property int $id
 * @property int $clinic
 * @property int $patient
 * @property int|null $purpose
 * @property int|null $external_doctor
 * @property string|null $inpatient
 * @property int $user
 * @property string $payment_mode
 * @property int|null $scheme
 * @property int|null $next_appointment
 * @property string|null $status
 * @property string|null $deleted_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property int|null $external_order
 * @property-read \Ignite\Inpatient\Entities\Admission $admission
 * @property-read \Ignite\Reception\Entities\Appointments $appointments
 * @property-read \Ignite\Settings\Entities\Clinics $clinics
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Evaluation\Entities\VisitDestinations[] $destinations
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Evaluation\Entities\Dispensing[] $dispensing
 * @property-read \Ignite\Users\Entities\User $doctors
 * @property-read \Ignite\Evaluation\Entities\Drawings $drawings
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Inventory\Entities\InventoryBatchProductSales[] $drug_purchases
 * @property-read \Ignite\Users\Entities\User|null $external_doctors
 * @property-read mixed $doctor
 * @property-read mixed $doctor_i_d
 * @property-read mixed $mode
 * @property-read mixed $place
 * @property-read mixed $signed_out
 * @property-read mixed $total_bill
 * @property-read mixed $unpaid_amount
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
 * @property-read \Ignite\Evaluation\Entities\Vitals $vitals
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Visit checkedAt($destination)
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Visit onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Visit whereClinic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Visit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Visit whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Visit whereExternalDoctor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Visit whereExternalOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Visit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Visit whereInpatient($value)
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

    public function getUnpaidAmountAttribute()
    {
        $amount = 0;
        $amount += $this->dispensing->where('payment_status', 0)->sum('amount');
        $amount += $this->investigations->where('is_paid', 0)->sum('price');
        return $amount;
    }

    public function getVisitDestinationAttribute()
    {
        return implode(' | ', $this->destinations->pluck('department')->toArray());
    }

    public function getSignedOutAttribute()
    {
        return empty($this->visit_destination);
    }

    public function scopeCheckedAt($query, $destination)
    {
        return $query->whereHas('destinations', function ($query) use ($destination) {
            $query->whereDepartment($destination);
            $query->whereCheckout(0);
        });
    }

    public function getModeAttribute()
    {
        if ($this->payment_mode == 'insurance') {

            try {
                return ucfirst($this->payment_mode) . " | " .
                    $this->patient_scheme->schemes->companies->name . " | " .
                    $this->patient_scheme->schemes->name;
            } catch (\Exception $exc) {
                return ($this->payment_mode);
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
            } else {
                return '';
            }
        }
        //return $doc;
    }

    public function getDoctorIDAttribute()
    {
        foreach ($this->destinations as $d) {
            if ($d->destination > 0) {
                return $d->medics->id;
            } else {
                return '';
            }
        }
        //return $doc;
    }

    public function patient_scheme()
    {
        return $this->belongsTo(PatientInsurance::class, 'scheme');
    }

    public function requesting_institutions()
    {
        return $this->belongsTo(PartnerInstitution::class, 'requesting_institution');
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
        return $this->hasOne(\Ignite\Inpatient\Entities\Admission::class, 'visit_id');
    }

    public function getPlaceAttribute()
    {
        $p = [];
        foreach ($this->destinations as $d) {
            if ($d->destination > 0) {
                $p[] = /*$d->department . */
                    $d->medics->profile->name;
            }
            if ($d->room) {
                $p[] = $d->room->name;
            }
        }
        return implode(' , ', $p);
    }
}
