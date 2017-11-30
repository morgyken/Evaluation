<?php

namespace Ignite\Evaluation\Entities;

use Ignite\Settings\Entities\Rooms;
use Ignite\Users\Entities\User;
use Illuminate\Database\Eloquent\Model;


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
