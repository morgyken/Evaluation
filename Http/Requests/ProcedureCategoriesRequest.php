<?php

namespace Ignite\Evaluation\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProcedureCategoriesRequest extends FormRequest {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        $name = $this->get('id');
        return [
            "name" => "required|unique:evaluation_procedure_categories,name,$name",
            "applies_to" => "required"
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
