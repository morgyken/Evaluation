<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Evaluation\Entities\EyeExam
 *
 * @property-read \Ignite\Evaluation\Entities\PatientVisits $visits
 * @mixin \Eloquent
 */
class EyeExam extends Model {

    public $primaryKey = 'visit';
    public $incrementing = false;
    public $fillable = ['visit', 'option'];

    public function visits() {
        return $this->belongsTo(PatientVisits::class, 'visit', 'visit_id');
    }

}
