<?php

namespace Ignite\Evaluation\Entities;

use Ignite\Evaluation\Entities\DiagnosisCodes;
use Ignite\Users\Entities\Sentinel;
use Illuminate\Database\Eloquent\Model;


class DoctorNotes extends Model
{

    //use SoftDeletes;

    public $primaryKey = 'visit';
    public $incrementing = false;
    protected $guarded = [];
    public $table = 'evaluation_doctor_notes';

    public function visits()
    {
        return $this->belongsTo(Visit::class, 'visit');
    }

    public function doctor()
    {
        return $this->belongsTo(Sentinel::class, 'user');
    }

    public function getVisitTypeAttribute()
    {
        $type = (bool)Visit::where('id', '<>', $this->visit)
            ->wherePatient($this->visits->patient)
            ->count();
        return $type ? 'Revisit' : 'New';
    }

    public function getCodesAttribute()
    {
        $_code = '';
        if (isset($this->diagnosis)) {
            try {
                foreach (json_decode($this->diagnosis) as $key => $value) {
                    $dcode = DiagnosisCodes::find($value);
                    $_code .= '<span class="label label-default">' . $dcode->name . '</span> ';
                }
                echo "Initial diagnoses:-<br/>" . $_code;
            } catch (\Exception $e) {
                return 'Invalid format';
            }
        } else {
            'None selected';
        }
    }

}
