<?php

/*
 * =============================================================================
 *
 * Collabmed Solutions Ltd
 * Project: Collabmed Health Platform
 * Author: Samuel Okoth <sodhiambo@collabmed.com>
 *
 * =============================================================================
 */

namespace Ignite\Evaluation\Library;

use Carbon\Carbon;
use Ignite\Evaluation\Entities\Additives;
use Ignite\Evaluation\Entities\CriticalValues;
use Ignite\Evaluation\Entities\ExternalOrders;
use Ignite\Evaluation\Entities\Formula;
use Ignite\Evaluation\Entities\HaemogramTitle;
use Ignite\Evaluation\Entities\PrescriptionPayment;
use Ignite\Evaluation\Entities\ProcedureInventoryItem;
use Ignite\Evaluation\Entities\DiagnosisCodes;
use Ignite\Evaluation\Entities\DoctorNotes;
use Ignite\Evaluation\Entities\Drawings;
use Ignite\Evaluation\Entities\EyeExam;
use Ignite\Evaluation\Entities\InvestigationResult;
use Ignite\Evaluation\Entities\Investigations;
use Ignite\Evaluation\Entities\OpNotes;
use Ignite\Evaluation\Entities\Preliminary;
use Ignite\Evaluation\Entities\Prescriptions;
use Ignite\Evaluation\Entities\ProcedureCategories;
use Ignite\Evaluation\Entities\Procedures;
use Ignite\Evaluation\Entities\ReferenceRange;
use Ignite\Evaluation\Entities\Remarks;
use Ignite\Evaluation\Entities\SampleCollectionMethods;
use Ignite\Evaluation\Entities\SampleType;
use Ignite\Evaluation\Entities\Sensitivity;
use Ignite\Evaluation\Entities\Unit;
use Ignite\Evaluation\Entities\VisitDestinations;
use Ignite\Evaluation\Entities\VisitMeta;
use Ignite\Evaluation\Entities\Visit;
use Ignite\Evaluation\Entities\Vitals;
use Ignite\Evaluation\Repositories\EvaluationRepository;
use Ignite\Inventory\Entities\InventoryProducts;
use Ignite\Inventory\Repositories\InventoryRepository;
use Ignite\Reception\Entities\Appointments;
use Ignite\Reception\Entities\PatientDocuments;
use Ignite\Reception\Entities\Patients;
use Ignite\Evaluation\Entities\Dispensing;
use Ignite\Evaluation\Entities\DispensingDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Jenssegers\Date\Date;
use Ignite\Evaluation\Entities\SubProcedures;
use Ignite\Evaluation\Entities\ProcedureTemplates;
use Ignite\Evaluation\Entities\ProcedureCategoryTemplates;
use Ignite\Evaluation\Entities\TemplateLab;
use Ignite\Evaluation\Entities\ExternalOrderDetails;

/**
 * Description of FunctionsRepository
 *
 * @author samuel
 */
class EvaluationFunctions implements EvaluationRepository
{

    /**
     * Incoming HTTP request
     * @var Request
     *
     */
    protected $request;

    /**
     * The filtered input
     * @var array
     */
    protected $input;

    /**
     * Visit reference ID
     * @var mixed|int
     */
    protected $visit;

    /**
     * User making the request
     * @var int
     */
    protected $user;

    /**
     * Model ID or null
     * @var null|int
     */
    protected $id = null;

    /**
     * EvaluationFunctions constructor.
     * @param Request $request
     * @param InventoryRepository $repo
     */
    public function __construct(Request $request, InventoryRepository $repo)
    {
        $this->request = $request;
        $this->repo = $repo;
        $this->input = $this->request->all();
        if ($this->request->has('visit')) {
            $this->visit = $this->request->visit;
        }
        if (Auth::check()) {
            $this->user = $this->request->user()->id;
        }
        $this->prepareInput($this->input);

        $this->inventoryRepository = $repo;
    }

    /**
     * Remove the token from the input array
     * Also remove empty values
     * @param $input
     */
    private function prepareInput(&$input)
    {
        unset($input['_token']);
        foreach ($input as $key => $value) {
            if (empty($value)) {
                unset($input[$key]);
            }
        }
        if (!empty($input['id'])) {
            $this->id = $input['id'];
            unset($input['id']);
        }
    }

    /**
     * Save a patient document from here
     * @param $file
     * @return PatientDocuments
     */
    private function upload_patient_doc($file)
    {
        return PatientDocuments::create([
            'patient' => Visit::find($this->visit)->patient,
            'document' => base64_encode(file_get_contents($file->getRealPath())),
            'filename' => $file->getClientOriginalName(),
            'mime' => $file->getClientMimeType(),
            'document_type' => 'investigation',
            'description' => $file->getSize(),
            'user' => $this->user
        ]);
    }

    /**
     * @return int|null
     */
    public function save_results_investigations()
    {
        $set = $this->_get_selected_stack();
        $user = null;
        //dd($this->input);
        foreach ($set as $item) {
            try {
                // if (empty($this->input['results' . $item])) {
                ///continue;
                // }
                if (isset($this->input['tests' . $item])) {
                    $_tests = \GuzzleHttp\json_decode($this->input['tests' . $item]);
                }

                $__in = InvestigationResult::firstOrNew(['investigation' => $item]);

                try {
                    $test_result = array();
                    $res_array = $this->input['results' . $item];
                    // dd($_tests);
                    foreach ($_tests as $key => $value) {
                        try {
                            $test_result[] = array($value, $res_array[$key]);
                        } catch (\Exception $e) {
                            $test_result[] = '';
                        }
                    }
                    $result_array = \GuzzleHttp\json_encode($test_result);
                    $__in->results = $result_array;
                } catch (\Exception $e) {
                    if (isset($this->input['results' . $item])) {
                        $__in->results = $this->input['results' . $item];
                    }
                }

                if ($this->request->hasFile('file' . $item)) {
                    $temp = "file$item";
                    $file = $this->upload_patient_doc($this->request->$temp);
                    $__in->file = $file->id;
                }
                $comment = "comments" . $item;
                $__in->comments = $this->request->$comment;
                $__in->user = $this->user;
                $__in->save();

                $user = $__in->investigations->user;

                if (isset($this->input['isolate' . $item])) {
                    foreach ($this->input['isolate' . $item] as $key => $value) {
                        try {
                            $s = Sensitivity::whereDrug_id($value)
                                ->whereResult_id($__in->id)
                                ->first();
                            if (empty($s)) {
                                $sens = new Sensitivity();
                            } else {
                                $sens = $s;
                            }
                            $sens->visit_id = $this->input['visit'];
                            $sens->drug_id = $value;
                            $sens->sensitivity = $this->input['interpretation' . $item][$key];//$this->input['rs'.$item];
                            $sens->result_id = $__in->id;
                            $sens->save();
                        } catch (\Exception $e) {

                        }
                    }
                }
            } catch (\Exception $e) {
                return null;
            }
        }
        //send_notification($user, 'Investigation results', 'Results have been added');
        return true;
    }

    /**
     * Create a central management for preemptive patient evaluation route
     * @param $patient_visit
     * @param bool $flag Switch to determine if we use the parameter patient_visit as either patient id or schedule id
     * @return array The associative array for patient record
     */
    public function patient_management($patient_visit, $flag = null)
    {
        $data = [];
        $data['schedule'] = $schedule = Appointments::findOrNew($patient_visit);
        $data['checked_in'] = empty($flag);
        $patient = empty($flag) ? $schedule->patient : $patient_visit;
        $data['visits'] = Visit::wherePatient($patient)->get();
        $data['patient'] = Patients::find($patient);
        return $data;
    }

    public function SaveTemplate($request)
    {
        // try {
        if ($this->request->has('lab')) {
            $this->saveLabBlueprint($request);
        } else {

            $template = ProcedureTemplates::findOrNew($request->template_id);
            $template->procedure = $request->procedure;
            $template->template = $request->template;
            $template->save();
        }
        flash("Template Saved....", "success");
        //} catch (\Exception $e) {
        // flash("Template Could NOT be Saved, please try again", 'danger');
        // }
        return redirect()->route('evaluation.setup.template');
    }

    public function saveLabBlueprint(Request $request)
    {
        foreach ($request->subtest as $key => $value) {
            $template = TemplateLab::findOrNew($request->template_id);
            $template->procedure = $request->procedure;
            $template->alias = $request->alias[$key];
            if ($request->title[$key] > 0) {
                $template->title = $request->title[$key];
            }
            try {
                $template->subtest = $request->subtest[$key];
            } catch (\Exception $e) {
                flash('Subtest cannot be null', 'error');
            }
            if ($request->sort_order[$key]) {
                $template->sort_order = $request->sort_order[$key];
            }
            $template->save();
        }
    }

    public function SavePCTemplate($request)
    {
        try {
            $template = ProcedureCategoryTemplates::findOrNew($request->template_id);
            $template->category = $request->category;
            $template->template = $request->template;
            $template->save();
            flash("Template Saved....", "success");
        } catch (\Exception $e) {
            flash("Template Could NOT be Saved, please try again", 'danger');
        }
        return redirect()->route('evaluation.setup.template');
    }

    /**
     * Create a new visit incase it has not been setup yet
     * @param $schedule
     * @deprecated since version 1.4 The current model does not require to create an new visit. Can implement by type-hinting
     * @return int
     */
    public function create_new_visit($schedule)
    {
        $appointment = Appointments::find($schedule);
        $visit = new Visit;
        $visit->clinic = config('practice.clinic');
        $visit->patient = $appointment->patient;
        $visit->user = Auth::user()->user_id;
        $visit->appointment = $appointment->id;
        $visit->save();
        return $visit->id;
    }

    /**
     * Save patient vitals
     * @param
     */
    public function save_vitals()
    {
        return Vitals::firstOrCreate('visit', $this->visit)->update($this->input);
    }

    public function get_diagnosis_codes_auto()
    {
        $ret = [];
        $term = $this->request->term['term'];
        if (!empty($term)) {
            $found = DiagnosisCodes::select('id', 'name as text')
                ->where('name', 'like', "%$term%")->get();
        }
        $ret['results'] = $found;
        return json_encode($ret);
    }

    /**
     * @param
     */
    public function save_notes()
    {
        if ($this->request->has('option')) {
            $this->save_eye_exam();
        }
        return DoctorNotes::updateOrCreate(
            ['visit' => $this->visit],
            [
                'presenting_complaints' => $this->request->presenting_complaints,
                'past_medical_history' => $this->request->past_medical_history,
                'examination' => $this->request->examination,
                'investigations' => $this->request->investigations,
                'treatment_plan' => $this->request->treatment_plan,
                'diagnosis' => $this->request->diagnosis,
                'user' => $this->request->user()->id
            ]);
    }

    public function save_eye_exam()
    {
        foreach ($this->request->option as $key => $exam) {
            $eye = EyeExam::firstOrCreate(['option' => $exam, 'visit' => $this->request->visit]);
            $eye->od = $this->request->od[$key];
            $eye->os = $this->request->os[$key];
            $eye->comments = $this->request->comments[$key];
            $eye->user = $this->request->user()->id;
            $eye->save();
        }
        return true;
    }

    public function save_drawings()
    {
        $drawing = Drawings::findOrNew($this->request->visit);
        $drawing->object = serialize($this->request->objects);
        $drawing->user = $this->request->user()->id;
        $drawing->visit = $this->request->visit;
        if ($this->request->hasFile('image')) {
            $image = Image::make($this->request->file('image')->getRealPath());
            $_encode = $image/* ->fit(160, 160) */
            ->encode('jpg');
            $stream = $_encode->stream();
            $drawing->background = base64_encode($stream);
        }
        $drawing->save();
    }

    /**
     * New way to checkin patient
     * @param $place
     * @return bool
     */
    private function check_in_at($place): bool
    {
        if ($place === 'treatment') {
            return true;
        }
        $department = $place;
        $destination = null;
        if ((int)$place > 0) {
            $destination = (int)$department;
            $department = 'doctor';
        }
        $destinations = VisitDestinations::firstOrNew(['visit' => $this->visit, 'department' => ucwords($department)]);
        $destinations->destination = $destination;
        $destinations->user = $this->request->user()->id;
        return $destinations->save();
    }

    /**
     * Save diagnosis
     * @return array
     */
    public function save_diagnosis()
    {
        DB::transaction(function () {
            foreach ($this->_get_selected_stack() as $treatment) {
                // dd($treatment);
                $discount = 'discount' . $treatment;

                try {
                    $amount = $this->input['amount' . $treatment];
                    $price = $this->input['price' . $treatment];
                } catch (\Exception $e) {
                    $amount = 0;
                    $price = 0;
                }
                Investigations::create([
                    'type' => $this->input['type' . $treatment],
                    'visit' => $this->visit,
                    'procedure' => $treatment,
                    'quantity' => $this->input['quantity' . $treatment],
                    'price' => $price,
                    'discount' => $this->request->$discount,
                    'amount' => $amount,
                    'instructions' => empty($this->input['instructions' . $treatment]) ? null : $this->input['instructions' . $treatment],
                    'user' => $this->user,
                    'ordered' => true
                ]);
                $this->check_in_at($this->input['type' . $treatment]);
            }
        });
        reload_payments();
        return ['result' => true];
    }

    /**
     * Build an index of items dynamically
     * @param null|string $needle
     * @return array
     */
    private function _get_selected_stack($needle = null)
    {
        $stack = [];
        $input = \request()->all();
        if (empty($needle)) {
            $needle = 'item';
        }
        foreach ($input as $key => $one) {
            if (starts_with($key, $needle)) {
                $stack[] = substr($key, strlen($needle));
            }
        }
        return $stack;
    }


    /**
     * @return Prescriptions|bool
     */
    public function save_prescriptions()
    {
        if (empty($this->request->drug)) {
            return false;
        }
        $cost = get_price_drug(Visit::find($this->visit), InventoryProducts::find($this->request->drug));
        $this->input['user'] = $this->user;
        $this->check_in_at('pharmacy');
        $prescription = Prescriptions::create(array_except($this->input, 'quantity'));
        $attributes = [
            'price' => $cost,
            'cost' => $cost * (int)$this->input['quantity'],
            'quantity' => (int)$this->input['quantity'],
        ];
        $prescription->payment()->create($attributes);
        reload_payments();
        return $prescription;
    }

    /**
     * Save diagnosis
     * @return array
     */
    public function dispense()
    {
        \DB::beginTransaction();
        $dis = new Dispensing;
        $dis->visit = $this->request->visit;
        $dis->user = \Auth::user()->id;
        $dis->save();
        $amount = 0;
        $prescription = null;
        foreach ($this->_get_selected_stack() as $index) {
            $item = 'item' . $index;
            $drug = 'drug' . $index;
            $qty = 'qty' . $index;
            $price = 'prc' . $index;
            $presc = 'presc' . $index;
            $disc = 'discount' . $index;

            $prescription = $this->request->$presc;
            $details = new DispensingDetails;
            $details->batch = $dis->id;
            $details->product = $this->request->$drug;
            $details->quantity = $this->request->$qty;
            $details->price = $this->request->$price;
            $details->discount = $this->request->$disc ?? 0;
            $details->save();
            $sub_total = $details->quantity * $details->price; //((100 - $this->request->$disc ? $this->request->$disc : 0) / 100) * ($details->quantity * $details->price);
            $amount += $sub_total;
            //adj stock
            $this->repo->take_dispensed_products($details);
            $this->updatePresc($this->request->$presc);
        }
        $dis->amount = $amount;
        $dis->prescription = $prescription;
        $dis->save();
        \DB::commit();
        return true;
    }

    public function updatePresc($id)
    {
        $presc = Prescriptions::find($id);
        $presc->status = 1;
        $presc->save();
    }

    /**
     * Save the op notes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function save_opnotes()
    {
        return OpNotes::updateOrCreate(['visit' => $this->visit], [
            'implants' => $this->request->implants,
            'surgery_indication' => $this->request->surgery_indication,
            'postop' => $this->request->postop,
            'date' => new Date($this->request->date . ' ' . $this->request->time),
            'doctor' => $this->request->doctor,
            'indication' => $this->request->indication,
            'user' => $this->user,
            'visit' => $this->visit
        ]);
    }

    public function SaveSampleType(Request $request)
    {
        $type = SampleType::findOrNew($request->id);
        $type->name = $this->request->name;
        $type->procedure = $this->request->procedure;
        $type->details = $this->request->details;
        $type->save();
    }

    function save_collection_method(Request $request)
    {
        $method = SampleCollectionMethods::findOrNew($request->id);
        $method->name = $request->name;
        $method->save();
    }

    function save_unit(Request $request)
    {
        $unit = Unit::findOrNew($request->id);
        $unit->name = $request->name;
        $unit->save();
    }

    function save_additives(Request $request)
    {
        $item = Additives::findOrNew($request->id);
        $item->name = $request->name;
        $item->save();
    }

    function save_remarks(Request $request)
    {
        $item = Remarks::findOrNew($request->id);
        $item->remarks = $request->remarks;
        $item->procedure = $request->procedure;
        $item->title = $request->title;
        $item->save();
    }

    function save_formula(Request $request)
    {
        $item = \Ignite\Evaluation\Entities\Formula::findOrNew($request->id);
        $item->procedure_id = $request->procedure_id;
        $item->test_id = $request->test_id;
        $item->formula = $request->formula;
        $item->save();
    }

    function save_range(Request $request)
    {
        $item = ReferenceRange::findOrNew($request->id);
        $item->procedure = $request->procedure;
        $item->gender = $request->gender;
        $item->age = $request->age;
        $item->type = $request->type;
        $request->lower ? $item->lower = $request->lower : '';
        $request->upper ? $item->upper = $request->upper : '';
        $item->lg_type = $request->lg_type;
        $item->flag = $request->flag;
        $item->other_type = $request->other;
        $request->lg_value ? $item->lg_value = $request->lg_value : '';
        $item->save();
    }


    function save_critical_values(Request $request)
    {
        $item = CriticalValues::findOrNew($request->id);
        $item->critical_value = $request->critical_value;
        $item->type = $request->type;
        $item->procedure = $request->procedure;
        $item->save();
    }

    function delete_critical_value(Request $request)
    {
        return CriticalValues::find($request->id)->delete();
    }

    function delete_range(Request $request)
    {
        return ReferenceRange::find($request->id)->delete();
    }

    public function del_critical_value(Request $request)
    {
        return CriticalValues::find($request->id)->delete();
    }

    public function delete_formulae(Request $request)
    {
        return Formula::find($request->id)->delete();
    }

    public function delete_procedure(Request $request)
    {
        Procedures::find($request->id)->delete();
        $inv = Investigations::whereProcedure($request->id)->get();
        if (count($inv) > 0) {
            foreach ($inv as $i) {
                $i->delete();
            }
        }
        return true;
    }


    /**
     * Set manual visit date especially for back-dating
     * @return bool
     */
    public function set_visit_date()
    {
        $visit = Visit::find($this->request->visit);
        $visit->created_at = $this->request->visit_date;
        return $visit->save();
    }

    /**
     * Update visit meta.inf
     * @return bool
     */
    public function update_visit_meta()
    {
        $meta = VisitMeta::findOrNew($this->request->visit);
        $meta->user = $this->request->user;
        $meta->visit = $this->request->visit;
        $meta->call = $this->request->has('call');
        $meta->pre_authorization = $this->request->has('pre_authorization');
        $meta->book_for_doctor = $this->request->has('book_for_doctor');
        $meta->refer_specialist = $this->request->has('refer_specialist');
        if ($this->request->has('book_theatre')) {
            if (!$meta->book_theatre) {
                $this->book_for_theatre($meta);
            }
        }
        $meta->book_theatre = $this->request->has('book_theatre');
        return $meta->save();
    }

    /**
     * Book patient for theatre
     * @param VisitMeta $meta
     * @return bool
     */
    public function book_for_theatre(VisitMeta $meta)
    {
        $object = [
            'title' => 'Book patient for theatre',
            'message' => 'Book ' . $meta->visits->patients->fullname . ' to thetre',
            'link' => route('system.reception.checkin', $meta->visit->patients->patient_id),
            'group' => 'reception',
        ];
//@todo Send notification
        return true; //send_notification();
//return new \Dervis\Library\Notification($object);
    }

    /**
     * Checkout patient
     * @param null $data
     * @return bool
     * @deprecated Use checkout_patient instead
     */
    public function checkout($data = null)
    {
        $section = null;
        if ($this->request->ajax()) {
            $id = $this->request->id;
            $section = $this->request->from;
        }/* else {
          $id = $data['id'];
          $section = $data['from'];
          } */
        $id = $this->request->visit;
        $section = $this->request->section;

        //$visit = Visit::find($id);
        $destination = VisitDestinations::whereVisit($id)->whereDepartment(ucfirst($section))->first();
        $destination->checkout = 1;
        return $destination->update();
    }

    public function checkout_patient()
    {
        $result = VisitDestinations::updateOrCreate(
            ['visit' => $this->request->id, 'department' => $this->request->from],
            ['checkout' => true, 'finish_at' => Date::now()]);
        return response()->json(['result' => $result]);
    }

    /**
     * Saves a new procedure category model. Updates a model if ID is supplied in param
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function add_procedure_category()
    {
        return ProcedureCategories::updateOrCreate(['id' => $this->id], $this->input);
    }

    /**
     * Save procedure model instance
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function add_procedure()
    {
        DB::transaction(function () {
            $stack = self::order_item_stack(array_keys($this->request->all()));
            if ($this->request->id == "") {
                $procedure = new Procedures();
            } else {
                $procedure = Procedures::findOrNew($this->request->id);
            }
            $procedure->name = $this->request->name;
            $procedure->code = $this->request->code;
            $procedure->gender = $this->request->gender;
            if ($this->request->category) {
                $procedure->category = $this->request->category;
            }
            $procedure->description = $this->request->description;
            $procedure->cash_charge = $this->request->cash_charge;
            if ($this->request->has('insurance_charge'))
                $procedure->insurance_charge = $this->request->insurance_charge;

            if ($this->request->cash_charge_insurance > 0) {
                $procedure->charge_insurance = 1;
            }

            if (isset($this->request->precharge)) {
                $procedure->precharge = true;
            }

            $procedure->status = $this->request->status;
            $procedure->sensitivity = $this->request->sense;
            $procedure->save();

            if ($this->request->category == 4) {
                $this->saveSubProcedure($procedure->id, $this->request);
            }
            foreach ($stack as $index) {
                $item = 'item' . $index;
                $quantity = 'qty' . $index;
                $pr_items = new ProcedureInventoryItem();
                $pr_items->procedure = $procedure->id;
                $pr_items->item = $this->request->$item;
                $pr_items->units = $this->request->$quantity;
                $pr_items->save();
            }
        });

        return true;
    }

    public function saveSubProcedure($procedure, $request)
    {
        if (!$s = SubProcedures::whereProcedure($procedure)->first()) {
            $s = new SubProcedures;
        }
        $s->procedure = $procedure;
        if ($request->parent > 0) {
            $s->parent = $request->parent;
        }
        if ($request->lab_category > 0) {
            $s->category = $request->lab_category;
        }
        if ($this->request->title) {
            $s->title = $this->request->title;
        }
        $s->lab_result_type = $request->result_type;
        $s->lab_sample_type = $request->sample_type;
        $s->method = $request->method;
        $s->gender = $request->gender;
        $s->turn_around_time = $request->turn_around_time;
        $s->units = $request->units;

        $s->lab_result_options = json_encode($request->result_options);
        $s->lab_ordered_independently = $request->ordered_independently;
        $s->lab_multiple_orders_allowed = $request->multiple_orders_allowed;
        return $s->save();
    }

    /**
     * Build an index of items in dynamic LPO
     * @param $keys
     * @return array
     */
    private function order_item_stack($keys)
    {
        $stack = [];
        foreach ($keys as $one) {
            if (substr($one, 0, 4) == 'item') {
                $stack[] = substr($one, 4);
            }
        }
        return $stack;
    }

    /**
     * Create an interface to order previously missing tests or direct checkin to the section
     * @param $type
     * @return bool
     */
    public function order_evaluation($type)
    {
        foreach ($this->_get_selected_stack() as $index) {
            $item = 'item' . $index;
            $price = 'price' . $index;
            $discount = 'discount' . $index;
            $quantity = 'quantity' . $index;
            $amount = 'amount' . $index;

            Investigations::create([
                'visit' => $this->visit,
                'type' => $type,
                'user' => $this->user,
                'procedure' => $this->input[$item],
                'price' => $this->input[$price],
                'quantity' => $this->request->$quantity,
                'discount' => $this->request->$discount,
                'amount' => $this->request->$amount,
            ]);

            $procedure = Procedures::find($this->input[$item]);
            if (!$procedure->items->isEmpty()) {
                foreach ($procedure->items as $item) {
                    $adj = new \Ignite\Inventory\Entities\InventoryStockAdjustment;
                    $adj->quantity = $item->units;
                    $adj->user = \Auth::user()->id;
                    $adj->method = '-';
                    $adj->type = 'procedure_consumption';
                    $adj->reason = $type . ":-" . $procedure->name;
                    $adj->product = $item->inventory->id;
                    $adj->opening_qty = $this->inventoryRepository->openingStock($item->inventory->id);
                    $adj->save();
                    $this->inventoryRepository->adjust_stock($adj);
                }
            }
        }

        return true;
    }

    /**
     * Record preliminary eye examination
     * @return bool
     */
    public function save_preliminary_eye()
    {
        foreach ($this->input['entity'] as $key => $entity) {
            Preliminary::updateOrCreate(
                [
                    'entity' => $entity, 'visit' => $this->visit], ['left' => $this->input['left'][$key] ?: 0,
                'right' => $this->input['right'][$key] ?: 0,
                'user' => $this->user, 'remarks' => str_random()]);
        }
        return true;
    }


    /**
     * Add a partner institution to the database
     *
     */
    public function SavePartnerInstitution()
    {
        $partner = \Ignite\Evaluation\Entities\PartnerInstitution::findOrNew($this->request->id);
        $partner->name = ucfirst($this->request->name);
        $partner->address = $this->request->address;
        $partner->telephone = $this->request->telephone;
        $partner->mobile = $this->request->mobile;
        $partner->post_code = $this->request->post_code;
        $partner->email = $this->request->email;
        $partner->building = $this->request->building;
        $partner->fax = $this->request->fax;
        $partner->street = $this->request->street;
        $partner->town = $this->request->town;
        return $partner->save();
    }

    public function make_external_order(Request $request)
    {
        $order = new ExternalOrders;
        $order->patient_id = $request->patient_id;
        $order->institution = $request->institution;
        $order->user = $request->user()->id;
        $order->save();
        foreach ($this->_get_selected_stack() as $index) {
            $item = 'item' . $index;
            $type = 'type' . $index;
            $det = new ExternalOrderDetails;
            $det->order_id = $order->id;
            $det->procedure_id = $this->input[$item];
            $det->type = $this->input[$type];
            $det->save();
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function delete_title_lab(Request $request)
    {
        $tit = HaemogramTitle::find($request->id);
        return $tit->delete();
    }

    /**
     * @param Request $request
     * @return string
     */
    public function delete_lab_template_test(Request $request)
    {
        $test = TemplateLab::find($request->id);
        $test->delete();
        return 'Test has been removed from template'; //
    }

    /**
     * @return bool
     */
    public function request_service()
    {
        $selection = $this->_get_selected_stack();
        if (empty($selection)) {
            return false;
        }
        $this->visit = $this->anticipateVisit();
        foreach ($selection as $item) {
            Investigations::create([
                'type' => 'nursing',
                'visit' => $this->visit,
                'procedure' => $this->input['item' . $item],
                'quantity' => $this->input['qty' . $item],
                'price' => $this->input['price' . $item],
                'amount' => $this->input['price' . $item] * $this->input['qty' . $item],
                'instructions' => empty($this->input['instructions' . $item]) ? null : $this->input['instructions' . $item],
                'user' => $this->user,
                'ordered' => true
            ]);
        }
        $this->check_in_at('nursing');
        return true;
    }

    /**
     * @return int
     */
    private function anticipateVisit()
    {
        $today = Carbon::now()->startOfDay()->toDateTimeString();
        $visit = Visit::wherePatient($this->request->patient)
            ->where('created_at', '>', $today)
            ->first();
        if ($visit) {
            return $visit->id;
        }
        $visit = new Visit;
        $visit->patient = $this->request->patient;
        $visit->clinic = session('clinic', 1);

        $visit->payment_mode = $this->request->payment_method ?? 'cash';
        $visit->user = $this->request->user()->id;
        $visit->save();
        return $visit->id;
    }
}
