<?php

namespace Ignite\Evaluation\Http\Controllers;

use Ignite\Evaluation\Entities\Prescriptions;
use Ignite\Evaluation\Repositories\EvaluationRepository;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Response;
use Ignite\Evaluation\Entities\ProcedureInventoryItem;

class ApiController extends Controller {

    /**
     * @var EvaluationRepository
     */
    protected $evaluationRepository;

    /**
     * ApiController constructor.
     * @param EvaluationRepository $evaluationRepository
     */
    public function __construct(EvaluationRepository $evaluationRepository) {
        $this->evaluationRepository = $evaluationRepository;
    }

    public function save_drawings(Request $request) {
        return Response::json($this->evaluationRepository->save_drawings($request));
    }

    public function diagnosis_codes($regex = null) {
        return $this->evaluationRepository->get_diagnosis_codes_auto();
    }

    public function save_vitals() {
        return Response::json($this->evaluationRepository->save_vitals());
    }

    public function save_opnotes() {
        return Response::json($this->evaluationRepository->save_opnotes());
    }

    public function save_notes() {
        return Response::json($this->evaluationRepository->save_notes());
    }

    public function investigation_result() {
        return Response::json($this->evaluationRepository->save_results_investigations());
    }

    public function save_diagnosis() {
        return Response::json($this->evaluationRepository->save_diagnosis());
    }

    public function save_prescription() {
        return Response::json($this->evaluationRepository->save_prescriptions());
    }

    public function set_next_date(Request $request) {
        return Response::json($this->evaluationRepository->set_next_visit($request));
    }

    public function set_visit_date(Request $request) {
        return Response::json($this->evaluationRepository->set_visit_date($request));
    }

    public function save_preliminary() {
        $this->evaluationRepository->save_preliminary_eye();
    }

    public function checkout_patient() {
        $this->evaluationRepository->checkout_patient();
    }

    public function get_procedures(Request $request, $type) {
        $term = $request->term['term'];
        $build = [];
        $found = get_procedures_for($type, $term);

        $co = null;
        if (isset($request->visit)) {
            $visit = \Ignite\Evaluation\Entities\Visit::find($request->visit);
            if ($visit->payment_mode == 'insurance') {
                $co = $visit->patient_scheme->schemes->companies->id;
            }
        }

        foreach ($found as $val) {
            $c_price = \Ignite\Settings\Entities\CompanyPrice::whereCompany(intval($co))
                    ->whereProcedure(intval($val['id']))
                    ->get()
                    ->first();
            if (isset($c_price)) {
                if ($c_price->price > 0) {
                    $price = $c_price->price;
                }
            } else {
                $price = $val['cash_charge'];
            }
            $build[] = ['text' => $val['name'], 'id' => $val['id'], 'price' => $price];
        }
        return json_encode(['results' => $build]);
    }

    public function get_drugs(Request $request, $type) {
        $term = $request->term['term'];
        $build = [];
        $found = get_procedures_for($type, $term);
        foreach ($found as $val) {
            $build[] = ['text' => $val['name'], 'id' => $val['id'], 'price' => $val['cash_charge']];
        }
        return json_encode(['results' => $build]);
    }

    public function pharmacy_cancel_prescription(Request $request) {
        $pres = Prescriptions::find($request->id);
        if ($pres->delete()) {
            echo '
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                    ×</button>
               <span class="glyphicon glyphicon-ok"></span> <strong>Prescription Cancelled.</strong>
            </div>';
        }
    }

    public function manage_inventory_items(Request $request) {
        $item = ProcedureInventoryItem::whereProcedure($request->procedure)
                ->whereItem($request->item)
                ->first();
        if ($request->type == 'delete') {
            $item->delete();
            echo 'Inventory Item Deleted';
        } elseif ($request->type == 'update') {
            $item->units = $request->quantity;
            $item->save();
            echo 'Inventory Item Updated';
        }
    }

    public function delete_title_lab(Request $request) {
        $this->evaluationRepository->delete_title_lab($request);
    }

}
