<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Evaluation\Entities\DispensingDetails
 *
 * @property-read \Ignite\Evaluation\Entities\Visit $visits
 * @mixin \Eloquent
 */
class DispensingDetails extends Model {

    public $table = 'evaluation_dispensing_details';
    protected $fillable = ['batch', 'product', 'quantity', 'price'];

    public function visits() {
        return $this->belongsTo(Visit::class, 'visit');
    }

    public function drug() {
        return $this->belongsTo(\Ignite\Inventory\Entities\InventoryProducts::class, 'product');
    }

}
