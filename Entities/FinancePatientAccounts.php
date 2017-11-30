<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;
use Ignite\Reception\Entities\Patients;



class FinancePatientAccounts extends Model
{
    protected $fillable = [
        'reference', 'details', 'credit', 'debit', 'patient', 'mode'
    ];

    protected $table = 'finance_patient_accounts';

    public function patients()
    {
        return $this->belongsTo(Patients::class, "patient", "id");
    }
}
