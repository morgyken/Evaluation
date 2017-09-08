<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Evaluation\Entities\RequestAdmission
 *
 * @property int $id
 * @property int $patient_id
 * @property int|null $visit_id
 * @property string|null $reason
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\RequestAdmission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\RequestAdmission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\RequestAdmission wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\RequestAdmission whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\RequestAdmission whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\RequestAdmission whereVisitId($value)
 * @mixin \Eloquent
 */
class RequestAdmission extends Model
{
    protected $fillable = [
        'reason','patient_id','visit_id'
    ];
    protected $table = 'request_admissions';
}
