<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Evaluation\Entities\Preliminary
 *
 * @property integer $id
 * @property integer $visit
 * @property string $entity
 * @property string $left
 * @property string $right
 * @property string $remarks
 * @property integer $user
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Preliminary whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Preliminary whereVisit($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Preliminary whereEntity($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Preliminary whereLeft($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Preliminary whereRight($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Preliminary whereRemarks($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Preliminary whereUser($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Preliminary whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Preliminary whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Preliminary extends Model {

    protected $guarded = [];
    public $table = 'evaluation_preliminary';

}
