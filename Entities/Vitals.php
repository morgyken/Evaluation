<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;
use Ignite\Users\Entities\User;
use Ignite\Reception\Entities\Patients;

/**
 * Ignite\Evaluation\Entities\Vitals
 *
 * @property int $id
 * @property int $visit
 * @property float|null $weight
 * @property float|null $height
 * @property string|null $bp_systolic
 * @property string|null $bp_diastolic
 * @property string|null $pulse
 * @property string|null $respiration
 * @property string|null $temperature
 * @property string|null $temperature_location
 * @property float|null $oxygen
 * @property float|null $waist
 * @property float|null $hip
 * @property string|null $blood_sugar
 * @property string $blood_sugar_units
 * @property string|null $allergies
 * @property string|null $chronic_illnesses
 * @property string|null $nurse_notes
 * @property int|null $user
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Ignite\Users\Entities\User $nurse
 * @property-read \Ignite\Evaluation\Entities\Visit $visits
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Vitals whereAllergies($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Vitals whereBloodSugar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Vitals whereBloodSugarUnits($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Vitals whereBpDiastolic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Vitals whereBpSystolic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Vitals whereChronicIllnesses($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Vitals whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Vitals whereHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Vitals whereHip($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Vitals whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Vitals whereNurseNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Vitals whereOxygen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Vitals wherePulse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Vitals whereRespiration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Vitals whereTemperature($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Vitals whereTemperatureLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Vitals whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Vitals whereUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Vitals whereVisit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Vitals whereWaist($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Vitals whereWeight($value)
 * @mixin \Eloquent
 */
class Vitals extends Model {

    public $primaryKey = 'visit';
    public $table = 'evaluation_vitals';

    public function visits() {
        return $this->belongsTo(Visit::class, 'visit');
    }

    public function nurse(){
    	return $this->hasOne(User::class, 'id', 'user');
    }

}
