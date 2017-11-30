<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;


class Procedures extends Model
{

    public $table = 'evaluation_procedures';
    protected $guarded = [];
    protected $appends = ['price'];
    public $timestamps = false;

    public function getPriceAttribute()
    {
        return (int)ceil($this->cash_charge);
    }

    public function categories()
    {
        return $this->belongsTo(ProcedureCategories::class, 'category');
    }

    public function items()
    {
        return $this->hasMany(ProcedureInventoryItem::class, 'procedure');
    }

    public function this_test()
    {
        return $this->belongsTo(SubProcedures::class, 'id', 'procedure');
    }

    public function children()
    {
        return $this->hasMany(SubProcedures::class, 'parent');
    }

    public function inclusions()
    {
        return $this->hasMany(\Ignite\Settings\Entities\CompanyPrice::class, 'procedure');
    }

    public function templates()
    {
        return $this->hasOne(ProcedureTemplates::class, 'procedure');
    }

    public function templates_lab()
    {
        return $this->hasOne(TemplateLab::class, 'procedure');
    }

    public function remarks()
    {
        return $this->hasOne(Remarks::class, 'procedure');
    }

    public function titles()
    {
        return $this->hasMany(HaemogramTitle::class, 'procedure');
    }

    public function formulae()
    {
        return $this->hasMany(Formula::class, 'procedure_id');
    }

    public function formula()
    {
        return $this->hasOne(Formula::class, 'test_id');
    }

    public function ref_ranges()
    {
        return $this->hasMany(ReferenceRange::class, 'procedure');
    }

    public function critical_values()
    {
        // return $this->hasMany(CriticalValues::class, 'procedure');
        return $this->hasOne(CriticalValues::class, 'procedure');
    }

    public function getInsuranceCharge($value)
    {
        if (empty($value)) {
            return $this->cash_charge;
        }
        return $value;
    }
}
