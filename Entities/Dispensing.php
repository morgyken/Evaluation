<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Evaluation\Entities\Dispensing
 *
 * @property integer $id
 * @property integer $visit
 * @property integer $user
 * @property integer $batch
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Ignite\Evaluation\Entities\Visit $visits
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Dispensing whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Dispensing whereVisit($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Dispensing whereUser($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Dispensing whereBatch($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Dispensing whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Dispensing whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Dispensing extends Model {

    public $table = 'inventory_evaluation_dispensing';
    protected $fillable = ['visit', 'user', 'batch'];

    public function visits() {
        return $this->belongsTo(Visit::class, 'visit');
    }

}
