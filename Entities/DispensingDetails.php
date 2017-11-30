<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;


class DispensingDetails extends Model {

    public $table = 'inventory_evaluation_dispensing_details'; //'evaluation_dispensing_details';
    protected $fillable = ['batch', 'product', 'quantity', 'price'];

    public function visits() {
        return $this->belongsTo(Visit::class, 'visit');
    }

    public function drug() {
        return $this->belongsTo(\Ignite\Inventory\Entities\InventoryProducts::class, 'product');
    }

}
