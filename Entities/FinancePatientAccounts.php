<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Evaluation\Entities\FinancePatientAccounts
 *
 * @property int $id
 * @property string $reference
 * @property string $details
 * @property float $credit
 * @property float $debit
 * @property int $patient
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\FinancePatientAccounts whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\FinancePatientAccounts whereCredit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\FinancePatientAccounts whereDebit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\FinancePatientAccounts whereDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\FinancePatientAccounts whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\FinancePatientAccounts wherePatient($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\FinancePatientAccounts whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\FinancePatientAccounts whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class FinancePatientAccounts extends Model
{
    protected $fillable = [
        'reference','details','credit','debit','patient','mode'
    ];
    protected $table = 'finance_patient_accounts';
}
