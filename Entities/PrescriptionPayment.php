<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Evaluation\Entities\PrescriptionPayment
 *
 * @property int $id
 * @property int|null $prescription_id
 * @property float $price
 * @property float $discount
 * @property float $cost
 * @property int $quantity
 * @property int $paid
 * @property int|null $invoiced
 * @property int $complete
 * @property string|null $transfer
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read mixed $total
 * @property-read \Ignite\Evaluation\Entities\Prescriptions|null $prescription
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\PrescriptionPayment whereComplete($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\PrescriptionPayment whereCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\PrescriptionPayment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\PrescriptionPayment whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\PrescriptionPayment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\PrescriptionPayment whereInvoiced($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\PrescriptionPayment wherePaid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\PrescriptionPayment wherePrescriptionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\PrescriptionPayment wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\PrescriptionPayment whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\PrescriptionPayment whereTransfer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\PrescriptionPayment whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PrescriptionPayment extends Model
{
    protected $guarded = [];
    protected $table = 'evaluation_prescription_payments';

    public function getTotalAttribute()
    {
        return $this->cost * $this->quantity;
    }

    public function prescription()
    {
        return $this->belongsTo(Prescriptions::class, 'prescription_id');
    }
}
