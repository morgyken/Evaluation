<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Evaluation\Entities\ReferenceRange
 *
 * @property-read \Ignite\Evaluation\Entities\Procedures $procedures
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
