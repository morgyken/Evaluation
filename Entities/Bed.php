<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;

class Bed extends Model
{
    protected $fillable = ['id','number','type'
                            ,'status','ward_id'
    ];

    protected $table = 'beds';

}