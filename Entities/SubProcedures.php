<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;


class SubProcedures extends Model {

    public $table = 'evaluation_subprocedures';

    public function subProcedureCategories() {
        return $this->belongsTo(LabtestCategories::class, 'category');
    }

    public function _procedure() {
        return $this->belongsTo(Procedures::class, 'procedure');
    }

    public function _parent() {
        return $this->belongsTo(Procedures::class, 'parent');
    }

}
