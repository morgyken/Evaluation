<?php

namespace Ignite\Evaluation\Entities;

use Ignite\Finance\Entities\RemovedBills;
use Illuminate\Database\Eloquent\Model;

use Ignite\Inpatient\Entities\Admission;
use Ignite\Inpatient\Entities\Visit;
use Ignite\Inpatient\Entities\NursingCharge;


class RecurrentCharge extends Model
{
  
    protected $table = 'inpatient_recurrent_charges';

    public function admission(){
        return $this->belongsTo(Admission::class, "admission_id", "id");
    }

    
    public function visit() {
        return $this->belongsTo(Visit::class, 'visit_id');
    }

//    public function charge() {
//        return $this->belongsTo(NursingCharge::class, 'recurrent_charge_id');
//    }

    public function removed_bills() {
        return $this->hasOne(RemovedBills::class, 'recurrent');
    }
}
