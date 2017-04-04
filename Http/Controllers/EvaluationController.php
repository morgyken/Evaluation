<?php

namespace Ignite\Evaluation\Http\Controllers;

use Ignite\Core\Http\Controllers\AdminBaseController;
use Ignite\Evaluation\Entities\Prescriptions;
use Ignite\Evaluation\Entities\Visit;
use Ignite\Evaluation\Entities\VisitDestinations;
use Ignite\Evaluation\Repositories\EvaluationRepository;
use Ignite\Reception\Entities\Patients;
use Ignite\Evaluation\Entities\DoctorNotes;
use Ignite\Evaluation\Entities\DiagnosisCodes;
use Ignite\Evaluation\Entities\Procedures;
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

    public function queues($department) {
        $this->data['all'] = Visit::checkedAt($department)
                ->oldest()
                ->get();

        $this->data['department'] = ucwords($department);
        $user = \Auth::user()->id;
        if ($department == 'doctor') {
            $this->data['doc'] = 1;
        }
        $this->data['myq'] = VisitDestinations::whereDestination($user)
                ->whereCheckout(0)
                ->oldest()
                ->get();
        return view('evaluation::queues', ['data' => $this->data]);
    }

    public function preview($visit, $department) {
        $this->data['visit'] = Visit::find($visit);
        $this->data['patient'] = $this->data['visit']->patients;
        $this->data['department'] = $department;
        $this->data['history'] = Visit::wherePatient($this->data['patient']->id)->where('id', '<>', $visit)->get();
        return view('evaluation::preview', ['data' => $this->data]);
    }

    public function evaluate($visit, $section) {
        try {
            $this->data['all'] = Visit::checkedAt('diagnostics')->get();
            $this->data['visit'] = Visit::find($visit);
            $this->data['section'] = $section;
            $this->data['nursing_procedures'] = Procedures::whereCategory(6)->get();
            $this->data['drug_prescriptions'] = Prescriptions::whereVisit($visit)->get();
            $this->data['investigations'] = \Ignite\Evaluation\Entities\Investigations::whereVisit($visit)->get();
            return view("evaluation::patient_$section", ['data' => $this->data]);
        } catch (\Exception $ex) {
            flash('There was a problem evaluating the patient', 'error');
            return back();
        }
    }

    public function pharmacy($id) {
        $this->data['visit'] = $v = Visit::find($id);
        $this->data['patient'] = Patients::find($v->patient);
        $this->data['section'] = 'pharmacy';
        $this->data['drug_prescriptions'] = Prescriptions::whereVisit($id)->get();
        return view('evaluation::patient_pharmacy', ['data' => $this->data]);
    }

    public function pharmacy_prescription() {
        if ($this->evaluationRepository->save_prescriptions()) {
            flash('Prescription saved');
        } else {
            flash('Prescription could not be saved', 'warning');
        }
        return back();
    }

    public function pharmacy_dispense() {
        if ($this->evaluationRepository->dispense()) {
            flash('Drugs dispensed, thank you', 'success');
        } else {
            flash('Drug(s) could not be dispensed', 'warning');
        }
        return back();
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

        return redirect()->back();
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

    public function patient_visits($id) {
        $this->data['visits'] = Visit::wherePatient($id)->get();
        $this->data['patient'] = Patients::find($id);
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

    public function view_result($visit) {
        $this->data['visit'] = Visit::find($visit);
        $this->data['results'] = Visit::find($visit)->investigations->where('has_result', true);
        return view('evaluation::partials.doctor.results', ['data' => $this->data]);
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

    public function VerifyLabResult(Request $request) {
        try {
            $this->updateResultStatus($request, 1, 'Verification');
            flash('Result status has been updated... thank you', 'success');
            return back();
        } catch (\Exception $e) {
            flash('Result status could not be updated... please try again', 'danger');
            return back();
        }
    }

    public function PublishLabResult(Request $request) {
        try {
            $this->updateResultStatus($request, 2, 'Publication');
            flash('Result status has been updated... thank you', 'success');
            return back();
        } catch (\Exception $e) {
            flash('Result status could not be updated... please try again', 'danger');
            return back();
        }
    }

    public function SendLabResult(Request $request) {
        try {
            $this->updateResultStatus($request, 3, 'Sent');
            flash('Test Result has been marked as sent... thank you', 'success');
            return back();
        } catch (\Exception $e) {
            flash('Result could not be sent... please try again', 'danger');
            return back();
        }
    }

    public function RejectLabResult(Request $request) {
        try {
            $result = \Ignite\Evaluation\Entities\InvestigationResult::find($request->result);
            $result->delete(); //send back to test phase literally
            flash('Result status has been updated... thank you', 'success');
            return back();
        } catch (\Exception $exc) {
            flash('Result status could not be updated... please try again', 'danger');
            return back();
        }
    }

    public function updateResultStatus(Request $request, $flag, $type) {
        try {
            $result = \Ignite\Evaluation\Entities\InvestigationResult::find($request->result);
            $result->status = $flag;
            $result->save();

            $status_change = new \Ignite\Evaluation\Entities\LabResultStatusChange;
            $status_change->user = auth()->id();
            $status_change->result = $request->result;
            $status_change->result = $request->result;
            $status_change->type = $type;
            $status_change->reason = $request->reason ? $request->reason : '';
            $status_change->save();

            flash('Result status has been updated... thank you', 'success');
            return back();
        } catch (\Exception $exc) {
            flash('Result status could not be updated... please try again', 'danger');
            return back();
        }
    }

}
