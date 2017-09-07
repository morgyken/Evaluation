<?php

namespace Ignite\Evaluation\Entities;

use Ignite\Inventory\Entities\InventoryProducts;
use Illuminate\Database\Eloquent\Model;

class Sensitivity extends Model
{
    protected $fillable = [];
    protected $guarded = [];
    protected $table = 'evaluation_sensitivity';

    public function drug(){
        return $this->belongsTo( InventoryProducts::class, 'drug_id');
    }
}
