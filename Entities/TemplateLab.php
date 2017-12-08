<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;


/**
 * Ignite\Evaluation\Entities\TemplateLab
 *
 * @property int $id
 * @property int $procedure
 * @property int|null $title
 * @property int $subtest
 * @property int|null $sort_order
 * @property string|null $alias
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
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Ignite\Evaluation\Entities\HaemogramTitle|null $header
 * @property-read \Ignite\Evaluation\Entities\Procedures $procedures
 * @property-read \Ignite\Evaluation\Entities\Procedures $subtests
 * @property-read \Ignite\Evaluation\Entities\HaemogramTitle|null $titles
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\TemplateLab where03dMaxrange($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\TemplateLab where03dMinrange($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\TemplateLab where124mMaxrange($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\TemplateLab where124mMinrange($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\TemplateLab where2560mMaxrange($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\TemplateLab where2560mMinrange($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\TemplateLab where430dMaxrange($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\TemplateLab where430dMinrange($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\TemplateLab where519yMaxrange($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\TemplateLab where519yMinrange($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\TemplateLab whereAdultMaxrange($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\TemplateLab whereAdultMinrange($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\TemplateLab whereAlias($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\TemplateLab whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\TemplateLab whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\TemplateLab whereLabMaxRange($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\TemplateLab whereLabMinRange($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\TemplateLab whereProcedure($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\TemplateLab whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\TemplateLab whereSubtest($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\TemplateLab whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\TemplateLab whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TemplateLab extends Model {

    protected $fillable = [];
    protected $guarded = [];
    protected $table = 'evaluation_templates_lab';

    public function procedures() {
        return $this->belongsTo(Procedures::class, 'procedure');
    }

    public function subtests() {
        return $this->belongsTo(Procedures::class, 'subtest');
    }

    public function titles() {
        return $this->belongsTo(HaemogramTitle::class, 'title');
    }

    public function header() {
        return $this->belongsTo(HaemogramTitle::class, 'title');
    }

}
