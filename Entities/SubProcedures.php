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
class SubProcedures extends Model {

    public $table = 'evaluation_subprocedures';
    protected $guarded = [];

    public function subProcedureCategories() {
        return $this->belongsTo(LabtestCategories::class, 'category');
    }

    public function _procedure() {
        return $this->belongsTo(Procedures::class, 'procedure');
    }

    public function _parent() {
        return $this->belongsTo(Procedures::class, 'parent');
    }

}
