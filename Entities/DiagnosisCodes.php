<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;


/**
 * Ignite\Evaluation\Entities\DiagnosisCodes
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @property int $level
 * @property string $diagnosis_type
 * @property string|null $created_at
 * @property string|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\DiagnosisCodes whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\DiagnosisCodes whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\DiagnosisCodes whereDiagnosisType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\DiagnosisCodes whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\DiagnosisCodes whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\DiagnosisCodes whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\DiagnosisCodes whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class DiagnosisCodes extends Model {

    public $primaryKey = 'id';
    public $timestamps = false;
    public $incrementing = false;
    public $table = 'evaluation_diagnosis_codes';

}
