<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Evaluation\Entities\PatientDrawings
 *
 * @property integer $id
 * @property integer $visit
 * @property string $object
 * @property integer $user
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Ignite\Evaluation\Entities\PatientVisits $visits
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientDrawings whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientDrawings whereVisit($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientDrawings whereObject($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientDrawings whereUser($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientDrawings whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientDrawings whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PatientDrawings extends Model {

    public function visits() {
        return $this->belongsTo(PatientVisits::class, 'visit', 'visit_id');
    }

}
