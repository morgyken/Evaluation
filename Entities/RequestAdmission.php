<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Evaluation\Entities\RequestAdmission
 *
 * @property int $id
 * @property int $visit_id
 * @property string $reason
 * @property int $patient_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\RequestAdmission whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\RequestAdmission whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\RequestAdmission wherePatientId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\RequestAdmission whereReason($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\RequestAdmission whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\RequestAdmission whereVisitId($value)
 * @mixin \Eloquent
 */
class RequestAdmission extends Model
{
    protected $fillable = [
        'reason','patient_id','visit_id'
    ];
    protected $table = 'request_admissions';
}
