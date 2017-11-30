<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;


class HaemogramTitle extends Model {

    protected $table = 'hemogram_titles';

    public function tests() {
        return $this->hasMany(SubProcedures::class, 'title');
    }

    public function procedures() {
        return $this->belongsTo(Procedures::class, 'procedure');
    }

}
