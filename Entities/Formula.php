<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Evaluation\Entities\Formula
 *
 * @property-read \Ignite\Evaluation\Entities\Procedures $procedure
 * @property-read \Ignite\Evaluation\Entities\Procedures $test
 * @mixin \Eloquent
 */
class Formula extends Model {

    protected $fillable = [];
    public $guarded = [];
    protected $table = 'evaluation_formula';

    public function procedure() {
        return $this->belongsTo(Procedures::class, 'procedure_id');
    }

    public function test() {
        return $this->belongsTo(Procedures::class, 'test_id');
    }

}
