<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;


class EyeExam extends Model {

    public $primaryKey = 'visit';
    public $incrementing = false;
    public $guarded = [];
    protected $table = 'evaluation_eye_exams';

    public function visits() {
        return $this->belongsTo(Visit::class, 'visit');
    }

}
