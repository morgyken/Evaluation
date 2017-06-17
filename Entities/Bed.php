<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Evaluation\Entities\Bed
 *
 * @property int $id
 * @property string $number
 * @property string $type
 * @property string $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Bed whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Bed whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Bed whereNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Bed whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Bed whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\Bed whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Bed extends Model
{
    protected $fillable = ['id','number','type'
                            ,'status','ward_id'
    ];

    protected $table = 'beds';

}
