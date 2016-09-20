<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Ignite\Evaluation\Entities\ProcedureCategories
 *
 * @property integer $id
 * @property string $name
 * @property string $applies_to
 * @property string $deleted_at
 * @property-read mixed $applies
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Evaluation\Entities\Procedures[] $procedures
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\ProcedureCategories whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\ProcedureCategories whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\ProcedureCategories whereAppliesTo($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\ProcedureCategories whereDeletedAt($value)
 * @mixin \Eloquent
 */
class ProcedureCategories extends Model {

    use SoftDeletes;

    public $timestamps = false;
    public $table = 'evaluation_procedure_categories';

    public function getAppliesAttribute() {
        return config('system.applies_to.' . $this->applies_to);
    }

    public function procedures() {
        return $this->hasMany(Procedures::class, 'category_id', 'category_id');
    }

}
