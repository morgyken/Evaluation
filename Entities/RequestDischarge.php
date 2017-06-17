<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;
use Ignite\Users\Entities\User;


/**
 * Ignite\Evaluation\Entities\RequestDischarge
 *
 * @property int $id
 * @property int $doctor_id
 * @property int $visit_id
 * @property string $reason
 * @property string $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\RequestDischarge whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\RequestDischarge whereDoctorId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\RequestDischarge whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\RequestDischarge whereReason($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\RequestDischarge whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\RequestDischarge whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\RequestDischarge whereVisitId($value)
 * @mixin \Eloquent
 */
class RequestDischarge extends Model
{
    protected $fillable = [
    'doctor_id',
'visit_id',
'status'
    ];
}
