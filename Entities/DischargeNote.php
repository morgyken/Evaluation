<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Evaluation\Entities\DischargeNote
 *
 * @mixin \Eloquent
 */
class DischargeNote extends Model
{
    protected $fillable = [
    'case_note','summary_note','visit_id','patient_id'
    ];
    protected $table = 'dischargeNotes';
}
