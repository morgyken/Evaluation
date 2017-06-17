<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Evaluation\Entities\V1Diagnosis
 *
 * @property-read \Ignite\Evaluation\Entities\DiagnosisCodes $diagnosis
 * @mixin \Eloquent
 */
class V1Diagnosis extends Model {

    public $table = 'v1_patient_diagnosis';

    public function diagnosis() {
        return $this->belongsTo(DiagnosisCodes::class, 'Unique_Diagnosis_Id', 'id');
    }

}
