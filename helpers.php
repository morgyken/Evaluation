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
use Ignite\Evaluation\Entities\ProcedureCategories;
use Ignite\Evaluation\Entities\Procedures;
use Ignite\Evaluation\Entities\VisitMeta;
use Ignite\Evaluation\Entities\Visit;
use Ignite\Evaluation\Entities\Vitals;
use Ignite\Reception\Entities\Appointments;
use Ignite\Reception\Entities\PatientDocuments;
use Ignite\Reception\Entities\Patients;
use Ignite\Settings\Entities\Clinics;

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
    function get_procedures_for($name, $term = null) {
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
                dd("Undefined section");
                break;
        }
        if (!empty($term)) {
            return Procedures::whereHas('categories', function ($query) use ($to_fetch) {
                        $query->where('applies_to', $to_fetch);
                    })->where('name', 'like', "%$term%")->get();
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
     * @deprecated Use repository
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
     * @param Visit $visit
     * @return \Illuminate\Database\Eloquent\Model
     * @internal param $id
     */
    function vitals_for_visit(Visit $visit) {
        return Vitals::firstOrNew(['visit' => $visit->id]);
    }

}
if (!function_exists('patient_visits')) {

    /**
     * @param $patient_id
     * @return array|\Illuminate\Database\Eloquent\Collection|static[]
     */
    function patient_visits($patient_id) {
        return Visit::wherePatient($patient_id)->get();
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
    function get_patient_doctor_notes(Visit $visit) {
        return DoctorNotes::firstOrNew(['visit' => $visit->id]);
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
    function get_visit_meta(Visit $visit) {
        return VisitMeta::firstOrNew(['visit' => $visit->id]);
    }

}
if (!function_exists('get_investigations')) {

    /**
     * Get investigations
     * @param $visit
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    function get_investigations(Visit $visit, $type = null) {
        if (empty($type)) {
            return Investigations::where(['visit' => $visit->id])->get();
        }
        return Investigations::where(['visit' => $visit->id])->whereIn('type', $type)->get();
    }

}
if (!function_exists('get_op_notes')) {

    /**
     * Get Op Notes for visit
     * @param $visit
     * @return $this
     */
    function get_op_notes(Visit $visit) {
        return OpNotes::firstOrNew(['visit' => $visit->id]);
    }

}

if (!function_exists('get_visit_data')) {

    /**
     * Get a subset of visit data
     * @param $visit
     * @param $section
     * @return mixed
     */
    function get_visit_data(Visit $visit, $section) {
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
if (!function_exists('get_product_categories')) {

    /**
     * @return \Illuminate\Support\Collection Procedure Collection
     */
    function get_procedure_categories() {
        return ProcedureCategories::all()->pluck('name', 'id');
    }

}
if (!function_exists('get_clinic_name')) {

    /**
     * Fetch the Clinic name given the ID
     * @param int $id
     * @return string
     */
    function get_clinic_name($id = null) {
        if (empty($id)) {
            $id = Cookie::get('clinic') || 1;
        }
        return Clinics::findOrNew($id)->name;
    }

}
if (!function_exists('get_procedures')) {

    /**
     * @return \Illuminate\Support\Collection
     */
    function get_procedures() {
        return Procedures::all()->pluck('name', 'id');
    }

}
if (!function_exists('generate_receipt_no')) {

    /**
     * Genearte a nice receipt number reference
     * @return string
     */
    function generate_receipt_no() {
        return m_setting('evaluation.receipt_prefix') . date('dmyHis');
    }

}

if (!function_exists('payment_label')) {

    /**
     * Helper to return fancy lable for payment status
     * @param bool $paid
     * @return string
     */
    function payment_label($paid = null) {
        $fanc = '';
        if ($paid) {
            $fanc = "<span class='label label-success'><i class='fa fa-check-circle-o'></i> Paid</span>";
        } else {
            $fanc = "<span class='label label-warning'><i class='fa fa-refresh fa-spin'></i> Pending</span>";
        }
        return $fanc;
    }

}
if (!function_exists('get_patients_with_bills')) {

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    function get_patients_with_bills() {
        return Patients::whereHas('visits', function ($query) {
                    $query->wherePaymentMode('cash');
                    $query->whereHas('investigations', function ($q3) {
                        // $q3->where('is_paid', false);
                    });
                })->get();
    }

}