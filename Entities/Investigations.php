<?php

namespace Ignite\Evaluation\Entities;

use Ignite\Finance\Entities\EvaluationPaymentsDetails;
use Ignite\Users\Entities\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Evaluation\Entities\Investigations
 *
 * @property integer $id
 * @property integer $visit
 * @property string $type
 * @property integer $procedure
 * @property float $price
 * @property integer $user
 * @property string $instructions
 * @property boolean $ordered
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read mixed $has_result
 * @property-read mixed $is_paid
 * @property-read \Ignite\Evaluation\Entities\Visit $visits
 * @property-read \Ignite\Evaluation\Entities\Procedures $procedures
 * @property-read \Ignite\Users\Entities\User $doctors
 * @property-read \Ignite\Evaluation\Entities\InvestigationResult $results
 * @property-read \Ignite\Finance\Entities\EvaluationPaymentsDetails $payments
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Investigations whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Investigations whereVisit($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Investigations whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Investigations whereProcedure($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Investigations wherePrice($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Investigations whereUser($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Investigations whereInstructions($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Investigations whereOrdered($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Investigations whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Investigations whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Investigations laboratory()
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Investigations diagnosis()
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Investigations treatment()
 * @mixin \Eloquent
 */
class Investigations extends Model {

    protected $table = 'evaluation_investigations';
    protected $guarded = [];
    protected $appends = ['is_paid'];

    public function getHasResultAttribute() {
        return count($this->results);
    }

    public function getPriceAttribute($value) {
        return intval($value);
    }

    public function getIsPaidAttribute() {
        return (bool) $this->payments;
    }

    public function scopeLaboratory($query) {
        return $query->where('type', 'laboratory');
    }

    public function scopeDiagnosis($query) {
        return $query->where('type', 'diagnosis');
    }

    public function scopeTreatment($query) {
        return $query->where('type', 'treatment');
    }

    public function visits() {
        return $this->belongsTo(Visit::class, 'visit');
    }

    public function procedures() {
        return $this->hasOne(Procedures::class, 'id', 'procedure');
    }

    public function doctors() {
        return $this->belongsTo(User::class, 'user');
    }

    public function results() {
        return $this->hasOne(InvestigationResult::class, 'investigation');
    }

    public function payments() {
        return $this->hasOne(EvaluationPaymentsDetails::class, 'investigation');
    }
    public function getPesaAttribute(){
        return 'Ksh '.number_format($this->price,2);
    }
}
