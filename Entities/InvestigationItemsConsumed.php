<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;
use Ignite\Inventory\Entities\InventoryProducts;


class InvestigationItemsConsumed extends Model {

    protected $fillable = [];
    protected $table = 'evaluation_investigation_items_consumed';

    public function investigations() {
        return $this->belongsTo(Investigations::class, 'investigation');
    }

    public function items() {
        return $this->belongsTo(InventoryProducts::class, 'item');
    }

}
