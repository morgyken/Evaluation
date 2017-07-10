<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Ignite\Evaluation\Entities\ProcedureCategories
 *
 * @property int $id
 * @property string $name
 * @property string $applies_to
 * @property string|null $deleted_at
 * @property-read mixed $applied_to
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Evaluation\Entities\Procedures[] $procedures
 * @property-read \Ignite\Evaluation\Entities\ProcedureCategoryTemplates $templates
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\ProcedureCategories onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\ProcedureCategories whereAppliesTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\ProcedureCategories whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\ProcedureCategories whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\ProcedureCategories whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\ProcedureCategories withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\ProcedureCategories withoutTrashed()
 * @mixin \Eloquent
 */
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
