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

use Ignite\Evaluation\Entities\DoctorNotes;
use Ignite\Evaluation\Entities\Drawings;
use Ignite\Evaluation\Entities\EyeExam;
use Ignite\Evaluation\Entities\Investigations;
use Ignite\Evaluation\Entities\OpNotes;
use Ignite\Evaluation\Entities\Prescriptions;
use Ignite\Evaluation\Entities\Treatment;
use Ignite\Evaluation\Entities\VisitMeta;
use Ignite\Evaluation\Entities\Visits;
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
     * @var mixed
     */
    protected $visit;

    /**
     * @var
     */
    protected $user;

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
        $this->user = $this->request->user()->id;
        $this->prepareInput($this->input);
    }

    /**
     * Remove the token from the input array
     * @param $input
     */
    private function prepareInput(&$input) {
        unset($input['_token']);
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
        $data['visits'] = Visits::wherePatient($patient)->get();
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
        $visit = new Visits;
        $visit->clinic = config('practice.clinic');
        $visit->patient = $appointment->patient;
        $visit->user = Auth::user()->user_id;
        $visit->appointment = $appointment->visit_id;
        $visit->save();
        return $visit->visit_id;
    }

    /**
     * Save patient vitals
     * @param Request $request
     */
    public function save_vitals() {
        $vital = Vitals::where('visit', $this->visit)->update($this->input);
        dd($vital);
        /* $vital->weight = $request->weight;
          $vital->height = $request->height;
          $vital->bp_systolic = $request->bp_systolic;
          $vital->bp_diastolic = $request->bp_diastolic;
          $vital->pulse = $request->pulse;
          $vital->respiration = $request->respiration;
          $vital->temperature = $request->temperature;
          $vital->temperature_location = $request->temperature_location;
          $vital->oxygen = $request->oxygen;
          $vital->hip = $request->hip;
          $vital->waist = $request->waist;
          $vital->blood_sugar = $request->blood_sugar;
          $vital->blood_sugar_units = $request->blood_sugar_unit;
          $vital->allergies = $request->allergies;
          $vital->chronic_illnesses = $request->chronic_illnesses;
          $vital->nurse_notes = $request->notes;
          $vital->user = $request->user()->id;
          return $vital->save(); */
    }

    /**
     * @param Request $request
     */
    public function save_notes(Request $request) {
        $notes = DoctorNotes::findOrNew($request->visit);
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

    public function save_eye_exam(Request $request) {
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

    public function save_drawings(Request $request) {
        $drawing = Drawings::findOrNew($request->visit);
        $drawing->object = serialize($request->objects);
        $drawing->user = $request->user()->id;
        $drawing->visit = $request->visit;
        if ($request->hasFile('image')) {
            $image = Image::make($request->file('image')->getRealPath());
            $_encode = $image/* ->fit(160, 160) */->encode('jpg');
            $stream = $_encode->stream();
            $drawing->background = base64_encode($stream);
        }
        $drawing->save();
    }

    /**
     * @param Request $request
     */
    public function save_treatment(Request $request) {
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

    public function save_diagnosis(Request $request) {
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
            $visit = Visits::find($request->visit);
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
     * @param Request $request
     * @return bool
     */
    public function save_prescriptions(Request $request) {
        if (empty($request->drug)) {
            return false;
        }
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
        return $prescribe->save();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function save_opnotes(Request $request) {
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
     * @param Request $request
     * @param type $visit_id
     * @return boolean
     * @deprecated since version 1 New method available on the same class
     */
    public function sign_out_patient(Request $request, $visit_id) {
        $visit = Visits::find($visit_id);
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

    public function set_next_visit(Request $request) {
        $visit = Visits::findOrFail($request->visit);
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

    public function set_visit_date(Request $request) {
        $visit = Visits::find($request->visit);
        $visit->created_at = $request->visit_date;
        return $visit->save();
    }

    public function update_visit_meta(Request $request) {
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

    public function checkout(Request $request, $data = null) {
        $visit_id = $section = null;
        if ($request->ajax()) {
            $visit_id = $request->id;
            $section = $request->from;
        } else {
            $visit_id = $data['id'];
            $section = $data['from'];
        }
        $visit = Visits::find($visit_id);
        $where = $section . '_out';
        $visit->$where = new Date();
        return $visit->save();
    }

    public function order_diagnosis(Request $request) {
        dd($request);
    }

}
