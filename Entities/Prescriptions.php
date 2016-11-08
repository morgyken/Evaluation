<?php

namespace Ignite\Evaluation\Entities;

use Ignite\Inventory\Entities\InventoryProducts;
use Ignite\Users\Entities\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Evaluation\Entities\Prescriptions
 *
 * @property integer $id
 * @property integer $visit
 * @property string $drug
 * @property integer $take
 * @property integer $whereto
 * @property integer $method
 * @property integer $duration
 * @property boolean $allow_substitution
 * @property integer $time_measure
 * @property integer $user
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read mixed $dose
 * @property-read mixed $sub
 * @property-read \Ignite\Evaluation\Entities\Visit $visits
 * @property-read \Ignite\Inventory\Entities\InventoryProducts $drugs
 * @property-read \Ignite\Users\Entities\User $users
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Prescriptions whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Prescriptions whereVisit($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Prescriptions whereDrug($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Prescriptions whereTake($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Prescriptions whereWhereto($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Prescriptions whereMethod($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Prescriptions whereDuration($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Prescriptions whereAllowSubstitution($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Prescriptions whereTimeMeasure($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Prescriptions whereUser($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Prescriptions whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Prescriptions whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Prescriptions extends Model {

    public $table = 'evaluation_prescriptions';
    protected $casts = ['allow_substitution' => 'boolean'];
    public $incrementing = false;
    protected $guarded = [];

    public function getDoseAttribute() {
        return $this->take . ' ' . mconfig('evaluation.options.prescription_whereto.' . $this->whereto) . ' '
                . mconfig('evaluation.options.prescription_method.' . $this->method) . ' '
                . $this->duration . ' ' . mconfig('evaluation.options.prescription_duration.' . $this->time_measure);
    }

    public function getSubAttribute() {
        return $this->allow_substitution ? 'Yes' : 'No';
    }

    public function visits() {
        return $this->belongsTo(Visit::class, 'visit');
    }

    public function drugs() {
        return $this->belongsTo(InventoryProducts::class, 'drug');
    }

    public function users() {
        return $this->belongsTo(User::class, 'user');
    }

}
