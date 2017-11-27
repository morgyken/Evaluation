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
use Ignite\Evaluation\Entities\InvestigationResult;
use Ignite\Evaluation\Entities\OpNotes;
use Ignite\Evaluation\Entities\ProcedureCategories;
use Ignite\Evaluation\Entities\Procedures;
use Ignite\Evaluation\Entities\VisitMeta;
use Ignite\Evaluation\Entities\Visit;
use Ignite\Evaluation\Entities\Vitals;
use Ignite\Inventory\Entities\InventoryProducts;
use Ignite\Reception\Entities\Appointments;
use Ignite\Reception\Entities\PatientDocuments;
use Ignite\Reception\Entities\Patients;
use Ignite\Settings\Entities\Clinics;
use Ignite\Settings\Entities\InsuranceSchemePricing;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\SimpleType\Jc;
use Ignite\Evaluation\Entities\ProcedureCategoryTemplates;
use Ignite\Evaluation\Entities\ProcedureTemplates;
use Ignite\Evaluation\Entities\TemplateLab;
use Ignite\Evaluation\Entities\ReferenceRange;

if (!function_exists('get_patient_queue')) {
    /**
     * @param Visit $visit
     * @return string
     */
    function translate_destination(Visit $visit)
    {
        $link = [];
        foreach ($visit->destinations as $dest) {
            $_l = route('evaluation.evaluate', [$visit->id, strtolower($dest->department)]);
            $link[] = '<a href="' . $_l . '" target="_blank">' . $dest->department . '</a>';
        }
        return implode(' ', $link);
    }
}
if (!function_exists('get_patient_queue')) {

    /**
     * Get patients in active queue
     * @return mixed Collection
     * @deprecated Do not use this, revamped the visit model to new version
     */
    function get_patient_queue()
    {
        return Appointments::whereStatus(2)->get();
    }

}

if (!function_exists('get_procedures_for')) {
    /**
     * @param string $name
     * @param string|null $term
     * @return \Illuminate\Database\Eloquent\Collection
     */
    function get_procedures_for($name, $term = null)
    {
        if (!empty($term)) {
            return __get_procedures_for($name, $term);
        }
//        return __get_procedures_for($name)->get();
        $minutes = 1440;
        return Cache::remember('get_procedures_for_' . $name, $minutes, function () use ($name) {
            return __get_procedures_for($name)->get();
        });
    }
}

if (!function_exists('__get_procedures_for')) {

    /**
     * @param string $name
     * @param string|null $term
     * @return $this|Builder|\Illuminate\Database\Eloquent\Collection|static|static[]
     */
    function __get_procedures_for($name, $term = null)
    {
        switch ($name) {
            case 'doctor':
                $to_fetch = 1;
                break;
            case 'lab';
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
            case 'ultrasound':
                $to_fetch = 6;
                break;
            case 'dental':
                $to_fetch = 10;
                break;
            case 'optical':
                $to_fetch = 11;
                break;
            case 'inpatient':
                $to_fetch = 10;
                break;
            default:
                $to_fetch = 'all';
                break;
        }
        if (!empty($term)) {
            if ($to_fetch === 'all') {
                return Procedures::where('name', 'like', "%$term%")->get();
            }
            return Procedures::whereHas('categories', function ($query) use ($to_fetch) {
                $query->where('applies_to', $to_fetch);
            })->where('name', 'like', "%$term%")->get();
        }
        if ($to_fetch === 3) {
            $use_new = (bool)m_setting('evaluation.enable_templates');
            if ($use_new) {
                return Procedures::whereHas('categories', function (Builder $query) use ($to_fetch) {
                    $query->where('applies_to', $to_fetch);
                })->whereDoesntHave('this_test', function (Builder $query) {
                    $query->where('lab_ordered_independently', 0);
                    $query->whereNull('lab_ordered_independently');
                })->where('name', 'NOT LIKE', 'LAB%');
            }
        }
        return Procedures::whereHas('categories', function (Builder $query) use ($to_fetch) {
            $query->where('applies_to', $to_fetch);
        });
    }

}
if (!function_exists('get_procedures_in')) {

    /**
     * @param string $name
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    function get_procedures_in($name, $term = null)
    {
        if (!empty($term)) {
            return Procedures::whereHas('categories', function (Builder $query) use ($name) {
                $query->where('name', $name);
            })->where('name', 'like', "%$term%")->get();
        }
        return Procedures::whereHas('categories', function (Builder $query) use ($name) {
            $query->where('name', $name);
        })->get();
    }

}
if (!function_exists('reload_payments')) {
    /**
     * @return mixed
     */
    function reload_payments()
    {
        return \Artisan::queue('finance:prepare-payments');
    }
}
if (!function_exists('get_price_procedure')) {

    function get_price_procedure(Visit $_v, Procedures $procedure)
    {
        if ($_v->scheme) {
            $c_price = InsuranceSchemePricing::whereSchemeId($_v->scheme)
                ->whereProcedureId($procedure->id)
                ->first();
            $c_price = $c_price->amount ?? $procedure->insurance_charge;
        }
        if (!empty($c_price)) {
            $price = $c_price;
        } else {
            $price = $procedure->price;
        }
        return $price;
    }
}
if (!function_exists('get_price_drug')) {

    function get_price_drug(Visit $_v, InventoryProducts $product)
    {
        if ($_v->scheme) {
//            $c_price = InsuranceSchemePricing::whereSchemeId($_v->scheme)
//                ->whereProductId($product->id)
//                ->first();
            $c_price = null;
            $c_price = $c_price->amount ?? $product->insurance_p;
        }
        if (!empty($c_price)) {
            $price = $c_price;
        } else {
            $price = $product->cash_price;
        }
        return $price;
    }
}
if (!function_exists('get_all_procedures')) {

    /**
     * @param string $name
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    function get_all_procedures($term = null)
    {
        return Procedures::where('name', 'like', "%$term%")->get();
    }

}
if (!function_exists('get_external_patients')) {

    function get_external_patients($id)
    {
        $patients = Patients::where('external_institution', '=', $id)
            ->get();
        return $patients;
    }

}

if (!function_exists('getOrthanc')) {
    function getOrthanc($patient, $test)
    {
        $orthanc = new \Ignite\Evaluation\Library\Pacs($patient, $test);
        return $orthanc->processPacsServer();
    }
}
if (!function_exists('get_template')) {

    function get_template($procedure, $cat)
    {
        $p_template = ProcedureTemplates::where('procedure', '=', $procedure)
            ->get()
            ->first();
        if (isset($p_template->id)) {
            echo $p_template->template;
        } else {
            get_category_template($cat);
        }
    }

}

if (!function_exists('get_lab_template')) {

    function get_lab_template($id)
    {
        //$procedure = Procedures::find($id);
        $template = TemplateLab::whereProcedure($id)->get();
        if (!$template->isEmpty()) {
            return $template;
        }
    }

}
if (!function_exists('get_patient_procedures')) {
    /**
     * @param $visit_id
     * @param bool $investigations
     * @return array
     */
    function get_patient_procedures($visit_id, $investigations = false)
    {
        $visit = Visit::find($visit_id);
        /** @var Investigations[] $data */
        if (request()->has('type')) {
            $data = get_investigations($visit, [request('type')]);
        } elseif ($investigations) {
            $data = get_investigations($visit, ['diagnostics', 'laboratory', 'radiology']);
        } else {
            $data = get_investigations($visit, ['treatment', 'nursing']);
        }
        $return = [];
        $count = 0;
        $is_insurance = $visit->payment_mode === 'insurance';
        $post_bill_insurance = $is_insurance && (bool)m_setting('finance.post_pay_insurance');
        foreach ($data as $key => $item) {
            $type = $item->type;
            $_paid = ($item->is_paid || $item->invoiced);
            $_origin = \request()->user()->id == $item->user;
            $can_show = $_paid || $_origin || $post_bill_insurance;
            $link = '';
            if ($investigations) {
                if ($item->has_result)
                    $link = '<a href="' . route('evaluation.view_result', $item->visit) . '"
                                               class="btn btn-xs btn-success" target="_blank">
                                                <i class="fa fa-external-link"></i> View Result
            </a>';
                else {
                    $link = '<span class="text-warning" ><i class="fa fa-warning" ></i > Results Pending</span>';
                }
            }
            if (!$_paid) {
                $link .= ' <button id="sapi_del" type="button" to="' .
                    route('api.evaluation.delete_diagnosis', $item->id)
                    . '" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> </a>';
            }

            if ($can_show) {
                $return[] = [
                    ++$count,
                    '<span title="' . $item->procedures->name . '">' . str_limit($item->procedures->name, 20, '...') . '</span>',
                    ucwords($type),
                    $item->price,
                    $item->quantity,
//                    $item->discount,
                    $item->amount ?? $item->price,
                    payment_label($_paid, $is_insurance),
                    $item->created_at->format('d/m/Y h:i a'),
                    $link,
                ];
            } else {
                $return[] = [
                    ++$count,
                    'Procedure ' . $count,
                    ucwords($type),
                    '<span class="text-danger">Send patient to cashier</span>',
                    '-',
                    '-',
                    '-',
                    payment_label($_paid, $is_insurance),
                    $item->created_at->format('d/m/Y h:i a'),
                    '-'
                ];
            }
        }
        return $return;
    }
}
if (!function_exists('has_headers')) {

    function has_headers($procedure)
    {
        $subtests = TemplateLab::whereProcedure($procedure)->pluck('title');
        $headers = array();
        foreach ($subtests as $test) {
            if (!empty($test)) {
                $headers[] = $test;
            }
        }

        if (!empty($headers)) {
            return true;
        } else {
            return false;
        }
    }

}

if (!function_exists('get_titles_for_procedure')) {

    function get_titles_for_procedure($procedures)
    {
        return \Ignite\Evaluation\Entities\HaemogramTitle::whereProcedure($procedures)
            ->get();
    }

}


if (!function_exists('load_template')) {

    function load_template($procedure)
    {
        $loaded = TemplateLab::whereProcedure($procedure)->get();
        dd($loaded);
        return $loaded;
    }

}

if (!function_exists('get_title_procedures')) {

    function get_title_procedures($procedure, $title)
    {
        return TemplateLab::whereProcedure($procedure)
            ->whereTitle($title)
            ->get();
    }

}

if (!function_exists('get_lab_templates')) {

    function get_lab_templates($procedure)
    {
        return TemplateLab::whereProcedure($procedure)
            ->get();
    }

}


if (!function_exists('get_category_template')) {

    function get_category_template($cat)
    {
        try {
            $cat_template = ProcedureCategoryTemplates::whereCategory($cat)
                ->get()
                ->first();
            echo $cat_template->template;
        } catch (\Exception $e) {
            return null;
        }
    }

}

if (!function_exists('get_vitals')) {

    /**
     *
     * @todo Move this declaration from here. Either use view creator or move to model repository
     * @param $id
     * @return \Illuminate\Database\Eloquent\Model|null|static
     */
    function get_vitals($id)
    {
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
    function get_diagnosis_codes($regex = null)
    {
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
    function vitals_for_visit(Visit $visit)
    {
        return Vitals::firstOrNew(['visit' => $visit->id]);
    }

}

if (!function_exists('vitals_for_patient')) {

    /**
     * @param Visit $visit
     * @return \Illuminate\Database\Eloquent\Model
     * @internal param $id
     */
    function vitals_for_patient($patient)
    {
        try {
            $visit = Visit::wherePatient($patient)->get()->first();
            return $visit->vitals;
        } catch (\Exception $e) {
            return null;
        }
    }

}

if (!function_exists('patient_visits')) {

    /**
     * @param $patient_id
     * @return array|\Illuminate\Database\Eloquent\Collection|static[]
     */
    function patient_visits($patient_id)
    {
        return Visit::query()->where('patient', '=', $patient_id)->get();
    }

}


if (!function_exists('v1_history')) {

    /**
     * @param $patient_id
     * @return array|\Illuminate\Database\Eloquent\Collection|static[]
     */
    function v1_history($patient_id)
    {
        try {
            $data['treatment'] = Ignite\Evaluation\Entities\V1Treatment::where('Patient_Id', '=', $patient_id)->get();
            $data['notes'] = Ignite\Evaluation\Entities\V1InvestigationNotes::where('Patient_Id', '=', $patient_id)->get();
            $data['gexam'] = Ignite\Evaluation\Entities\V1GeneralExam::where('Patient_Id', '=', $patient_id)->get();
            $data['diagnosis'] = Ignite\Evaluation\Entities\V1Diagnosis::where('Patient_Id', '=', $patient_id)->get();
            $data['ghistory'] = Ignite\Evaluation\Entities\V1GeneralHistory::where('Patient_Id', '=', $patient_id)->get();
            return $data;
        } catch (Exception $ex) {

        }
    }

}

if (!function_exists('get_patient_documents')) {

    /**
     * @param $patient_id
     * @return array|\Illuminate\Database\Eloquent\Collection|static[]
     */
    function get_patient_documents($patient_id)
    {
        return PatientDocuments::wherePatient($patient_id)->get();
    }

}
if (!function_exists('get_patient_doctor_notes')) {

    /**
     * @param $visit
     * @return mixed
     */
    function get_patient_doctor_notes(Visit $visit)
    {
        return DoctorNotes::firstOrNew(['visit' => $visit->id]);
    }

}
if (!function_exists('get_eye_exams')) {

    /**
     * Get eye examination data
     * @param $visit
     * @return mixed
     */
    function get_eye_exams($visit)
    {
        return EyeExam::firstOrNew(['visit' => $visit]);
    }

}
if (!function_exists('get_visit_meta')) {

    /**
     * Get visit meta
     * @param $visit
     * @return \Illuminate\Database\Eloquent\Model
     */
    function get_visit_meta(Visit $visit)
    {
        return VisitMeta::firstOrNew(['visit' => $visit->id]);
    }

}
if (!function_exists('get_investigations')) {

    /**
     * Get investigations
     * @param Visit $visit
     * @param string|null $type
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    function get_investigations(Visit $visit, $type = null)
    {
        if (empty($type)) {
            return Investigations::where(['visit' => $visit->id])->orderBy('created_at', 'desc')->get();
        }
        return Investigations::where(['visit' => $visit->id])->whereIn('type', $type)
            ->orderBy('created_at', 'desc')->get();
    }

}

if (!function_exists('get_inpatient_investigations')) {

    /**
     * Get investigations
     * @param int $visit_id
     * @param string $section
     * @param array|null $type
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     * @internal param $visit
     */
    function get_inpatient_investigations($visit_id, $section = 'investigation', $type = null)
    {
        if (empty($type)) {
            return Investigations::whereVisit($visit_id)
                ->where('type', 'like', 'inpatient.' . $section . '%')->get();
        }
        return Investigations::whereVisit($visit_id)->whereIn('type', $type)->get();
    }

}

if (!function_exists('get_op_notes')) {

    /**
     * Get Op Notes for visit
     * @param $visit
     * @return $param
     */
    function get_op_notes(Visit $visit)
    {
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
    function get_visit_data(Visit $visit, $section)
    {
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
    function get_procedure_categories()
    {
        return ProcedureCategories::all()->pluck('name', 'id');
    }

}

if (!function_exists('get_parent_procedures')) {

    /**
     * @return \Illuminate\Support\Collection Procedure Collection
     */
    function get_parent_procedures()
    {
        return Procedures::all()->pluck('name', 'id');
    }

}

if (!function_exists('get_lab_cats')) {

    /**
     * @return \Illuminate\Support\Collection Procedure Collection
     */
    function get_lab_cats()
    {
        return Ignite\Evaluation\Entities\LabtestCategories::all()->pluck('name', 'id');
    }

}

if (!function_exists('get_lab_titles')) {

    /**
     * @return \Illuminate\Support\Collection Procedure Collection
     */
    function get_lab_titles()
    {
        return Ignite\Evaluation\Entities\HaemogramTitle::all()->pluck('name', 'id');
    }

}


if (!function_exists('get_clinic_name')) {

    /**
     * Fetch the Clinic name given the ID
     * @param int $id
     * @return string
     */
    function get_clinic_name($id = null)
    {
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
    function get_procedures()
    {
        return Procedures::all()->pluck('name', 'id');
    }

}


if (!function_exists('get_sample_types')) {

    function get_sample_types()
    {
        ///dd(\Ignite\Evaluation\Entities\SampleType::all());
        return \Ignite\Evaluation\Entities\SampleType::all()->pluck('name', 'id');
    }

}

if (!function_exists('get_sample_methods')) {

    function get_sample_methods()
    {
        return \Ignite\Evaluation\Entities\SampleCollectionMethods::all()->pluck('name', 'id');
    }

}

if (!function_exists('get_units')) {

    function get_units()
    {
        return \Ignite\Evaluation\Entities\Unit::all()->pluck('name', 'name');
    }

}


if (!function_exists('get_additives')) {

    function get_additives()
    {
        return \Ignite\Evaluation\Entities\Additives::all()->pluck('name', 'id');
    }

}


if (!function_exists('generate_receipt_no')) {

    /**
     * Genearte a nice receipt number reference
     * @return string
     */
    function generate_receipt_no()
    {
        return m_setting('evaluation.receipt_prefix') . date('dmyHis');
    }

}

if (!function_exists('payment_label')) {

    /**
     * Helper to return fancy lable for payment status
     * @param bool $paid
     * @param bool $insurance
     * @return string
     */
    function payment_label($paid, $insurance = false)
    {
        if ($paid) {
            $string = $insurance ? 'Invoiced' : 'Paid';
            $fancy = "<span class='text-success'><i class='fa fa-check-circle-o'></i> $string</span>";
        } else {
            $string = $insurance ? 'Not Invoiced' : 'Not Paid';
            $fancy = "<span class='text-danger'><i class='fa fa-warning'></i> $string</span>";
        }
        return $fancy;
    }

}
if (!function_exists('get_patients_with_bills')) {

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    function get_patients_with_bills()
    {
        return Patients::whereHas('visits', function ($query) {
            $query->wherePaymentMode('cash');
            $query->whereHas('investigations', function ($q3) {
                $q3->doesntHave('payments');
                $q3->doesntHave('removed_bills');
            });

            //$query->orWhereHas('admission', function ($a){
            //});

            $query->orWhereHas('dispensing', function ($q) {
                $q->doesntHave('removed_bills');
                $q->whereHas('details', function ($qd) {
                    $qd->whereStatus(0);
                });
                // $q->wherePayment_status(0);
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
    function get_patients_with_drugs()
    {
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
    function get_patients_with_pharm()
    {
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
    function get_patients_from_pos()
    {
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
    function visit_destination(Visit $visit)
    {
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
    function exportSickOff(Request $request, $patient)
    {
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

    function exportPatientNotes($patient, $visit)
    {
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
                    $c->addText($n += 1);
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

    function exportPatientNotesDate($patient, $visit)
    {
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
            $section->addText($v->notes->diagnosis);
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
                $c->addText($n += 1);
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

}

function paymentFor($procedures)
{
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
     * @param $procedure , $age_days, $age_years
     * @return $range
     */
    function get_min_range($p, $age_days, $age_years)
    {
        if (!empty($p->ref_ranges)) {
            if (get_gender_range($p)) {
                $range = get_gender_range($p);
                return $range->lower;
            } else {
                $r = get_first_ranges($p->id);
                if (!empty($r)) {
                    return $r->lower;
                }
            }
        } else {
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
        }
    }

}

if (!function_exists('get_gender_range')) {

    function get_gender_range($p)
    {
        get_ref_range($p);
        $patient = \Session::get('active_patient');
        $range = ReferenceRange::whereProcedure($p->id)
            ->whereGender(strtolower($patient->sex))
            ->get()
            ->first();
        if (!empty($range)) {
            return $range;
        } else {
            return false;
        }
    }

}


if (!function_exists('get_ref_range')) {

    function get_ref_range($p)
    {
        $interval = null;

        if (gender_specific_interval($p)) {
            $interval = gender_specific_interval($p);
        } else {
            if (specified_time_intervals($p)) {
                $interval = specified_time_intervals($p);
            } else {
                $interval = general_interval($p);
            }
        }
        return $interval;
    }

}


if (!function_exists('get_ref_interval')) {
    function get_ref_interval($range)
    {
        try {
            $flg = mconfig('evaluation.options.lp_flags');
            if ($range->type == 'range') {
                $interval = $range->lower . ' - ' . $range->upper;
            } elseif ($range->type == 'less_greater') {
                $interval = $range->lg_type . ' ' . $range->lg_value;
            } else {
                $interval = $range->other_type;
            }
            return $range->flag ? $flg[$range->flag] . ' ' . $interval : $interval;
        } catch (\Exception $e) {
            return null;
        }
    }

}

if (!function_exists('with_and_without_headers')) {
    function with_and_without_headers($other_tests, $with_headers)
    {
        $has_both = false;
        foreach ($other_tests as $othertest) {
            if (!in_array($othertest->subtests->id, $with_headers)) {
                $has_both = true;
            }
        }
        return $has_both;
    }

}

if (!function_exists('is_critical')) {

    function is_critical($test, $result)
    {
        if (!empty($result)) {
            try {
                $r = $result[$test->subtests->id];
                $cv = $test->subtests->critical_values;

                if ($cv->type == '>') {
                    if ($r > $cv->critical_value) {
                        return true;
                    }
                } elseif ($cv->type == '<') {
                    if ($r < $cv->critical_value) {
                        return true;
                    }
                } elseif ($cv->type == '>=') {
                    if ($r >= $cv->critical_value) {
                        return true;
                    }
                } elseif ($cv->type == '<=') {
                    if ($r <= $cv->critical_value) {
                        return true;
                    }
                } else {
                    return false;
                }
            } catch (\Exception $exception) {
                return false;
            }
        } else {
            return false;
        }
    }

}

/*
if (!function_exists('get_result')) {
    function get_result($results, $test) {
        if (!empty($test->formula)) {
            $formula = $test->formula->formula;
            $signs = ['+', '-', '*', '/'];
            $sign = '';

            foreach ($signs as $s) {
                if (strpos($formula, $s)) {
                    $sign = $s;
                }
            }

            $f = explode($sign, $formula);
            $test1 = $results[substr($f[0], 1)];
            $test2 = $results[substr($f[1], 1)];
            if ($sign == '*') {
                return $test1 * $test2;
            } elseif ($sign == '/') {
                return $test1 / $test2;
            } elseif ($sign == '-') {
                return $test1 - $test2;
            } elseif ($sign == '+') {
                return $test1 + $test2;
            }
        } else {
            return strip_tags($results[$test->id]);
        }
    }

}
*/


if (!function_exists('get_result')) {

    /**
     * @return Test result
     */
    function get_result($results, $test)
    {
        if (!$test->sensitivity) {
            if (!empty($test->formula)) {
                $formula = $test->formula->formula;
                $formula = str_replace(' ', '', strtoupper($test->formula->formula));

                preg_match_all('/P\s*(\d+)/', $formula, $matches);
                $test_ids = $matches[1];

                $search = array();
                $replace = array();
                foreach ($test_ids as $id) {
                    $search[] = "P" . $id;
                    $replace[] = $results[$id];
                }
                $parsable = str_replace($search, $replace, $formula);

                return parse_expression($parsable);
            } else {
                try {
                    return strip_tags($results[$test->id]);
                } catch (\Exception $e) {
                    return '';
                }
            }
        }
    }

}

function parse_expression($expression)
{
    $calculator = \Hoa\Compiler\Llk::load(new \Hoa\File\Read('hoa://Library/Math/Arithmetic.pp'));
    $visitor = new Hoa\Math\Visitor\Arithmetic();
    $ast = $calculator->parse($expression);
    return number_format($visitor->visit($ast), 4);
}

function general_interval($p)
{
    $patient = \Session::get('active_patient');
    if (empty($patient->dob)) {
        return false;
    }
    $dob = \Carbon\Carbon::parse($patient->dob);
    $today = new DateTime();
    $age = $dob->diff($today);

    $age_d = $dob->diffInDays();
    $age_y = $dob->age;
    $age_m = ($age->format('%y') * 12) + $age->format('%m');

    $all = ReferenceRange::whereProcedure($p->id)
        ->whereAge('all')
        ->whereGender('both')
        ->get()
        ->first();

    $adult = ReferenceRange::whereProcedure($p->id)
        ->whereAge('adult')
        ->whereGender('both')
        ->get()
        ->first();

    $child = ReferenceRange::whereProcedure($p->id)
        ->whereAge('child')
        ->whereGender('both')
        ->get()
        ->first();

    $birth = ReferenceRange::whereProcedure($p->id)
        ->whereAge('birth')
        ->whereGender('both')
        ->get();

    if ($age_y > 18) {
        if (!empty($adult)) {
            return $adult;
        } else {
            return $all;
        }
    } elseif (($age_y > 0 && $age_y < 18) && $age_d > 0) {
        if (!empty($child)) {
            return $child;
        } else {
            return $all;
        }
    } else {
        if (isset($dob) && $age_d < 0) {
            if (!empty($birth)) {
                return $birth;
            } else {
                return $all;
            }
        } else {
            return false;
        }
    }
}

function gender_specific_interval($p)
{
    $patient = \Session::get('active_patient');
    if (empty($patient->dob)) {
        return false;
    }
//    $dob = \Carbon\Carbon::createFromDate('2000');
    $dob = \Carbon\Carbon::parse($patient->dob);
    $today = new DateTime();
    $age = $dob->diff($today);

    $age_d = $dob->diffInDays();
    $age_y = $dob->age;
    $age_m = ($age->format('%y') * 12) + $age->format('%m');

    $range = null;

    $all = ReferenceRange::whereProcedure($p->id)
        ->whereAge('all')
        ->whereGender(strtolower($patient->sex))
        ->get()
        ->first();

    $adult = ReferenceRange::whereProcedure($p->id)
        ->whereAge('adult')
        ->whereGender(strtolower($patient->sex))
        ->get()
        ->first();

    $child = ReferenceRange::whereProcedure($p->id)
        ->whereAge('child')
        ->whereGender(strtolower($patient->sex))
        ->get()
        ->first();

    $birth = ReferenceRange::whereProcedure($p->id)
        ->whereAge('birth')
        ->whereGender(strtolower($patient->sex))
        ->get();

    if ($age_y > 18) {
        if (!empty($adult)) {
            return $adult;
        } else {
            return $all;
        }
    } elseif (($age_y > 0 && $age_y < 18) && $age_d > 0) {
        if (!empty($child)) {
            return $child;
        } else {
            return $all;
        }
    } else {
        if (isset($dob) && $age_d < 0) {
            if (!empty($birth)) {
                return $birth;
            } else {
                return $all;
            }
        } else {
            return false;
        }
    }
}

function contains_strings($res)
{

    foreach ($res as $key => $value) {
        if (is_numeric($value)) return false;
    }

    return true;
}

function specified_time_intervals($p)
{
    /**
     * Get ranges for more specified time ranges
     * i.e 0-3 days etc.
     * last character of age string denotes time ie d=days, w=weeks, m=months etc
     * @param $procedure_id
     * @return $interval
     */
    $patient = \Session::get('active_patient');
    if (empty($patient->dob)) {
        return true;
    }
    $dob = \Carbon\Carbon::parse($patient->dob);

    $interval = null;
    $patient_age = null;
    $search = '-';

    $gender_specific = ReferenceRange::whereProcedure($p->id)
        ->where('age', 'LIKE', '%' . $search . '%')
        ->whereGender(strtolower($patient->sex))
        ->get();


    $ranges_default = ReferenceRange::whereProcedure($p->id)
        ->where('age', 'LIKE', '%' . $search . '%')
        ->whereGender('both')
        ->get();

    if ($gender_specific->count() > 0) {
        $interval = get_interval($gender_specific, $dob);
    } else {
        $interval = get_interval($ranges_default, $dob);
    }

    if (!empty($interval)) {
        return $interval;
    } else {
        return false;
    }
}


if (!function_exists('get_specified_age')) {

    function get_interval($ranges, $dob)
    {
        if (!empty($ranges)) {
            foreach ($ranges as $r) {
                $patient_age = get_specified_age($r->age, $dob);
                $time_range = explode('-', $r->age);
                $min = $time_range[0];
                $max = substr($time_range[1], 0, -1);

                if ($patient_age >= $min && $patient_age <= $max) {
                    return $r;
                } else {
                    return null;
                }
            }
        }
    }

}

if (!function_exists('get_specified_age')) {

    /**
     * Choose time measure to use and return patient's age in the specified time unit
     * @param string $age_str i.e. 0-3d
     * @param date $age Patient's age
     * @return $patient_age age in specified time unit
     */
    function get_specified_age($age_str, $dob)
    {
        $today = new DateTime();
        $age = $dob->diff($today);

        $age_d = $dob->diffInDays();
        $age_y = $dob->age;
        $age_m = ($age->format('%y') * 12) + $age->format('%m');

        $patient_age = null;
        if (substr($age_str, -1) == 'd') {
            $patient_age = $age_d;
        } elseif (substr($age_str, -1) == 'm') {
            $patient_age = $age_m;
        } elseif (substr($age_str, -1) == 'y') {
            $patient_age = $age_y;
        }
        return $patient_age;
    }

}

if (!function_exists('get_max_range')) {

///*********DEPRECEATED**********//////////
    /**
     * Get Maximum lab range depending on patient age
     * @param $procedure , $age_days, $age_years
     * @return $range
     */
    function get_max_range($p, $age_days, $age_years)
    {
        $max_range = null;
        try {
            if (!empty($p->ref_ranges)) {
                if (get_gender_range($p)) {
                    $range = get_gender_range($p);
                    return $range->upper;
                } else {
                    $r = get_first_ranges($p->id);
                    if (!empty($r)) {
                        return $r->upper;
                    }
                }
            } else {
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
            }
            return $max_range;
        } catch (\Exception $e) {
            //return null;
        }
    }

}

function get_age_string($dob)
{
    $str = '';
    $days = (new Date($dob))->diff(Carbon\Carbon::now())->format('%d');
    $months = (new Date($dob))->diff(Carbon\Carbon::now())->format('%m');
    $years = (new Date($dob))->diff(Carbon\Carbon::now())->format('%y');
    //$years = (new Date($dob))->diff(Carbon\Carbon::now())->format('%y years, %m months and %d days');
    if ($years < 0 && $months < 0) {
        $str .= $days . ' days old';
    } elseif ($months > 0 && $years < 0) {
        $str .= $months . ' months old';
    } elseif ($years <= 5 && $months > 0) {
        $str .= $years . 'years, ' . $months . ' months old';
    } else {
        $str .= $years . ' years old';
    }
    return $str;
}

if (!function_exists('get_first_ranges')) {

    /**
     * Get Lab test unit
     * @param $procedure /test
     * @return $unit
     */
    function get_first_ranges($procedure_id)
    {
        try {
            $ref = \Ignite\Evaluation\Entities\ReferenceRange::whereProcedure($procedure_id)->first();
            ///dd($ref);
            if (!empty($ref)) {
                return $ref;
            }
        } catch (\Exception $e) {

        }
    }

}


if (!function_exists('getOrderResults')) {

    /**
     * Get Lab test unit
     * @param $procedure /test
     * @return $unit
     */
    function getOrderResults($patient)
    {
        $results = Investigations::whereHas('visits', function ($query2) use ($patient) {
            $query2->wherePatient($patient);
        })
            ->whereHas('results')
            ->get();
        return $results;
    }

}

if (!function_exists('getUnit')) {

    /**
     * Get Lab test unit
     * @param $procedure /test
     * @return $unit
     */
    function getUnit($p)
    {
        if (!empty($p->this_test)) {
            if ($p->this_test->units !== 'NULL') {
                return $p->this_test->units;
            }
            /*
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
              } */
        }
    }

}


if (!function_exists('getFlag')) {

    /**
     * Get Appropriate flag for lab result
     * @param $result , $min_range, $max_range
     * @return $flag
     */

    function getFlag($r, $range)
    {
        if ($range->type == 'range') {
            if ($r < $range->lower) {
                return "<span style = ''> L</span>";
            } elseif ($r > $range->upper) {
                return "<span style = ''> H</span>";
            }
        } elseif ($range->type == 'less_greater') {
            if ($range->lg_type == '>' || $range->lg_type == 'greater_than') {
                if ($r < $range->lg_value) {
                    return "<span style = ''> L </span>";
                }
            } elseif ($range->lg_type == '>=' || $range->lg_type == 'greater_than_or') {
                if ($r < $range->lg_value) {
                    return "<span style = ''> L</span>";
                }
            } elseif ($range->lg_type == '<' || $range->lg_type == 'less_than') {
                if ($r > $range->lg_value) {
                    return "<span style = ''> H </span>";
                } else {
                    return null;
                }
            } elseif ($range->lg_type == '<=' || $range->lg_type == 'less_than_or') {
                if ($r > $range->lg_value) {
                    return "<span style = ''> H </span>";
                }
            } else {
                return null;
            }
        }
    }

}

if (!function_exists('has_ranges')) {
    function has_ranges($ids)
    {
        try {
            $has = false;
            foreach ($ids as $id) {
                $range = ReferenceRange::whereProcedure($id)->get();
                if (count($range) > 0) {
                    $has = true;
                }
            }
            return $has;
        } catch (\Exception $e) {
            return false;
        }
    }
}

if (!function_exists('get_reverted_test')) {

    function get_reverted_test($test)
    {
        $reverted = \Session::get('last_reverted');
        $reverted_value = '';
        if (array_has($reverted, $test)) {
            $r = array_only($reverted, $test);
            foreach ($r as $key => $value) {
                $reverted_value .= $value;
            }
        }
        echo $reverted_value;
    }

}

if (!function_exists('get_patient_samples')) {

    function get_patient_samples($id)
    {
        return \Ignite\Evaluation\Entities\Sample::wherePatient_id($id)->get();
    }

}

if (!function_exists('get_aliases')) {

    function get_aliases($procedure_id)
    {
        return TemplateLab::whereProcedure($procedure_id)->pluck('alias', 'subtest');
    }

}

if (!function_exists('get_formula')) {

    function get_formula($test_id)
    {
        $formula = \Ignite\Evaluation\Entities\Formula::whereTest_id($test_id)->get()->first();
        if (!empty($formula)) {
            return $formula->formula;
        } else {
            return null;
        }
    }

}


if (!function_exists('handle_formula')) {

    function handle_formula($test_id)
    {
        $formula = \Ignite\Evaluation\Entities\Formula::whereTest_id($test_id)->get()->first();
        if (!empty($formula)) {

            $vars = preg_split("/[+,-,*]+/", $formula->formula);
            return $formula->formula;
        } else {
            return null;
        }
    }

}

function get_res($name, $test, $results)
{
    $data = array();
    if (strpos($name, 'HEMOGRAM')) {
        if (str_contains(strtolower($test->subtests->name), 'wbc') ||
            str_contains(strtolower($test->subtests->name), 'white blood cell count')) {
            $data['wbc'] = $wbc = $results[$test->subtest];
            return $data;
        }

        if (str_contains(strtolower($test->subtests->name), 'neutrophils') &&
            str_contains($test->subtests->name, '%')) {
            $data['np'] = $np = $results[$test->subtest];
            return $data;
        }

        if (str_contains(strtolower($test->subtests->name), 'lymphocyte') &&
            str_contains($test->subtests->name, '%')) {
            $data['lp'] = $lp = $results[$test->subtest];
            return $data;
        }

        if (str_contains(strtolower($test->subtests->name), 'monocyte') &&
            str_contains($test->subtests->name, '%')) {
            $data['mp'] = $mp = $results[$test->subtest];
            return $data;
        }

        if (str_contains(strtolower($test->subtests->name), 'eosinophils') &&
            str_contains($test->subtests->name, '%')) {
            $data['ep'] = $ep = $results[$test->subtest];
            return $data;
        }

        if (str_contains(strtolower($test->subtests->name), 'basophils') &&
            str_contains($test->subtests->name, '%')) {
            $data['bp'] = $bp = $results[$test->subtest];
            return $data;
        }
    }
}

if (!function_exists('consumables')) {

    function get_consumables($id)
    {
        $procedure = \Ignite\Evaluation\Entities\Procedures::whereId($id)->get()->first();
        if (!$procedure->items->isEmpty()) {
            echo ""
                . "<table class='table table-striped table-condensed'>"
                . "<tr>"
                . "<th>Consumable(s)</th><th>Units</th>"
                . "</tr>";
            $n = 0;
            //dd($procedure->items);
            foreach ($procedure->items as $item) {
                $n += 1;
                echo ""
                    . "<tr>"
                    . "<td>" . $item->inventory->name . "</td>"
                    . "<td>"
                    . "<input type='text' name='item_product[]' value='$item->units'>"
                    . "<input type='hidden' name='item_procedure[]' value='$procedure->id'>"
                    . "</td>"
                    . "</tr>";
            }
            echo ""
                . "</table>";
        }
    }

}
