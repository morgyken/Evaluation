<?php

namespace Ignite\Evaluation\Http\Controllers;

use Ignite\Core\Http\Controllers\AdminBaseController;
use Ignite\Evaluation\Entities\Visit;
use Ignite\Reception\Entities\Patients;
use Illuminate\Http\Request;

class EvaluationController extends AdminBaseController {

    public function __construct() {
        parent::__construct();
    }

    public function waiting_nurse() {
        $this->data['all'] = Visit::checkedAt('nurse')->get();
        return view('evaluation::queue_nurse')->with('data', $this->data);
    }

    public function preliminary_examinations($patient_visit, $flag = null) {
        $this->data['route'] = 'preliminary_examinations';
        $this->data = array_merge($this->data, patient_management($patient_visit, $flag));
        return view('evaluation::preliminary_section')->with('data', $this->data);
    }

    public function patient_nursing($visit) {
        $this->data['visits'] = $v = Visit::find($visit);
        if (empty($v)) {
            return redirect()->route('evaluation.waiting_nurse');
        } $this->data['visit'] = $visit;
        $this->data['patient'] = Patients::find($v->patient);
        return view('evaluation::patient_preview1')->with('data', $this->data);
    }

    public function waiting_doctor() {
        $this->data['all'] = Visit::checkedAt('evaluation')->get();
        return view('evaluation::queue_doctor')->with('data', $this->data);
    }

    public function patient_evaluation($visit) {
        $this->data['visits'] = $v = Visit::find($visit);
        if (empty($v)) {
            return redirect()->route('evaluation.waiting_doctor');
        }
        $this->data['visit'] = $visit;
        $this->data['patient'] = Patients::find($v->patient);
        return view('evaluation::evaluation')->with('data', $this->data);
    }

    public function waiting_radiology() {
        $this->data['all'] = Visit::checkedAt('radiology')->get();
        return view('evaluation::queue_radiology')->with('data', $this->data);
    }

    public function radiology($id) {
        $this->data['visits'] = Visit::find($id);
        $this->data['visit'] = $id;
        return view('evaluation::radiology')->with('data', $this->data);
    }

    /**
     * @todo Optimize this
     * @return type
     */
    public function waiting_diagnostics() {
        $this->data['all'] = Visit::checkedAt('diagnostics')->get();
        return view('evaluation::queue_diagnostics')->with('data', $this->data);
    }

    /**
     *
     * @param int $id
     * @return type
     * @todo Improve diagnostics
     */
    public function diagnostics($id) {
        $this->data['visits'] = Visit::find($id);
        $this->data['visit'] = $id;
        return view('evaluation::diagnostics')->with('data', $this->data);
    }

    public function waiting_labs() {
        $this->data['all'] = Visit::checkedAt('laboratory')->get();
        return view('evaluation::queue_labs')->with('data', $this->data);
    }

    /**
     * @todo Work on labs later
     * @param int $id
     * @return type
     */
    public function labs($visit) {
        $this->data['visit'] = Visit::find($visit);
        return view('evaluation::labs')->with('data', $this->data);
    }

    public function waiting_theatre() {
        $this->data['all'] = Visit::checkedAt('theatre')->get();
        return view('evaluation::queue_theatre')->with('data', $this->data);
    }

    public function theatre($id) {
        $this->data['visits'] = $v = Visit::find($id);
        $this->data['visit'] = $id;
        $this->data['patient'] = Patients::find($v->patient);
        return view('evaluation::theatre')->with('data', $this->data);
    }

    public function sign_out(Request $request, $visit_id, $section) {
        $checkout = EvaluationFunctions::checkout($request, ['id' => $visit_id, 'from' => $section]);
        if ($checkout) {
            $request->session()->flash('success', 'Patient checked out from ' . ucfirst($section));
        } else {
            $request->session()->flash('warning', 'Patient could not be checked out.' . ucfirst($section));
        }
        if ($section == 'evaluation') {
            $section = 'doctor';
        }
        return redirect()->route('evaluation.waiting_' . $section);
    }

    public function review() {
        $this->data['patients'] = Patients::whereHas('visits', function($query) {

                })->get();
        return view('evaluation::reviews')->with('data', $this->data);
    }

    public function review_patient($patient_id) {
        $this->data['patients'] = Patients::wherePatient($patient_id)->get();
        return view('evaluation::patient_preview')->with('data', $this->data);
    }

    public function patient_visits($patient_id) {
        $this->data['visits'] = Visit::wherePatient($patient_id)->get();
        $this->data['patient'] = Patients::find($patient_id);
        return view('evaluation::patient_visits')->with('data', $this->data);
    }

}
