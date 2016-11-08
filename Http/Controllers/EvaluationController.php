<?php

namespace Ignite\Evaluation\Http\Controllers;

use Ignite\Core\Http\Controllers\AdminBaseController;
use Ignite\Evaluation\Entities\Visit;
use Ignite\Evaluation\Repositories\EvaluationRepository;
use Ignite\Reception\Entities\Patients;
use Illuminate\Http\Request;

class EvaluationController extends AdminBaseController {

    /**
     * @var EvaluationRepository
     */
    protected $evaluationRepository;

    /**
     * EvaluationController constructor.
     * @param EvaluationRepository $evaluationRepository
     */
    public function __construct(EvaluationRepository $evaluationRepository) {
        parent::__construct();
        $this->evaluationRepository = $evaluationRepository;
        $this->__require_assets();
    }

    /**
     * Nursing queue
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function waiting_nurse() {
        $this->data['all'] = Visit::checkedAt('nurse')->get();
        return view('evaluation::queue_nurse', ['data' => $this->data]);
    }

    public function preliminary_examinations($patient_visit, $flag = null) {
        $this->data['route'] = 'preliminary_examinations';
        $this->data = array_merge($this->data, patient_management($patient_visit, $flag));
        return view('evaluation::preliminary_section', ['data' => $this->data]);
    }

    /**
     * @param $visit
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function patient_nursing($visit) {
        $this->data['visit'] = Visit::find($visit);
        $this->data['section'] = 'nurse';
        return view('evaluation::patient_nurse', ['data' => $this->data]);
    }

    /**
     * Queue for doctor
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function waiting_doctor() {
        $this->data['all'] = Visit::checkedAt('evaluation')->get();
        return view('evaluation::queue_doctor', ['data' => $this->data]);
    }

    /**
     * Doctor evaluate patient
     * @param $visit
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function patient_evaluation($visit) {
        $this->data['visit'] = $v = Visit::find($visit);
        return view('evaluation::patient_doctor', ['data' => $this->data]);
    }

    public function waiting_radiology() {
        $this->data['all'] = Visit::checkedAt('radiology')->get();
        return view('evaluation::queue_radiology', ['data' => $this->data]);
    }

    public function radiology($id) {
        $this->data['visits'] = Visit::find($id);
        $this->data['visit'] = $id;
        return view('evaluation::radiology', ['data' => $this->data]);
    }

    /**
     * @todo Optimize this
     * @return type
     */
    public function waiting_diagnostics() {
        $this->data['all'] = Visit::checkedAt('diagnostics')->get();
        return view('evaluation::queue_diagnostics', ['data' => $this->data]);
    }

    /**
     *
     * @param int $id
     * @return type
     * @todo Improve diagnostics
     */
    public function diagnostics($id) {
        $this->data['visit'] = Visit::find($id);
        return view('evaluation::patient_diagnostics', ['data' => $this->data]);
    }

    public function waiting_labs() {
        $this->data['all'] = Visit::checkedAt('laboratory')->get();
        return view('evaluation::queue_labs', ['data' => $this->data]);
    }

    /**
     * @todo Work on labs later
     * @param int $id
     * @return type
     */
    public function labs($visit) {
        $this->data['visit'] = Visit::find($visit);
        $this->data['section'] = 'laboratory';
        return view('evaluation::patient_labs', ['data' => $this->data]);
    }

    public function waiting_theatre() {
        $this->data['all'] = Visit::checkedAt('theatre')->get();
        return view('evaluation::queue_theatre', ['data' => $this->data]);
    }

    public function theatre($id) {
        $this->data['visits'] = Visit::find($id);
        $this->data['patient'] = Patients::find($v->patient);
        return view('evaluation::theatre', ['data' => $this->data]);
    }

    public function waiting_pharmacy() {
        $this->data['all'] = Visit::checkedAt('pharmacy')->get();
        return view('evaluation::queue_pharmacy', ['data' => $this->data]);
    }

    public function pharmacy($id) {
        $this->data['visit'] = $v = Visit::find($id);
        $this->data['patient'] = Patients::find($v->patient);
        $this->data['section'] = 'pharmacy';
        return view('evaluation::patient_pharmacy', ['data' => $this->data]);
    }

    public function sign_out(Request $request, $visit_id, $section) {
        $checkout = $this->evaluationRepository->checkout($request, ['id' => $visit_id, 'from' => $section]);
        if ($checkout) {
            flash('Patient checked out from ' . ucfirst($section));
        } else {
            flash('Patient could not be checked out.' . ucfirst($section));
        }
        if ($section == 'evaluation') {
            $section = 'doctor';
        }
        return redirect()->route('evaluation.waiting_' . $section);
    }

    public function review() {
        $this->data['patients'] = Patients::whereHas('visits', function ($query) {

                })->get();
        return view('evaluation::reviews', ['data' => $this->data]);
    }

    public function review_patient($patient) {
        $this->data['visits'] = Visit::wherePatient($patient)->get();
        return view('evaluation::patient_review', ['data' => $this->data]);
    }

    public function patient_visits($patient_id) {
        $this->data['visits'] = Visit::wherePatient($patient_id)->get();
        $this->data['patient'] = Patients::find($patient_id);
        return view('evaluation::patient_visits', ['data' => $this->data]);
    }

    public function investigation_result() {
        $story = $this->evaluationRepository->save_results_investigations();
        if ($story) {
            flash('Investigation result posted', 'success');
        } else {
            flash('Uh, Oh. Something wrong happened, retry');
        }
        return back();
    }

    private function __require_assets() {
        $assets = [
            'doctor-investigations.js' => m_asset('evaluation:js/doctor-investigations.min.js'),
            'doctor-treatment.js' => m_asset('evaluation:js/doctor-treatment.min.js'),
            'doctor-next-steps.js' => m_asset('evaluation:js/doctor-next-steps.min.js'),
            'doctor-notes.js' => m_asset('evaluation:js/doctor-notes.min.js'),
            'doctor-opnotes.js' => m_asset('evaluation:js/doctor-opnotes.min.js'),
            'doctor-prescriptions.js' => m_asset('evaluation:js/doctor-prescriptions.min.js'),
            'doctor-visit-date.js' => m_asset('evaluation:js/doctor-set-visit-date.min.js'),
            'nurse-vitals.js' => m_asset('evaluation:js/nurse-vitals.min.js'),
            //'order-investigation.js' => m_asset('evaluation:js/doctor-treatment.min.js'),
            'nurse_eye_preliminary.js' => m_asset('evaluation:js/nurse_eye_preliminary.min.js'),
        ];
        foreach ($assets as $key => $asset) {
            $this->assetManager->addAssets([$key => $asset]);
            $this->assetPipeline->requireJs($key);
        }
    }

}
