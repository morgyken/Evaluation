<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Evaluation\Entities\PatientVitals
 *
 * @property integer $id
 * @property integer $visit
 * @property float $weight
 * @property float $height
 * @property string $bp_systolic
 * @property string $bp_diastolic
 * @property string $pulse
 * @property string $respiration
 * @property string $temperature
 * @property string $temperature_location
 * @property float $oxygen
 * @property float $waist
 * @property float $hip
 * @property string $blood_sugar
 * @property string $blood_sugar_units
 * @property string $allergies
 * @property string $chronic_illnesses
 * @property string $nurse_notes
 * @property integer $user
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Ignite\Evaluation\Entities\PatientVisits $visits
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientVitals whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientVitals whereVisit($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientVitals whereWeight($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientVitals whereHeight($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientVitals whereBpSystolic($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientVitals whereBpDiastolic($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientVitals wherePulse($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientVitals whereRespiration($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientVitals whereTemperature($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientVitals whereTemperatureLocation($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientVitals whereOxygen($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientVitals whereWaist($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientVitals whereHip($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientVitals whereBloodSugar($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientVitals whereBloodSugarUnits($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientVitals whereAllergies($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientVitals whereChronicIllnesses($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientVitals whereNurseNotes($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientVitals whereUser($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientVitals whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PatientVitals whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PatientVitals extends Model {

    public $primaryKey = 'visit';
    public $fillable = ['visit'];

    public function visits() {
        return $this->belongsTo(PatientVisits::class, 'visit', 'visit_id');
    }

}
