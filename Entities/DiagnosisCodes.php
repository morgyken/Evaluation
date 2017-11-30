<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;


class DiagnosisCodes extends Model {

    public $primaryKey = 'id';
    public $timestamps = false;
    public $incrementing = false;
    public $table = 'evaluation_diagnosis_codes';

}
