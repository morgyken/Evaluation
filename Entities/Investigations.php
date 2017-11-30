<?php

namespace Ignite\Evaluation\Entities;

use Ignite\Finance\Entities\EvaluationPaymentsDetails;
use Ignite\Users\Entities\User;
use Illuminate\Database\Eloquent\Model;


class Investigations extends Model
{

    protected $table = 'evaluation_investigations';
    protected $guarded = [];
    protected $appends = ['is_paid'];

    public function getHasResultAttribute()
    {
        return count($this->results);
    }

    public function getPriceAttribute($value)
    {
        return intval($value);
    }

    public function getIsPaidAttribute()
    {
        return (bool)$this->payments;
    }

    public function scopeLaboratory($query)
    {
        return $query->where('type', 'laboratory');
    }

    public function scopeDiagnosis($query)
    {
        return $query->where('type', 'diagnosis');
    }

    public function scopeTreatment($query)
    {
        return $query->where('type', 'treatment');
    }

    public function visits()
    {
        return $this->belongsTo(Visit::class, 'visit');
    }

    public function procedures()
    {
        return $this->hasOne(Procedures::class, 'id', 'procedure');
    }

    public function doctors()
    {
        return $this->belongsTo(User::class, 'user');
    }

    public function p()
    {
        return $this->belongsTo(Procedures::class, 'procedure');
    }

    public function results()
    {
        return $this->hasOne(InvestigationResult::class, 'investigation');
    }

    public function payments()
    {
        return $this->hasOne(EvaluationPaymentsDetails::class, 'investigation');
    }

    public function getCashAttribute()
    {

    }

    public function getPesaAttribute()
    {
        return 'Ksh ' . number_format($this->price, 2);
    }

    public function removed_bills()
    {
        return $this->hasOne(\Ignite\Finance\Entities\RemovedBills::class, 'investigation');
    }

    public function getNiceTypeAttribute()
    {
        $type = ucfirst($this->type);
        if (ends_with($type, '.inpatient')) {
            $type = substr($type, 0, strpos($type, '.'))
                . '<span title="Inpatient"> <i class="fa fa-bed"></i></span>';
        }
        return $type;
    }
}
