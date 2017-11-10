<?php

namespace Ignite\Evaluation\Repositories;

use Ignite\Inpatient\Entities\RequestAdmission;

use Carbon\Carbon;

class AdmissionRequestRepository
{
    protected $admissionRequest;

    /*
    * Gets an admission request by id
    */
    public function find($id)
    {
        return RequestAdmission::find($id);
    }

    /*
    * Create an admission request for view by the cashier
    * Sets the default admitted type to false
    */
    public function create($fields)
    {
        $fields['admitted'] = false;

        return RequestAdmission::create($fields);
    }

    /*
    * Return the admission requests that have been made by the doctors
    */
    public function getAdmissionRequests()
    {
        $admissionRequests = RequestAdmission::orderBy('created_at', 'ASC')->get();

        return $admissionRequests->map(function($request){

            return [
                'id' => $request->id,

                'reason' => $request->reason,

                'due' => $this->due($request),

                'admit' => $this->admit($request),

                'created_at' => Carbon::parse($request->created_at)->toFormattedDateString(),

                'patient' => $this->patient($request->patient),

                'type' => $this->admissionType($request->admissionType)
            ];

        });
    }

    /*
    * Tranforms the patient within an admission request into a more json encodedable array
    */
    public function patient($patient)
    {
        return [
            'id' => $patient->id,
            'name' => $patient->fullName,
            'visit' => $patient->visit_id,
            'account' => $this->patientAccount($patient->account),
            'schemes' => $this->patientSchemes($patient->schemes),
            'admitted' => $this->admitted($patient->admission)
        ];
    }

    /*
    * Returns true if a patient has been admitted and false otherwise
    */
    public function admitted($patientAdmission)
    {
        return $patientAdmission and is_null($patientAdmission->deleted_at);
    }

    /*
    * Transform the patient account
    */
    public function patientAccount($account)
    {
        $accounts['balance'] = $account ? $account->balance : 0;

        return $accounts;
    }

    /*
    * Transform the details of the patient schemes
    */
    public function patientSchemes($schemes)
    {
        if($schemes)
        {

        }

        return [];
    }

    /*
    * Tranforms the amdission type within an admission request into a more json encodedable array
    */
    public function admissionType($type)
    {
        return [
            'name' => $type->name,
            'deposit' => $type->deposit,
            'description' => $type->description
        ];
    }

    /*
    * Add the amount due before the patient can receive any form of treatment
    */
    public function due($request)
    {
        $deposit = $request->admissionType->deposit;

        $balance = $request->patient->account ? $request->patient->account->balance : 0;

        return ($deposit - $balance) < 0 ? 0 : ($deposit - $balance);
    }

    /*
    * Determine if a request is good enough for admittance
    */
    public function admit()
    {
        return false;
    }

}