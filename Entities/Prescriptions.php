<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Evaluation\Entities\Prescriptions
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
 * @property-read \Ignite\Evaluation\Entities\Visit $visits
 * @property-read mixed $dose
 * @property-read mixed $sub
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Prescriptions whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Prescriptions whereVisit($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Prescriptions whereDrug($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Prescriptions whereTake($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Prescriptions whereWhereto($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Prescriptions whereMethod($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Prescriptions whereDuration($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Prescriptions whereAllowSubstitution($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Prescriptions whereUser($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Prescriptions whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Prescriptions whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Prescriptions extends Model {

    protected $casts = ['allow_substitution' => 'boolean'];
    //public $primaryKey = 'visit';
    public $incrementing = false;
    public $table = 'evaluation_prescriptions';

    public function visits() {
        return $this->belongsTo(Visit::class, 'visit');
    }

    public function drugs() {
        return $this->belongsTo(\Ignite\Inventory\Entities\InventoryProducts::class, 'id');
    }

    public function users() {
        return $this->belongsTo(\Ignite\Users\Entities\User::class, 'id');
    }

    public function getDoseAttribute() {
        return $this->take . ' ' . config('system.prescription_whereto.' . $this->whereto) . ' '
                . config('system.prescription_method.' . $this->method);
    }

    public function getSubAttribute() {
        return $this->allow_substitution ? 'Yes' : 'No';
    }

}
