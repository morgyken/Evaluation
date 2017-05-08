<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;

class Discharge extends Model
{
    protected $fillable = [
    'visit_id',
'doctor_id',
'DischargeNote',
'dateofdeath',
'type',
'timeofdeath'
    ];
    protected $table = 'discharges';
}
