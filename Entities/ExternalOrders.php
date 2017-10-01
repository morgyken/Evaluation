<?php

namespace Ignite\Evaluation\Entities;

use Ignite\Users\Entities\User;
use Ignite\Reception\Entities\Patients;
use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Evaluation\Entities\ExternalOrders
 *
 * @property int $id
 * @property int $patient_id
 * @property int $institution
 * @property int $user
 * @property string|null $description
 * @property string|null $status
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Evaluation\Entities\ExternalOrderDetails[] $details
 * @property-read \Ignite\Evaluation\Entities\PartnerInstitution $from
 * @property-read \Ignite\Reception\Entities\Patients $patient
 * @property-read \Ignite\Users\Entities\User $users
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\ExternalOrders whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\ExternalOrders whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\ExternalOrders whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\ExternalOrders whereInstitution($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\ExternalOrders wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\ExternalOrders whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\ExternalOrders whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\ExternalOrders whereUser($value)
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
