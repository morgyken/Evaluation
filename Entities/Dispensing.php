<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Evaluation\Entities\Dispensing
 *
 * @property int $id
 * @property int $visit
 * @property int|null $prescription
 * @property int|null $user
 * @property int|null $payment_status
 * @property float|null $amount
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Evaluation\Entities\DispensingDetails[] $details
 * @property-read \Ignite\Evaluation\Entities\Prescriptions|null $prescriptions
 * @property-read \Ignite\Finance\Entities\RemovedBills $removed_bills
 * @property-read \Ignite\Evaluation\Entities\Visit $visits
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Dispensing whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Dispensing whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Dispensing whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Dispensing wherePaymentStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Dispensing wherePrescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Dispensing whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Dispensing whereUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Dispensing whereVisit($value)
 * @mixin \Eloquent
 */
class Dispensing extends Model {

    public $table = 'inventory_evaluation_dispensing';
    protected $fillable = ['visit', 'user', 'prescription'];

    public function visits() {
        return $this->belongsTo(Visit::class, 'visit');
    }

    public function details() {
        return $this->hasMany(DispensingDetails::class, 'batch');
    }

    public function prescriptions() {
        return $this->belongsTo(Prescriptions::class, 'prescription');
    }

    public function removed_bills() {
        return $this->hasOne(\Ignite\Finance\Entities\RemovedBills::class, 'dispensing');
    }

}
