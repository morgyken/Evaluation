<?php

namespace Ignite\Evaluation\Entities;

use Ignite\Finance\Entities\EvaluationPaymentsDetails;
use Ignite\Users\Entities\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Evaluation\Entities\Investigations
 *
 * @property int $id
 * @property int $visit
 * @property string $type
 * @property int $procedure
 * @property int $quantity
 * @property float $price
 * @property float $discount
 * @property float $amount
 * @property int $user
 * @property string $instructions
 * @property bool $ordered
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Ignite\Users\Entities\User $doctors
 * @property-read mixed $cash
 * @property-read mixed $has_result
 * @property-read mixed $is_paid
 * @property-read mixed $pesa
 * @property-read \Ignite\Finance\Entities\EvaluationPaymentsDetails $payments
 * @property-read \Ignite\Evaluation\Entities\Procedures $procedures
 * @property-read \Ignite\Finance\Entities\RemovedBills $removed_bills
 * @property-read \Ignite\Evaluation\Entities\InvestigationResult $results
 * @property-read \Ignite\Evaluation\Entities\Visit $visits
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Investigations diagnosis()
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Investigations laboratory()
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Investigations treatment()
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Investigations whereAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Investigations whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Investigations whereDiscount($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Investigations whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Investigations whereInstructions($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Investigations whereOrdered($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Investigations wherePrice($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Investigations whereProcedure($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Investigations whereQuantity($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Investigations whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Investigations whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Investigations whereUser($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Investigations whereVisit($value)
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

    public function p() {
        return $this->belongsTo(Procedures::class, 'procedure');
    }

    public function results() {
        return $this->hasOne(InvestigationResult::class, 'investigation');
    }

    public function payments() {
        return $this->hasOne(EvaluationPaymentsDetails::class, 'investigation');
    }

    public function getCashAttribute() {

    }

    public function getPesaAttribute() {
        return 'Ksh ' . number_format($this->price, 2);
    }

    public function removed_bills() {
        return $this->hasOne(\Ignite\Finance\Entities\RemovedBills::class, 'investigation');
    }

}
