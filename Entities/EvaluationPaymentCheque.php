<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Evaluation\Entities\EvaluationPaymentCheque
 *
 * @property integer $id
 * @property integer $payment
 * @property string $name
 * @property string $number
 * @property string $date
 * @property string $bank
 * @property string $bank_branch
 * @property float $amount
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\EvaluationPaymentCheque whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\EvaluationPaymentCheque wherePayment($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\EvaluationPaymentCheque whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\EvaluationPaymentCheque whereNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\EvaluationPaymentCheque whereDate($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\EvaluationPaymentCheque whereBank($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\EvaluationPaymentCheque whereBankBranch($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\EvaluationPaymentCheque whereAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\EvaluationPaymentCheque whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\EvaluationPaymentCheque whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EvaluationPaymentCheque extends Model {

    protected $guarded = [];
    public $table = 'evaluation_payments_cheque';

}
