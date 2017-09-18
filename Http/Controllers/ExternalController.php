<?php

namespace Ignite\Evaluation\Http\Controllers;

use Ignite\Core\Http\Controllers\AdminBaseController;
use Ignite\Evaluation\Repositories\EvaluationRepository;
use Illuminate\Http\Request;
use Ignite\Reception\Entities\Patients;
use Ignite\Evaluation\Entities\ExternalOrders;

class ExternalController extends AdminBaseController {

    /**
     * @var EvaluationRepository
     */
    protected $evaluationRepository;

    /**
     * SetupController constructor.
     * @param EvaluationRepository $evaluationRepository
     */
    public function __construct(EvaluationRepository $evaluationRepository) {
        parent::__construct();
        $this->evaluationRepository = $evaluationRepository;
    }

    //External Doctor Functionality
    public function patients(Request $request) {
        $institution = $request->user()->profile->partner_institution;
        $this->data['patients'] = null;
        if (!is_null($institution)) {
            $this->data['patients'] = Patients::whereExternal_institution($institution)
                    ->get();
        }
        return view('evaluation::external.patients', ['data' => $this->data]);
    }

    public function orders(Request $request) {
        $institution = $request->user()->profile->partner_institution;
        $this->data['orders'] = null;
        $this->data['patients'] = null;
        if (!is_null($institution)) {
            $this->data['patients'] = Patients::whereExternal_institution($institution)
                    ->get();
        }
        return view('evaluation::external.order', ['data' => $this->data]);
    }

    public function view_order(Request $request) {
        $this->data['order_details'] = \Ignite\Evaluation\Entities\ExternalOrderDetails::whereOrder_id($request->id)->get();
        return view('evaluation::external.order_details', ['data' => $this->data]);
    }

    public function make_order(Request $request) {
        if ($request->isMethod('post')) {
            if ($this->evaluationRepository->make_external_order($request)) {
                flash('Order has been placed, thank you');
                return back();
            }
        }
        $this->data['institution'] = $institution = $request->user()->profile->partner_institution;
        $this->data['orders'] = null;
        $this->data['patient'] = null;
        $this->data['visit'] = 1;

        if($request->results){
            $this->data['results_mode'] = $request->results;
        }

        if (!is_null($institution)) {
            $this->data['orders'] = ExternalOrders::whereInstitution($institution)
                    ->wherePatient_id($request->patient)
                    ->get();
            $this->data['patient'] = Patients::find($request->patient);
        }
        return view('evaluation::external_order', ['data' => $this->data]);
    }

    public function p_results(Request $request){
        $institution = $request->user()->profile->partner_institution;
        $this->data['patients'] = null;
        if (!is_null($institution)) {
            $this->data['patients'] = Patients::whereExternal_institution($institution)
                ->get();
        }
        return view('evaluation::external.p_results', ['data' => $this->data]);
    }

    public function p_order(Request $request){
        $institution = $request->user()->profile->partner_institution;
        $this->data['patients'] = null;
        if (!is_null($institution)) {
            $this->data['patients'] = Patients::whereExternal_institution($institution)
                ->get();
        }
        return view('evaluation::external.p_order', ['data' => $this->data]);
    }

}
