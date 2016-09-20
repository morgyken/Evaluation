<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Evaluation\Entities\Investigations
 *
 * @property integer $id
 * @property integer $visit
 * @property string $type
 * @property integer $test
 * @property float $price
 * @property float $base
 * @property boolean $is_paid
 * @property integer $to_user
 * @property integer $from_user
 * @property string $instructions
 * @property string $results
 * @property integer $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property mixed $file
 * @property-read \Ignite\Evaluation\Entities\Visits $visits
 * @property-read \Ignite\Evaluation\Entities\Procedures $procedures
 * @property-read \Ignite\Users\Entities\UserProfile $doctors
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Investigations whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Investigations whereVisit($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Investigations whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Investigations whereTest($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Investigations wherePrice($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Investigations whereBase($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Investigations whereIsPaid($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Investigations whereToUser($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Investigations whereFromUser($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Investigations whereInstructions($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Investigations whereResults($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Investigations whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Investigations whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Investigations whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Investigations whereFile($value)
 * @mixin \Eloquent
 */
class Investigations extends Model {

    public $primaryKey = 'visit';
    protected $table = 'evaluation_investigations';
    protected $guarded = [];

    public function visits() {
        return $this->belongsTo(Visits::class, 'visit', 'visit_id');
    }

    public function procedures() {
        return $this->hasOne(Procedures::class, 'id', 'test');
    }

    public function doctors() {
        return $this->belongsTo(\Ignite\Users\Entities\UserProfile::class, 'from_user', 'user_id');
    }

}
