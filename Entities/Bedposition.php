<?php

namespace Ignite\Evaluation\Entities;

use Ignite\Inpatient\Entities\Ward;
use Illuminate\Database\Eloquent\Model;


class Bedposition extends Model
{
	protected $table = 'bed_position';
    protected $fillable = ['name','ward_id','status'];

    public function ward()
{
	return $this->belongsTo(Ward::class, 'ward_id');
}
}
