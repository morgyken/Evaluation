<?php

namespace Ignite\Evaluation\Entities;

use Ignite\Inventory\Entities\InventoryProducts;
use Illuminate\Database\Eloquent\Model;


/**
 * Ignite\Evaluation\Entities\Sensitivity
 *
 * @property int $id
 * @property int $visit_id
 * @property int $drug_id
 * @property int|null $test_id
 * @property int|null $result_id
 * @property int|null $procedure_id
 * @property string $sensitivity
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Ignite\Inventory\Entities\InventoryProducts $drug
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Sensitivity whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Sensitivity whereDrugId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Sensitivity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Sensitivity whereProcedureId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Sensitivity whereResultId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Sensitivity whereSensitivity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Sensitivity whereTestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Sensitivity whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Sensitivity whereVisitId($value)
 * @mixin \Eloquent
 */
class Sensitivity extends Model
{
    protected $fillable = [];
    protected $guarded = [];
    protected $table = 'evaluation_sensitivity';

    public function drug(){
        return $this->belongsTo( InventoryProducts::class, 'drug_id');
    }
}
