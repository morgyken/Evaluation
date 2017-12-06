<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;

use Ignite\Inpatient\Entities\AdministerDrug;

class Dispensing extends Model {

    public $table = 'inventory_evaluation_dispensing';
    protected $fillable = ['visit', 'user', 'prescription'];

    public function visits() {
        return $this->belongsTo(Visit::class, 'visit');
    }

    public function details() {
        return $this->hasMany(DispensingDetails::class, 'batch');
    }

    public function prescriptions() {
        return $this->belongsTo(Prescriptions::class, 'prescription');
    }

    public function removed_bills() {
        return $this->hasOne(\Ignite\Finance\Entities\RemovedBills::class, 'dispensing');
    }
}
