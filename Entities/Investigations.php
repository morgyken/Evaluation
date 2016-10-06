<?php

namespace Ignite\Evaluation\Entities;

use Ignite\Users\Entities\UserProfile;
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
 * @property boolean $paid
 * @property integer $user
 * @property boolean $orderd
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Ignite\Evaluation\Entities\Visit $visits
 * @property-read \Ignite\Evaluation\Entities\Procedures $procedures
 * @property-read \Ignite\Users\Entities\UserProfile $doctors
 * @property-read \Ignite\Evaluation\Entities\InvestigationResult $results
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Investigations whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Investigations whereVisit($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Investigations whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Investigations whereTest($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Investigations wherePrice($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Investigations whereBase($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Investigations wherePaid($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Investigations whereUser($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Investigations whereOrderd($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Investigations whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Investigations whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Investigations extends Model {

    public $primaryKey = 'visit';
    protected $table = 'evaluation_investigations';
    protected $guarded = [];

    public function visits() {
        return $this->belongsTo(Visit::class, 'visit');
    }

    public function procedures() {
        return $this->hasOne(Procedures::class, 'id', 'test');
    }

    public function doctors() {
        return $this->belongsTo(UserProfile::class, 'from_user', 'user_id');
    }

    public function results() {
        return $this->hasOne(InvestigationResult::class, 'id', 'id');
    }

}
