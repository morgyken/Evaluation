<?php

/*
 * =============================================================================
 *
 * Collabmed Solutions Ltd
 * Project: Collabmed Health Platform
 * Author: Samuel Okoth <sodhiambo@collabmed.com>
 *
 * =============================================================================
 */

namespace Ignite\Evaluation\Repositories;

use Ignite\Evaluation\Entities\EvaluationPaymentCash;
use Ignite\Evaluation\Entities\EvaluationPaymentMpesa;
use Ignite\Evaluation\Entities\EvaluationPayments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Description of EvaluationFinanceFunctions
 *
 * @author samuel
 */
class EvaluationFinanceFunctions implements EvaluationFinanceRepository {

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var array
     */
    protected $input;

    /**
     * @var
     */
    protected $user;

    /**
     * EvaluationFinanceFunctions constructor.
     * @param Request $request
     */
    public function __construct(Request $request) {
        $this->request = $request;
        $this->input = $this->request->all();
        if (Auth::check()) {
            $this->user = $this->request->user()->id;
        }
        $this->prepareInput($this->input);
    }

    /**
     * Record payment
     * @return bool
     */
    public function record_payment() {
        DB::transaction(function () {
            $payment = new EvaluationPayments;
            $payment->patient = $this->request->patient;
            $payment->receipt = generate_receipt_no();
            $payment->description = 'Patient Payments';
            $payment->user = $this->user;
            $payment->save();
            $this->payment_methods($payment);
            $this->update_units();
            session(['pay_id' => $payment->id]);
        });
        return true;
    }

    private function update_units() {
        \Ignite\Evaluation\Entities\Investigations::whereIn('id', $this->__get_selected_stack())->update(['is_paid' => true]);
    }

    private function payment_methods(EvaluationPayments $payment) {
        if ($this->request->has('CashAmount')) {
            EvaluationPaymentCash::create(['amount' => $this->input['CashAmount'], 'payment' => $payment->id]);
        }
        if ($this->request->has('MpesaAmount')) {
            EvaluationPaymentMpesa::create([
                'amount' => $this->input['MpesaAmount'], 'payment' => $payment->id, 'reference' => $this->input['MpesaCode']
            ]);
        }
    }

    private function prepareInput(&$input) {
        unset($input['_token']);
        foreach ($input as $key => $value) {
            if (empty($value)) {
                unset($input[$key]);
            }
        }
        if (!empty($input['id'])) {
            $this->id = $input['id'];
            unset($input['id']);
        }
    }

    /**
     * Build an index of items dynamically
     * @return array
     */
    private function __get_selected_stack() {
        $stack = [];
        foreach ($this->input as $key => $one) {
            if (starts_with($key, 'item')) {
                $stack[] = substr($key, 4);
            }
        }
        return $stack;
    }

}
