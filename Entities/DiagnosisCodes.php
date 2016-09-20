<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Evaluation\Entities\DiagnosisCodes
 *
 * @property integer $id
 * @property string $code
 * @property string $name
 * @property integer $level
 * @property string $diagnosis_type
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\DiagnosisCodes whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\DiagnosisCodes whereCode($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\DiagnosisCodes whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\DiagnosisCodes whereLevel($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\DiagnosisCodes whereDiagnosisType($value)
 * @mixin \Eloquent
 */
class DiagnosisCodes extends Model {

    public $primaryKey = 'code';
    public $timestamps = false;
    public $incrementing = false;

}
