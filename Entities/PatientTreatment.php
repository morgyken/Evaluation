<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Evaluation\Entities\PatientTreatment
 *
 * @property integer $id
 * @property integer $visit
 * @property integer $procedure
 * @property float $price
 * @property float $base
 * @property integer $no_performed
 * @property boolean $is_paid
 * @property integer $user
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Ignite\Evaluation\Entities\PatientVisits $visits
 * @property-read \Ignite\Setup\Entities\Procedures $procedures
 * @property-read mixed $net
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientTreatment whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientTreatment whereVisit($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientTreatment whereProcedure($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientTreatment wherePrice($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientTreatment whereBase($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientTreatment whereNoPerformed($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientTreatment whereIsPaid($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientTreatment whereUser($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientTreatment whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientTreatment whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PatientTreatment extends Model {

    public $primaryKey = 'visit';

    public function visits() {
        return $this->belongsTo(PatientVisits::class, 'visit', 'visit_id');
    }

    public function procedures() {
        return $this->belongsTo(\Ignite\Setup\Entities\Procedures::class, 'procedure', 'procedure_id');
    }

    public function getNetAttribute() {
        return $this->price * $this->no_performed;
    }

}
