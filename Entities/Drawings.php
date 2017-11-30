<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;


class Drawings extends Model {

    public $table = 'evaluation_drawings';

    public function visits() {
        return $this->belongsTo(Visit::class, 'visit');
    }

}
