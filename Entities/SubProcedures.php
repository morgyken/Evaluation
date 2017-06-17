<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Evaluation\Entities\SubProcedures
 *
 * @property int $id
 * @property int $procedure
 * @property int $parent
 * @property int $category
 * @property string $titles
 * @property string $title
 * @property string $lab_sample_type
 * @property string $lab_result_type
 * @property string $result_type_details
 * @property string $lab_result_options
 * @property string $units
 * @property float $lab_min_range
 * @property float $lab_max_range
 * @property float $_0_3d_minrange
 * @property float $_0_3d_maxrange
 * @property float $_4_30d_minrange
 * @property float $_4_30d_maxrange
 * @property float $_1_24m_minrange
 * @property float $_1_24m_maxrange
 * @property float $_25_60m_minrange
 * @property float $_25_60m_maxrange
 * @property float $_5_19y_minrange
 * @property float $_5_19y_maxrange
 * @property float $adult_minrange
 * @property float $adult_maxrange
 * @property bool $lab_default
 * @property bool $lab_ordered_independently
 * @property bool $lab_multiple_orders_allowed
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Ignite\Evaluation\Entities\Procedures $_parent
 * @property-read \Ignite\Evaluation\Entities\Procedures $_procedure
 * @property-read \Ignite\Evaluation\Entities\LabtestCategories $subProcedureCategories
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\SubProcedures where03dMaxrange($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\SubProcedures where03dMinrange($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\SubProcedures where124mMaxrange($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\SubProcedures where124mMinrange($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\SubProcedures where2560mMaxrange($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\SubProcedures where2560mMinrange($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\SubProcedures where430dMaxrange($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\SubProcedures where430dMinrange($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\SubProcedures where519yMaxrange($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\SubProcedures where519yMinrange($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\SubProcedures whereAdultMaxrange($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\SubProcedures whereAdultMinrange($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\SubProcedures whereCategory($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\SubProcedures whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\SubProcedures whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\SubProcedures whereLabDefault($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\SubProcedures whereLabMaxRange($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\SubProcedures whereLabMinRange($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\SubProcedures whereLabMultipleOrdersAllowed($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\SubProcedures whereLabOrderedIndependently($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\SubProcedures whereLabResultOptions($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\SubProcedures whereLabResultType($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\SubProcedures whereLabSampleType($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\SubProcedures whereParent($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\SubProcedures whereProcedure($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\SubProcedures whereResultTypeDetails($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\SubProcedures whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\SubProcedures whereTitles($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\SubProcedures whereUnits($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\SubProcedures whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SubProcedures extends Model {

    public $table = 'evaluation_subprocedures';

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
