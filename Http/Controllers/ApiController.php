<?php

namespace Ignite\Evaluation\Http\Controllers;

use Nwidart\Modules\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Ignite\Evaluation\Library\EvaluationFunctions;

class ApiController extends Controller {

    /**
     * @var array The application datas
     */
    protected $data = [];

    public function index() {
        return view('ajax::index');
    }

    public function get_clinic($clinic_id) {
        $clinic = Clinics::find($clinic_id);
        return Response::json($clinic);
    }

    public function delete_clinic($clinic_id) {
        $clinic = Clinics::destroy($clinic_id);
        return Response::json($clinic);
    }

    public function get_wards($clinic_id = null) {
        $them = get_wards($clinic_id);
        return Response::json($them);
    }

    public function get_schemes(Request $request) {
        return Response::json(get_schemes($request->id));
    }

    public function cancel_appointment(Request $request) {
        $appointment = \Ignite\Reception\Entities\Appointments::destroy($request->id);
        return Response::json($appointment);
    }

    public function cancel_checkin(Request $request) {
        return Response::json(\Ignite\Evaluation\Entities\PatientVisits::destroy($request->id));
    }

    public function checkout_patient(Request $request) {
        return Response::json(EvaluationFunctions::checkout($request));
    }

    public function get_schedule(Request $request) {
        $this->data['appointments'] = get_appointments($request);
        return view('system.ajax.clinic_appointments')->with('data', $this->data);
    }

    public function phones($regex) {
        $users = \Ignite\Core\Entities\UserProfile::orWhere('first_name', 'like binary', "%$regex%")
                ->orWhere('middle_name', 'like binary', "%$regex%")
                ->orWhere('last_name', 'like binary', "%$regex%");
        return Response::json($users);
    }

    public function reschedule(Request $request) {
        $this->data['form'] = \Ignite\Reception\Entities\Appointments::find($request->id);
        return view('system.ajax.reschedule')->with('data', $this->data);
    }

    public function upload_document(Request $request) {
        $document = new \Ignite\Reception\Entities\PatientDocuments;
        $document->patient = $request->patient;
        $document->type = $request->type;
        $document->document = $file->getRealPath();
        /*
         * @todo check if this works
         */
        return true;
    }

    public function save_drawings(Request $request) {
        return Response::json(EvaluationFunctions::save_drawings($request));
    }

    public function diagnosis_codes($regex = null) {
        return Response::json(get_diagnosis_codes($regex));
    }

    public function save_vitals(Request $request) {
        return Response::json(EvaluationFunctions::save_vitals($request));
    }

    public function save_opnotes(Request $request) {
        return Response::json(EvaluationFunctions::save_opnotes($request));
    }

    public function save_notes(Request $request) {
        return Response::json(EvaluationFunctions::save_notes($request));
    }

    public function save_diagnosis(Request $request) {
        return Response::json(EvaluationFunctions::save_diagnosis($request));
    }

    public function save_treatment(Request $request) {
        return Response::json(EvaluationFunctions::save_treatment($request));
    }

    public function change_destination(Request $request) {
        $meta = \Ignite\Evaluation\Entities\PatientVisits::find($request->id);
        $meta->destination = $request->new_dest;
        return Response::json($meta->save());
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

    public function delete_doc(Request $request) {
        return Response::json(\Ignite\Reception\Entities\PatientDocuments::destroy($request->id));
    }

    public function notifications() {
        if (Auth::check()) {
            $this->data['notifications'] = \Ignite\Notification\Entities\Notification::all();
            return view('system.ajax.notifications')->with('data', $this->data);
        }
    }

    public function delete_procedure_cat(Request $request) {
        return Response::json(\Ignite\Setup\Entities\ProcedureCategories::destroy($request->id));
    }

    public function delete_schedule_cat(Request $request) {
        return Response::json(\Ignite\Setup\Entities\AppointmentCategory::destroy($request->id));
    }

    public function save_visit_metas(Request $request) {
        return Response::json(EvaluationFunctions::update_visit_meta($request));
    }

    public function order_diagnosis(Request $request) {
        return Response::json(EvaluationFunctions::order_diagnosis($request));
    }

}
