<?php

namespace Ignite\Evaluation\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentsRequest extends FormRequest {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected $rules;

    /**
     * @todo Add rules for other modes
     * @return type
     */
    public function rules() {
        $this->rules['patient'] = 'required';
        $this->mpesa_rules();
        $this->cash_rules();
        $this->card_rules();
        return $this->rules;
    }

    private function mpesa_rules() {
        if ($this->has('MpesaAmount')) {
            $this->rules['MpesaAmount'] = 'required|numeric';
            $this->rules['MpesaCode'] = 'required';
        }
    }

    private function cash_rules() {
        if ($this->has('CashAmount')) {
            $this->rules['CashAmount'] = 'required|numeric';
        }
    }

    private function card_rules() {
        if ($this->has('CardAmount')) {
            $this->rules['CardAmount'] = 'required|numeric';
            $this->rules['MpesaCode'] = 'required';
        }
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
