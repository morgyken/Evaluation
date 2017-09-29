<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Evaluation\Entities\Remarks
 *
 * @property-read \Ignite\Evaluation\Entities\Procedures $procedures
 * @mixin \Eloquent
 */
class Remarks extends Model
{
    protected $guarded = [];
    protected $table = 'evaluation_remarks';

    public function procedures() {
        return $this->belongsTo(Procedures::class, 'procedure');
    }
}
