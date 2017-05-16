<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;

class TemplateLab extends Model {

    protected $fillable = [];
    protected $table = 'evaluation_templates_lab';

    public function procedures() {
        return $this->belongsTo(Procedures::class, 'procedure');
    }

    public function subtests() {
        return $this->belongsTo(Procedures::class, 'subtest');
    }

    public function titles() {
        return $this->belongsTo(HaemogramTitle::class, 'title');
    }

}
