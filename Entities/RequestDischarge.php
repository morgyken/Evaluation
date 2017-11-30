<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;
use Ignite\Users\Entities\User;



class RequestDischarge extends Model
{
    protected $fillable = [
    'doctor_id',
'visit_id',
'status'
    ];
}
