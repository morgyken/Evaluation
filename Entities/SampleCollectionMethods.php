<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Evaluation\Entities\SampleCollectionMethods
 *
 * @mixin \Eloquent
 */
class SampleCollectionMethods extends Model
{
    protected $guarded = [];
    protected $table = 'evaluation_sample_collection_methods';
    public $timestamps = false;
}
