<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;

class NursingCharge extends Model
{
    protected $fillable = [
    	'name','cost','ward_id','type'
    ];
    protected $table = 'nursing_charges';

   
}
