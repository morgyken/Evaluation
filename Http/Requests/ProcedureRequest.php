<?php

namespace Ignite\Evaluation\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProcedureRequest extends FormRequest {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        $code = $this->get('id');
        return [
            "name" => "required",
            "code" => "required|unique:evaluation_procedures,code,$code",
            "category" => "required",
            "cash_charge" => "numeric",
            "status" => "required",
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

}
