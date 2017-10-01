<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Evaluation\Entities\SampleType
 *
 * @property int $id
 * @property string $name
 * @property int|null $procedure
 * @property string|null $details
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Ignite\Evaluation\Entities\Procedures|null $procedures
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\SampleType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\SampleType whereDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\SampleType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\SampleType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\SampleType whereProcedure($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\SampleType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SampleType extends Model{
    protected $guarded = [];
    protected $table = 'evaluation_sample_types';

    public function procedures() {
        return $this->belongsTo(Procedures::class, 'procedure');
    }
}
