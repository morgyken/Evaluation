<?php

namespace Ignite\Evaluation\Http\Controllers;

use Ignite\Evaluation\Entities\Visits;
use Ignite\Reception\Entities\Patients;
use Illuminate\Http\Request;

class EvaluationController extends \Ignite\Core\Http\Controllers\AdminBaseController {

    public function waiting_nurse() {
        $this->data['all'] = Visits::checkedAt('nurse')->get();
        return view('evaluation::queue_nurse')->with('data', $this->data);
    }

    public function preliminary_examinations($patient_visit, $flag = null) {
        $this->data['route'] = 'preliminary_examinations';
        $this->data = array_merge($this->data, patient_management($patient_visit, $flag));
        dd($this->data);
        return view('evaluation::preliminary_section')->with('data', $this->data);
    }

    public function patient_nursing($visit) {
        $this->data['visits'] = $v = Visits::find($visit);
        if (empty($v)) {
            return redirect()->route('evaluation.waiting_nurse');
        } $this->data['visit'] = $visit;
        $this->data['patient'] = Patients::find($v->patient);
        return view('evaluation::patient_preview1')->with('data', $this->data);
    }

    public function waiting_doctor() {
        $this->data['all'] = Visits::checkedAt('evaluation')->get();
        return view('evaluation::queue_doctor')->with('data', $this->data);
    }

    public function patient_evaluation($visit) {
        $this->data['visits'] = $v = \Ignite\Evaluation\Entities\Visits::find($visit);
        if (empty($v)) {
            return redirect()->route('evaluation.waiting_doctor');
        }
        $this->data['visit'] = $visit;
        $this->data['patient'] = \Ignite\Reception\Entities\Patients::find($v->patient);
        return view('evaluation::evaluation')->with('data', $this->data);
    }

    public function waiting_radiology() {
        $this->data['all'] = \Ignite\Evaluation\Entities\Visits::checkedAt('radiology')->get();
        return view('evaluation::queue_radiology')->with('data', $this->data);
    }

    public function radiology(int $id) {
        $this->data['visits'] = \Ignite\Evaluation\Entities\Visits::find($id);
        $this->data['visit'] = $id;
        return view('evaluation::radiology')->with('data', $this->data);
    }

    /**
     * @todo Optimize this
     * @return type
     */
    public function waiting_diagnostics() {
        $this->data['all'] = \Ignite\Evaluation\Entities\Visits::checkedAt('diagnostics')->get();
        return view('evaluation::queue_diagnostics')->with('data', $this->data);
    }

    /**
     *
     * @param int $id
     * @return type
     * @todo Improve diagnostics
     */
    public function diagnostics($id) {
        $this->data['visits'] = \Ignite\Evaluation\Entities\Visits::find($id);
        $this->data['visit'] = $id;
        return view('evaluation::diagnostics')->with('data', $this->data);
    }

    public function waiting_labs() {
        $this->data['all'] = \Ignite\Evaluation\Entities\Visits::checkedAt('laboratory')->get();
        return view('evaluation::queue_labs')->with('data', $this->data);
    }

    /**
     * @todo Work on labs later
     * @param int $id
     * @return type
     */
    public function labs($id) {
        $this->data['visits'] = \Ignite\Evaluation\Entities\Visits::find($id);
        $this->data['visit'] = $id;
        return view('evaluation::labs')->with('data', $this->data);
    }

    public function waiting_theatre() {
        $this->data['all'] = \Ignite\Evaluation\Entities\Visits::checkedAt('theatre')->get();
        return view('evaluation::queue_theatre')->with('data', $this->data);
    }

    public function theatre($id) {
        $this->data['visits'] = $v = \Ignite\Evaluation\Entities\Visits::find($id);
        $this->data['visit'] = $id;
        $this->data['patient'] = \Ignite\Reception\Entities\Patients::find($v->patient);
        return view('evaluation::theatre')->with('data', $this->data);
    }

    public function sign_out(Request $request, $visit_id, $section) {
        $checkout = \Ignite\Evaluation\Library\EvaluationFunctions::checkout($request, ['id' => $visit_id, 'from' => $section]);
        if ($checkout) {
            $request->session()->flash('success', 'Patient checked out from ' . ucfirst($section));
        } else {
            $request->session()->flash('warning', 'Patient could not be checked out.' . ucfirst($section));
        }
        if ($section == 'evaluation')
            $section = 'doctor';
        return redirect()->route('evaluation.waiting_' . $section);
    }

    public function review() {
        $this->data['patients'] = \Ignite\Reception\Entities\Patients::whereHas('visits', function($query) {

                })->get();
        return view('evaluation::reviews')->with('data', $this->data);
    }

    public function review_patient($patient_id) {
        $this->data['patients'] = \Ignite\Reception\Entities\Patients::wherePatient($patient_id)->get();
        return view('evaluation::patient_preview')->with('data', $this->data);
    }

    public function patient_visits($patient_id) {
        $this->data['visits'] = \Ignite\Evaluation\Visits::wherePatient($patient_id)->get();
        $this->data['patient'] = \Ignite\Reception\Patients::find($patient_id);
        return view('evaluation::patient_visits')->with('data', $this->data);
    }

}
