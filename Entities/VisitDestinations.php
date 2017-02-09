<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Evaluation\Entities\VisitDestinations
 *
 * @property integer $id
 * @property integer $visit
 * @property integer $user
 * @property integer $destination
 * @property string $department
 * @property boolean $checkout
 * @property string $begin_at
 * @property string $finish_at
 * @property string $deleted_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\VisitDestinations whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\VisitDestinations whereVisit($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\VisitDestinations whereUser($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\VisitDestinations whereDestination($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\VisitDestinations whereDepartment($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\VisitDestinations whereCheckout($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\VisitDestinations whereBeginAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\VisitDestinations whereFinishAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\VisitDestinations whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\VisitDestinations whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\VisitDestinations whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class VisitDestinations extends Model {

    public $table = 'evaluation_visit_destinations';
    protected $guarded = [];

    public function visits() {
        return $this->hasMany(Visit::class, 'id', 'visit');
    }

}
