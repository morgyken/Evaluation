<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Evaluation\Entities\PatientPreliminary
 *
 * @property integer $id
 * @property integer $visit
 * @property string $entity
 * @property string $left
 * @property string $right
 * @property string $remarks
 * @property integer $user
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientPreliminary whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientPreliminary whereVisit($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientPreliminary whereEntity($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientPreliminary whereLeft($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientPreliminary whereRight($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientPreliminary whereRemarks($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientPreliminary whereUser($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientPreliminary whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientPreliminary whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PatientPreliminary extends Model {

    protected $fillable = [];
    public $table = 'patient_preliminary';

}
