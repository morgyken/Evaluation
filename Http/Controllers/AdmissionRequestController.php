<?php

namespace Ignite\Evaluation\Http\Controllers;

use Ignite\Core\Http\Controllers\AdminBaseController;

use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Ignite\Evaluation\Repositories\VisitRepository;
use Ignite\Inpatient\Repositories\AdmissionTypeRepository;
use Ignite\Evaluation\Repositories\AdmissionRequestRepository;

use Auth;


class AdmissionRequestController extends AdminBaseController
{

    protected $admissionRequestRepository, $admissionTypeRepository, $visitRepository;

    /*
    * Inject the various dependencies that will be required
    */
    public function __construct(VisitRepository $visitRepository,
                                AdmissionTypeRepository $admissionTypeRepository,
                                AdmissionRequestRepository $admissionRequestRepository)
    {
        parent::__construct();

        $this->visitRepository = $visitRepository;

        $this->admissionTypeRepository = $admissionTypeRepository;

        $this->admissionRequestRepository = $admissionRequestRepository;
        $this->_require_assets();
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $this->admissionRequestRepository->getAdmissionRequests();
        // return view('evaluation::index');
    }

    private function _require_assets()
    {
        $assets = [
            'doctor-investigations.js' => m_asset('evaluation:js/doctor-investigations.js'),
            'doctor-treatment.js' => m_asset('evaluation:js/doctor-treatment.js'),
            'doctor-next-steps.js' => m_asset('evaluation:js/doctor-next-steps.min.js'),
            'doctor-notes.js' => m_asset('evaluation:js/doctor-notes.js'),
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

    /*
     * Show the form for creating a new resource.
     */
    public function create($visit, $section)
    {
        $visit = $this->visitRepository->findById($visit);

        $admissionTypes = $this->admissionTypeRepository->all();

        $viewData = compact('visit', 'admissionTypes');

        return view("evaluation::patient_$section", ['data' => $viewData]);
    }

    /*
     *  Store admission requests and approvals
     */
    public function store()
    {
        $admissionRequest = $this->admissionRequestRepository->create(request()->all());

        return $admissionRequest ? redirect()->back()->with('success', 'Admission request sent!') :
            redirect()->back()->with('error', 'Something Went Wrong ');
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('evaluation::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('evaluation::edit');
    }

    /*
     * Update the specified resource in storage.
     */
    public function update()
    {
        $id = request()->get('admission_request_id');

        if (request()->has('authorized')) {
            $details = [
                'authorized_by' => Auth::id(),
                'authorized' => request()->get('authorized'),
            ];
        }

        $admissionRequest = $this->admissionRequestRepository->update($id, $details);

        return $admissionRequest ? redirect()->back()->with('success', 'Process completed successfully!') :
            redirect()->back()->with('error', 'Something Went Wrong ');
    }

    /*
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
    }
}
