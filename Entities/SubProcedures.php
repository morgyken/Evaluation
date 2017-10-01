<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Evaluation\Entities\SubProcedures
 *
 * @property int $id
 * @property int $procedure
 * @property int|null $parent
 * @property int|null $category
 * @property string|null $titles
 * @property string|null $title
 * @property string|null $lab_sample_type
 * @property string|null $method
 * @property string|null $turn_around_time
 * @property string|null $lab_result_type
 * @property string|null $result_type_details
 * @property string|null $lab_result_options
 * @property string|null $units
 * @property string|null $gender
 * @property float|null $lab_min_range
 * @property float|null $lab_max_range
 * @property float|null $_0_3d_minrange
 * @property float|null $_0_3d_maxrange
 * @property float|null $_4_30d_minrange
 * @property float|null $_4_30d_maxrange
 * @property float|null $_1_24m_minrange
 * @property float|null $_1_24m_maxrange
 * @property float|null $_25_60m_minrange
 * @property float|null $_25_60m_maxrange
 * @property float|null $_5_19y_minrange
 * @property float|null $_5_19y_maxrange
 * @property float|null $adult_minrange
 * @property float|null $adult_maxrange
 * @property int|null $lab_default
 * @property int|null $lab_ordered_independently
 * @property int|null $lab_multiple_orders_allowed
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Ignite\Evaluation\Entities\Procedures|null $_parent
 * @property-read \Ignite\Evaluation\Entities\Procedures $_procedure
 * @property-read \Ignite\Evaluation\Entities\LabtestCategories|null $subProcedureCategories
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\SubProcedures where03dMaxrange($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\SubProcedures where03dMinrange($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\SubProcedures where124mMaxrange($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\SubProcedures where124mMinrange($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\SubProcedures where2560mMaxrange($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\SubProcedures where2560mMinrange($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\SubProcedures where430dMaxrange($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\SubProcedures where430dMinrange($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\SubProcedures where519yMaxrange($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\SubProcedures where519yMinrange($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\SubProcedures whereAdultMaxrange($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\SubProcedures whereAdultMinrange($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\SubProcedures whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\SubProcedures whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\SubProcedures whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\SubProcedures whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\SubProcedures whereLabDefault($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\SubProcedures whereLabMaxRange($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\SubProcedures whereLabMinRange($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\SubProcedures whereLabMultipleOrdersAllowed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\SubProcedures whereLabOrderedIndependently($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\SubProcedures whereLabResultOptions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\SubProcedures whereLabResultType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\SubProcedures whereLabSampleType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\SubProcedures whereMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\SubProcedures whereParent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\SubProcedures whereProcedure($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\SubProcedures whereResultTypeDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\SubProcedures whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\SubProcedures whereTitles($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\SubProcedures whereTurnAroundTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\SubProcedures whereUnits($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\SubProcedures whereUpdatedAt($value)
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
