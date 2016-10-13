<?php

namespace Ignite\Evaluation\Http\Controllers;

use Ignite\Core\Http\Controllers\AdminBaseController;
use Ignite\Evaluation\Http\Requests\PaymentsRequest;
use Ignite\Evaluation\Repositories\EvaluationFinanceRepository;
use Ignite\Reception\Entities\Patients;

class FinanceController extends AdminBaseController {

    protected $financeRepository;

    public function __construct(EvaluationFinanceRepository $financeRepository) {
        parent::__construct();
        $this->financeRepository = $financeRepository;
    }

    public function payment_details() {
        $id = session('pay_id');
        $this->data['payment'] = \Ignite\Evaluation\Entities\EvaluationPayments::find($id);
        return view('evaluation::finance.details', ['data' => $this->data]);
    }

    public function pay_save(PaymentsRequest $request) {
        $this->financeRepository->record_payment();
        return redirect()->route('evaluation.finance.payment_details');
    }

    public function pay($patient = null) {
        if (!empty($patient)) {
            $this->data['patient'] = Patients::find($patient);
            return view('evaluation::finance.pay')->with('data', $this->data);
        }
        $this->data['patients'] = Patients::whereHas('visits', function ($query) {
                    $query->whereHas('investigations', function ($q3) {
                        $q3->whereIsPaid(false);
                    });
                })->get();
        return view('evaluation::finance.patient_accounts', ['data' => $this->data]);
    }

}
