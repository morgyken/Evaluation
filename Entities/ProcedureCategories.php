<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ProcedureCategories extends Model {

    use SoftDeletes;

    public $timestamps = false;
    public $table = 'evaluation_procedure_categories';
    protected $guarded = [];

    public function getAppliedToAttribute() {
        return mconfig('evaluation.options.applies_to.' . $this->applies_to);
    }

    public function procedures() {
        return $this->hasMany(Procedures::class, 'category_id');
    }

    public function templates() {
        return $this->hasOne(ProcedureCategoryTemplates::class, 'category');
    }

}
