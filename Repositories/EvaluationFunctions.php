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

namespace Ignite\Evaluation\Repositories;

use Ignite\Evaluation\Entities\DiagnosisCodes;
use Ignite\Evaluation\Entities\DoctorNotes;
use Ignite\Evaluation\Entities\Drawings;
use Ignite\Evaluation\Entities\EyeExam;
use Ignite\Evaluation\Entities\Investigations;
use Ignite\Evaluation\Entities\OpNotes;
use Ignite\Evaluation\Entities\Prescriptions;
use Ignite\Evaluation\Entities\ProcedureCategories;
use Ignite\Evaluation\Entities\Procedures;
use Ignite\Evaluation\Entities\Treatment;
use Ignite\Evaluation\Entities\VisitMeta;
use Ignite\Evaluation\Entities\Visit;
use Ignite\Evaluation\Entities\Vitals;
use Ignite\Reception\Entities\Appointments;
use Ignite\Reception\Entities\Patients;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Jenssegers\Date\Date;

/**
 * Description of FunctionsRepository
 *
 * @author samuel
 */
class EvaluationFunctions implements EvaluationRepository {

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var array
     */
    protected $input;

    /**
     * @var mixed|int
     */
    protected $visit;

    /**
     * @var int
     */
    protected $user;

    /**
     * @var null|int
     */
    protected $id = null;

    /**
     * EvaluationFunctions constructor.
     * @param Request $request
     */
    public function __construct(Request $request) {
        $this->request = $request;
        $this->input = $request->all();
        if ($request->has('visit')) {
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
//$notes->investigation = $request->investigations;
        $notes->diagnosis = serialize($request->diagnosis);
//$notes->professional_history = $request->professional_history;
        $notes->visit = $request->visit;
        $notes->presenting_complaints = $request->presenting_complaints;
        $notes->past_medical_history = $request->past_medical_history;
//$notes->treatment_history = $request->drug_history;
        $notes->examination = $request->examination;
        $notes->treatment_plan = $request->treatment_plan;
        $notes->user = $request->user;
        $notes->save();
        if ($request->has('option')) {
            $this->save_eye_exam($request);
        }
    }

    public function save_eye_exam() {
// $pre_run = \Dervis\Model\Evaluation\EyeExam::whereVisit($request->visit)->delete();
//  dd($pre_run);
        foreach ($request->option as $key => $exam) {
            $eye = EyeExam::firstOrCreate(['option' => $exam, 'visit' => $request->visit]);
            $eye->od = $request->od[$key];
            $eye->os = $request->os[$key];
            $eye->comments = $request->comments[$key];
            $eye->user = $request->user()->id;
            $eye->save();
        }
        return true;
    }

    public function save_drawings() {
        $drawing = Drawings::findOrNew($request->visit);
        $drawing->object = serialize($request->objects);
        $drawing->user = $request->user()->id;
        $drawing->visit = $request->visit;
        if ($request->hasFile('image')) {
            $image = Image::make($request->file('image')->getRealPath());
            $_encode = $image/* ->fit(160, 160) */
                    ->encode('jpg');
            $stream = $_encode->stream();
            $drawing->background = base64_encode($stream);
        }
        $drawing->save();
    }

    /**
     * @param
     */
    public function save_treatment() {
        $id = 0;
        Treatment::whereVisit($request->visit)->whereIsPaid(false)->delete();
        foreach ($request->procedure as $treatment) {
            $record = new Treatment;
            $record->procedure = $treatment;
            $record->price = $request->price[$id];
            $record->base = $request->cost[$id];
            $record->visit = $request->visit;
            $record->user = $request->user()->id;
            $record->save();
            $id++;
        }
        return true;
    }

    public function save_diagnosis() {
        $id = 0;
        if ($request->has('procedure')) {
            Investigations::whereVisit($request->visit)->whereType($request->type)->whereIsPaid(false)
                    ->whereNull('results')->delete();
            foreach ($request->procedure as $treatment) {
                $record = new Investigations;
                $record->visit = $request->visit;
                $record->type = $request->type;
                $record->test = $treatment;
                $record->price = $request->cost[$id];
                $record->base = $request->price[$id];
                $record->instructions = $request->instructions[$id];
                $record->from_user = $request->user;
                $record->save();
                $id++;
            }
//@todo Remove patient in diagnostics queue if not booked
            $visit = Visit::find($request->visit);
            $type = $request->type;
            switch ($type) {
                case 'diagnosis':
                    $visit->diagnostics = true;
                    break;
                case 'laboratory':
                    $visit->laboratory = true;
                    break;
            }
// $visit->$type = true;
// @todo Add laboratory here
//dd($visit);
            return $visit->save();
        }
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
          $prescribe->drug = strtoupper($request->drug);
          $prescribe->take = $request->take;
          $prescribe->whereto = $request->prescription_whereto;
          $prescribe->method = $request->prescription_method;
          $prescribe->duration = $request->duration;
          $prescribe->visit = $request->visit;
          $prescribe->user = $request->user;
          if ($request->has('allow_substitution')) {
          $prescribe->allow_substitution = true;
          }
          return $prescribe->save(); */
    }

    /**
     * @param
     * @return mixed
     */
    public function save_opnotes() {
        $op = OpNotes::firstOrNew(['visit' => $request->visit]);
        $op->implants = $request->implants;
        $op->surgery_indication = $request->indication;
        $op->postop = $request->postop;
        $op->date = new Date($request->date . ' ' . $request->time);
        $op->doctor = $request->surgeon;
        $op->indication = $request->indication;
        $op->user = $request->user;
        $op->visit = $request->visit;
        return $op->save();
    }

    /**
     *
     * @param
     * @param type $id
     * @return boolean
     * @deprecated since version 1 New method available on the same class
     */
    public function sign_out_patient($id) {
        $visit = Visit::find($id);
        $to_up = Appointments::whereVisitId($visit->appointment);
        $to_up->update(['status' => 3]);
        $visit->sign_out = true;
        if ($visit->save()) {
            $request->session()->flash('success', 'Patient signed out');
            return true;
        } else {
            $request->session()->flash('error', 'An error occured');
        }
        return false;
    }

    public function set_next_visit() {
        $visit = Visit::findOrFail($request->visit);
        $this_appointment = $visit->appointments;
        if (empty($this_appointment->next_visit)) {
            $appointment = new Appointments;
        } else {
            $appointment = Appointments::findOrNew($this_appointment->next_visit);
        }
        $appointment->patient = $this_appointment->patient;
        $appointment->time = new Date($request->next_visit . ' 10:00');
        $appointment->procedure = $this_appointment->procedure;
        $appointment->doctor = $this_appointment->doctor;
        $appointment->status = 5;
        $appointment->instructions = $this_appointment->instructions;
        $appointment->payment_mode = $this_appointment->payment_mode;
        $appointment->clinic = $this_appointment->clinic;
        $appointment->category = $this_appointment->category;
        if ($appointment->save()) {
//dispatch(new \Dervis\Jobs\SendNotificationSMS($appointment->schedule_id), 'reminders');
//sendAppointmentNotification($appointment->id);
            $this_appointment->next_visit = $appointment->id;
            flash("Appointment has been saved");
            return $this_appointment->save();
        }
        flash()->error("An error occurred");
        return false;
    }

    public function set_visit_date() {
        $visit = Visit::find($request->visit);
        $visit->created_at = $request->visit_date;
        return $visit->save();
    }

    public function update_visit_meta() {
        $meta = VisitMeta::findOrNew($request->visit);
        $meta->user = $request->user;
        $meta->visit = $request->visit;
        $meta->call = $request->has('call');
        $meta->pre_authorization = $request->has('pre_authorization');
        $meta->book_for_doctor = $request->has('book_for_doctor');
        $meta->refer_specialist = $request->has('refer_specialist');
        if ($request->has('book_theatre')) {
            if (!$meta->book_theatre) {
                $this->book_for_theatre($meta);
            }
        }
        $meta->book_theatre = $request->has('book_theatre');
        return $meta->save();
    }

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

    public function checkout($data = null) {
        $id = $section = null;
        if ($request->ajax()) {
            $id = $request->id;
            $section = $request->from;
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

    public function order_evaluation($type) {
        foreach ($this->__get_selected_stack() as $index) {
            $item = 'item' . $index;
            $price = 'price' . $index;
            Investigations::create([
                'visit' => $this->visit,
                'type' => $type,
                'user' => $this->user,
                'test' => $this->input[$item],
                'price' => $this->input[$price],
                'base' => 0
            ]);
        }
        return true;
    }

    /**
     * Build an index of items dynamically
     * @param $keys
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
