<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Evaluation\Entities\HaemogramTitle
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Evaluation\Entities\SubProcedures[] $tests
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\HaemogramTitle whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\HaemogramTitle whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\HaemogramTitle whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\HaemogramTitle whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\HaemogramTitle whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class HaemogramTitle extends Model {

    protected $table = 'hemogram_titles';

    public function tests() {
        return $this->hasMany(SubProcedures::class, 'title');
    }

    public function procedures() {
        return $this->belongsTo(Procedures::class, 'procedure');
    }

}
