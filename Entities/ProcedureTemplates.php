<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Evaluation\Entities\ProcedureTemplates
 *
 * @property integer $id
 * @property mixed $template
 * @property string $payload
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\ProcedureTemplates whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\ProcedureTemplates whereTemplate($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\ProcedureTemplates wherePayload($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\ProcedureTemplates whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\ProcedureTemplates whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ProcedureTemplates extends Model {

    protected $fillable = [];
    protected $table = 'evaluation_procedure_templates';

}
