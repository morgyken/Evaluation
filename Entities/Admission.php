<?php

namespace Ignite\Evaluation\Entities;

use Ignite\Reception\Entities\Patients;
use Illuminate\Database\Eloquent\Model;


/**
 * Ignite\Evaluation\Entities\Admission
 *
 * @property-read \Ignite\Reception\Entities\Patients $patient
 * @mixin \Eloquent
 */
class Admission extends Model
{
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'ward_id',
        'bed_id',
        'cost',
        'reason',
        'external_doctor',
        'visit_id',
        'bedposition_id'
    ];


    public function patient()
    {
        return $this->belongsTo(Patients::class, 'patient_id');
    }
}
