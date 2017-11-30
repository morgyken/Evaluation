<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;


class OpNotes extends Model {

    public $primaryKey = 'visit';
    public $incrementing = false;
    public $table = 'evaluation_opnotes';
    protected $guarded = [];

    public function visits() {
        return $this->belongsTo(Visit::class, 'visit');
    }

}
