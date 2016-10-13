<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Evaluation\Entities\EvaluationPaymentMpesa
 *
 * @property integer $id
 * @property integer $payment
 * @property string $reference
 * @property string $number
 * @property string $paybil
 * @property string $account
 * @property float $amount
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\EvaluationPaymentMpesa whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\EvaluationPaymentMpesa wherePayment($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\EvaluationPaymentMpesa whereReference($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\EvaluationPaymentMpesa whereNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\EvaluationPaymentMpesa wherePaybil($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\EvaluationPaymentMpesa whereAccount($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\EvaluationPaymentMpesa whereAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\EvaluationPaymentMpesa whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\EvaluationPaymentMpesa whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EvaluationPaymentMpesa extends Model {

    protected $guarded = [];
    public $table = 'evaluation_payments_mpesa';

}
