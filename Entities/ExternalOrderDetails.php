<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Evaluation\Entities\ExternalOrderDetails
 *
 * @property int $id
 * @property int $order_id
 * @property int $procedure_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $type
 * @property-read \Ignite\Evaluation\Entities\Procedures $procedures
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\ExternalOrderDetails whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\ExternalOrderDetails whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\ExternalOrderDetails whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\ExternalOrderDetails whereProcedureId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\ExternalOrderDetails whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\ExternalOrderDetails whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ExternalOrderDetails extends Model {

    public $table = 'evaluation_external_order_details';
    protected $fillable = ['order_id', 'procedure_id'];

    public function procedures() {
        return $this->hasOne(Procedures::class, 'id', 'procedure_id');
    }

}
