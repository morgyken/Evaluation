<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Evaluation\Entities\HaemogramTitle
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Ignite\Evaluation\Entities\Procedures $procedures
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Evaluation\Entities\SubProcedures[] $tests
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\HaemogramTitle whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\HaemogramTitle whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\HaemogramTitle whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\HaemogramTitle whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\HaemogramTitle whereUpdatedAt($value)
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
