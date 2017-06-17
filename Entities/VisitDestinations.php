<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Evaluation\Entities\VisitDestinations
 *
 * @property int $id
 * @property int $visit
 * @property int $user
 * @property int $destination
 * @property string $department
 * @property bool $checkout
 * @property string $begin_at
 * @property string $finish_at
 * @property string $deleted_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Ignite\Users\Entities\User $medics
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Evaluation\Entities\Visit[] $visits
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\VisitDestinations whereBeginAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\VisitDestinations whereCheckout($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\VisitDestinations whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\VisitDestinations whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\VisitDestinations whereDepartment($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\VisitDestinations whereDestination($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\VisitDestinations whereFinishAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\VisitDestinations whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\VisitDestinations whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\VisitDestinations whereUser($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\VisitDestinations whereVisit($value)
 * @mixin \Eloquent
 */
class VisitDestinations extends Model {

    public $table = 'evaluation_visit_destinations';
    protected $guarded = [];

    public function visits() {
        return $this->hasMany(Visit::class, 'id', 'visit');
    }

    public function medics() {
        return $this->belongsTo(\Ignite\Users\Entities\User::class, 'destination');
    }

}
