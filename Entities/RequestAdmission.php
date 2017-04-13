<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;

class RequestAdmission extends Model
{
    protected $fillable = [
        'reason','patient_id','visit_id'
    ];
    protected $table = 'request_admissions';
}
