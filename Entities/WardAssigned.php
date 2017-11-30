<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;


class WardAssigned extends Model
{
    protected $fillable = [
    	'visit_id',
'ward_id',
'admitted_at',
'discharged_at',
'price',
'status'
    ];
    protected $table = 'ward_assigned';
}
