<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;

class FinancePatientAccounts extends Model
{
    protected $fillable = [
        'reference','details','credit','debit','patient'
    ];
    protected $table = 'finance_patient_accounts';
}
