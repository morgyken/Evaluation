<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Evaluation\Entities\EvaluationPaymentsDetails
 *
 * @property integer $id
 * @property integer $payment
 * @property integer $investigation
 * @property float $cost
 * @property float $price
 * @property string $description
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Ignite\Evaluation\Entities\Investigations $investigations
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\EvaluationPaymentsDetails whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\EvaluationPaymentsDetails wherePayment($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\EvaluationPaymentsDetails whereInvestigation($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\EvaluationPaymentsDetails whereCost($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\EvaluationPaymentsDetails wherePrice($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\EvaluationPaymentsDetails whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\EvaluationPaymentsDetails whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\EvaluationPaymentsDetails whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EvaluationPaymentsDetails extends Model {

    protected $guarded = [];
    public $table = 'evaluation_payment_details';

    public function investigations() {
        return $this->belongsTo(Investigations::class, 'investigation');
    }

}
