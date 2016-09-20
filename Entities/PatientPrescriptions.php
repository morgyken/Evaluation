<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Evaluation\Entities\PatientPrescriptions
 *
 * @property integer $id
 * @property integer $visit
 * @property string $drug
 * @property string $take
 * @property integer $whereto
 * @property integer $method
 * @property string $duration
 * @property boolean $allow_substitution
 * @property integer $user
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Ignite\Evaluation\Entities\PatientVisits $visits
 * @property-read mixed $dose
 * @property-read mixed $sub
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientPrescriptions whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientPrescriptions whereVisit($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientPrescriptions whereDrug($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientPrescriptions whereTake($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientPrescriptions whereWhereto($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientPrescriptions whereMethod($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientPrescriptions whereDuration($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientPrescriptions whereAllowSubstitution($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientPrescriptions whereUser($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientPrescriptions whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientPrescriptions whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PatientPrescriptions extends Model {

    protected $casts = ['allow_substitution' => 'boolean'];
    public $primaryKey = 'visit';
    public $incrementing = false;

    public function visits() {
        return $this->belongsTo(PatientVisits::class, 'visit', 'visit_id');
    }

    public function getDoseAttribute() {
        return $this->take . ' ' . config('system.prescription_whereto.' . $this->whereto) . ' '
                . config('system.prescription_method.' . $this->method);
    }

    public function getSubAttribute() {
        return $this->allow_substitution ? 'Yes' : 'No';
    }

}
