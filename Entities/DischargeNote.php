<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Evaluation\Entities\DischargeNote
 *
 * @property int $id
 * @property int $admission_id
 * @property int|null $doctor_id
 * @property int|null $visit_id
 * @property string|null $summary_note
 * @property string|null $case_note
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\DischargeNote whereAdmissionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\DischargeNote whereCaseNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\DischargeNote whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\DischargeNote whereDoctorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\DischargeNote whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\DischargeNote whereSummaryNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\DischargeNote whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\DischargeNote whereVisitId($value)
 * @mixin \Eloquent
 */
class DischargeNote extends Model
{
    protected $fillable = [
    'case_note','summary_note','visit_id','patient_id'
    ];
    protected $table = 'dischargeNotes';
}
