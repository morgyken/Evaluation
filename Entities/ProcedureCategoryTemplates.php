<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Evaluation\Entities\ProcedureCategoryTemplates
 *
 * @property int $id
 * @property int $category
 * @property string $template
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Ignite\Evaluation\Entities\Procedures $procedures
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\ProcedureCategoryTemplates whereCategory($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\ProcedureCategoryTemplates whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\ProcedureCategoryTemplates whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\ProcedureCategoryTemplates whereTemplate($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\ProcedureCategoryTemplates whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ProcedureCategoryTemplates extends Model {

    protected $fillable = [];
    protected $table = 'evaluation_procedure_category_templates';

    public function procedures() {
        return $this->belongsTo(Procedures::class, 'procedure');
    }

}
