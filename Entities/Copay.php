<?php

namespace Ignite\Evaluation\Entities;

use Ignite\Finance\Entities\CopayPayments;
use Ignite\Settings\Entities\Schemes;
use Illuminate\Database\Eloquent\Model;

class Copay extends Model
{
    protected $guarded = [];
    protected $table = 'evaluation_copay';

    public function visit() {
        return $this->belongsTo(Visit::class, 'visit_id');
    }

    public function scheme() {
        return $this->belongsTo(Schemes::class, 'scheme_id');
    }

    public function payment() {
        return $this->hasOne(CopayPayments::class, 'copay_id');
    }

    public function getPaidAttribute() {
        $is_paid = false;
        if (!empty($this->payment)){
            $is_paid = true;
        }
        return $is_paid;
    }
}
