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
use Ignite\Evaluation\Entities\VisitMeta;
use Ignite\Evaluation\Entities\Visit;
use Ignite\Evaluation\Entities\Vitals;
use Ignite\Evaluation\Repositories\EvaluationRepository;
use Ignite\Reception\Entities\Appointments;
use Ignite\Reception\Entities\Patients;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Jenssegers\Date\Date;

/**
 * Description of FunctionsRepository
 *
 * @author samuel
 */
class EvaluationFunctions implements EvaluationRepository {

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
     */
    public function __construct(Request $request) {
        $this->request = $request;
        $this->input = $this->request->all();
        if ($this->request->has('visit')) {
            $this->visit = $this->request->visit;
        }
        if (Auth::check()) {
            $this->user = $this->request->user()->id;
        }
        $this->prepareInput($this->input);
    }

    /**
     * Remove the token from the input array
     * Also remove empty values
     * @param $input
     */
    private function prepareInput(&$input) {
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
     * @return int|null
     */
    public function save_results_investigations() {
        $set = $this->__get_selected_stack();
        foreach ($set as $item) {
            if (empty($this->input['results' . $item]))
                continue;
            $__in = InvestigationResult::firstOrNew(['investigation' => $item]);
            $__in->results = $this->input['results' . $item];
            if ($this->request->hasFile('file' . $item)) {
                $__in->file = base64_encode(file_get_contents($this->request->file['file' . $item]->getRealPath()));
            }
            $__in->user = $this->user;
            $__in->save();
        }
        return true;
    }

    /**
     * Create a central management for preemptive patient evaluation route
     * @param $patient_visit
     * @param bool $flag Switch to determine if we use the parameter patient_visit as either patient id or schedule id
     * @return array The associative array for patient record
     */
    public function patient_management($patient_visit, $flag = null) {
        $data = [];
        $data['schedule'] = $schedule = Appointments::findOrNew($patient_visit);
        $data['checked_in'] = empty($flag);
        $patient = empty($flag) ? $schedule->patient : $patient_visit;
        $data['visits'] = Visit::wherePatient($patient)->get();
        $data['patient'] = Patients::find($patient);
        return $data;
    }

    /**
     * Create a new visit incase it has not been setup yet
     * @param $schedule
     * @deprecated since version 1.4 The current model does not require to create an new visit. Can implement by type-hinting
     * @return int
     */
    public function create_new_visit($schedule) {
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
    public function save_vitals() {
        Vitals::firstOrCreate(['visit' => $this->visit]); //safety first
        return Vitals::where('visit', $this->visit)->update($this->input);
    }

    public function get_diagnosis_codes_auto() {
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
    public function save_notes() {
        dd($this->input);
        return DoctorNotes::updateOrCreate(['visit' => $this->visit], $this->input);
        dd($notes);
//$notes->investigation = $this->request->investigations;
        $notes->diagnosis = serialize($this->request->diagnosis);
//$notes->professional_history = $this->request->professional_history;
        $notes->visit = $this->request->visit;
        $notes->presenting_complaints = $this->request->presenting_complaints;
        $notes->past_medical_history = $this->request->past_medical_history;
//$notes->treatment_history = $this->request->drug_history;
        $notes->examination = $this->request->examination;
        $notes->treatment_plan = $this->request->treatment_plan;
        $notes->user = $this->request->user;
        $notes->save();
        if ($this->request->has('option')) {
            $this->save_eye_exam($this->request);
        }
    }

    public function save_eye_exam() {
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

    public function save_drawings() {
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
     * Check in patient to another section
     * @param $section
     * @return bool
     */
    private function check_in_at($section) {
        $visit = Visit::find($this->visit);
        switch ($section) {
            case 'diagnosis':
                $visit->diagnostics = true;
                break;
            case 'laboratory':
                $visit->laboratory = true;
                break;
            default :
                return;
        }
        return $visit->save();
    }

    /**
     * Save diagnosis
     * @return array
     */
    public function save_diagnosis() {
        DB::transaction(function () {
            foreach ($this->__get_selected_stack() as $treatment) {
                Investigations::create([
                    'type' => $this->input['type' . $treatment],
                    'visit' => $this->visit,
                    'procedure' => $treatment,
                    'price' => $this->input['price' . $treatment],
                    'instructions' => empty($this->input['instructions' . $treatment]) ? null : $this->input['instructions' . $treatment],
                    'user' => $this->user,
                    'ordered' => true
                ]);
                $this->check_in_at($this->input['type' . $treatment]);
            }
        });
        return ['result' => true];
    }

    /**
     * @param
     * @return bool
     */
    public function save_prescriptions() {
        dd($this->input);
        if (empty($this->request->drug)) {
            return false;
        }
        Prescriptions::create($this->input);
        /*
          $prescribe = new Prescriptions;
          $prescribe->drug = strtoupper($this->request->drug);
          $prescribe->take = $this->request->take;
          $prescribe->whereto = $this->request->prescription_whereto;
          $prescribe->method = $this->request->prescription_method;
          $prescribe->duration = $this->request->duration;
          $prescribe->visit = $this->request->visit;
          $prescribe->user = $this->request->user;
          if ($this->request->has('allow_substitution')) {
          $prescribe->allow_substitution = true;
          }
          return $prescribe->save(); */
    }

    /**
     * Save the op notes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function save_opnotes() {
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

    /**
     * Set manual visit date especially for back-dating
     * @return bool
     */
    public function set_visit_date() {
        $visit = Visit::find($this->request->visit);
        $visit->created_at = $this->request->visit_date;
        return $visit->save();
    }

    /**
     * Update visit meta.inf
     * @return bool
     */
    public function update_visit_meta() {
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
    public function book_for_theatre(VisitMeta $meta) {
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
     */
    public function checkout($data = null) {
        $id = $section = null;
        if ($this->request->ajax()) {
            $id = $this->request->id;
            $section = $this->request->from;
        } else {
            $id = $data['id'];
            $section = $data['from'];
        }
        $visit = Visit::find($id);
        $where = $section . '_out';
        $visit->$where = new Date();
        return $visit->save();
    }

    /**
     * Saves a new procedure category model. Updates a model if ID is supplied in param
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function add_procedure_category() {
        return ProcedureCategories::updateOrCreate(['id' => $this->id], $this->input);
    }

    /**
     * Save procedure model instance
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function add_procedure() {
        return Procedures::updateOrCreate(['id' => $this->id], $this->input);
    }

    /**
     * Create an interface to order previously missing tests or direct checkin to the section
     * @param $type
     * @return bool
     */
    public function order_evaluation($type) {
        foreach ($this->__get_selected_stack() as $index) {
            $item = 'proc_item' . $index;
            $price = 'proc_price' . $index;
            Investigations::create([
                'visit' => $this->visit,
                'type' => $type,
                'user' => $this->user,
                'procedure' => $this->input[$item],
                'price' => $this->input[$price],
            ]);
        }
        return true;
    }

    /**
     * Record preliminary eye examination
     * @return bool
     */
    public function save_preliminary_eye() {
        foreach ($this->input['entity'] as $key => $entity) {
            Preliminary::updateOrCreate(
                    [
                'entity' => $entity, 'visit' => $this->visit], ['left' => $this->input['left'][$key] ? : 0,
                'right' => $this->input['right'][$key] ? : 0,
                'user' => $this->user, 'remarks' => str_random()]);
        }
        return true;
    }

    /**
     * Build an index of items dynamically
     * @return array
     */
    private function __get_selected_stack() {
        $stack = [];
        foreach ($this->input as $key => $one) {
            if (starts_with($key, 'item')) {
                $stack[] = substr($key, 4);
            }
        }
        return $stack;
    }

}
