<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;


/**
 * Ignite\Evaluation\Entities\OpNotes
 *
 * @property int $id
 * @property int $visit
 * @property string|null $surgery_indication
 * @property string|null $implants
 * @property string|null $postop
 * @property string|null $date
 * @property int|null $doctor
 * @property string|null $indication
 * @property int|null $user
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Ignite\Evaluation\Entities\Visit $visits
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\OpNotes whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\OpNotes whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\OpNotes whereDoctor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\OpNotes whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\OpNotes whereImplants($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\OpNotes whereIndication($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\OpNotes wherePostop($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\OpNotes whereSurgeryIndication($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\OpNotes whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\OpNotes whereUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\OpNotes whereVisit($value)
 * @mixin \Eloquent
 */
class OpNotes extends Model {

    public $primaryKey = 'visit';
    public $incrementing = false;
    public $table = 'evaluation_opnotes';
    protected $guarded = [];

    public function visits() {
        return $this->belongsTo(Visit::class, 'visit');
    }

}
