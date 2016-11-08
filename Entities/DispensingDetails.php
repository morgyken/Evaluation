<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Evaluation\Entities\DispensingDetails
 *
 * @property integer $id
 * @property integer $batch
 * @property integer $product
 * @property integer $quantity
 * @property float $price
 * @property string $deleted_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Ignite\Evaluation\Entities\Visit $visits
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\DispensingDetails whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\DispensingDetails whereBatch($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\DispensingDetails whereProduct($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\DispensingDetails whereQuantity($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\DispensingDetails wherePrice($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\DispensingDetails whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\DispensingDetails whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\DispensingDetails whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class DispensingDetails extends Model {

    public $table = 'evaluation_dispensing_details';
    protected $fillable = ['batch', 'product', 'quantity', 'price'];

    public function visits() {
        return $this->belongsTo(Visit::class, 'visit');
    }

}
