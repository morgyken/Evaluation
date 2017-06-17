<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Evaluation\Entities\WardAssigned
 *
 * @property int $id
 * @property int $visit_id
 * @property int $ward_id
 * @property string $admitted_at
 * @property string $discharged_at
 * @property float $price
 * @property string $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\WardAssigned whereAdmittedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\WardAssigned whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\WardAssigned whereDischargedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\WardAssigned whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\WardAssigned wherePrice($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\WardAssigned whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\WardAssigned whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\WardAssigned whereVisitId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\WardAssigned whereWardId($value)
 * @mixin \Eloquent
 */
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
