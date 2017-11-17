<?php

namespace Ignite\Evaluation\Entities;

use Ignite\Settings\Entities\Rooms;
use Ignite\Users\Entities\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Evaluation\Entities\VisitDestinations
 *
 * @property int $id
 * @property int $visit
 * @property int $user
 * @property int|null $destination
 * @property int|null $room_id
 * @property string $department
 * @property int $checkout
 * @property string|null $begin_at
 * @property string|null $finish_at
 * @property string|null $deleted_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Ignite\Users\Entities\User|null $medics
 * @property-read \Ignite\Settings\Entities\Rooms|null $room
 * @property-read \Ignite\Evaluation\Entities\Visit $visits
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\VisitDestinations whereBeginAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\VisitDestinations whereCheckout($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\VisitDestinations whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\VisitDestinations whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\VisitDestinations whereDepartment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\VisitDestinations whereDestination($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\VisitDestinations whereFinishAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\VisitDestinations whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\VisitDestinations whereRoomId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\VisitDestinations whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\VisitDestinations whereUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\VisitDestinations whereVisit($value)
 * @mixin \Eloquent
 */
class VisitDestinations extends Model
{

    public $table = 'evaluation_visit_destinations';
    protected $guarded = [];

    public function visits()
    {
        return $this->belongsTo(Visit::class, 'visit');
    }

    public function medics()
    {
        return $this->belongsTo(User::class, 'destination');
    }

    public function room()
    {
        return $this->belongsTo(Rooms::class);
    }

//    public function getDestinationAttribute($value)
//    {
//        $_c = [
//            'mch' => 'MCH',
//            'hpd' => 'Hypertension and Diabetes',
//            'orthopeadic' => 'Orthopeadic',
//            'popc' => 'Pedeatrics',
//            'mopc' => 'Medical',
//            'sopc' => 'Sergical',
//            'gopc' => 'Gyenecology',
//            'physio' => 'Physiotherapy',
//        ];
//        return $_c[$value] ?? $value;
//    }

}
