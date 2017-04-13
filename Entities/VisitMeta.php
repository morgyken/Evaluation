<?php

namespace Ignite\Evaluation\Entities;

use Ignite\Users\Entities\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Evaluation\Entities\VisitMeta
 *
 * @property integer $visit
 * @property string $sick_off
 * @property string $sick_off_review
 * @property string $next_appointment
 * @property boolean $call
 * @property boolean $pre_authorization
 * @property boolean $book_theatre
 * @property boolean $refer_specialist
 * @property boolean $book_for_doctor
 * @property integer $user
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Ignite\Evaluation\Entities\Visit $visits
 * @property-read \Ignite\Users\Entities\User $users
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\VisitMeta whereVisit($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\VisitMeta whereSickOff($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\VisitMeta whereSickOffReview($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\VisitMeta whereNextAppointment($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\VisitMeta whereCall($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\VisitMeta wherePreAuthorization($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\VisitMeta whereBookTheatre($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\VisitMeta whereReferSpecialist($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\VisitMeta whereBookForDoctor($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\VisitMeta whereUser($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\VisitMeta whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\VisitMeta whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class VisitMeta extends Model {

    public $primaryKey = 'visit';
    public $incrementing = false;
    protected $guarded = [];
    public $table = 'evaluation_visit_metas';

    public function visits() {
        return $this->belongsTo(Visit::class, 'visit');
    }

    public function users() {
        return $this->belongsTo(User::class, 'user');
    }

}
