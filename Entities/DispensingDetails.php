<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Evaluation\Entities\DispensingDetails
 *
 * @property int $id
 * @property int $batch
 * @property int $product
 * @property int $quantity
 * @property float $price
 * @property float $discount
 * @property bool $status
 * @property string $deleted_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Ignite\Inventory\Entities\InventoryProducts $drug
 * @property-read \Ignite\Evaluation\Entities\Visit $visits
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\DispensingDetails whereBatch($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\DispensingDetails whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\DispensingDetails whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\DispensingDetails whereDiscount($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\DispensingDetails whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\DispensingDetails wherePrice($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\DispensingDetails whereProduct($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\DispensingDetails whereQuantity($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\DispensingDetails whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\DispensingDetails whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
