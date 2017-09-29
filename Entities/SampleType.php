<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Evaluation\Entities\SampleType
 *
 * @property-read \Ignite\Evaluation\Entities\Procedures $procedures
 * @mixin \Eloquent
 */
class SampleType extends Model{
    protected $guarded = [];
    protected $table = 'evaluation_sample_types';

    public function procedures() {
        return $this->belongsTo(Procedures::class, 'procedure');
    }
}
