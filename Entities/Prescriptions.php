<?php

namespace Ignite\Evaluation\Entities;

use Ignite\Inventory\Entities\InventoryProducts;
use Ignite\Users\Entities\User;
use Ignite\Inpatient\Entities\Admission;
use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Evaluation\Entities\Prescriptions
 *
 * @property int $id
 * @property int $visit
 * @property string $drug
 * @property int $take
 * @property int $whereto
 * @property int $method
 * @property int $duration
 * @property int $status
 * @property bool $allow_substitution
 * @property int $time_measure
 * @property int $user
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property int|null $admission_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Evaluation\Entities\Dispensing[] $dispensing
 * @property-read \Ignite\Inventory\Entities\InventoryProducts $drugs
 * @property-read mixed $dose
 * @property-read mixed $sub
 * @property-read \Ignite\Users\Entities\User $users
 * @property-read \Ignite\Evaluation\Entities\Visit $visits
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Prescriptions whereAdmissionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Prescriptions whereAllowSubstitution($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Prescriptions whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Prescriptions whereDrug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Prescriptions whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Prescriptions whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Prescriptions whereMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Prescriptions whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Prescriptions whereTake($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Prescriptions whereTimeMeasure($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Prescriptions whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Prescriptions whereUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Prescriptions whereVisit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Prescriptions whereWhereto($value)
 * @mixin \Eloquent
 */
class Prescriptions extends Model {

    public $table = 'evaluation_prescriptions';
    protected $casts = ['allow_substitution' => 'boolean'];
    public $incrementing = false;
    protected $guarded = [];

    public function getDoseAttribute() {
        return $this->take . ' ' . mconfig('evaluation.options.prescription_whereto.' . $this->whereto) . ' '
                . mconfig('evaluation.options.prescription_method.' . $this->method) . ' '
                . $this->duration . ' ' . mconfig('evaluation.options.prescription_duration.' . $this->time_measure);
    }

    public function getSubAttribute() {
        return $this->allow_substitution ? 'Yes' : 'No';
    }

    public function admission() {
        return $this->belongsTo(Admission::class, 'admission_id');
    }

    public function visits() {
        return $this->belongsTo(Visit::class, 'visit');
    }

    public function drugs() {
        return $this->belongsTo(InventoryProducts::class, 'drug');
    }

    public function users() {
        return $this->belongsTo(User::class, 'user');
    }

    public function dispensing() {
        return $this->hasMany(Dispensing::class, 'prescription');
    }

}
