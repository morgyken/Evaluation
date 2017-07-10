<?php

namespace Ignite\Evaluation\Entities;

use Ignite\Users\Entities\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Evaluation\Entities\VisitMeta
 *
 * @property int $visit
 * @property string|null $sick_off
 * @property string|null $sick_off_review
 * @property string|null $next_appointment
 * @property int $call
 * @property int $pre_authorization
 * @property int $book_theatre
 * @property int $refer_specialist
 * @property int $book_for_doctor
 * @property int|null $user
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Ignite\Users\Entities\User|null $users
 * @property-read \Ignite\Evaluation\Entities\Visit $visits
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\VisitMeta whereBookForDoctor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\VisitMeta whereBookTheatre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\VisitMeta whereCall($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\VisitMeta whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\VisitMeta whereNextAppointment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\VisitMeta wherePreAuthorization($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\VisitMeta whereReferSpecialist($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\VisitMeta whereSickOff($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\VisitMeta whereSickOffReview($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\VisitMeta whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\VisitMeta whereUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\VisitMeta whereVisit($value)
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
