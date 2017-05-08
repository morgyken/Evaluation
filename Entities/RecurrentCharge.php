<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;

class RecurrentCharge extends Model
{
    protected $fillable = [
    	'visit_id','recurrent_charge_id','status'
    ];
    protected $table = 'recurrent_charges';
}
