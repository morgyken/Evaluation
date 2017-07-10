<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Evaluation\Entities\Discharge
 *
 * @property int $id
 * @property int $visit_id
 * @property int|null $doctor_id
 * @property string $type
 * @property string $DischargeNote
 * @property string|null $dateofdeath
 * @property string|null $timeofdeath
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Discharge whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Discharge whereDateofdeath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Discharge whereDischargeNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Discharge whereDoctorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Discharge whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Discharge whereTimeofdeath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Discharge whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Discharge whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Discharge whereVisitId($value)
 * @mixin \Eloquent
 */
class Discharge extends Model
{
    protected $fillable = [
    'visit_id',
'doctor_id',
'DischargeNote',
'dateofdeath',
'type',
'timeofdeath'
    ];
    protected $table = 'discharges';
}
