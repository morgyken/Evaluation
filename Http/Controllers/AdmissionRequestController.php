<?php

namespace Ignite\Evaluation\Http\Controllers;

use Ignite\Core\Http\Controllers\AdminBaseController;

use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Ignite\Evaluation\Repositories\VisitRepository;
use Ignite\Inpatient\Repositories\AdmissionTypeRepository;
use Ignite\Evaluation\Repositories\AdmissionRequestRepository;


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

    /*
     * Show the form for creating a new resource.
     */
    public function create($visit, $section)
    {
        $visit = $this->visitRepository->findById($visit);

        $admissionTypes = $this->admissionTypeRepository->all();

        $viewData = compact('visit', 'admissionTypes');

        return view("evaluation::patient_$section", [ 'data' =>  $viewData ]);
    }

    /*
     *  Store admission requests and approvals
     */
    public function store()
    {   
        $admissionRequest = $this->admissionRequestRepository->create(request()->all());

        return $admissionRequest ?  redirect()->back()->with('success', 'Admission request sent!') : 
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
    }

    /*
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
    }
}
