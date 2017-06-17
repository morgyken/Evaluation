<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Evaluation\Entities\Bedposition
 *
 * @property int $id
 * @property string $name
 * @property int $ward_id
 * @property string $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Ignite\Evaluation\Entities\Ward $ward
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Bedposition whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Bedposition whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Bedposition whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Bedposition whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Bedposition whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Bedposition whereWardId($value)
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
