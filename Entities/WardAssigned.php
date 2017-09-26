<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Evaluation\Entities\WardAssigned
 *
 * @property int $id
 * @property int $admission_id
 * @property int|null $visit_id
 * @property int $ward_id
 * @property string|null $admitted_at
 * @property string|null $discharged_at
 * @property float $price
 * @property string $status
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property int $invoiced
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\WardAssigned whereAdmissionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\WardAssigned whereAdmittedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\WardAssigned whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\WardAssigned whereDischargedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\WardAssigned whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\WardAssigned whereInvoiced($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\WardAssigned wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\WardAssigned whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\WardAssigned whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\WardAssigned whereVisitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\WardAssigned whereWardId($value)
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
