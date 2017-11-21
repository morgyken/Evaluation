<?php

namespace Ignite\Evaluation\Http\Controllers;

use Ignite\Evaluation\Entities\Investigations;
use Ignite\Evaluation\Entities\Prescriptions;
use Ignite\Evaluation\Entities\ProcedureInventoryItem;
use Ignite\Evaluation\Entities\Sensitivity;
use Ignite\Evaluation\Entities\Visit;
use Ignite\Evaluation\Repositories\EvaluationRepository;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ApiController extends Controller
{

    /**
     * @var EvaluationRepository
     */
    protected $evaluationRepository;

    /**
     * ApiController constructor.
     * @param EvaluationRepository $evaluationRepository
     */
    public function __construct(EvaluationRepository $evaluationRepository)
    {
        $this->evaluationRepository = $evaluationRepository;
    }

    public function save_drawings(Request $request)
    {
        return response()->json($this->evaluationRepository->save_drawings($request));
    }

    public function diagnosis_codes($regex = null)
    {
        return $this->evaluationRepository->get_diagnosis_codes_auto();
    }


    public function drugInfo(Request $request)
    {
        return response()->json(Prescriptions::with('drugs')->with('payment')->find($request->id));
    }

    public function deletePrescription(Request $request)
    {
        $success = false;
        $pres = Prescriptions::find($request->id);
        if ($pres) {
            $success = $pres->delete();
        }
        return response()->json(['success' => $success]);
    }

    public function getPrescriptions($visit_id)
    {
        $visit = Visit::find($visit_id);
        $found = [];
        foreach ($visit->prescriptions as $pres) {
            $found[] = [
                $pres->drugs->name,
                $pres->payment->quantity,
                $pres->dose,
//                $pres->duration . ' '
//                . mconfig('evaluation.options.prescription_duration.' . $pres->time_measure),
                $pres->payment->complete ?
                    "<i class='fa fa-check-circle-o' title='Drug Processed'></i>"
                    : "<button type='button' tom='$pres->id' class='editP btn btn-xs btn-primary'><i class='fa fa-edit' title='Edit Drug'></i></button>" .
                    "<button type='button' tom='$pres->id' class='deleteP btn btn-xs btn-danger'><i class='fa fa-trash' title='Delete Drug'></i></button>",
            ];
        }
        return response()->json(['data' => $found]);
    }

    public function save_vitals()
    {
        return response()->json($this->evaluationRepository->save_vitals());
    }

    public function save_opnotes()
    {
        return response()->json($this->evaluationRepository->save_opnotes());
    }

    public function save_notes()
    {
        return response()->json($this->evaluationRepository->save_notes());
    }

    public function investigation_result()
    {
        return response()->json($this->evaluationRepository->save_results_investigations());
    }

    public function save_diagnosis()
    {
        return response()->json($this->evaluationRepository->save_diagnosis());
    }

    public function deleteInvestigation($id)
    {
        return response()->json($this->evaluationRepository->deleteInvestigation($id));
    }

    public function save_external_order(Request $request)
    {
        return response()->json($this->evaluationRepository->make_external_order($request));
    }

    public function save_prescription()
    {
        return response()->json($this->evaluationRepository->save_prescriptions());
    }

    public function set_next_date(Request $request)
    {
        return response()->json($this->evaluationRepository->set_next_visit($request));
    }

    public function set_visit_date(Request $request)
    {
        return response()->json($this->evaluationRepository->set_visit_date($request));
    }

    public function save_preliminary()
    {
        $this->evaluationRepository->save_preliminary_eye();
    }

    public function delete_range(Request $request)
    {
        $this->evaluationRepository->delete_range($request);
    }

    public function del_critical_value(Request $request)
    {
        $this->evaluationRepository->delete_critical_value($request);
    }

    public function delete_formulae(Request $request)
    {
        $this->evaluationRepository->delete_formulae($request);
    }

    public function delete_procedure(Request $request)
    {
        $this->evaluationRepository->delete_procedure($request);
    }

    public function save_sensitivity(Request $request)
    {
        try {
            $s = new Sensitivity();
            $s->visit_id = $request->visit_id;
            $s->drug_id = $request->drug_id;
            $s->sensitivity = $request->sensitivity;
            $s->test_id = $request->test_id;
            $s->procedure_id = $request->procedure_id;
            $s->save();
            return 'Saved';
        } catch (\Exception $e) {
            return null;
        }
    }

    public function checkout_patient()
    {
        return $this->evaluationRepository->checkout_patient();
    }

    public function getProceduresFor($dept, $_v)
    {
        $visit = Visit::find($_v);
        $list = get_procedures_for($dept);
        $build = [];
        foreach ($list as $procedure) {
            $price = get_price_procedure($visit, $procedure);
            $build[] = [
                '<input type="checkbox" id="checked_' . $procedure->id . '" name="item' . $procedure->id . '" value="' . $procedure->id . '" class="check"/>',
                '<span id="name' . $procedure->id . '">' . $procedure->name . '</span>',
                '<input class="quantity" size="5" value="1" id="quantity' . $procedure->id . '"  type="text"  name="quantity' . $procedure->id . '"/>',
                '<input class="discount" size="5" value="0"
                   id="discount' . $procedure->id . '" type="hidden"
                   name="discount' . $procedure->id . '"/>
            <input type="hidden" name="type' . $procedure->id . '" value="laboratory" disabled/>
            <input disabled="" type="text" name="price' . $procedure->id . '" value="' . $price . '"
                   id="cost' . $procedure->id . '" size="5" readonly=""/>
            <input size="5" id="amount' . $procedure->id . '" type="hidden"
                   name="amount' . $procedure->id . '" value="' . $price . '"/>'
            ];
        }
        return response()->json(['data' => $build]);
    }

    public function get_procedures(Request $request, $type)
    {
        try {
            $patient = \Session::get('active_patient');
            $sex = strtolower($patient->sex);
        } catch (\Exception $e) {
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

            if (!empty($val->gender)) {
                if ($val->gender == $sex) {
                    $build[] = ['text' => $val['name'], 'id' => $val['id'], 'price' => $price];
                }
            } else {
                $build[] = ['text' => $val['name'], 'id' => $val['id'], 'price' => $price];
            }
        }
        return json_encode(['results' => $build]);
    }

    public function get_all_procedures(Request $request)
    {
        $term = $request->term['term'];
        $build = [];
        $found = get_all_procedures($term);

        foreach ($found as $val) {
            $build[] = ['text' => $val['name'], 'id' => $val['id'], 'price' => $price = $val['cash_charge']];
        }
        return json_encode(['results' => $build]);
    }

    public function get_drugs(Request $request, $type)
    {
        $term = $request->term['term'];
        $build = [];
        $found = get_procedures_for($type, $term);
        foreach ($found as $val) {
            $build[] = ['text' => $val['name'], 'id' => $val['id'], 'price' => $val['cash_charge']];
        }
        return json_encode(['results' => $build]);
    }

    public function pharmacy_cancel_prescription(Request $request)
    {
        $pres = Prescriptions::find($request->id);
        return response()->json(['status' => $pres->delete()]);
    }

    public function manage_inventory_items(Request $request)
    {
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

    public function delete_title_lab(Request $request)
    {
        $this->evaluationRepository->delete_title_lab($request);
    }

    public function delete_critical_value(Request $request)
    {
        $this->evaluationRepository->delete_critical_value($request);
    }

    //
    public function delete_lab_template_test(Request $request)
    {
        $this->evaluationRepository->delete_lab_template_test($request);
    }

    public function getDoneTreatment($visit_id)
    {
        return response()->json(['data' => get_patient_procedures($visit_id)]);
    }

    public function getDoneInvestigations(Visit $visit_id)
    {
        return response()->json(['data' => get_patient_procedures($visit_id, true)]);
    }
}
