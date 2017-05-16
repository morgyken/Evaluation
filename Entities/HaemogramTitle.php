<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Evaluation\Entities\EyeExam
 *
 * @property integer $id
 * @property integer $visit
 * @property string $option
 * @property string $od
 * @property string $os
 * @property string $comments
 * @property integer $user
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Ignite\Evaluation\Entities\Visit $visits
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\EyeExam whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\EyeExam whereVisit($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\EyeExam whereOption($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\EyeExam whereOd($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\EyeExam whereOs($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\EyeExam whereComments($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\EyeExam whereUser($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\EyeExam whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\EyeExam whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class HaemogramTitle extends Model {

    protected $table = 'hemogram_titles';

    public function tests() {
        return $this->hasMany(SubProcedures::class, 'title');
    }

    public function procedures() {
        return $this->belongsTo(Procedures::class, 'procedure');
    }

}
