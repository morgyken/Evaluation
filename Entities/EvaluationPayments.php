<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Evaluation\Entities\EvaluationPayments
 *
 * @property integer $id
 * @property string $receipt
 * @property integer $patient
 * @property string $description
 * @property integer $user
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Ignite\Evaluation\Entities\EvaluationPaymentCash $cash
 * @property-read \Ignite\Evaluation\Entities\EvaluationPaymentMpesa $mpesa
 * @property-read \Ignite\Evaluation\Entities\EvaluationPaymentCheque $cheque
 * @property-read \Ignite\Evaluation\Entities\EvaluationPaymentCard $card
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\EvaluationPayments whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\EvaluationPayments whereReceipt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\EvaluationPayments wherePatient($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\EvaluationPayments whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\EvaluationPayments whereUser($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\EvaluationPayments whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\EvaluationPayments whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EvaluationPayments extends Model {

    protected $fillable = [];
    public $table = 'evaluation_payments';

    public function cash() {
        return $this->hasOne(EvaluationPaymentCash::class, 'payment');
    }

    public function mpesa() {
        return $this->hasOne(EvaluationPaymentMpesa::class, 'payment');
    }

    public function cheque() {
        return $this->hasOne(EvaluationPaymentCheque::class, 'payment');
    }

    public function card() {
        return $this->hasOne(EvaluationPaymentCard::class, 'payment');
    }

}
