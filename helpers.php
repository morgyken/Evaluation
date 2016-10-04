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
use Ignite\Evaluation\Entities\DoctorNotes;
use Ignite\Evaluation\Entities\EyeExam;
use Ignite\Evaluation\Entities\Investigations;
use Ignite\Evaluation\Entities\OpNotes;
use Ignite\Evaluation\Entities\Procedures;
use Ignite\Evaluation\Entities\Treatment;
use Ignite\Evaluation\Entities\VisitMeta;
use Ignite\Evaluation\Entities\Visits;
use Ignite\Evaluation\Entities\Vitals;
use Ignite\Reception\Entities\Appointments;
use Ignite\Reception\Entities\PatientDocuments;

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
if (!function_exists('get_procedures_for')) {

    /**
     * @param string $name
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    function get_procedures_for($name) {
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
        return Procedures::whereHas('categories', function ($query) use ($to_fetch) {
                    $query->where('applies_to', $to_fetch);
                })->get();
    }

}
if (!function_exists('get_vitals')) {

    /**
     *
     * @todo Move this declaration from here. Either use view creator or move to model repository
     * @param $id
     * @return \Illuminate\Database\Eloquent\Model|null|static
     */
    function get_vitals($id) {
        return Vitals::whereHas('visits', function ($query) use ($id) {
                    return $query->where('patient', $id);
                })->first();
    }

}
if (!function_exists('get_diagnosis_code')) {

    /**
     * @param string|null $regex
     * @return array Diagnosis codes
     */
    function get_diagnosis_codes($regex = null) {
        if (!empty($regex)) {
            return DiagnosisCodes::where('name', 'like', "%$regex%")
                            ->get()->pluck('id', 'name')->toArray();
        }
        return DiagnosisCodes::all()->pluck('name')->toArray();
    }

}
if (!function_exists('vitals_for_visit')) {

    /**
     * @param $visit_id
     * @return \Illuminate\Database\Eloquent\Model
     */
    function vitals_for_visit($visit_id) {
        return Vitals::firstOrNew(['visit' => $visit_id]);
    }

}
if (!function_exists('patient_visits')) {

    /**
     * @param $patient_id
     * @return array|\Illuminate\Database\Eloquent\Collection|static[]
     */
    function patient_visits($patient_id) {
        return Visits::wherePatient($patient_id)->get();
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
     * @return mixed
     */
    function get_patient_doctor_notes($visit) {
        return DoctorNotes::firstOrNew(['visit' => $visit]);
    }

}
if (!function_exists('get_eye_exams')) {

    /**
     * Get eye examination data
     * @param $visit
     * @return mixed
     */
    function get_eye_exams($visit) {
        return EyeExam::firstOrNew(['visit' => $visit]);
    }

}
if (!function_exists('get_visit_meta')) {

    /**
     * Get visit meta
     * @param $visit
     * @return \Illuminate\Database\Eloquent\Model
     */
    function get_visit_meta($visit) {
        return VisitMeta::firstOrNew(['visit' => $visit]);
    }

}
if (!function_exists('get_investigations')) {

    /**
     * Get investigations
     * @param $visit
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    function get_investigations($visit) {
        return Investigations::where(['visit' => $visit])->get();
    }

}
if (!function_exists('get_treatments')) {

    /**
     * Get patient treatment for visit
     * @param $visit
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    function get_treatments($visit) {
        return Treatment::where(['visit' => $visit])->get();
    }

}
if (!function_exists('get_op_notes')) {

    /**
     * Get Op Notes for visit
     * @param $visit
     * @return $this
     */
    function get_op_notes($visit) {
        return OpNotes::firstOrNew(['visit' => $visit]);
    }

}

if (!function_exists('get_visit_data')) {

    /**
     * Get a subset of visit data
     * @param $visit
     * @param $section
     * @return mixed
     */
    function get_visit_data($visit, $section) {
        switch ($section) {
            case 'treatment':
                return get_treatments($visit);
            case 'investigation':
                return get_investigations($visit);
            case 'meta':
                return get_visit_meta($visit);
            case 'eye':
                return get_eye_exams($visit);
            case 'vital':
                return vitals_for_visit($visit);
            case 'op_notes':
                return get_op_notes($visit);
        }
        flash('Could not find subset data for ' . $section, 'warning');
        return null;
    }

}