<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;

class Formula extends Model
{
    protected $fillable = [];
    public $guarded = [];
    protected $table = 'evaluation_formula';
}
