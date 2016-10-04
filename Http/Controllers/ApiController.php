<?php

namespace Ignite\Evaluation\Http\Controllers;

use Ignite\Evaluation\Entities\PatientDiagnosis;
use Ignite\Evaluation\Repositories\EvaluationRepository;
use Nwidart\Modules\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Ignite\Evaluation\Library\EvaluationFunctions;

class ApiController extends Controller {

    /**
     * @var EvaluationRepository
     */
    protected $evaluation;

    /**
     * ApiController constructor.
     * @param EvaluationRepository $evaluation
     */
    public function __construct(EvaluationRepository $evaluation) {
        $this->evaluation = $evaluation;
    }

    public function save_drawings(Request $request) {
        return Response::json(EvaluationFunctions::save_drawings($request));
    }

    public function diagnosis_codes($regex = null) {
        return Response::json(get_diagnosis_codes($regex));
    }

    public function save_vitals() {
        return Response::json($this->evaluation->save_vitals());
    }

    public function save_opnotes(Request $request) {
        return Response::json(EvaluationFunctions::save_opnotes($request));
    }

    public function save_notes(Request $request) {
        return Response::json(EvaluationFunctions::save_notes($request));
    }

    public function investigation_result(Request $request) {
        foreach ($request->investigation as $item) {
            $__in = PatientDiagnosis::firstOrNew(['visit' => $request->visit[$item], 'test' => $item]);
            $__in->results = $request->result[$item];
            $__in->file = base64_encode(file_get_contents($request->file[$item]->getRealPath()));
            $__in->save();
        }
        return 'okay';
    }

    public function save_diagnosis(Request $request) {
        return Response::json(EvaluationFunctions::save_diagnosis($request));
    }

    public function save_treatment(Request $request) {
        return Response::json(EvaluationFunctions::save_treatment($request));
    }

    public function save_prescription(Request $request) {
        return Response::json(EvaluationFunctions::save_prescriptions($request));
    }

    public function set_next_date(Request $request) {
        return Response::json(EvaluationFunctions::set_next_visit($request));
    }

    public function set_visit_date(Request $request) {
        return Response::json(EvaluationFunctions::set_visit_date($request));
    }

    public function save_preliminary(Request $request) {
        foreach ($request->eye_vision as $key => $entity) {

        }
    }

}
