<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Evaluation\Entities\Admission
 *
 * @property int $id
 * @property int $patient_id
 * @property int $doctor_id
 * @property int $ward_id
 * @property int $bed_id
 * @property int $bedposition_id
 * @property float $cost
 * @property string $reason
 * @property string $external_doctor
 * @property int $visit_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Admission whereBedId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Admission whereBedpositionId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Admission whereCost($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Admission whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Admission whereDoctorId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Admission whereExternalDoctor($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Admission whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Admission wherePatientId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Admission whereReason($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Admission whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Admission whereVisitId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Admission whereWardId($value)
 * @mixin \Eloquent
 */
class Admission extends Model
{
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'ward_id',
        'bed_id',
        'cost',
        'reason',
        'external_doctor',
        'visit_id',
        'bedposition_id'
    ];
}
