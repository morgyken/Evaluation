<?php

namespace Ignite\Evaluation\Http\Controllers;

use Ignite\Core\Http\Controllers\AdminBaseController;
use Ignite\Evaluation\Entities\EvaluationPayments;
use Ignite\Evaluation\Http\Requests\PaymentsRequest;
use Ignite\Evaluation\Repositories\EvaluationFinanceRepository;
use Ignite\Finance\Entities\InsuranceInvoice;
use Ignite\Reception\Entities\Patients;

class FinanceController extends AdminBaseController {

    protected $financeRepository;

    public function __construct(EvaluationFinanceRepository $financeRepository) {
        parent::__construct();
        $this->financeRepository = $financeRepository;
    }

    public function payment_details($id) {
        $this->data['payment'] = EvaluationPayments::find($id);
        return view('evaluation::finance.details', ['data' => $this->data]);
    }

    public function pay_save(PaymentsRequest $request) {
        $id = $this->financeRepository->record_payment();
        return redirect()->route('evaluation.finance.payment_details', $id);
    }

    public function pay($patient = null) {
        if (!empty($patient)) {
            $this->data['patient'] = Patients::find($patient);
            return view('evaluation::finance.pay', ['data' => $this->data]);
        }
        $this->data['patients'] = get_patients_with_bills();
        return view('evaluation::finance.payment_list', ['data' => $this->data]);
    }

    public function accounts() {
        $this->data['patients'] = Patients::all();
        return view('evaluation::finance.patient_list', ['data' => $this->data]);
    }

    public function individual_account($patient) {
        $this->data['payments'] = EvaluationPayments::wherePatient($patient)->get();
        $this->data['patient'] = Patients::find($patient);
        return view('evaluation::finance.account', ['data' => $this->data]);
    }

    /*
      public function workbench($view = null) {
      $this->data['insurance'] = $this->data['cash'] = collect();
      if (!empty($view)) {
      switch ($view) {
      case 'insurance':
      $this->data['insurance'] = \Dervis\Modules\Finance\Entities\InsuranceInvoice::all();
      break;
      case 'cash':
      $this->data['cash'] = \Dervis\Modules\Finance\Entities\PatientPayments::all();
      break;
      }
      }
      return view('finance::workbench')->with('data', $this->data);
      }

      public function insurance() {
      \Dervis\Helpers\FinancialFunctions::updateInvoice();
      $this->data['invoice'] = \Dervis\Modules\Finance\Entities\InsuranceInvoice::all();
      return view('finance::insurance')->with('data', $this->data);
      }
     */

    public function insurance() {
        $this->data['all'] = \Ignite\Evaluation\Entities\Visit::wherePaymentMode('insurance');
        return view('evaluation::finance.workbench', ['data' => $this->data]);
    }

    public function summary() {
        $this->data['all'] = EvaluationPayments::all();
        return view('evaluation::finance.summary', ['data' => $this->data]);
    }

    public function cash_bills() {
        $this->data['cash'] = EvaluationPayments::all();
        return view('evaluation::finance.cash_bills', ['data' => $this->data]);
    }

}
