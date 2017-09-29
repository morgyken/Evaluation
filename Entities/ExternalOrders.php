<?php

namespace Ignite\Evaluation\Entities;

use Ignite\Users\Entities\User;
use Ignite\Reception\Entities\Patients;
use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Evaluation\Entities\ExternalOrders
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Evaluation\Entities\ExternalOrderDetails[] $details
 * @property-read \Ignite\Evaluation\Entities\PartnerInstitution $from
 * @property-read \Ignite\Reception\Entities\Patients $patient
 * @property-read \Ignite\Users\Entities\User $users
 * @mixin \Eloquent
 */
class ExternalOrders extends Model {

    public $table = 'evaluation_external_orders';

    public function users() {
        return $this->belongsTo(User::class, 'user');
    }

    public function patient() {
        return $this->belongsTo(Patients::class, 'patient_id');
    }

    public function from() {
        return $this->belongsTo(PartnerInstitution::class, 'institution');
    }

    public function details() {
        return $this->hasMany(ExternalOrderDetails::class, 'order_id');
    }

}
