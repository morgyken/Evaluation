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

namespace Ignite\Evaluation\Library;

use Ignite\Evaluation\Entities\EyeExam;
use Ignite\Evaluation\Entities\OP;
use Ignite\Evaluation\Entities\PatientDiagnosis;
use Ignite\Evaluation\Entities\PatientDrawings;
use Ignite\Evaluation\Entities\PatientPrescriptions;
use Ignite\Evaluation\Entities\PatientTreatment;
use Ignite\Evaluation\Entities\VisitMeta;
use Illuminate\Http\Request;
use Ignite\Reception\Entities\Patients;
use Ignite\Evaluation\Entities\PatientVisits;
use Ignite\Evaluation\Entities\PatientVitals;
use Ignite\Reception\Entities\Appointments;
use Ignite\Evaluation\Entities\PatientDoctorNotes;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Jenssegers\Date\Date;

/**
 * Description of EvaluationFunctions
 *
 * @author Samuel Dervis <samueldervis@gmail.com>
 */
class EvaluationFunctions {

    /**
     * Create a central management for preemptive patient evaluation route
     * @param $patient_visit
     * @param bool $flag Switch to determine if we use the parameter patient_visit as either patient id or schedule id
     * @return array The associative array for patient record
     */
    public static function patient_management($patient_visit, bool $flag = null) {
        $data = [];
        $data['schedule'] = $schedule = Appointments::findOrNew($patient_visit);
        $data['checked_in'] = empty($flag);
        $patient = empty($flag) ? $schedule->patient : $patient_visit;
        $data['visits'] = PatientVisits::wherePatient($patient)->get();
        $data['patient'] = Patients::find($patient);
        return $data;
    }

    /**
     * Create a new visit incase it has not been setup yet
     * @param $schedule
     * @deprecated since version 1.4 The current model does not require to create an new visit. Can implement by type-hinting
     * @return int
     */
    public static function create_new_visit($schedule) {
        $appointment = Appointments::find($schedule);
        $visit = new PatientVisits;
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
    public static function save_vitals(Request $request) {
        $vital = PatientVitals::findOrNew($request->visit);
        $vital->visit = $request->visit;
        $vital->weight = $request->weight;
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
        return $vital->save();
    }

    /**
     * @param Request $request
     */
    public static function save_notes(Request $request) {
        $notes = PatientDoctorNotes::findOrNew($request->visit);
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
            save_eye_exam($request);
        }
    }

    public static function save_eye_exam(Request $request) {
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

    public static function save_drawings(Request $request) {
        $drawing = PatientDrawings::findOrNew($request->visit);
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
    public static function save_treatment(Request $request) {
        $id = 0;
        PatientTreatment::whereVisit($request->visit)->whereIsPaid(false)->delete();
        foreach ($request->procedure as $treatment) {
            $record = new PatientTreatment;
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

    public static function save_diagnosis(Request $request) {
        $id = 0;
        if ($request->has('procedure')) {
            PatientDiagnosis::whereVisit($request->visit)->whereType($request->type)->whereIsPaid(false)
                    ->whereNull('results')->delete();
            foreach ($request->procedure as $treatment) {
                $record = new PatientDiagnosis;
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
            $visit = PatientVisits::find($request->visit);
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
    public static function save_prescriptions(Request $request) {
        if (empty($request->drug)) {
            return false;
        }
        $prescribe = new PatientPrescriptions;
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
    public static function save_opnotes(Request $request) {
        $op = OP::firstOrNew(['visit' => $request->visit]);
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
    public static function sign_out_patient(Request $request, $visit_id) {
        return true;
        $visit = PatientVisits::find($visit_id);
        $to_up = Appointments::whereVisitId($visit->appointment);
//var_dump($request);
        $to_up->update(['status' => 3]);
// dd($to_up);
        $visit->sign_out = true;
        if ($visit->save()) {
            $request->session()->flash('success', 'Patient signed out');
            return true;
        } else {
            $request->session()->flash('error', 'An error occured');
        }
        return false;
    }

    public static function set_next_visit(Request $request) {
        $visit = PatientVisits::findOrFail($request->visit);
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

    public static function set_visit_date(Request $request) {
        $visit = PatientVisits::find($request->visit);
        $visit->created_at = $request->visit_date;
        return $visit->save();
    }

    public static function update_visit_meta(Request $request) {
        $meta = VisitMeta::findOrNew($request->visit);
        $meta->user = $request->user;
        $meta->visit = $request->visit;
        $meta->call = $request->has('call');
        $meta->pre_authorization = $request->has('pre_authorization');
        $meta->book_for_doctor = $request->has('book_for_doctor');
        $meta->refer_specialist = $request->has('refer_specialist');
        if ($request->has('book_theatre')) {
            if (!$meta->book_theatre) {
                book_for_theatre($meta);
            }
        }
        $meta->book_theatre = $request->has('book_theatre');
        return $meta->save();
    }

    public static function book_for_theatre(VisitMeta $meta) {
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

    public static function checkout(Request $request, $data = null) {
        $visit_id = $section = null;
        if ($request->ajax()) {
            $visit_id = $request->id;
            $section = $request->from;
        } else {
            $visit_id = $data['id'];
            $section = $data['from'];
        }
        $visit = PatientVisits::find($visit_id);
        $where = $section . '_out';
        $visit->$where = new Date();
        return $visit->save();
    }

    public static function order_diagnosis(Request $request) {
        dd($request);
    }

}
