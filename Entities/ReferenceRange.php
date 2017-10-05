<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Evaluation\Entities\ReferenceRange
 *
 * @property int $id
 * @property int $procedure
 * @property string $type
 * @property string|null $gender
 * @property string|null $age
 * @property string|null $lg_type
 * @property float|null $lower
 * @property float|null $upper
 * @property float|null $lg_value
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Ignite\Evaluation\Entities\Procedures $procedures
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\ReferenceRange whereAge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\ReferenceRange whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\ReferenceRange whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\ReferenceRange whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\ReferenceRange whereLgType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\ReferenceRange whereLgValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\ReferenceRange whereLower($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\ReferenceRange whereProcedure($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\ReferenceRange whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\ReferenceRange whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\ReferenceRange whereUpper($value)
 * @mixin \Eloquent
 */
class ReferenceRange extends Model
{
    protected $fillable = [];
    protected $table = 'evaluation_reference_range';
    protected $guarded =[];

    public function procedures() {
        return $this->belongsTo(Procedures::class, 'procedure');
    }
}
