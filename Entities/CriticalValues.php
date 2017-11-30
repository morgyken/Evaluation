<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;


class CriticalValues extends Model
{
    protected $fillable = [];
    protected $table = 'evaluation_critical_values';
    protected $guarded =[];

    public function procedures() {
        return $this->belongsTo(Procedures::class, 'procedure');
    }
}
