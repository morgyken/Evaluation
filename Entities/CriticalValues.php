<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;


/**
 * Ignite\Evaluation\Entities\CriticalValues
 *
 * @property int $id
 * @property int $procedure
 * @property float|null $critical_value
 * @property string $type
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Ignite\Evaluation\Entities\Procedures $procedures
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\CriticalValues whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\CriticalValues whereCriticalValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\CriticalValues whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\CriticalValues whereProcedure($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\CriticalValues whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\CriticalValues whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CriticalValues extends Model
{
    protected $fillable = [];
    protected $table = 'evaluation_critical_values';
    protected $guarded =[];

    public function procedures() {
        return $this->belongsTo(Procedures::class, 'procedure');
    }
}
