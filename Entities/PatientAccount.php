<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;

class PatientAccount extends Model
{
    protected $fillable = [
        'patient_id','balance'
    ];
    protected $table = 'Patient_account';
}
