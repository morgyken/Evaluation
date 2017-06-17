<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Evaluation\Entities\Drawings
 *
 * @property int $id
 * @property int $visit
 * @property string $object
 * @property int $user
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Ignite\Evaluation\Entities\Visit $visits
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Drawings whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Drawings whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Drawings whereObject($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Drawings whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Drawings whereUser($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Drawings whereVisit($value)
 * @mixin \Eloquent
 */
class Drawings extends Model {

    public $table = 'evaluation_drawings';

    public function visits() {
        return $this->belongsTo(Visit::class, 'visit');
    }

}
