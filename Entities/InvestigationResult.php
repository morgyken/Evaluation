<?php

namespace Ignite\Evaluation\Entities;

use Ignite\Reception\Entities\PatientDocuments;
use Ignite\Users\Entities\User;
use Illuminate\Database\Eloquent\Model;


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
