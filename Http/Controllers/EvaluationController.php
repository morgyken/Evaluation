<?php

namespace Ignite\Evaluation\Http\Controllers;

use Ignite\Core\Http\Controllers\AdminBaseController;
use Ignite\Evaluation\Entities\Admission;
use Ignite\Evaluation\Entities\Bed;
use Ignite\Evaluation\Entities\Bedposition;
use Ignite\Evaluation\Entities\Deposit;
use Ignite\Evaluation\Entities\FinancePatientAccounts;
use Ignite\Evaluation\Entities\Formula;
use Ignite\Evaluation\Entities\InvestigationResult;
use Ignite\Evaluation\Entities\Investigations;
use Ignite\Evaluation\Entities\NursingCharge;
use Ignite\Evaluation\Entities\Patient_vital;
use Ignite\Evaluation\Entities\PatientAccount;
use Ignite\Evaluation\Entities\Prescriptions;
use Ignite\Evaluation\Entities\Procedures;
use Ignite\Evaluation\Entities\Request_admission;
use Ignite\Evaluation\Entities\Sample;
use Ignite\Evaluation\Entities\Visit;
use Ignite\Evaluation\Entities\VisitDestinations;
use Ignite\Evaluation\Entities\Ward;
use Ignite\Evaluation\Entities\WardAssigned;
use Ignite\Evaluation\Repositories\EvaluationRepository;
use Ignite\Inpatient\Entities\DischargeType;
use Ignite\Inpatient\Repositories\AdmissionTypeRepository;
use Ignite\Inventory\Entities\Store;
use Ignite\Inventory\Entities\StoreDepartment;
use Ignite\Inventory\Entities\StorePrescription;
use Ignite\Reception\Entities\Patients;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Ignite\Evaluation\Entities\Facility;

class EvaluationController extends AdminBaseController
{

    /**
     * @var EvaluationRepository
     */
    protected $evaluationRepository, $admissionTypeRepository;

    /**
     * EvaluationController constructor.
     * @param EvaluationRepository $evaluationRepository
     */
    public function __construct(EvaluationRepository $evaluationRepository)
    {
        parent::__construct();
        $this->evaluationRepository = $evaluationRepository;


        $this->_require_assets();
    }

    public function queues($department)
    {
        if(!session()->has('department_id') and !session()->has('store_id') and $department === 'pharmacy')
        {
            $departments = StoreDepartment::all();

            $stores = Store::all();

            return view('evaluation::stores.department-select', compact('departments', 'stores'));
        }

        $this->data['referer'] = \URL::previous();
        $this->data['department'] = ucwords($department);
        $user = \Auth::user()->id;

        if ($department === 'doctor') {
            $this->data['doc'] = 1;
            $this->data['myq'] = VisitDestinations::whereDestination($user)
                ->orWhereNotNull('room_id')
                ->whereCheckout(false)
                ->latest()
                ->paginate(100);
        } else {
            $this->data['myq'] = VisitDestinations::whereDepartment($department)
                ->whereCheckout(false)
                ->latest()
                ->paginate(100);

//            if($department === 'pharmacy')
//            {
//                $this->data['myq'] = $this->data['myq']->filter(function($data) {
//
//                    if($data->visits->admission_request_id == true)
//                    {
//                        return true;
//                    }
//                    else{
//                        $prescriptions = $data->visits->prescriptions;
//
//                        $prescriptionExists = false;
//
//                        foreach($prescriptions as $prescription)
//                        {
//                            $storePrescription = StorePrescription::where('prescription_id', $prescription->id)
//                                ->where('store_id', session()->get('store_id'))
//                                ->first();
//
//                            if(StorePrescription::where('prescription_id', $prescription->id)->first())
//                            {
//                                $prescriptionExists = true;
//
//                                break;
//                            }
//                        }
//
//                        return $prescriptionExists;
//                    }
//                });
//            }
        }
        return view('evaluation::queues', ['data' => $this->data]);
    }

    public function preview($visit, $department, $facility=null)
    {
        $this->data['facility'] = $facility ? $facility : 'outpatient';
        $this->data['visit'] = Visit::find($visit);
        $this->data['patient'] = $this->data['visit']->patients;
        $this->data['department'] = $department;
        $this->data['history'] = Visit::wherePatient($this->data['patient']->id)->where('id', '<>', $visit)->get();
        return view('evaluation::preview', ['data' => $this->data]);
    }

    public function updateDrug(Request $request)
    {
        $prescription = Prescriptions::updateOrCreate(['id' => $request->id]
            , array_except(\request()->all(), 'quantity'));
        $attributes = [
            'quantity' => $request->quantity,
        ];
        $prescription->payment()->update($attributes);
        flash('Saved');
        return redirect()->back();
    }

    public function evaluate($visit, $section, $facility = null)
    {
        $this->data['visit'] = Visit::find($visit);
        $this->data['facility'] =  $facility ? $facility : 'outpatient';
        $facility = Facility::where('name', 'inpatient')->first();
        $this->data['departments'] = StoreDepartment::all();

        if(is_module_enabled('Inpatient'))
        {
            $this->admissionTypeRepository = app(AdmissionTypeRepository::class);
            $this->data['admissionTypes'] = $this->admissionTypeRepository->all();
            $this->data['dischargeTypes'] = DischargeType::all();
        }

        if ($this->data['facility'] == 'inpatient') 
        {
            if($section == "pharmacy")
            {
                return redirect("inpatient/visit/$visit/dispense-drugs");
            }
        }

        try {
            $this->data['all'] = Visit::checkedAt('diagnostics')->get();
            $this->data['visit'] = Visit::find($visit);
            $this->data['section'] = $section;
            $this->data['nursing_procedures'] = Procedures::whereCategory(6)->get();

            $this->data['drug_prescriptions'] = Prescriptions::whereVisit($visit)
                ->where('status', 0)
                ->where('facility_id', '!=', $facility->id)
                ->get();
            session(['v' => $visit]);
            $this->data['dispensed'] = Prescriptions::whereHas('dispensing', function ($query) {

                $query->whereHas('visits', function ($q) {
                    $q->whereId(\Session::get('v'));
                });
            })->get();

            //this->data['drug_prescriptions'] = Prescriptions::whereVisit($visit)->get();
            //check if has requested for admission
            $this->data['investigations'] = Investigations::whereVisit($visit)->get();

            try {
                return view("evaluation::patient_$section", ['data' => $this->data]);
            } catch (\InvalidArgumentException $e) {
                $_c = [
                    'mch' => 'MCH',
                    'hpd' => 'Hypertension and Diabetes',
                    'orthopeadic' => 'Orthopeadic',
                    'popc' => 'Pedeatrics',
                    'mopc' => 'Medical',
                    'sopc' => 'Sergical',
                    'gopc' => 'Gyenecology',
                    'physio' => 'Physiotherapy',
                ];
                $this->data['section'] = $_c[$section];
                return view('evaluation::patient_clinic', ['data' => $this->data]);
            }
        } catch (\Exception $ex) {
            flash($ex->getMessage(), 'error');
            return back();
        }
    }

    public function pharmacy($id)
    {
        $this->data['visit'] = $v = Visit::find($id);
        $this->data['patient'] = Patients::find($v->patient);
        $this->data['section'] = 'pharmacy';
        $this->data['drug_prescriptions'] = Prescriptions::whereVisit($id)->get();
        //$this->data['dispensed'] = \Ignite\Evaluation\Entities\Dispensing::whereVisit($id)->get();
        return view('evaluation::patient_pharmacy', ['data' => $this->data]);
    }

    public function labotomy(Request $request)
    {
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

    public function Formulae(Request $request)
    {
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

    public function labotomy_print()
    {
        //return $this->assetManager;
    }


    public function pharmacy_prescription()
    {
        if ($this->evaluationRepository->save_prescriptions()) {
            flash('Prescription saved');
        } else {
            flash('Prescription could not be saved', 'warning');
        }
        return back();
    }

    public function pharmacy_dispense()
    {
        if ($this->evaluationRepository->dispense()) {
            flash('Drugs dispensed, thank you', 'success');
        } else {
            flash('Drug(s) could not be dispensed', 'warning');
        }
        return back();
    }

    public function sign_out(Request $request, $visit_id, $section)
    {
        $checkout = $this->evaluationRepository->checkout($request, ['id' => $visit_id, 'from' => $section]);
        if ($checkout) {
            flash('Patient checked out from ' . ucfirst($section));
        } else {
            flash('Patient could not be checked out.' . ucfirst($section));
        }
        if ($section == 'evaluation') {
            $section = 'doctor';
        }

    }

    public function review()
    {
        $this->data['patients'] = Patients::whereHas('visits')->get();
        return view('evaluation::reviews', ['data' => $this->data]);
    }

    public function review_patient($patient)
    {
        $this->data['patient'] = Patients::find($patient);
        $this->data['visits'] = Visit::wherePatient($patient)->get();
        return view('evaluation::patient_review', ['data' => $this->data]);
    }

    public function patient_visits($id)
    {
        $this->data['visits'] = Visit::wherePatient($id)->get();
        $this->data['patient'] = Patients::find($id);
        return view('evaluation::patient_visits', ['data' => $this->data]);
    }

    public function investigation_result()
    {
        $story = $this->evaluationRepository->save_results_investigations();
        if ($story) {
            flash('Investigation result posted', 'success');
        } else {
            flash('Uh, Oh. Something wrong happened, retry');
        }
        return back();
    }

    public function view_result($visit)
    {
        $this->data['visit'] = Visit::find($visit);
        $this->data['results'] = Visit::find($visit)->investigations->where('has_result', true);
        return view('evaluation::partials.doctor.results', ['data' => $this->data]);
    }


    public function cancelPresc(Request $request)
    {
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

    public function VerifyLabResult(Request $request)
    {
        try {
            $this->updateResultStatus($request, 1, 'Verification');
            flash('Result status has been updated... thank you', 'success');
            return back();
        } catch (\Exception $e) {
            flash('Result status could not be updated... please try again', 'danger');
            return back();
        }
    }

    public function PublishLabResult(Request $request)
    {
        try {
            $this->updateResultStatus($request, 2, 'Publication');
            flash('Result status has been updated... thank you', 'success');
            return back();
        } catch (\Exception $e) {
            flash('Result status could not be updated... please try again', 'danger');
            return back();
        }
    }

    public function SendLabResult(Request $request)
    {
        try {
            $this->updateResultStatus($request, 3, 'Sent');
            flash('Test Result has been marked as sent... thank you', 'success');
            return back();
        } catch (\Exception $e) {
            flash('Result could not be sent... please try again', 'danger');
            return back();
        }
    }


    public function RejectLabResult(Request $request)
    {
        // try {
        $result = InvestigationResult::find($request->result);

        $purged_results = json_decode($result->results);
        $test = array();
        $res = array();
        try {
            foreach ($purged_results as $r) {
                $test[] = $r[0];
                $res[] = $r[1];
            }
        } catch (\Exception $e) {

        }
        session(['last_reverted' => array_combine($test, $res)]);
        $result->delete(); //send back to test phase literally
        flash('Result status has been reverted... thank you', 'success');
        return back();
    }

    public function RevertResult(Request $request)
    {
        try {
            $result = InvestigationResult::find($request->result);
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

    public function updateResultStatus(Request $request, $flag, $type)
    {
        try {
            $result = InvestigationResult::find($request->result);
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

    /* In patient functions */

    public function listWards()
    {
        $wards = Ward::all();
        return view('Evaluation::inpatient.listWards', compact('wards'));
    }

    public function addWard()
    {
        return view('Evaluation::inpatient.addWardForm');
    }

    public function addwordFormPost(Request $request)
    {
        $request['category'] = 'inpatients';
        Ward::create($request->all());
        return redirect('/evaluation/inpatient/list')->with('success', 'successfully added a ward');
    }

//list the beds
    public function listBeds()
    {

        $wards = Ward::all();
        $beds = Bed::all();
        return view('Evaluation::inpatient.listBeds', compact('beds', 'wards'));
    }

    public function addBedFormPost(Request $request)
    {
        $request['status'] = 'available';
        Bed::create($request->all());
        return redirect()->back()->with('success', 'successfully added a bed');
    }

    public function availableBeds($wardId)
    {
        //return wards bedpositions
        return Bedposition::where('ward_id', $wardId)->where('status', 'available')->get();
    }

    public function delete_ward(Request $request)
    {
        $ward = Ward::findorfail($request->ward_id);
        $ward->delete();
        return redirect()->back()->with('success', 'successfully deleted the ward');
    }

    public function delete_bed(Request $request)
    {
        $ward = Bed::findorfail($request->bed_id);
        $ward->delete();
        return redirect()->back()->with('success', 'successfully deleted the bed');
    }

    public function deposit()
    {
        $deposits = Deposit::all();
        return view('Evaluation::inpatient.deposit', compact('deposits'));
    }

    public function addDepositType(Request $request)
    {
        Deposit::create($request->all());
        return redirect()->back()->with('success', 'successfully added a new deposit type');
    }

    public function delete_deposit($deposit_id)
    {
        $d = Deposit::find($deposit_id);
        $d->delete();
        if (Admission::where('cost', $d->cost)->count()) {
            return redirect()->back()->with('error', 'Could not delete the deposit.');
        }
        return redirect()->back()->with('success', 'Successfully deleted');
    }

    public function topUp()
    {
        $patients = Patients::all();
        $deposits = FinancePatientAccounts::where('credit', '>', 0)->get();
        return view('Evaluation::inpatient.topUp', compact('patients', 'deposits'));
    }

    public function topUpAmount(Request $request)
    {
        if (count(PatientAccount::where('patient_id', $request->patient_id)->get())) {
            $patient = PatientAccount::where('patient_id', $request->patient_id)->first();
            $patient->update(['balance' => $patient->balance + $request->amount]);
        } else {
            $request['balance'] = $request->amount;
            $patient = PatientAccount::create($request->all());
        }

        $request['patient'] = $request->patient_id;
        $request['reference'] = 'deposit_' . str_random(5);
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


//        return view('Evaluation::inpatient.print.topUpSlip',compact('tras','patient','balance','amount'));
        $pdf = \PDF::loadView('Evaluation::inpatient.print.topUpSlip', ['tras' => $tras, 'patient' => $patient, 'balance' => $balance, 'amount' => $amount]);
        $pdf->setPaper('a4', 'Landscape');
        return $pdf->stream('Deposit_slip' . str_random(4) . '.pdf');


        return view('Evaluation::inpatient.deposit_slip', compact('patient', 'depo', 'balance'));
    }

    public function withdraw()
    {
        $patients = Patients::all();
        $deposits = FinancePatientAccounts::where('debit', '>', 0)->get();

        return view('Evaluation::inpatient.withdraw', compact('deposits', 'patients'));
    }

    public function WithdrawAmount(Request $request)
    {
        //search for the account..
        if (count(PatientAccount::where('patient_id', $request->patient_id)->get())) {
            $patient_acc = PatientAccount::where('patient_id', $request->patient_id)->first();
            $account_balance = $patient_acc->balance;
        } else {
            $account_balance = 0;
        }
        if ($request->amount > $account_balance) {
            $validator = Validator::make($request->all(), ['amount' => 'required']);
            $validator->errors()
                ->add('amount', 'Insufficient fund in your account to withdraw Kshs. ' . $request->amount);
            return redirect()->back()->withErrors($validator);
        }
        //reduce the amount
        $patient_acc->update(['balance' => $account_balance - $request->amount]);

        $wit = FinancePatientAccounts::create([
            'reference' => 'withdraw_' . str_random(5),
            'details' => 'withdraw amount from patient account',
            'debit' => $request->amount,
            'credit' => 0.00,
            'patient' => $request->patient_id
        ]);
        $patient = Patients::find($request->patient_id);
        $balance = $patient_acc->balance;

        $pdf = \PDF::loadView('Evaluation::inpatient.print.withdraw', ['tras' => $wit, 'patient' => $patient, 'balance' => $balance, 'amount' => $request->amount]);
        $pdf->setPaper('a4', 'Landscape');
        return $pdf->stream('Deposit_slip' . str_random(4) . '.pdf');


        $pdf = \PDF::loadView('Evaluation::inpatient.print.withdraw', ['tras' => $wit, 'patient' => $patient, 'balance' => $balance, 'amount' => $request->amount]);
        $pdf->setPaper('a4', 'Landscape');
        return $pdf->stream('Withdraw_slip' . str_random(4) . '.pdf');
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
        return redirect()->back()->with('success', 'Successfully edited a bed');
    }

    public function cancel_checkin(Request $request)
    {
        $v = Visit::find($request->id);
        if (count($v)) {
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
        return redirect()->back()->with('success', 'updated deposit successfully');
    }

    public function topUpAccount(Request $request)
    {
        $acc = PatientAccount::where('patient_id', $request->patient_id)->first();

        if (!count($acc)) {
            //create a patient account
            $acc = PatientAccount::create([
                'patient_id' => $request->patient_id,
                'balance' => 0
            ]);
        }
        /* record this trans. */
        FinancePatientAccounts::create([
            'reference' => 'Deposit_' . str_random(5),
            'details' => 'Deposit to patient account',
            'credit' => 0.00,
            'debit' => $request->amount,
            'patient' => $request->patient_id,
        ]);

        $acc->update(['balance' => $acc->balance + $request->amount]);
        return redirect()->back()->with('success', 'successfully topped up patient account');
    }

    public function deleteThisWard($id)
    {
        $ward = Ward::find($id);
        $ward->delete();
        return redirect()->back()->with('success', 'Successfully deleted a ward');
    }

    public function getRecordWard($id)
    {
        return Ward::findorfail($id);
    }

    public function update_ward(Request $request)
    {
        $ward = Ward::findorfail($request->wardId);
        $ward->update($request->all());
        return redirect()->back()->with('success', 'Successfully updated the ward');
        //dd($request->all());
    }

    public function bedPosition()
    {
        $bedpositions = Bedposition::all();
        $wards = Ward::all();
        return view('Evaluation::inpatient.bedposition', compact('bedpositions', 'wards'));
    }

    public function postbedPosition(Request $request)
    {
        Bedposition::create($request->all());


        return redirect()->back()->with('success', 'Successfully added a new bed position to ward ');
    }

    public function deletebedPosition($request)
    {
        $bedpos = Bedposition::find($request);
        $bedpos->delete();
        return redirect()->back()->with('success', 'Successfully deleted a bed position');
    }

    public function postaddBed(Request $request)
    {
        Bed::create($request->all());
        return redirect()->back()->with('success', 'Successfully added a new bed');
    }

    public function postdelete_bed($value)
    {
        $bed = Bed::find($value);
        $bed->delete();
        return redirect()->back()->with('success', 'Successfully deleted a bed');
    }

    public function move_patient($visit)
    {
        $admission = Admission::find($visit);
        $visit = Admission::find($visit)->visit_id;
        $v = Visit::find($visit);
        $patient = Patients::find($v->patient);
        $acc = PatientAccount::where('patient_id', $v->patient)->first();
        if (count($acc)) {
            $balance = $acc->balance;
        } else {
            $balance = 0;
        }
        $ward = Ward::find($admission->ward_id);
        $bed = Bed::find($admission->bed_id)->number;
        $beds = Bed::where('status', 'available')->get();
        $wards = Ward::all();
        return view('Evaluation::.inpatient.movePatient', compact('v', 'wards', 'bed', 'beds', 'ward', 'balance', 'patient', 'admission'));
    }

    public function getAvailableBedPosition($ward)
    {

        return Bedposition::where('status', 'available')->where('ward_id', $ward)->get();
    }

    public function change_bed(Request $request)
    {
        $admission = Admission::find($request->admission_id);

        if ($admission->ward_id != $request->ward_id) {
            //ward change to be indicated here..
            $ward_assigned = WardAssigned::where('visit_id', $admission->visit_id)->orderBy('created_at', 'desc')->first();
            if (count($ward_assigned)) {
                $ward_assigned->update(['discharged_at' => date("Y-m-d G:i:s")]);
            }
            //assign another ward
            $ward = Ward::find($request->ward_id);
            WardAssigned::create([
                'visit_id' => $admission->visit_id,
                'ward_id' => $request->ward_id,
                'price' => $ward->cost
            ]);
        }
        $admission->update([
            'ward_id' => $request->ward_id,
            'bed_id' => $request->bed_id,
            'bedPosition_id' => $request->bedposition_id
        ]);
        //if there is ward change

        return redirect()->back()->with('success', 'Successfully moved the patient');
    }

    public function Nursing_services(Request $request)
    {
        $charges = NursingCharge::all();
        $wards = Ward::all();
        return view('Evaluation::inpatient.Nursing_services', compact('charges', 'wards'));
    }

    public function AddReccurentCharge(Request $request)
    {
        $req = (request()->all());
        if ($req['type'] != 'nursing') {
            $req['ward_id'] = null;
        }
        NursingCharge::create($req);
        return redirect()->back()->with('success', 'Successfully added a new recurrent charge');
    }

    public function delete_service($id)
    {
        $service = NursingCharge::find($id);
        if ($service) {
            $service->delete();
        }
        return redirect()->back()->with('success', 'Successfully deleted a recurrent charge.');
    }

///patient account operations
    public function account_deposit_amount($patient_id)
    {
        $acc = PatientAccount::where('patient_id', $patient_id)->first();
        if (!count($acc)) {
            $acc = PatientAccount::create([
                'patient_id' => $patient_id,
                'balance' => 0
            ]);
        }
        $patient = Patients::find($patient_id);
        $this->data['patient'] = $patient;
        $this->data['acc'] = $acc;
        return view('Evaluation::inpatient.account_deposit', ['data' => $this->data]);
    }

    public function topUpAccountPost(Request $request)
    {
        $amount = 0;
        $acc = PatientAccount::where('patient_id', $request->patient_id)->first();

        $a = 'evaluation/inpatient/print?type=deposit&patient_id=' . $request->patient_id;
        //cash
        if ($request->cash) {
            $cash = FinancePatientAccounts::create([
                'patient' => $request->patient_id,
                'reference' => 'deposit_' . str_random(5),
                'details' => 'deposit to patient\'s account',
                'debit' => 0.00,
                'credit' => $request->cash,
                'mode' => 'cash'
            ]);
            $amount += $request->cash;
            $a .= '&cash=' . $cash->id;
        }
        if ($request->cheque) {
            $cheque = FinancePatientAccounts::create([
                'patient' => $request->patient_id,
                'reference' => $request->chequenumber . str_random(5),
                'details' => 'deposit to patient\'s account',
                'debit' => 0.00,
                'credit' => $request->cheque,
                'mode' => 'cheque'
            ]);
            $amount += $request->cheque;
            $a .= '&cheque=' . $cheque->id;
        }
        if ($request->mpesa) {
            $mpesa = FinancePatientAccounts::create([
                'patient' => $request->patient_id,
                'reference' => $request->mpesaTransactionCode . str_random(5),
                'details' => 'deposit to patient\'s account',
                'debit' => 0.00,
                'credit' => $request->mpesa,
                'mode' => 'Mpesa'
            ]);
            $amount += $request->mpesa;
            $a .= '&mpesa=' . $mpesa->id;
        }
        $patient = Patients::find($request->patient_id);
        $acc->update(['balance' => ($acc->balance + $amount)]);
        $success = 'Successfully deposited Kshs.' . number_format($amount, 2) . ' your account balance is Kshs.' . number_format($acc->balance, 2) . '.';
        return view('Evaluation::inpatient.print', compact('success', 'a', 'patient'));
    }

    public function account_withdraw_amount($patient_id)
    {
        $acc = PatientAccount::where('patient_id', $patient_id)->first();
        if (!count($acc)) {
            $acc = PatientAccount::create([
                'patient_id' => $patient_id,
                'balance' => 0
            ]);
        }
        $patient = Patients::find($patient_id);
        $this->data['patient'] = $patient;
        $this->data['acc'] = $acc;
        return view('Evaluation::inpatient.account_withdraw', ['data' => $this->data]);
    }

    public function PostWithdrawAccount(Request $request)
    {
        $amount = 0;
        $a = 'evaluation/inpatient/print?type=withdraw&patient_id=' . $request->patient_id;
        $acc = PatientAccount::where('patient_id', $request->patient_id)->first();
        if ($acc->balance < ($request->cash + $request->cheque + $request->mpesa)) {
            return redirect()->back()->with('error', 'Insufficient account balance. Your account balance is Kshs. ' . number_format($acc->balance, 2));
        }
        //cash
        if ($request->cash) {
            $cash = FinancePatientAccounts::create([
                'patient' => $request->patient_id,
                'reference' => 'withdraw_' . str_random(5),
                'details' => 'withdraw from patient\'s account',
                'credit' => 0.00,
                'debit' => $request->cash,
                'mode' => 'cash'
            ]);
            $amount += $request->cash;
            $a .= '&cash=' . $cash->id;
        }
        if ($request->cheque) {
            $cheque = FinancePatientAccounts::create([
                'patient' => $request->patient_id,
                'reference' => $request->chequenumber . '_' . str_random(5),
                'details' => 'withdraw from patient\'s account',
                'credit' => 0.00,
                'debit' => $request->cheque,
                'mode' => 'cheque'
            ]);
            $amount += $request->cheque;
            $a .= '&cheque=' . $cheque->id;
        }
        if ($request->mpesa) {
            $mpesa = FinancePatientAccounts::create([
                'patient' => $request->patient_id,
                'reference' => $request->mpesaTransactionCode . '_' . str_random(5),
                'details' => 'withdraw from patient\'s account',
                'credit' => 0.00,
                'debit' => $request->mpesa,
                'mode' => 'Mpesa'
            ]);
            $amount += $request->mpesa;
            $a .= '&mpesa=' . $mpesa->id;
        }
        $patient = Patients::find($request->patient_id);
        $acc->update(['balance' => ($acc->balance + $amount)]);


        /* $patient = Patients::find($request->patient_id);
          $acc->update(['balance' => ($acc->balance - $amount)]);
          $a = '/a'; */
        $success = 'Successfully withdrawn Kshs.' . number_format($amount, 2) . ' your account balance is Kshs.' . number_format($acc->balance, 2) . '.';
        return view('evaluation::inpatient.print', compact('success', 'a', 'patient'));
    }

    public function _print(Request $request)
    {
        $patient = \Ignite\Reception\Entities\Patients::find($request->patient_id);
        $t = [];
        if ($request->cash) {
            array_push($t, $request->cash);
        }
        if ($request->mpesa) {
            array_push($t, $request->mpesa);
        }
        if ($request->cheque) {
            array_push($t, $request->cheque);
        }

        $trans = \Ignite\Evaluation\Entities\FinancePatientAccounts::findMany($t);
        $acc = \Ignite\Evaluation\Entities\PatientAccount::where('patient_id', $request->patient_id)->first();
        if ($request->type == 'deposit') {
            $pdf = \PDF::loadView('Evaluation::inpatient.print.topUpSlip', ['patient' => $patient, 'trans' => $trans, 'type' => $request->type, 'acc' => $acc]);
            $pdf->setPaper('a4', 'Landscape');
            return $pdf->stream('Bill' . $request->id . '.pdf');
        }
        $pdf = \PDF::loadView('Evaluation::inpatient.print.withdraw', ['patient' => $patient, 'trans' => $trans, 'type' => $request->type, 'acc' => $acc]);
        $pdf->setPaper('a4', 'Landscape');
        return $pdf->stream('Bill' . $request->id . '.pdf');
    }

    private function _require_assets()
    {
        $assets = [
            'doctor-investigations.js' => m_asset('evaluation:js/doctor-investigations.js'),
            'doctor-treatment.js' => m_asset('evaluation:js/doctor-treatment.js'),
            'doctor-next-steps.js' => m_asset('evaluation:js/doctor-next-steps.js'),
            'doctor-notes.js' => m_asset('evaluation:js/doctor-notes.js'),
            'doctor-opnotes.js' => m_asset('evaluation:js/doctor-opnotes.js'),
            'doctor-prescriptions.js' => m_asset('evaluation:js/doctor-prescriptions.js'),
            'doctor-visit-date.js' => m_asset('evaluation:js/doctor-set-visit-date.js'),
            'nurse-vitals.js' => m_asset('evaluation:js/nurse-vitals.js'),
            //'order-investigation.js' => m_asset('evaluation:js/doctor-treatment.min.js'),
            'nurse_eye_preliminary.js' => m_asset('evaluation:js/nurse_eye_preliminary.js'),
        ];
        foreach ($assets as $key => $asset) {
            $this->assetManager->addAssets([$key => $asset]);
            $this->assetPipeline->requireJs($key);
        }
    }

    public function authStore()
    {
        session([
            'department_id' => request('department'),
            'store_id' => request('store')
        ]);

        return redirect()->route('evaluation.queues', ['department' => 'pharmacy']);
    }

    /*
     * Select a store to dispense drugs from
     */
    public function selectStore()
    {
        $departments = StoreDepartment::all();

        $stores = Store::all();

        return view('evaluation::stores.department-select', compact('departments', 'stores'));
    }

}
