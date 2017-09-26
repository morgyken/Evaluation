<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;

use Ignite\Inpatient\Entities\Admission;
use Ignite\Inpatient\Entities\Visit;
use Ignite\Inpatient\Entities\NursingCharge;

/**
 * Ignite\Evaluation\Entities\RecurrentCharge
 *
 * @property int $id
 * @property int $admission_id
 * @property int $visit_id
 * @property int $recurrent_charge_id
 * @property string $status
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property int $invoiced
 * @property-read \Ignite\Inpatient\Entities\Admission $admission
 * @property-read \Ignite\Inpatient\Entities\NursingCharge $charge
 * @property-read \Ignite\Finance\Entities\RemovedBills $removed_bills
 * @property-read \Ignite\Inpatient\Entities\Visit $visit
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\RecurrentCharge whereAdmissionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\RecurrentCharge whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\RecurrentCharge whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\RecurrentCharge whereInvoiced($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\RecurrentCharge whereRecurrentChargeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\RecurrentCharge whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\RecurrentCharge whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\RecurrentCharge whereVisitId($value)
 * @mixin \Eloquent
 */
class RecurrentCharge extends Model
{
  
    protected $table = 'inpatient_recurrent_charges';

    public function admission(){
        return $this->belongsTo(Admission::class, "admission_id", "id");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function visit() {
        return $this->belongsTo(Visit::class, 'visit_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function charge() {
        return $this->belongsTo(NursingCharge::class, 'recurrent_charge_id');
    }

    public function removed_bills() {
        return $this->hasOne(\Ignite\Finance\Entities\RemovedBills::class, 'recurrent');
    }
}
