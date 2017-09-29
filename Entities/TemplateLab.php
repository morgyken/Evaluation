<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Evaluation\Entities\TemplateLab
 *
 * @property-read \Ignite\Evaluation\Entities\HaemogramTitle $header
 * @property-read \Ignite\Evaluation\Entities\Procedures $procedures
 * @property-read \Ignite\Evaluation\Entities\Procedures $subtests
 * @property-read \Ignite\Evaluation\Entities\HaemogramTitle $titles
 * @mixin \Eloquent
 */
class TemplateLab extends Model {

    protected $fillable = [];
    protected $guarded = [];
    protected $table = 'evaluation_templates_lab';

    public function procedures() {
        return $this->belongsTo(Procedures::class, 'procedure');
    }

    public function subtests() {
        return $this->belongsTo(Procedures::class, 'subtest');
    }

    public function titles() {
        return $this->belongsTo(HaemogramTitle::class, 'title');
    }

    public function header() {
        return $this->belongsTo(HaemogramTitle::class, 'title');
    }

}
