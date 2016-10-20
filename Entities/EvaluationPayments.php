<?php

namespace Ignite\Evaluation\Entities;

use Ignite\Reception\Entities\Patients;
use Ignite\Users\Entities\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Evaluation\Entities\EvaluationPayments
 *
 * @property integer $id
 * @property string $receipt
 * @property integer $patient
 * @property integer $user
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read mixed $total
 * @property-read mixed $modes
 * @property-read \Ignite\Evaluation\Entities\EvaluationPaymentCash $cash
 * @property-read \Ignite\Evaluation\Entities\EvaluationPaymentMpesa $mpesa
 * @property-read \Ignite\Evaluation\Entities\EvaluationPaymentCheque $cheque
 * @property-read \Ignite\Evaluation\Entities\EvaluationPaymentCard $card
 * @property-read \Ignite\Reception\Entities\Patients $patients
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Evaluation\Entities\EvaluationPaymentsDetails[] $details
 * @property-read \Ignite\Users\Entities\User $users
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\EvaluationPayments whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\EvaluationPayments whereReceipt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\EvaluationPayments wherePatient($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\EvaluationPayments whereUser($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\EvaluationPayments whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\EvaluationPayments whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EvaluationPayments extends Model
{

    protected $fillable = [];
    public $table = 'evaluation_payments';

    public function getTotalAttribute()
    {
        $total = 0;
        if (!empty($this->cash)) {
            $total += $this->cash->amount;
        }
        if (!empty($this->card)) {
            $total += $this->card->amount;
        }
        if (!empty($this->mpesa)) {
            $total += $this->mpesa->amount;
        }
        if (!empty($this->cheque)) {
            $total += $this->cheque->amount;
        }
        return number_format($total, 2);
    }

    public function getModesAttribute()
    {
        return payment_modes($this);
    }

    public function cash()
    {
        return $this->hasOne(EvaluationPaymentCash::class, 'payment');
    }

    public function mpesa()
    {
        return $this->hasOne(EvaluationPaymentMpesa::class, 'payment');
    }

    public function cheque()
    {
        return $this->hasOne(EvaluationPaymentCheque::class, 'payment');
    }

    public function card()
    {
        return $this->hasOne(EvaluationPaymentCard::class, 'payment');
    }

    public function patients()
    {
        return $this->belongsTo(Patients::class, 'patient');
    }

    public function details()
    {
        return $this->hasMany(EvaluationPaymentsDetails::class, 'payment');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user');
    }
}
