<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Evaluation\Entities\OP
 *
 * @property integer $id
 * @property integer $visit
 * @property string $surgery_indication
 * @property string $implants
 * @property string $postop
 * @property string $date
 * @property integer $doctor
 * @property string $indication
 * @property integer $user
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Ignite\Evaluation\Entities\PatientVisits $visits
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\OP whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\OP whereVisit($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\OP whereSurgeryIndication($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\OP whereImplants($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\OP wherePostop($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\OP whereDate($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\OP whereDoctor($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\OP whereIndication($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\OP whereUser($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\OP whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\OP whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class OP extends Model {

    public $primaryKey = 'visit';
    public $incrementing = false;
    public $table = 'patient_opnotes';
    protected $fillable = ['visit'];

    public function visits() {
        return $this->belongsTo(PatientVisits::class, 'visit', 'visit_id');
    }

}
