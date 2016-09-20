<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Evaluation\Entities\Vitals
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
 * @property-read \Ignite\Evaluation\Entities\Visits $visits
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Vitals whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Vitals whereVisit($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Vitals whereWeight($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Vitals whereHeight($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Vitals whereBpSystolic($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Vitals whereBpDiastolic($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Vitals wherePulse($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Vitals whereRespiration($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Vitals whereTemperature($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Vitals whereTemperatureLocation($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Vitals whereOxygen($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Vitals whereWaist($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Vitals whereHip($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Vitals whereBloodSugar($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Vitals whereBloodSugarUnits($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Vitals whereAllergies($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Vitals whereChronicIllnesses($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Vitals whereNurseNotes($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Vitals whereUser($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Vitals whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Vitals whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Vitals extends Model {

    public $primaryKey = 'visit';
    public $fillable = ['visit'];
    public $table = 'evaluation_vitals';

    public function visits() {
        return $this->belongsTo(Visits::class, 'visit', 'visit_id');
    }

}
