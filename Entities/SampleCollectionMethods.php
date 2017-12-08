<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;


/**
 * Ignite\Evaluation\Entities\SampleCollectionMethods
 *
 * @property int $id
 * @property string $name
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\SampleCollectionMethods whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\SampleCollectionMethods whereName($value)
 * @mixin \Eloquent
 */
class SampleCollectionMethods extends Model
{
    protected $guarded = [];
    protected $table = 'evaluation_sample_collection_methods';
    public $timestamps = false;
}
