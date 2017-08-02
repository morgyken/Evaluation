<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;

class SampleType extends Model{
    protected $guarded = [];
    protected $table = 'evaluation_sample_types';

    public function procedures() {
        return $this->belongsTo(Procedures::class, 'procedure');
    }
}
