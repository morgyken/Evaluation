<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Evaluation\Entities\Procedures
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property int $category
 * @property int|null $template
 * @property float $cash_charge
 * @property int $charge_insurance
 * @property int $precharge
 * @property string|null $description
 * @property int $status
 * @property-read \Ignite\Evaluation\Entities\ProcedureCategories $categories
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Evaluation\Entities\SubProcedures[] $children
 * @property-read \Ignite\Evaluation\Entities\CriticalValues $critical_values
 * @property-read \Ignite\Evaluation\Entities\Formula $formula
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Evaluation\Entities\Formula[] $formulae
 * @property-read mixed $price
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Settings\Entities\CompanyPrice[] $inclusions
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Evaluation\Entities\ProcedureInventoryItem[] $items
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Evaluation\Entities\ReferenceRange[] $ref_ranges
 * @property-read \Ignite\Evaluation\Entities\Remarks $remarks
 * @property-read \Ignite\Evaluation\Entities\ProcedureTemplates $templates
 * @property-read \Ignite\Evaluation\Entities\TemplateLab $templates_lab
 * @property-read \Ignite\Evaluation\Entities\SubProcedures $this_test
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Evaluation\Entities\HaemogramTitle[] $titles
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Procedures whereCashCharge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Procedures whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Procedures whereChargeInsurance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Procedures whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Procedures whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Procedures whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Procedures whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Procedures wherePrecharge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Procedures whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\Procedures whereTemplate($value)
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
        return $this->hasMany(Formula::class, 'procedure_id');
    }

    public function formula() {
        return $this->hasOne(Formula::class, 'test_id');
    }

    public function ref_ranges() {
        return $this->hasMany(ReferenceRange::class, 'procedure');
    }

    public function critical_values() {
       // return $this->hasMany(CriticalValues::class, 'procedure');
        return $this->hasOne(CriticalValues::class, 'procedure');
    }

}
