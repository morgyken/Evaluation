<?php

namespace Ignite\Evaluation\Entities;

use Ignite\Inpatient\Entities\Ward;
use Illuminate\Database\Eloquent\Model;


/**
 * Ignite\Evaluation\Entities\Bedposition
 *
 * @property-read \Ignite\Inpatient\Entities\Ward $ward
 * @mixin \Eloquent
 */
class Bedposition extends Model
{
	protected $table = 'bed_position';
    protected $fillable = ['name','ward_id','status'];

    public function ward()
{
	return $this->belongsTo(Ward::class, 'ward_id');
}
}
