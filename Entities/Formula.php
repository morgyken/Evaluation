<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Evaluation\Entities\Formula
 *
 * @property int $id
 * @property int|null $procedure_id
 * @property int|null $test_id
 * @property int|null $template_id
 * @property string $formula
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Ignite\Evaluation\Entities\Procedures|null $procedure
 * @property-read \Ignite\Evaluation\Entities\Procedures|null $test
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Formula whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Formula whereFormula($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Formula whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Formula whereProcedureId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Formula whereTemplateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Formula whereTestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Formula whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Formula extends Model {

    protected $fillable = [];
    public $guarded = [];
    protected $table = 'evaluation_formula';

    public function procedure() {
        return $this->belongsTo(Procedures::class, 'procedure_id');
    }

    public function test() {
        return $this->belongsTo(Procedures::class, 'test_id');
    }

}
