<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Evaluation\Entities\EyeExam
 *
 * @property int $id
 * @property int $visit
 * @property string $option
 * @property string $od
 * @property string $os
 * @property string $comments
 * @property int $user
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Ignite\Evaluation\Entities\Visit $visits
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\EyeExam whereComments($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\EyeExam whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\EyeExam whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\EyeExam whereOd($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\EyeExam whereOption($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\EyeExam whereOs($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\EyeExam whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\EyeExam whereUser($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\EyeExam whereVisit($value)
 * @mixin \Eloquent
 */
class EyeExam extends Model {

    public $primaryKey = 'visit';
    public $incrementing = false;
    public $guarded = [];
    protected $table = 'evaluation_eye_exams';

    public function visits() {
        return $this->belongsTo(Visit::class, 'visit');
    }

}
