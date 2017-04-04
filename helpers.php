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
use Illuminate\Http\Request;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\SimpleType\Jc;

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
            case 'nurse':
                $to_fetch = 5;
                break;
            case 'radiology':
                $to_fetch = 4;
                break;
            case 'physio':
                $to_fetch = 9;
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
        return Visit::query()->where('patient', '=', $patient_id)->get();
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
     * @return $param
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
            $fanc = "<span class='text-success'><i class='fa fa-check-circle-o'></i> Paid</span>";
        } else {
            $fanc = "<span class='text-warning'><i class='fa fa-refresh fa-spin'></i> Pending</span>";
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
                                $q3->doesntHave('payments');
                            });
                            $query->orWhereHas('dispensing', function ($q) {
                                $q->wherePayment_status(0);
                            });
                        })
                        ->orderBy('created_at', 'desc')
                        ->get();
    }

}

if (!function_exists('get_patients_with_drugs')) {

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    function get_patients_with_drugs() {
        return Patients::whereHas('visits', function ($query) {
                    $query->wherePaymentMode('cash');
                    $query->whereHas('dispensing', function ($q) {
                        $q->wherePayment_status(0);
                    });
                })->get();
    }

}


if (!function_exists('get_patients_with_pharm')) {

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    function get_patients_with_pharm() {
        return Patients::whereHas('visits', function ($query) {
                    $query->wherePaymentMode('cash');
                    $query->whereHas('dispensing', function ($q) {
                        $q->wherePayment_status(0);
                    });
                })->get();
    }

}

if (!function_exists('get_patients_from_pos')) {

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    function get_patients_from_pos() {
        return Patients::whereHas('drug_purchases', function ($query) {
                    $query->wherePaid(0);
                })->get();
    }

}

if (!function_exists('visit_destination')) {

    /**
     * Build for the visit destination
     * @param Visit $visit
     * @return string
     */
    function visit_destination(Visit $visit) {
        $build = [];
        if (!empty($visit->destination) and $visit->evaluation) {
            $build[] = 'Doctor: ' . $visit->doctors->profile->full_name;
        }
        if ($visit->nurse) {
            $build[] = 'Nurse';
        }
        if ($visit->theatre) {
            $build[] = 'Theatre';
        }
        if ($visit->diagnostics) {
            $build[] = 'Diagnostics';
        }
        if ($visit->laboratory) {
            $build[] = 'Laboratory';
        }
        if ($visit->radiology) {
            $build[] = 'Radiology';
        }
        if ($visit->pharmacy) {
            $build[] = 'Pharmacy';
        }
        if ($visit->pharmacy) {
            $build[] = 'Physiotherapy';
        }
        return $build;
    }

}


if (!function_exists('exportSickOff')) {

    /**
     * @param Request $request
     * @param int $patient
     * @return mixed
     */
    function exportSickOff(Request $request, $patient) {
        $defaultFont = ['name' => 'Times New Roman', 'size' => 12];
        $date = (new Date())->format('j/m/Y');
        $runtext = "The above named was attended at our clinic and diagnosed to have a medical/ surgically condition. Please allow sickoff for a period of ";
        $phpWord = new PhpWord();
        $section = $phpWord->addSection();
        //headers
        $header = $section->addHeader();
        $header->firstPage();
        $table = $header->addTable();
        $table->addRow();
        $cell = $table->addCell(4500);
        $textrun = $cell->addTextRun();
        $textrun->addText(htmlspecialchars(config('practice.name'), ENT_COMPAT, 'UTF-8'), ['name' => 'Times New Roman', 'size' => 18, 'bold' => true]);
        $table->addRow();
        $cell2 = $table->addCell(4500);
        $location = $cell2->addTextRun();
        $location->addText('P.O BOX ' . config('practice.address') . '  ' . config('practice.town') . ' Mobile: ' . config('practice.mobile'), $defaultFont);
        // $table->addCell(4500)->addImage('img/logo.png', array('width' => 100, 'height' => 80, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::END));
        $header->addLine(['weight' => 1, 'width' => 400, 'height' => 0, 'color' => 635552]);


        // Adding Text element with font customized inline...
        $story = $section->addTextRun();
        $story->addText(htmlspecialchars('Name:    '), ['bold' => true]);
        $story->addText($patient->full_name);
        $story->addText(htmlspecialchars('             Date:   '), ['bold' => true, 'alignment' => Jc::END]);
        $story->addText($date);
        $part = $section->addTextRun();
        $part->addText(htmlspecialchars($runtext), $defaultFont);
        $part->addText(htmlspecialchars($request->period . '.'), ['underline' => true, 'bold' => true]);
        $review = $section->addTextRun();
        $review->addText(htmlspecialchars("Review on"));
        //   $review_on = (new Date($request->review_on))->format('j/m/Y');
        $review->addText(htmlspecialchars(" $request->review_on"), ['underline' => true, 'bold' => true]);
        $section->addText(htmlspecialchars(auth()->user()->profile->full_name));
        $section->addText(htmlspecialchars("For " . config('practice.name')));

        // Saving the document as OOXML file...
        return IOFactory::createWriter($phpWord, 'Word2007');
    }

    function exportPatientNotes($patient, $visit) {
        $history = patient_visits($patient->id);
        $vst = Visit::find($visit);
        if (empty($vst)) {
            return redirect()->back();
        }

        $patient = Patients::find($vst->patient);

        $defaultFont = ['name' => 'Times New Roman', 'size' => 12];
        $date = (new Date())->format('j/m/Y');
        $runtext = "";
        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $section1 = $phpWord->addSection();
        //headers
        $header = $section1->addHeader();
        $header->firstPage();
        $table = $header->addTable();
        $table->addRow();
        $cell = $table->addCell(4500);
        $textrun = $cell->addTextRun();
        $textrun->addText(htmlspecialchars(config('practice.name'), ENT_COMPAT, 'UTF-8'), ['name' => 'Times New Roman', 'size' => 18, 'bold' => true]);
        $table->addRow();
        $cell2 = $table->addCell(4500);
        $location = $cell2->addTextRun();
        $location->addText('P.O BOX ' . config('practice.address') . '  ' . config('practice.town') . ' Mobile: ' . config('practice.mobile'), $defaultFont);
        // $table->addCell(4500)->addImage('img/logo.png', array('width' => 100, 'height' => 80, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::END));
        $header->addLine(['weight' => 1, 'width' => 400, 'height' => 0, 'color' => 635552]);

        // Adding Text element with font customized inline...
        $story = $section1->addTextRun();
        $story->addText(htmlspecialchars('Name: '), ['bold' => true]);
        $story->addText($patient->full_name);
        $story->addText(htmlspecialchars('Date: '), ['bold' => true, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::END]);
        $story->addText($date);

        foreach ($history as $v) {
            $section = $phpWord->addSection();
            $section->addText('Date:', ['bold' => true]);
            $date = (new Date($v->created_at))->format('j/m/Y');
            $section->addText($date);

            $section->addText(htmlspecialchars('Doctor\'s Notes', ENT_COMPAT, 'UTF-8'), ['name' => 'Times New Roman', 'size' => 16, 'bold' => true]);
            if (!empty($v->notes)) {
                $section->addText(htmlspecialchars('Presenting Complaints'), ['bold' => true]);
                $section->addText($v->notes->presenting_complaints);
                $section->addText(htmlspecialchars('Past Medical History'), ['bold' => true]);
                $section->addText($v->notes->past_medical_history);
                $section->addText(htmlspecialchars('Examination'), ['bold' => true]);
                $section->addText($v->notes->examination);
                //$section->addText(htmlspecialchars('Diagnosis'), ['bold' => true]);
                //$section->addText(implode(', ', unserialize($v->notes->diagnosis)));
                $section->addText(htmlspecialchars('Treatment Plan'), ['bold' => true]);
                $section->addText($v->notes->treatment_plan);
            } else {
                $section->addText("No records to show");
            }


            $section->addText(htmlspecialchars('Treatment', ENT_COMPAT, 'UTF-8'), ['name' => 'Times New Roman', 'size' => 16, 'bold' => true]);
            $table = $section->addTable();
            $table->addRow();
            $c = $table->addCell(900);
            $c->addText('#');
            $c = $table->addCell(2000);
            $c->addText('Procedure');
            $c = $table->addCell(2000);
            $c->addText('Cost');
            $c = $table->addCell(2000);
            $c->addText('NO');
            $c = $table->addCell(2000);
            $c->addText('Payment');
            $n = 0;

            if (isset($vst->treatments)) {
                foreach ($vst->treatments as $item) {
                    $table->addRow();
                    $c = $table->addCell(900);
                    $c->addText($n+=1);
                    $c = $table->addCell(2000);
                    $c->addText(empty($item->procedures) ? '-' : str_limit($item->procedures->name, 20, '...'));
                    $c = $table->addCell(2000);
                    $c->addText($item->price);
                    $c = $table->addCell(2000);
                    $c->addText($item->no_performed);
                    $c = $table->addCell(2000);
                    $c->addText($item->is_paid ? 'Paid' : 'Not Paid');
                }
            }

            $section->addText(htmlspecialchars('OP Notes', ENT_COMPAT, 'UTF-8'), ['name' => 'Times New Roman', 'size' => 16, 'bold' => true]);
            if (isset($v->opnotes)) {
                $section->addText(htmlspecialchars('Surgery Indications'), ['bold' => true]);
                $section->addText($v->opnotes->surgery_indication);
                $section->addText(htmlspecialchars('Implants'), ['bold' => true]);
                $section->addText($v->opnotes->implants);
                $section->addText(htmlspecialchars('Post OP'), ['bold' => true]);
                $section->addText($v->opnotes->postop);
                $section->addText(htmlspecialchars('Indication + procedure'), ['bold' => true]);
                $section->addText($v->opnotes->indication);
            } else {
                $section->addText("No records to show");
            }
        }
// Saving the document as OOXML file...
        return \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
    }

    function exportPatientNotesDate($patient, $visit) {
        $history = patient_visits($patient);
        $v = Visit::find($visit);
        if (empty($v)) {
            return redirect()->back();
        }

        $patient = Patients::find($v->patient);

        $defaultFont = ['name' => 'Times New Roman', 'size' => 12];
        $date = (new Date())->format('j/m/Y');
        $runtext = "";
        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $section1 = $phpWord->addSection();
        //headers
        $header = $section1->addHeader();
        $header->firstPage();
        $table = $header->addTable();
        $table->addRow();
        $cell = $table->addCell(4500);
        $textrun = $cell->addTextRun();
        $textrun->addText(htmlspecialchars(config('practice.name'), ENT_COMPAT, 'UTF-8'), ['name' => 'Times New Roman', 'size' => 18, 'bold' => true]);
        $table->addRow();
        $cell2 = $table->addCell(4500);
        $location = $cell2->addTextRun();
        $location->addText('P.O BOX ' . config('practice.address') . '  ' . config('practice.town') . ' Mobile: ' . config('practice.mobile'), $defaultFont);
        // $table->addCell(4500)->addImage('img/logo.png', array('width' => 100, 'height' => 80, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::END));
        $header->addLine(['weight' => 1, 'width' => 400, 'height' => 0, 'color' => 635552]);

        // Adding Text element with font customized inline...
        $story = $section1->addTextRun();
        $story->addText(htmlspecialchars('Name: '), ['bold' => true]);
        $story->addText($patient->full_name);
        $story->addText(htmlspecialchars('Date: '), ['bold' => true, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::END]);
        $story->addText($date);

        // foreach ($history as $v) {
        $section = $phpWord->addSection();
        $section->addText('Date:', ['bold' => true]);
        $date = (new Date($v->created_at))->format('j/m/Y');
        $section->addText($date);

        $section->addText(htmlspecialchars('Doctor\'s Notes', ENT_COMPAT, 'UTF-8'), ['name' => 'Times New Roman', 'size' => 16, 'bold' => true]);
        if (!empty($v->notes)) {
            $section->addText(htmlspecialchars('Presenting Complaints'), ['bold' => true]);
            $section->addText($v->notes->presenting_complaints);
            $section->addText(htmlspecialchars('Past Medical History'), ['bold' => true]);
            $section->addText($v->notes->past_medical_history);
            $section->addText(htmlspecialchars('Examination'), ['bold' => true]);
            $section->addText($v->notes->examination);
            $section->addText(htmlspecialchars('Diagnosis'), ['bold' => true]);
            $section->addText(implode(', ', unserialize($v->notes->diagnosis)));
            $section->addText(htmlspecialchars('Treatment Plan'), ['bold' => true]);
            $section->addText($v->notes->treatment_plan);
        } else {
            $section->addText("No records to show");
        }

        $section->addText(htmlspecialchars('Treatment', ENT_COMPAT, 'UTF-8'), ['name' => 'Times New Roman', 'size' => 16, 'bold' => true]);
        $table = $section->addTable();
        $table->addRow();
        $c = $table->addCell(900);
        $c->addText('#');
        $c = $table->addCell(2000);
        $c->addText('Procedure');
        $c = $table->addCell(2000);
        $c->addText('Cost');
        $c = $table->addCell(2000);
        $c->addText('NO');
        $c = $table->addCell(2000);
        $c->addText('Payment');
        $n = 0;
        if (isset($v->treatments)) {
            foreach ($v->treatments as $item) {
                $table->addRow();
                $c = $table->addCell(900);
                $c->addText($n+=1);
                $c = $table->addCell(2000);
                $c->addText(empty($item->procedures) ? '-' : str_limit($item->procedures->name, 20, '...'));
                $c = $table->addCell(2000);
                $c->addText($item->price);
                $c = $table->addCell(2000);
                $c->addText($item->no_performed);
                $c = $table->addCell(2000);
                $c->addText($item->is_paid ? 'Paid' : 'Not Paid');
            }
        }

        $section->addText(htmlspecialchars('OP Notes', ENT_COMPAT, 'UTF-8'), ['name' => 'Times New Roman', 'size' => 16, 'bold' => true]);
        if (isset($v->opnotes)) {
            $section->addText(htmlspecialchars('Surgery Indications'), ['bold' => true]);
            $section->addText($v->opnotes->surgery_indication);
            $section->addText(htmlspecialchars('Implants'), ['bold' => true]);
            $section->addText($v->opnotes->implants);
            $section->addText(htmlspecialchars('Post OP'), ['bold' => true]);
            $section->addText($v->opnotes->postop);
            $section->addText(htmlspecialchars('Indication + procedure'), ['bold' => true]);
            $section->addText($v->opnotes->indication);
        } else {
            $section->addText("No records to show");
        }
        //  }
// Saving the document as OOXML file...
        return \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
    }

    function paymentFor($procedures) {
        $stat = unserialize($procedures);
        $build = collect();
        foreach ($stat as $key => $procedure) {
            $samd = Investigations::where('visit', $procedure['visit'])->where('procedure', $procedure['procedure']);
            $build->prepend($samd->first());
        }
        return $build;
    }

    if (!function_exists('get_min_range')) {

        /**
         * Get Minimum lab range depending on patient age
         * @param $procedure, $age_days, $age_years
         * @return $range
         */
        function get_min_range($p, $age_days, $age_years) {
            try {
                if ($age_days < 4) {
                    return $p->this_test->_0_3d_minrange;
                } elseif ($age_days >= 4 && $age_days <= 30) {
                    return $p->this_test->_4_30d_minrange;
                } elseif ($age_days > 30 && $age_days <= 730) {
                    return $p->this_test->_1_24m_minrange;
                } elseif ($age_days > 730 && $age_days <= 1825) {
                    return $p->this_test->_25_60m_minrange;
                } else {
                    if ($age_years > 4 && $age_years <= 19) {
                        return $p->this_test->_5_19y_minrange;
                    } else {
                        return $p->this_test->adult_minrange;
                    }
                }
            } catch (\Exception $e) {

            }
        }

    }

    if (!function_exists('get_max_range')) {

        /**
         * Get Maximum lab range depending on patient age
         * @param $procedure, $age_days, $age_years
         * @return $range
         */
        function get_max_range($p, $age_days, $age_years) {
            $max_range = null;
            try {
                if ($age_days < 4) {
                    $max_range = $p->this_test->_0_3d_maxrange;
                } elseif ($age_days >= 4 && $age_days <= 30) {
                    $max_range = $p->this_test->_4_30d_maxrange;
                } elseif ($age_days > 30 && $age_days <= 730) {
                    $max_range = $p->this_test->_1_24m_maxrange;
                } elseif ($age_days > 730 && $age_days <= 1825) {
                    $max_range = $p->this_test->_25_60m_maxrange;
                } else {
                    if ($age_years > 4 && $age_years <= 19) {
                        $max_range = $p->this_test->_5_19y_maxrange;
                    } else {
                        $max_range = $p->this_test->adult_maxrange;
                    }
                }
                return $max_range;
            } catch (\Exception $e) {
                return $p->this_test->lab_max_range;
            }
        }

    }

    if (!function_exists('getUnit')) {

        /**
         * Get Lab test unit
         * @param $procedure/test
         * @return $unit
         */
        function getUnit($p) {
            $unit_str = $p->this_test->result_type_details;
            preg_match("/\(([^\)]*)\)/", $unit_str, $matches);
            if ($matches) {
                $unit = $matches[1];
            }
            if (strpos($p->name, '%')) {
                return '%';
            } elseif ($matches) {
                return html_entity_decode($unit);
            } else {
                return $p->this_test->units;
            }
        }

    }


    if (!function_exists('getFlag')) {

        /**
         * Get Appropriate flag for lab result
         * @param $result, $min_range, $max_range
         * @return $flag
         */
        function getFlag($r, $min_range, $max_range) {
            if ($r < $min_range) {
                return "<span style = 'color: red;'> L</span>";
            } elseif ($r > $max_range) {
                return "<span style = 'color: red;'> H</span>";
            } else
                return "N";
        }

    }
}