<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    protected $fillable = ['name','number','category', 'cost','age_group','gender'];

}
