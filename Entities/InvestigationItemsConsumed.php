<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;
use Ignite\Inventory\Entities\InventoryProducts;

/**
 * Ignite\Evaluation\Entities\InvestigationItemsConsumed
 *
 * @property int $id
 * @property int $investigation
 * @property int $item
 * @property float $units_consumed
 * @property float|null $amount
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Ignite\Evaluation\Entities\Investigations $investigations
 * @property-read \Ignite\Inventory\Entities\InventoryProducts $items
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\InvestigationItemsConsumed whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\InvestigationItemsConsumed whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\InvestigationItemsConsumed whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\InvestigationItemsConsumed whereInvestigation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\InvestigationItemsConsumed whereItem($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\InvestigationItemsConsumed whereUnitsConsumed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\InvestigationItemsConsumed whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
