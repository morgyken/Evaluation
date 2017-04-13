<?php

namespace Ignite\Evaluation\Http\Controllers;

use Ignite\Core\Http\Controllers\AdminBaseController;
use Ignite\Evaluation\Entities\Formula;
use Ignite\Evaluation\Entities\Prescriptions;
use Ignite\Evaluation\Entities\Sample;
use Ignite\Evaluation\Entities\Admission;
use Ignite\Evaluation\Entities\Bed;
use Ignite\Evaluation\Entities\Deposit;
use Ignite\Evaluation\Entities\FinancePatientAccounts;
use Ignite\Evaluation\Entities\Patient_vital;
use Ignite\Evaluation\Entities\PatientAccount;
use Ignite\Evaluation\Entities\Request_admission;
use Ignite\Evaluation\Entities\RequestAdmission;
use Ignite\Evaluation\Entities\Visit;
use Ignite\Evaluation\Entities\VisitDestinations;
use Ignite\Evaluation\Entities\Vitals;
use Ignite\Evaluation\Entities\Ward;
use Ignite\Evaluation\Repositories\EvaluationRepository;
use Ignite\Reception\Entities\Patients;
use Ignite\Evaluation\Entities\ExternalOrders;
use Ignite\Evaluation\Entities\Procedures;
use Ignite\Users\Entities\Roles;
use Ignite\Users\Entities\User;
use Ignite\Users\Entities\UserRoles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Zend\Validator\File\Count;

class EvaluationController extends AdminBaseController {

    /**
     * @var EvaluationRepository
     */
    protected $evaluationRepository;

    /**
     * EvaluationController constructor.
     * @param EvaluationRepository $evaluationRepository
     */
    public function __construct(EvaluationRepository $evaluationRepository) {
        parent::__construct();
        $this->evaluationRepository = $evaluationRepository;
        $this->__require_assets();
    }

    public function queues($department) {
        $this->data['all'] = Visit::checkedAt($department)
                ->whereHas('destinations', function($query) {
                    $query->whereCheckout(0);
                })
                ->orderBy('created_at', 'asc')
                ->get();

        $this->data['referer'] = \URL::previous();
        $this->data['department'] = ucwords($department);

        $user = \Auth::user()->id;
        if ($department == 'doctor') {
            $this->data['doc'] = 1;
        }
        $this->data['myq'] = VisitDestinations::whereDestination($user)
                ->whereCheckout(0)
                ->oldest()
                ->get();

        return view('evaluation::queues', ['data' => $this->data]);
    }

    public function preview($visit, $department) {
        $this->data['visit'] = Visit::find($visit);
        $this->data['patient'] = $this->data['visit']->patients;
        $this->data['department'] = $department;
        $this->data['history'] = Visit::wherePatient($this->data['patient']->id)->where('id', '<>', $visit)->get();
        return view('evaluation::preview', ['data' => $this->data]);
    }

    public function evaluate($visit, $section) {
        try {
            $this->data['all'] = Visit::checkedAt('diagnostics')->get();
            $this->data['visit'] = Visit::find($visit);
            $this->data['section'] = $section;
            $this->data['nursing_procedures'] = Procedures::whereCategory(6)->get();

            $this->data['drug_prescriptions'] = Prescriptions::whereVisit($visit)
                    ->whereStatus(0)
                    ->get();
            session(['v' => $visit]);
            $this->data['dispensed'] = Prescriptions::whereHas('dispensing', function ($query) {
                        $query->whereHas('visits', function ($q) {
                            $q->whereId(\Session::get('v'));
                        });
                    })->get();

            $this->data['investigations'] = \Ignite\Evaluation\Entities\Investigations::whereVisit($visit)->get();
            return view("evaluation::patient_$section", ['data' => $this->data]);
        } catch (\Exception $ex) {
            flash('There was a problem evaluating the patient', 'error');
            return back();
        }
    }
    public function pharmacy($id) {
        $this->data['visit'] = $v = Visit::find($id);
        $this->data['patient'] = Patients::find($v->patient);
        $this->data['section'] = 'pharmacy';
        $this->data['drug_prescriptions'] = Prescriptions::whereVisit($id)->get();
        //$this->data['dispensed'] = \Ignite\Evaluation\Entities\Dispensing::whereVisit($id)->get();
        return view('evaluation::patient_pharmacy', ['data' => $this->data]);
    }

    public function labotomy(Request $request) {
        $sample = new Sample();
        $sample->patient_id = $request->patient;
        $sample->visit_id = $request->visit;
        $sample->type_id = $request->type;
        $sample->details = $request->details;
        $sample->collection_method_id = $request->collection_method;
        $sample->save();
        flash("Sample collected successfully", "success");
        return back();
    }

    public function Formulae(Request $request) {
        foreach ($request->formular as $key => $value) {
            if (!empty($value)) {
                $formula = new Formula();
                $formula->procedure_id = $request->procedure;
                $formula->test_id = $request->test[$key];
                $formula->formula = $value;
                $formula->save();
            }
        }
        flash("Formula saved successfully", "success");
        return back();
    }

    public function labotomy_print() {
        //return $this->assetManager;
    }

    public function pharmacy_prescription() {
        if ($this->evaluationRepository->save_prescriptions()) {
            flash('Prescription saved');
        } else {
            flash('Prescription could not be saved', 'warning');
        }
        return back();
    }

    public function pharmacy_dispense() {
        if ($this->evaluationRepository->dispense()) {
            flash('Drugs dispensed, thank you', 'success');
        } else {
            flash('Drug(s) could not be dispensed', 'warning');
        }
        return back();
    }

    public function sign_out(Request $request, $visit_id, $section) {
        $checkout = $this->evaluationRepository->checkout($request, ['id' => $visit_id, 'from' => $section]);
        if ($checkout) {
            flash('Patient checked out from ' . ucfirst($section));
        } else {
            flash('Patient could not be checked out.' . ucfirst($section));
        }
        if ($section == 'evaluation') {
            $section = 'doctor';
        }

        return redirect()->back();
    }

    public function review() {
        $this->data['patients'] = Patients::whereHas('visits', function ($query) {

                })->get();
        return view('evaluation::reviews', ['data' => $this->data]);
    }

    public function review_patient($patient) {
        $this->data['visits'] = Visit::wherePatient($patient)->get();
        return view('evaluation::patient_review', ['data' => $this->data]);
    }

    public function patient_visits($id) {
        $this->data['visits'] = Visit::wherePatient($id)->get();
        $this->data['patient'] = Patients::find($id);
        return view('evaluation::patient_visits', ['data' => $this->data]);
    }

    public function investigation_result() {
        $story = $this->evaluationRepository->save_results_investigations();
        if ($story) {
            flash('Investigation result posted', 'success');
        } else {
            flash('Uh, Oh. Something wrong happened, retry');
        }
        return back();
    }

    public function view_result($visit) {
        $this->data['visit'] = Visit::find($visit);
        $this->data['results'] = Visit::find($visit)->investigations->where('has_result', true);
        return view('evaluation::partials.doctor.results', ['data' => $this->data]);
    }

    private function __require_assets() {
        $assets = [
            'doctor-investigations.js' => m_asset('evaluation:js/doctor-investigations.js'),
            'doctor-treatment.js' => m_asset('evaluation:js/doctor-treatment.js'),
            'doctor-next-steps.js' => m_asset('evaluation:js/doctor-next-steps.min.js'),
            'doctor-notes.js' => m_asset('evaluation:js/doctor-notes.min.js'),
            'doctor-opnotes.js' => m_asset('evaluation:js/doctor-opnotes.min.js'),
            'doctor-prescriptions.js' => m_asset('evaluation:js/doctor-prescriptions.min.js'),
            'doctor-visit-date.js' => m_asset('evaluation:js/doctor-set-visit-date.min.js'),
            'nurse-vitals.js' => m_asset('evaluation:js/nurse-vitals.min.js'),
            //'order-investigation.js' => m_asset('evaluation:js/doctor-treatment.min.js'),
            'nurse_eye_preliminary.js' => m_asset('evaluation:js/nurse_eye_preliminary.min.js'),
        ];
        foreach ($assets as $key => $asset) {
            $this->assetManager->addAssets([$key => $asset]);
            $this->assetPipeline->requireJs($key);
        }
    }

    public function cancelPresc(Request $request) {
        try {
            $presc = Prescriptions::find($request->id);
            $presc->status = 0;
            $presc->save();
            $disp = \Ignite\Evaluation\Entities\Dispensing::wherePrescription($request->id)->get();
            foreach ($disp as $d) {
                $d->delete();
            }
            flash('prescription cancelled', 'success');
        } catch (\Exception $ex) {
            flash('prescription could NOT cancelled', 'danger');
        }
        return back();
    }

    public function VerifyLabResult(Request $request) {
        try {
            $this->updateResultStatus($request, 1, 'Verification');
            flash('Result status has been updated... thank you', 'success');
            return back();
        } catch (\Exception $e) {
            flash('Result status could not be updated... please try again', 'danger');
            return back();
        }
    }

    public function PublishLabResult(Request $request) {
        try {
            $this->updateResultStatus($request, 2, 'Publication');
            flash('Result status has been updated... thank you', 'success');
            return back();
        } catch (\Exception $e) {
            flash('Result status could not be updated... please try again', 'danger');
            return back();
        }
    }

    public function SendLabResult(Request $request) {
        try {
            $this->updateResultStatus($request, 3, 'Sent');
            flash('Test Result has been marked as sent... thank you', 'success');
            return back();
        } catch (\Exception $e) {
            flash('Result could not be sent... please try again', 'danger');
            return back();
        }
    }

    public function RejectLabResult(Request $request) {
        try {
        $result = \Ignite\Evaluation\Entities\InvestigationResult::find($request->result);

        $purged_results = json_decode($result->results);
        $test = array();
        $res = array();
        try{
            foreach ($purged_results as $r) {
                $test[] = $r[0];
                $res[] = $r[1];
            }
        }catch (\Exception $e){

        }
        session(['last_reverted' => array_combine($test, $res)]);
        $result->delete(); //send back to test phase literally
        flash('Result status has been reverted... thank you', 'success');
        return back();
         } catch (\Exception $exc) {
          flash('Result status could not be updated... please try again', 'danger');
          return back();
         }
    }

    public function RevertResult(Request $request) {
        try {
            $result = \Ignite\Evaluation\Entities\InvestigationResult::find($request->result);
            //$purged_results = json_decode($result->results);
            session(['last_reverted' => array_combine(array($result->investigation), array($result->results))]);
            $result->delete(); //send back to test phase literally
            flash('Result status has been reverted... thank you', 'success');
            return back();
        } catch (\Exception $exc) {
            flash('Result status could not be reverted... please try again', 'danger');
            return back();
        }
    }

    public function updateResultStatus(Request $request, $flag, $type) {
        try {
            $result = \Ignite\Evaluation\Entities\InvestigationResult::find($request->result);
            $result->status = $flag;
            $result->save();

            $status_change = new \Ignite\Evaluation\Entities\LabResultStatusChange;
            $status_change->user = auth()->id();
            $status_change->result = $request->result;
            $status_change->result = $request->result;
            $status_change->type = $type;
            $status_change->reason = $request->reason ? $request->reason : '';
            $status_change->save();

            flash('Result status has been updated... thank you', 'success');
            return back();
        } catch (\Exception $exc) {
            flash('Result status could not be updated... please try again', 'danger');
            return back();
        }
    }

    /*In patient functions*/
    public function admit()
    {
        $patientIds = RequestAdmission::where('id','!=',null)->get(['patient_id'])->toArray();
        $patients = RequestAdmission::all();
        return view('evaluation::inpatient.admit_patient',compact('patients'));
    }

 public function admit_patient($id,$visit_id)
    {
        $doctor_rule = Roles::where('name','Doctor')->first();
        $doctor_ids = UserRoles::where('role_id',$doctor_rule->id)->get(['user_id'])->toArray();
        $doctors = User::findMany($doctor_ids);


        $patient = Patients::find($id);
        $visit = Visit::find($visit_id);
        $wards = Ward::all();
        $deposits = Deposit::all();
        return view('evaluation::inpatient.admit_form',compact('doctors','patient','wards','deposits','visit'));
    }
    public function post_admit_patient(Request $request)
    {//add a patient
        Patients::create($request->all());
      return redirect('/evaluation/inpatient/admit')->with('success','Successfully admitted a patient');

    }
    public function listWards()
    {
        $wards = Ward::all();
        return view('Evaluation::inpatient.listWards',compact('wards'));
    }
    public function addWard()
    {
        return view('Evaluation::inpatient.addWardForm');
    }
    public function addwordFormPost(Request $request)
    {
        Ward::create($request->all());
        return redirect('/evaluation/inpatient/list')->with('success','successfully added a ward');
    }

//list the beds
    public function listBeds()
    {
        $wards = Ward::all();
        $beds = Bed::all();
        return view('Evaluation::inpatient.listBeds',compact('beds','wards'));
    }
    public function addBedFormPost(Request $request)
    {
        $request['status'] = 'available';
        Bed::create($request->all());
        return redirect()->back()->with('success','successfully added a bed');
    }
    public function availableBeds($wardId)
    {
        $beds = Bed::where('status','available')->where('ward_id',$wardId)->get();
        return ($beds);
    }
    public function admit_patient_Post(Request $request)
    {
        if(count(FinancePatientAccounts::where('patient',$request->patient_id)->get())){
            $patientAcc =FinancePatientAccounts::where('patient',$request->patient_id)->first();
        }else{
            $validator = Validator::make($request->all(),
                []);
            $validator->errors()->add('deposit','Please top up your account');
            return redirect()->back()->withErrors($validator);
        }

//        $patientAcc -> update(['balance'=>$patientAcc->balance - $request->amount]);

        if($request->admission_doctor == 'other'){
            $request['external_doctor'] = $request->external_doc;
            $request['doctor_id'] = null;
        }else{
            $request['external_doctor'] = null;
            $request['doctor_id'] = $request['admission_doctor'];
        }
        if(count(RequestAdmission::where('patient_id',$request->patient_id)->get())){
            $request_admission = RequestAdmission::where('patient_id',$request->patient_id)->first();
            $request_admission->delete();
        }
        if(count(Visit::where('patient',$request->patient_id)->get())){
            $v = Visit::where('patient',$request->patient_id)->first();
            $v->delete();
        }
        /*apply charges*/
        if($request->payment_mode == 'cash'){
            $depo_cost = Deposit::find($request->deposit);
            $ward_cost = Ward::find($request->ward_id);


            FinancePatientAccounts::create([
                'debit' =>$depo_cost->cost,
                'credit' => 0.00,
                'details' => 'Charged for '.$depo_cost->name,
                'reference' => 'deposit_charge_'.str_random(5),
                'patient' => $request->patient_id
        ]);
            FinancePatientAccounts::create([
                'debit' =>$ward_cost->cost,
                'credit' => 0.00,
                'details' => 'Charged for ward'.$ward_cost->name,
                'reference' => 'Ward_charge'.str_random(5),
                'patient' => $request->patient_id
        ]);
            $request['cost'] = $depo_cost->cost + $ward_cost->cost;
            /*debit the patient account*/
            $acc = PatientAccount::where('patient_id',$request->patient_id)->first();
            $acc->update(['balance' => $acc->balance - $request['cost']]);

        }
        Admission::create($request->all());
        return redirect('/evaluation/inpatient/admissions')->with('success','Successfully admitted a patient');
    }
    public function admissionList()
    {
        $admissions = Admission::all();
      return view('Evaluation::inpatient.admissionList',compact('admissions'));
    }
    public function managePatient($id)
    {
        $patient = Patients::find($id);
        $admission = Admission::where('patient_id',$id)->first();
        $ward = Admission::where('patient_id',$id)->orderBy('created_at','desc')->first();
        ///the vitals taken during visits
        /*all the visits for this patient*/
        $vitals = null;
        $doctor_note = null;
        if(count(Visit::where('patient',$id)->orderBy('created_at','desc')->get())>0){
            $visit_id = Visit::where('patient',$id)->orderBy('created_at','desc')->first()->id;
            $vitals = Vitals::where('visit',$visit_id)->get();
            $doctor_note = DoctorNotes::where('visit',$visit_id)->first();
        }
        return view('Evaluation::inpatient.manage_patient',compact('patient','admission',
            'ward','vitals','doctor_note'));
    }
    public function recordVitals(Request $request)
    {
        Vitals::create($request->all());
        return redirect()->back()->with('success','Recorded patient\'s vitals successfully.');
    }
    public function admitAwaiting()
    {
        $patient_awaiting = Visit::where('inpatient','on')->get();
        return view('Evaluation::inpatient.admitAwaiting',compact('patient_awaiting'));
    }
    public function admit_patientPostForm(Request $request)
    {
        ///waiting admission queue.
        //charge the patient
        RequestAdmission::create($request->all());
     return redirect('/evaluation/inpatient/admit')->with('success','successfully requested for admission');
    }
    public function delete_ward(Request $request)
    {
        $ward = Ward::findorfail($request->ward_id);
            $ward->delete();
        return redirect()->back()->with('success','successfully deleted the ward');
    }
    public function delete_bed(Request $request)
    {
        $ward = Bed::findorfail($request->bed_id);
            $ward->delete();
        return redirect()->back()->with('success','successfully deleted the bed');
    }
    public function deposit()
    {
        $deposits = Deposit::all();
        return view('Evaluation::inpatient.deposit',compact('deposits'));
    }
    public function addDepositType(Request $request)
    {
        Deposit::create($request->all());
        return redirect()->back()->with('success','successfully added a new deposit type');
    }
    public function delete_deposit(Request $request)
    {
        $d = Deposit::find($request->deposit_id);
        $d->delete();
        return redirect()->back()->with('success','Successfully deleted');
    }
    public function admit_check(Request $request)
    {
        $account_balance = PatientAccount::where('patient_id',$request->patient_id)->first();

        if(count($account_balance)){
            $account_balance = $account_balance->balance;
        }else{
            $account_balance = 0;
        }
        /*get the cost of the ward..*/
        $ward_cost = Ward::find($request->ward_id)->cost;

        $deposit_amount = Deposit::find($request->depositTypeId)->cost;
        if($account_balance < ($deposit_amount + $ward_cost)){
            return array('status'=>'insufficient','description'=>'Your account balance is less than the deposit');
        }
        return array('status'=>'sufficient','description'=>'Your account balance is sufficient');
    }
    public function topUp()
    {
        $patients = Patients::all();
        $deposits = FinancePatientAccounts::where('credit','>',0)->get();
        return view('Evaluation::inpatient.topUp',compact('patients','deposits'));
    }
    public function topUpAmount(Request $request)
    {
        if(count(PatientAccount::where('patient_id',$request->patient_id)->get())){
            $patient = PatientAccount::where('patient_id',$request->patient_id)->first();
                $patient->update(['balance'=>$patient->balance + $request->amount]);
        }else{
            $request['balance']  = $request->amount;
            $patient = PatientAccount::create($request->all());
        }

        $request['patient'] = $request->patient_id;
        $request['reference'] = 'deposit_'.str_random(5);
        $request['details'] = 'deposit to patient\' account';
        $request['debit'] = 0.00;
        $request['credit'] = $request['amount'];

        $depo = FinancePatientAccounts::create($request->all());
        $balance = $patient->balance;
        $patient = (Patients::find($patient->patient_id));
        $request['depo'] = $depo;
        $request['balance'] = $balance;
        $request['patient'] = $patient;
        $amount = $request['amount'];


        $tras = $depo;
/*
//        return view('Evaluation::inpatient.print.topUpSlip',compact('tras','patient','balance','amount'));
        $pdf = \PDF::loadView('Evaluation::inpatient.print.topUpSlip',['tras'=>$tras,'patient'=>$patient,'balance'=>$balance,'amount'=>$amount]);
        $pdf->setPaper('a4','Landscape');
        return $pdf->stream('Deposit_slip'.str_random(4).'.pdf');





        $pdf = \PDF::loadView('finance::prints.bill', ['bill' => $bill, 'sold' => $sold]);
        $pdf->setPaper('a4', 'Landscape');
        return $pdf->stream('Bill' . $request->id . '.pdf');*/


        return view('Evaluation::inpatient.deposit_slip',compact('patient','depo','balance'));
    }
    public  function withdraw()
    {
        $patients  = Patients::all();
        $deposits = FinancePatientAccounts::where('debit','>',0)->get();
        return view('Evaluation::inpatient.withdraw',compact('deposits','patients'));
    }
    public function WithdrawAmount(Request $request)
    {
        //search for the account..
        if(count(PatientAccount::where('patient_id',$request->patient_id)->get())){
            $patient_acc = PatientAccount::where('patient_id',$request->patient_id)->first();
            $account_balance = $patient_acc->balance;
        }else{
            $account_balance = 0;
        }
        if($request->amount > $account_balance){
            $validator =Validator::make($request->all(),
                ['amount'=>'required']);
            $validator->errors()
                ->add('amount','Insufficient fund in your account to withdraw Kshs. '.$request->amount);
        return redirect()->back()->withErrors($validator);
        }
        //reduce the amount
        $patient_acc->update(['balance'=>$account_balance-$request->amount]);

       $wit =  FinancePatientAccounts::create([
           'reference'=>'withdraw_'.str_random(5),
            'details'=>'withdraw amount from patient account',
            'debit' => $request->amount,
            'credit' => 0.00,
            'patient' => $request->patient_id
        ]);
        $patient = Patients::find($request->patient_id);
       $balance = $patient_acc->balance;
        return view('Evaluation::inpatient.withdraw_slip',compact('patient','wit','balance'));
    }
    public function editBed($id)
    {
        $bed = Bed::findorfail($id);
        return $bed;
    }
    public function edit_bed(Request $request)
    {
        $bed = Bed::find($request->bed_id);
        $bed->update([
           'number' => $request->bed_no,
            'type' => $request->bed_type,
            'ward' => $request->ward
        ]);
        return redirect()->back()->with('success','Successfully edited a bed');
    }
    public function cancel_checkin(Request $request)
    {
        $v =Visit::find($request->id);
        if( count($v)){
            $v->delete();
        }
         return '';
    }
    public function edit_deposit($id)
    {
        return Deposit::find($id);
    }
    public function deposit_adit(Request $request)
    {
        $dep = Deposit::find($request->deposit_id);
        $request['name'] = $request->deposit;
        $dep->update($request->all());
        return redirect()->back()->with('success','updated deposit successfully');
    }
    public function topUpAccount(Request $request)
    {
        $acc = PatientAccount::where('patient_id',$request->patient_id)->first();
        /*record this trans.*/
        FinancePatientAccounts::create([
            'reference' => 'Deposit_'.str_random(5),
            'details' => 'Deposit to patient account',
            'credit' => 0.00,
            'debit' => $request->amount,
            'patient' => $request->patient_id,
        ]);

        $acc->update(['balance'=>$acc->balance + $request->amount]);
        return redirect()->back()->with('success','successfully topped up patient account');
    }
}
