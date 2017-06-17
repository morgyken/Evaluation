<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Evaluation\Entities\RecurrentCharge
 *
 * @property int $id
 * @property int $visit_id
 * @property int $recurrent_charge_id
 * @property string $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\RecurrentCharge whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\RecurrentCharge whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\RecurrentCharge whereRecurrentChargeId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\RecurrentCharge whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\RecurrentCharge whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\RecurrentCharge whereVisitId($value)
 * @mixin \Eloquent
 */
class RecurrentCharge extends Model
{
    protected $fillable = [
    	'visit_id','recurrent_charge_id','status'
    ];
    protected $table = 'recurrent_charges';
}
