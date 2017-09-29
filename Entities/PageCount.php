<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Evaluation\Entities\PageCount
 *
 * @mixin \Eloquent
 */
class PageCount extends Model
{
    protected $fillable = [];
    protected $table = 'page_count';
    protected  $guarded = [];
}
