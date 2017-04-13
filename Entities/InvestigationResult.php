<?php

namespace Ignite\Evaluation\Entities;

use Ignite\Reception\Entities\PatientDocuments;
use Ignite\Users\Entities\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Evaluation\Entities\InvestigationResult
 *
 * @property integer $id
 * @property integer $investigation
 * @property integer $user
 * @property string $instructions
 * @property string $results
 * @property integer $file
 * @property integer $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Ignite\Evaluation\Entities\Investigations $investigations
 * @property-read \Ignite\Reception\Entities\PatientDocuments $documents
 * @property-read \Ignite\Users\Entities\User $users
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\InvestigationResult whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\InvestigationResult whereInvestigation($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\InvestigationResult whereUser($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\InvestigationResult whereInstructions($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\InvestigationResult whereResults($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\InvestigationResult whereFile($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\InvestigationResult whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\InvestigationResult whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\InvestigationResult whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class InvestigationResult extends Model {

    protected $guarded = [];
    public $table = 'evaluation_investigation_results';

    public function investigations() {
        return $this->belongsTo(Investigations::class, 'investigation');
    }

    public function documents() {
        return $this->belongsTo(PatientDocuments::class, 'file');
    }

    public function users() {
        return $this->belongsTo(User::class, 'user');
    }

    public function sensitivity_results() {
        return $this->hasMany(Sensitivity::class, 'result_id');
    }
}
