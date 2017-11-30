<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;


class ProcedureCategoryTemplates extends Model {

    protected $fillable = [];
    protected $table = 'evaluation_procedure_category_templates';

    public function procedures() {
        return $this->belongsTo(Procedures::class, 'procedure');
    }

}
