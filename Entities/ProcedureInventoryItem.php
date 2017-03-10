<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;
use Ignite\Inventory\Entities\InventoryProducts;

class ProcedureInventoryItem extends Model {

    protected $table = 'evaluation_procedure_inventory_items';

    public function procedures() {
        return $this->belongsTo(Procedures::class, 'procedures');
    }

    public function inventory() {
        return $this->belongsTo(InventoryProducts::class, 'item');
    }

}
