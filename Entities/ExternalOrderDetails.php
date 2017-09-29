<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Evaluation\Entities\ExternalOrderDetails
 *
 * @property-read \Ignite\Evaluation\Entities\Procedures $procedures
 * @mixin \Eloquent
 */
class ExternalOrderDetails extends Model {

    public $table = 'evaluation_external_order_details';
    protected $fillable = ['order_id', 'procedure_id'];

    public function procedures() {
        return $this->hasOne(Procedures::class, 'id', 'procedure_id');
    }

}
