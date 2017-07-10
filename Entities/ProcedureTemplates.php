<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Evaluation\Entities\ProcedureTemplates
 *
 * @property int $id
 * @property int $procedure
 * @property string $template
 * @property string|null $payload
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Ignite\Evaluation\Entities\Procedures $procedures
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\ProcedureTemplates whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\ProcedureTemplates whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\ProcedureTemplates wherePayload($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\ProcedureTemplates whereProcedure($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\ProcedureTemplates whereTemplate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\ProcedureTemplates whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ProcedureTemplates extends Model {

    protected $fillable = [];
    protected $table = 'evaluation_procedure_templates';

    public function procedures() {
        return $this->belongsTo(Procedures::class, 'procedure');
    }

}
