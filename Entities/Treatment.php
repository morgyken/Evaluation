<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Evaluation\Entities\Treatment
 *
 * @property integer $id
 * @property integer $visit
 * @property integer $procedure
 * @property float $price
 * @property float $base
 * @property boolean $is_paid
 * @property integer $user
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Ignite\Evaluation\Entities\Visit $visits
 * @property-read \Ignite\Evaluation\Entities\Procedures $procedures
 * @property-read mixed $net
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Treatment whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Treatment whereVisit($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Treatment whereProcedure($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Treatment wherePrice($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Treatment whereBase($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Treatment whereIsPaid($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Treatment whereUser($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Treatment whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Treatment whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Treatment extends Model {

    public $primaryKey = 'visit';
    public $table = 'evaluation_treatments';

    public function visits() {
        return $this->belongsTo(Visit::class, 'visit');
    }

    public function procedures() {
        return $this->belongsTo(Procedures::class, 'procedure');
    }

    public function getNetAttribute() {
        return $this->price * $this->no_performed;
    }

}
