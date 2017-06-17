<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Evaluation\Entities\DischargeNote
 *
 * @property int $id
 * @property string $summary_note
 * @property string $case_note
 * @property int $doctor_id
 * @property int $visit_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\DischargeNote whereCaseNote($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\DischargeNote whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\DischargeNote whereDoctorId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\DischargeNote whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\DischargeNote whereSummaryNote($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\DischargeNote whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\DischargeNote whereVisitId($value)
 * @mixin \Eloquent
 */
class DischargeNote extends Model
{
    protected $fillable = [
    'case_note','summary_note','visit_id','patient_id'
    ];
    protected $table = 'dischargeNotes';
}
