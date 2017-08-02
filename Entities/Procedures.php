<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Evaluation\Entities\Procedures
 *
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property integer $category
 * @property integer $template
 * @property float $cash_charge
 * @property boolean $charge_insurance
 * @property string $description
 * @property boolean $status
 * @property-read mixed $price
 * @property-read \Ignite\Evaluation\Entities\ProcedureCategories $categories
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Procedures whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Procedures whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Procedures whereCode($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Procedures whereCategory($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Procedures whereTemplate($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Procedures whereCashCharge($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Procedures whereChargeInsurance($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Procedures whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Procedures whereStatus($value)
 * @mixin \Eloquent
 */
class Procedures extends Model {

    public $table = 'evaluation_procedures';
    protected $guarded = [];
    protected $appends = ['price'];
    protected $hidden = ['cah_charge'];
    public $timestamps = false;

    public function getPriceAttribute() {
        return (int) ceil($this->cash_charge);
    }

    public function categories() {
        return $this->belongsTo(ProcedureCategories::class, 'category');
    }

    public function items() {
        return $this->hasMany(ProcedureInventoryItem::class, 'procedure');
    }

    public function this_test() {
        return $this->belongsTo(SubProcedures::class, 'id', 'procedure');
    }

    public function children() {
        return $this->hasMany(SubProcedures::class, 'parent');
    }

    public function inclusions() {
        return $this->hasMany(\Ignite\Settings\Entities\CompanyPrice::class, 'procedure');
    }

    public function templates() {
        return $this->hasOne(ProcedureTemplates::class, 'procedure');
    }

    public function templates_lab() {
        return $this->hasOne(TemplateLab::class, 'procedure');
    }

    public function remarks() {
        return $this->hasOne(Remarks::class, 'procedure');
    }
    
    public function titles() {
        return $this->hasMany(HaemogramTitle::class, 'procedure');
    }

    public function formulae() {
        return $this->hasMany(Formula::class, 'procedure');
    }

    public function ref_ranges() {
        return $this->hasMany(ReferenceRange::class, 'procedure');
    }

}
