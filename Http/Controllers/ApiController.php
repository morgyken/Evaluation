<?php

namespace Ignite\Evaluation\Http\Controllers;

use Ignite\Evaluation\Entities\Prescriptions;
use Ignite\Evaluation\Entities\Sensitivity;
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

    public function save_external_order(Request $request) {
        return Response::json($this->evaluationRepository->make_external_order($request));
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

    public function delete_range(Request $request) {
        $this->evaluationRepository->delete_range($request);
    }

    public function del_critical_value(Request $request) {
        $this->evaluationRepository->delete_critical_value($request);
    }

    public function delete_formulae(Request $request) {
        $this->evaluationRepository->delete_formulae($request);
    }

    public function save_sensitivity(Request $request)
    {
        try{
            $s = new Sensitivity();
            $s->visit_id = $request->visit_id;
            $s->drug_id = $request->drug_id;
            $s->sensitivity = $request->sensitivity;
            $s->test_id = $request->test_id;
            $s->procedure_id = $request->procedure_id;
            $s->save();
            return 'Saved';
        }catch (\Exception $e){
            return null;
        }
    }

    public function checkout_patient() {
        $this->evaluationRepository->checkout_patient();
    }

    public function get_procedures(Request $request, $type) {
        try{
            $patient = \Session::get('active_patient');
            $sex = strtolower($patient->sex);
        }catch (\Exception $e){
            $patient = null;
            $sex = null;
        }
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

            if(!empty($val->gender)){
                if ($val->gender == $sex){
                    $build[] = ['text' => $val['name'], 'id' => $val['id'], 'price' => $price];
                }
            }else{
                $build[] = ['text' => $val['name'], 'id' => $val['id'], 'price' => $price];
            }
        }
        return json_encode(['results' => $build]);
    }

    public function get_all_procedures(Request $request) {
        $term = $request->term['term'];
        $build = [];
        $found = get_all_procedures($term);

        foreach ($found as $val) {
            $build[] = ['text' => $val['name'], 'id' => $val['id'], 'price' => $price = $val['cash_charge']];
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

    public function delete_critical_value(Request $request) {
        $this->evaluationRepository->delete_critical_value($request);
    }
    //
    public function delete_lab_template_test(Request $request) {
        $this->evaluationRepository->delete_lab_template_test($request);
    }

}
