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
        return $this->hasMany(AdmissionRequest::class, 'visit_id');
    }

    
    public function chargeSheet()
    {
        return $this->hasMany(ChargeSheet::class);
    } 
}
