<?php

namespace Ignite\Evaluation\Entities;

use Ignite\Users\Entities\User;
use Illuminate\Database\Eloquent\Model;


class VisitMeta extends Model {

    public $primaryKey = 'visit';
    public $incrementing = false;
    protected $guarded = [];
    public $table = 'evaluation_visit_metas';

    public function visits() {
        return $this->belongsTo(Visit::class, 'visit');
    }

    public function users() {
        return $this->belongsTo(User::class, 'user');
    }

}
