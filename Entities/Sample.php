<?php

namespace Ignite\Evaluation\Entities;

use Ignite\Reception\Entities\Patients;
use Illuminate\Database\Eloquent\Model;


/**
 * Ignite\Evaluation\Entities\Sample
 *
 * @property int $id
 * @property int $patient_id
 * @property int|null $visit_id
 * @property int|null $type_id
 * @property string|null $details
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property int|null $collection_method_id
 * @property-read \Ignite\Evaluation\Entities\SampleCollectionMethods|null $method
 * @property-read \Ignite\Reception\Entities\Patients $patient
 * @property-read \Ignite\Evaluation\Entities\SampleType|null $type
 * @property-read \Ignite\Evaluation\Entities\Visit|null $visit
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Sample whereCollectionMethodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Sample whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Sample whereDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Sample whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Sample wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Sample whereTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Sample whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Sample whereVisitId($value)
 * @mixin \Eloquent
 */
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
