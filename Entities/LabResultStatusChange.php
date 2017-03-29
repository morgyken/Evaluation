<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Evaluation\Entities\InvestigationResult
 *
 * @property integer $id
 * @property integer $user
 * @property integer $result
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Ignite\Evaluation\Entities\InvestigationResult $result
 * @property-read \Ignite\Users\Entities\User $users
 * @mixin \Eloquent
 */
class LabResultStatusChange extends Model {

    protected $fillable = [];
    public $table = 'evaluation_investigation_results_publications';

}
