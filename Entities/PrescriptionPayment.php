<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;


class PrescriptionPayment extends Model
{
    protected $guarded = [];
    protected $table = 'evaluation_prescription_payments';

    public function getTotalAttribute()
    {
        return $this->cost;
    }

    public function prescription()
    {
        return $this->belongsTo(Prescriptions::class, 'prescription_id');
    }
}
