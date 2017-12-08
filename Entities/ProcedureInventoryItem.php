<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;
use Ignite\Inventory\Entities\InventoryProducts;


/**
 * Ignite\Evaluation\Entities\ProcedureInventoryItem
 *
 * @property int $id
 * @property int $procedure
 * @property int $item
 * @property float|null $units
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Ignite\Inventory\Entities\InventoryProducts $inventory
 * @property-read \Ignite\Evaluation\Entities\Procedures $the_procedures
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\ProcedureInventoryItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\ProcedureInventoryItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\ProcedureInventoryItem whereItem($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\ProcedureInventoryItem whereProcedure($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\ProcedureInventoryItem whereUnits($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\ProcedureInventoryItem whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ProcedureInventoryItem extends Model {

    protected $table = 'evaluation_procedure_inventory_items';

    public function the_procedures() {
        return $this->belongsTo(Procedures::class, 'procedures');
    }

    public function inventory() {
        return $this->belongsTo(InventoryProducts::class, 'item');
    }

}
