<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Evaluation\Entities\EvaluationPaymentCard
 *
 * @property integer $id
 * @property integer $payment
 * @property string $type
 * @property string $name
 * @property string $number
 * @property string $expiry
 * @property string $security
 * @property float $amount
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\EvaluationPaymentCard whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\EvaluationPaymentCard wherePayment($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\EvaluationPaymentCard whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\EvaluationPaymentCard whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\EvaluationPaymentCard whereNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\EvaluationPaymentCard whereExpiry($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\EvaluationPaymentCard whereSecurity($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\EvaluationPaymentCard whereAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\EvaluationPaymentCard whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\EvaluationPaymentCard whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EvaluationPaymentCard extends Model {

    protected $guarded = [];
    public $table = 'evaluation_payments_card';

}
