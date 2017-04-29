<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;

class Bedposition extends Model
{
	protected $table = 'bed_position';
    protected $fillable = ['name','ward_id','status'];
}
