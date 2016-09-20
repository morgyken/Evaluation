<?php

/*
 * =============================================================================
 *
 * Collabmed Solutions Ltd
 * Project: iClinic
 * Author: Samuel Okoth <sodhiambo@collabmed.com>
 *
 * =============================================================================
 */

use Ignite\Evaluation\Entities\DiagnosisCodes;
use Ignite\Evaluation\Entities\PatientDoctorNotes;
use Ignite\Evaluation\Entities\PatientVisits;
use Ignite\Evaluation\Entities\PatientVitals;
use Ignite\Reception\Entities\Appointments;
use Ignite\Reception\Entities\PatientDocuments;
use Ignite\Setup\Entities\Procedures;

if (!function_exists('get_patient_queue')) {

    /**
     * Get patients in active queue
     * @return mixed Collection
     * @deprecated Do not use this, revamped the visit model to new version
     */
    function get_patient_queue() {
        return Appointments::whereStatus(2)->get();
    }

}
if (!function_exists('get_diagnostics')) {

    /**
     * @return type
     */
    function get_diagnostics() {
        return Procedures::whereHas('category', function ($query) {
                    $query->where('applies_to', 7);
                })->get();
    }

}
if (!function_exists('get_laboratory')) {

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    function get_laboratory() {
        return Procedures::whereHas('category', function ($query) {
                    $query->where('applies_to', 3);
                })->get();
    }

}
if (!function_exists('get_treatments')) {

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    function get_treatments() {
        return Procedures::whereHas('category', function ($query) {
                    $query->where('applies_to', 1);
                })->get();
    }

}
if (!function_exists('get_procedures')) {

    /**
     * @param string $name
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    function get_procedures_for(string $name) {
        $to_fetch = 0;
        switch ($name) {
            case 'doctor':
                $to_fetch = 1;
                break;
            case 'laboratory':
                $to_fetch = 3;
                break;
            case 'diagnostics':
                $to_fetch = 7;
                break;
            default :
                break;
        }
        return Procedures::whereHas('category', function ($query) use ($to_fetch) {
                    $query->where('applies_to', $to_fetch);
                })->get();
    }

}
if (!function_exists('patient_vitals')) {

    /**
     *
     * @todo Move this declaration from here. Either use view creator or move to model repository
     * @param $id
     * @return \Illuminate\Database\Eloquent\Model|null|static
     */
    function patient_vitals($id) {
        return PatientVitals::whereHas('visits', function ($query) use ($id) {
                    return $query->where('patient', $id);
                })->first();
    }

}
if (!function_exists('get_diagnosis_code')) {

    /**
     * @param string|null $regex
     * @return array Diagnosis codes
     */
    function get_diagnosis_codes(string $regex = null) {
        if (!empty($regex)) {
            return DiagnosisCodes::where('name', 'like', "%$regex%")
                            ->get()->pluck('id', 'name')->toArray();
        }
        return DiagnosisCodes::all()->pluck('name')->toArray();
    }

}if (!function_exists('vitals_for_visit')) {

    /**
     * @param $visit_id
     * @return \Illuminate\Database\Eloquent\Model
     */
    function vitals_for_visit($visit_id) {
        return PatientVitals::firstOrNew(['visit' => $visit_id]);
    }

}if (!function_exists('patient_visits')) {

    /**
     * @param $patient_id
     * @return array|\Illuminate\Database\Eloquent\Collection|static[]
     */
    function patient_visits($patient_id) {
        return PatientVisits::wherePatient($patient_id)->get();
    }

}
if (!function_exists('get_patient_documents')) {

    /**
     * @param $patient_id
     * @return array|\Illuminate\Database\Eloquent\Collection|static[]
     */
    function get_patient_documents($patient_id) {
        return PatientDocuments::wherePatient($patient_id)->get();
    }

}
if (!function_exists('get_patient_doctor_notes')) {

    /**
     * @param $visit
     * @return \Illuminate\Database\Eloquent\Model|mixed|null|static
     */
    function get_patient_doctor_notes($visit) {
        return PatientDoctorNotes::whereVisit($visit)->first();
    }

}