<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Evaluation\Entities\Drawings
 *
 * @property integer $id
 * @property integer $visit
 * @property integer $user
 * @property integer $patient
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Ignite\Evaluation\Entities\Visit $visits
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Drawings whereId($value)
 * @mixin \Eloquent
 */
class Dispensing extends Model {

    public $table = 'inventory_evaluation_dispensing';
    protected $fillable = ['visit', 'user', 'batch'];

    public function visits() {
        return $this->belongsTo(Visit::class, 'visit');
    }

}
