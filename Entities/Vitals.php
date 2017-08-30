<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;
use Ignite\Users\Entities\User;
use Ignite\Reception\Entities\Patients;

class Vitals extends Model {

    public $primaryKey = 'visit';
    public $table = 'evaluation_vitals';

    public function visits() {
        return $this->belongsTo(Visit::class, 'visit');
    }

    public function nurse(){
    	return $this->hasOne(User::class, 'id', 'user');
    }

}
