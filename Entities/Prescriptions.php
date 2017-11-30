<?php

namespace Ignite\Evaluation\Entities;

use Ignite\Inventory\Entities\InventoryProducts;
use Ignite\Users\Entities\User;
use Ignite\Inpatient\Entities\Admission;
use Illuminate\Database\Eloquent\Model;
use Ignite\Inpatient\Entities\AdministerDrug;


class Prescriptions extends Model
{

    public $table = 'evaluation_prescriptions';
    protected $casts = ['allow_substitution' => 'boolean'];
    protected $guarded = [];
//    protected $appends = ['payment'];

    public function getDoseAttribute()
    {
        return $this->take . ' ' . mconfig('evaluation.options.prescription_whereto.' . $this->whereto) . ' '
            . mconfig('evaluation.options.prescription_method.' . $this->method) . ' '
            . $this->duration . ' ' . mconfig('evaluation.options.prescription_duration.' . $this->time_measure);
    }

    public function getSubAttribute()
    {
        return $this->allow_substitution ? 'Yes' : 'No';
    }

    public function admission()
    {
        return $this->belongsTo(Admission::class, 'admission_id');
    }

    public function visits()
    {
        return $this->belongsTo(Visit::class, 'visit');
    }

    public function drugs()
    {
        return $this->belongsTo(InventoryProducts::class, 'drug');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user');
    }

    public function dispensing()
    {
        return $this->hasMany(Dispensing::class, 'prescription');
    }

    public function payment()
    {
        return $this->hasOne(PrescriptionPayment::class, 'prescription_id');
    }

    public function getPricedAmountAttribute()
    {
        return $this->payment->total;
    }

    public function getIsPaidAttribute()
    {
        return $this->payment->invoiced || $this->payment->paid;
    }

    
    public function administered()
    {
        return  $this->hasMany(AdministerDrug::class, 'prescription_id');
    }
   
}
