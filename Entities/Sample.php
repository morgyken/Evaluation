<?php

namespace Ignite\Evaluation\Entities;

use Ignite\Reception\Entities\Patients;
use Illuminate\Database\Eloquent\Model;


class Sample extends Model
{
    //protected $fillable = [];
    protected $table = 'evaluation_samples';

    public function visit() {
        return $this->belongsTo(Visit::class, 'visit_id');
    }
    public function patient() {
        return $this->belongsTo(Patients::class, 'patient_id');
    }
    public function type() {
        return $this->belongsTo(SampleType::class, 'type_id');
    }
    public function method() {
        return $this->belongsTo(SampleCollectionMethods::class, 'collection_method_id');
    }
}
