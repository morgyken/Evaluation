<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;

class ReferenceRange extends Model
{
    protected $fillable = [];
    protected $table = 'evaluation_reference_range';
    protected $guarded =[];

    public function procedures() {
        return $this->belongsTo(Procedures::class, 'procedure');
    }
}
