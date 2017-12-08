<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;


/**
 * Ignite\Evaluation\Entities\LabResultStatusChange
 *
 * @property int $id
 * @property int $result
 * @property string|null $type
 * @property string|null $reason
 * @property int $user
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\LabResultStatusChange whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\LabResultStatusChange whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\LabResultStatusChange whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\LabResultStatusChange whereResult($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\LabResultStatusChange whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\LabResultStatusChange whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\LabResultStatusChange whereUser($value)
 * @mixin \Eloquent
 */
class LabResultStatusChange extends Model {

    protected $fillable = [];
    public $table = 'evaluation_investigation_results_publications';

}
