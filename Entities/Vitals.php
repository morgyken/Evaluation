<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;

class Vitals extends Model {

    public $primaryKey = 'visit';
    public $fillable = ['visit'];
    public $table = 'evaluation_vitals';

    public function visits() {
        return $this->belongsTo(Visit::class, 'visit');
    }

}
