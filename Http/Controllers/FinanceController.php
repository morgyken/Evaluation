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

    public function pay_save(PaymentsRequest $request) {
        dd($request);
        if ($ref = \Dervis\Helpers\FinancialFunctions::receive_payments($request, $patient)) {
            \Dervis\Helpers\FinancialFunctions::updateInvoice();
            return redirect()->route('finance::payment_details', $ref);
        }
    }

    public function pay($patient = null) {
        if (!empty($patient)) {
            $this->data['patient'] = Patients::find($patient);
            return view('evaluation::finance.pay')->with('data', $this->data);
        }
        $this->data['patients'] = Patients::whereHas('visits', function ($query) {
                    $query->whereHas('treatments', function ($q2) {
                        $q2->whereIsPaid(false);
                    });
                    $query->orWhereHas('investigations', function ($q3) {
                        $q3->whereIsPaid(false);
                    });
                })->get();
        return view('evaluation::finance.patient_accounts', ['data' => $this->data]);
    }

}
