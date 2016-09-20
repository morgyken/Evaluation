<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Evaluation\Entities\PatientDiagnosis
 *
 * @property integer $id
 * @property integer $visit
 * @property string $type
 * @property integer $test
 * @property float $price
 * @property float $base
 * @property boolean $is_paid
 * @property integer $to_user
 * @property integer $from_user
 * @property string $instructions
 * @property string $results
 * @property integer $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property mixed $file
 * @property-read \Ignite\Evaluation\Entities\PatientVisits $visits
 * @property-read \Ignite\Setup\Entities\Procedures $procedures
 * @property-read \Ignite\Core\Entities\UserProfile $doctors
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientDiagnosis whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientDiagnosis whereVisit($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientDiagnosis whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientDiagnosis whereTest($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientDiagnosis wherePrice($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientDiagnosis whereBase($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientDiagnosis whereIsPaid($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientDiagnosis whereToUser($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientDiagnosis whereFromUser($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientDiagnosis whereInstructions($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientDiagnosis whereResults($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientDiagnosis whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientDiagnosis whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientDiagnosis whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientDiagnosis whereFile($value)
 * @mixin \Eloquent
 */
class PatientDiagnosis extends Model {

    public $primaryKey = 'visit';
    protected $table = 'patient_investigations';
    protected $guarded = [];

    public function visits() {
        return $this->belongsTo(PatientVisits::class, 'visit', 'visit_id');
    }

    public function procedures() {
        return $this->hasOne(\Ignite\Setup\Entities\Procedures::class, 'id', 'test');
    }

    public function doctors() {
        return $this->belongsTo(\Ignite\Core\Entities\UserProfile::class, 'from_user', 'user_id');
    }

}
