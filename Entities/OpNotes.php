<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Evaluation\Entities\OpNotes
 *
 * @property integer $id
 * @property integer $visit
 * @property string $surgery_indication
 * @property string $implants
 * @property string $postop
 * @property string $date
 * @property integer $doctor
 * @property string $indication
 * @property integer $user
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Ignite\Evaluation\Entities\Visits $visits
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\OpNotes whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\OpNotes whereVisit($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\OpNotes whereSurgeryIndication($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\OpNotes whereImplants($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\OpNotes wherePostop($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\OpNotes whereDate($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\OpNotes whereDoctor($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\OpNotes whereIndication($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\OpNotes whereUser($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\OpNotes whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\OpNotes whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class OpNotes extends Model {

    public $primaryKey = 'visit';
    public $incrementing = false;
    public $table = 'evaluation_opnotes';
    protected $guarded= [];

    public function visits() {
        return $this->belongsTo(Visits::class, 'visit', 'visit_id');
    }

}
