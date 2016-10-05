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

    protected $guarded = [];
    public $timestamps = false;
    public $table = 'evaluation_procedures';

    public function categories() {
        return $this->belongsTo(ProcedureCategories::class, 'category');
    }

}
