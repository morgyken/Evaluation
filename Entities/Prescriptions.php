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
 * @property int $user
 * @property string $drug
 * @property int $take
 * @property int $whereto
 * @property int $method
 * @property int $duration
 * @property string|null $stop_reason
 * @property int $stopped
 * @property int $status
 * @property bool $allow_substitution
 * @property int $time_measure
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property int $type
 * @property string|null $notes
 * @property int $canceled
 * @property int|null $admission_id
 * @property int $for_discharge
 * @property-read \Ignite\Inpatient\Entities\Admission|null $admission
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Evaluation\Entities\Dispensing[] $dispensing
 * @property-read \Ignite\Inventory\Entities\InventoryProducts $drugs
 * @property-read mixed $dose
 * @property-read mixed $is_paid
 * @property-read mixed $priced_amount
 * @property-read mixed $sub
 * @property-read \Ignite\Evaluation\Entities\PrescriptionPayment $payment
 * @property-read \Ignite\Users\Entities\User $users
 * @property-read \Ignite\Evaluation\Entities\Visit $visits
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Prescriptions whereAdmissionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Prescriptions whereAllowSubstitution($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Prescriptions whereCanceled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Prescriptions whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Prescriptions whereDrug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Prescriptions whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Prescriptions whereForDischarge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Prescriptions whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Prescriptions whereMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Prescriptions whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Prescriptions whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Prescriptions whereStopReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Prescriptions whereStopped($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Prescriptions whereTake($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Prescriptions whereTimeMeasure($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Prescriptions whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Prescriptions whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Prescriptions whereUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Prescriptions whereVisit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Prescriptions whereWhereto($value)
 * @mixin \Eloquent
 */
class Prescriptions extends Model
{

    public $table = 'evaluation_prescriptions';
    protected $casts = ['allow_substitution' => 'boolean'];
    protected $guarded = [];
//    protected $appends = ['payment'];

    public function getDoseAttribute()
    {
        return $this->take . ' ' . mconfig('evaluation.options.prescription_whereto.' . $this->whereto) . ' '
            . mconfig('evaluation.options.prescription_method.' . $this->method) . ' '
            . $this->duration . ' ' . mconfig('evaluation.options.prescription_duration.' . $this->time_measure);
    }

    public function getSubAttribute()
    {
        return $this->allow_substitution ? 'Yes' : 'No';
    }

    public function admission()
    {
        return $this->belongsTo(Admission::class, 'admission_id');
    }

    public function visits()
    {
        return $this->belongsTo(Visit::class, 'visit');
    }

    public function drugs()
    {
        return $this->belongsTo(InventoryProducts::class, 'drug');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user');
    }

    public function dispensing()
    {
        return $this->hasMany(Dispensing::class, 'prescription');
    }

    public function payment()
    {
        return $this->hasOne(PrescriptionPayment::class, 'prescription_id');
    }

    public function getPricedAmountAttribute()
    {
        return $this->payment->total;
    }

    public function getIsPaidAttribute()
    {
        return $this->payment->invoiced || $this->payment->paid;
    }
}
