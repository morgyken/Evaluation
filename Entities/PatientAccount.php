<?php

namespace Ignite\Evaluation\Entities;

use Ignite\Reception\Entities\Patients;
use Illuminate\Database\Eloquent\Model;


/**
 * Ignite\Evaluation\Entities\PatientAccount
 *
 * @property-read \Ignite\Reception\Entities\Patients $patient
 * @mixin \Eloquent
 */
class PatientAccount extends Model
{
    protected $fillable = [
        'patient_id', 'balance'
    ];

    public function patient()
    {
        return $this->belongsTo(Patients::class, 'patient_id', 'id');
    }

    protected $table = 'patient_account';
}
