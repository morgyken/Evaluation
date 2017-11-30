<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;


class Remarks extends Model
{
    protected $guarded = [];
    protected $table = 'evaluation_remarks';

    public function procedures() {
        return $this->belongsTo(Procedures::class, 'procedure');
    }
}
