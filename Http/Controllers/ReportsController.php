<?php

namespace Ignite\Evaluation\Http\Controllers;

use Ignite\Evaluation\Entities\EvaluationPayments;
use Ignite\Evaluation\Entities\Prescriptions;
use Ignite\Finance\Entities\InsuranceInvoice;
use Ignite\Reception\Entities\Patients;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Ignite\Evaluation\Entities\Visit;

class ReportsController extends Controller {

    public function sick_off(Request $request) {
        $patient = Patients::find($request->patient);
        $name = 'Sick-off notes ' . $patient->full_name . '.docx';

        $exported = exportSickOff($request, $patient);
        $exported->save($temp_file = tempnam(sys_get_temp_dir(), 'PHPWord'));

        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $name . '"');
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . filesize($temp_file));
        flush();
        readfile($temp_file); // or echo file_get_contents($temp_file);
        unlink($temp_file);  // remove temp file
        echo "<script>window.close();</script>";
    }

    public function payment_receipt(Request $request) {
        $info = \Ignite\Finance\Entities\EvaluationPayments::find($request->payment);
        $pdf = \PDF::loadView('evaluation::prints.print_receipts', ['data' => $info]);
        $pdf->setPaper('a4');
        return $pdf->download($info->receipt . '.pdf');
    }

    public function cashier(Request $request) {
        $temp = Payments::query();
        if ($request->has('start')) {
            $temp->where('created_at', '>=', $request->start);
            $this->data['filter']['from'] = (new \Date($request->start))->format('jS M Y');
        }
        if ($request->has('end')) {
            $temp->where('created_at', '<=', $request->end);
            $this->data['filter']['to'] = (new \Date($request->end))->format('jS M Y');
        }
        $this->data['records'] = $temp->get();
        $pdf = \PDF::loadView('system.prints.cashier_report', ['data' => $this->data]);
        return $pdf->stream('report.pdf');
    }

    /**
     * Stream PDF from helper intent
     * @param int $visit_id
     * @return \Illuminate\Http\Response
     */
    public function print_prescription(Request $request) {
        try {
            $this->data['prescription'] = Prescriptions::whereVisit($request->visit)->get();
            $this->data['visit'] = Visit::find($request->visit);
            $pdf = \PDF::loadView('evaluation::prints.prescriptions', ['data' => $this->data]);
            $pdf->setPaper('A5', 'Landscape');
            return $pdf->stream('prescription.pdf');
        } catch (\Exception $ex) {
            return back();
        }
    }

    public function print_lab(Request $request) {
        //try {
            $this->data['visit'] = Visit::find($request->visit);
            $this->data['results'] = \Ignite\Evaluation\Entities\Investigations::find($request->id);
            $pdf = \PDF::loadView('evaluation::prints.lab.results', ['data' => $this->data]);
            $pdf->setPaper('A4', 'potrait');
            return $pdf->stream('LabResults.pdf');
        //} catch (\Exception $exc) {
          //  return back();
       // }
    }

    public function print_lab_one(Request $request) {
       // try {
            $this->data['visit'] = Visit::find($request->visit);
            $this->data['results'] = \Ignite\Evaluation\Entities\Investigations::find($request->id);
            $pdf = \PDF::loadView('evaluation::prints.lab.one_lab', ['data' => $this->data]);
            $pdf->setPaper('A4', 'potrait');
            return $pdf->stream('LabResult.pdf');
      //  } catch (\Exception $ex) {
      //      return back();
      //  }
    }

    public function print_results(Request $request) {
        //try {
            $this->data['visit'] = Visit::find($request->visit);
            $this->data['type'] = $request->type;
            $pdf = \PDF::loadView('evaluation::prints.results', ['data' => $this->data]);
            $pdf->setPaper('A4', 'potrait');

            $pdf->render();
            $font = $pdf->getFontMetrics()->get_font("helvetica", "bold");
            $pdf->getCanvas()->page_text(72, 18, "Header: {PAGE_NUM} of {PAGE_COUNT}", $font, 10, array(0,0,0));
            return $pdf->stream('Results.pdf');
       // } catch (\Exception $exc) {
         //   return back();
       // }
    }

    public function print_results_one(Request $request) {
       // try {
            $this->data['visit'] = Visit::find($request->visit);
            $this->data['result'] = \Ignite\Evaluation\Entities\InvestigationResult::find($request->id);
            $this->data['type'] = $request->type;
            $pdf = \PDF::loadView('evaluation::prints.one_result', ['data' => $this->data]);
            $pdf->setPaper('A4', 'potrait');
            return $pdf->stream('Result.pdf');
       // } catch (\Exception $ex) {
        //    return back();
       // }
    }

    public function invoice($invoice) {
        $this->data['invoice'] = InsuranceInvoice::find($invoice);
        $pdf = \PDF::loadView('system.prints.invoice', ['data' => $this->data]);
        return $pdf->stream('invoice.pdf');
    }

    public function pn_specific(Request $request) {
        $visit = $request->visit;
        $this->data['visits'] = $v = Visit::find($visit);
        if (empty($v)) {
            return redirect()->back();
        }
        $this->data['visit'] = $v;
        $this->data['patient'] = Patients::find($v->patient);
        $pdf = \PDF::loadView('evaluation::prints.patient_notes_specific', ['data' => $this->data]);
        $pdf->setPaper('A5', 'Landscape');
        return $pdf->stream('patient_notes_summary.pdf');
    }

    public function pn_towrd_specific(Request $request) {
        $visit = $request->visit;
        $this->data['visits'] = $v = Visit::find($visit);
        if (empty($v)) {
            return redirect()->back();
        }
        $this->data['visit'] = $visit;
        $this->data['patient'] = $patient = Patients::find($v->patient);

        $name = 'Patient Notes ' . $patient->full_name . '.docx';

        $exported = exportPatientNotesDate($v->patient, $visit);
        $exported->save($temp_file = tempnam(sys_get_temp_dir(), 'PHPWord'));

        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $name . '"');
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . filesize($temp_file));
        flush();
        readfile($temp_file); // or echo file_get_contents($temp_file);
        unlink($temp_file);  // remove temp file
        echo "<script>window.close();</script>";
    }

    public function patient_notes($visit) {
        $this->data['visits'] = $v = Visit::find($visit);
        if (empty($v)) {
            return redirect()->back();
        }
        $this->data['visit'] = $visit;
        $this->data['patient'] = Patients::find($v->patient);
        $pdf = \PDF::loadView('evaluation::prints.patient_notes', ['data' => $this->data]);
        $pdf->setPaper('A5', 'Landscape');
        return $pdf->stream('patient_notes.pdf');
    }

    public function patient_notes_to_word($visit) {
        $this->data['visits'] = $v = Visit::find($visit);
        if (empty($v)) {
            return redirect()->back();
        }
        $this->data['visit'] = $visit;
        $this->data['patient'] = $patient = Patients::find($v->patient);

        $name = 'Patient Notes ' . $patient->full_name . '.docx';

        $exported = exportPatientNotes($patient, $visit);
        $exported->save($temp_file = tempnam(sys_get_temp_dir(), 'PHPWord'));

        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $name . '"');
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . filesize($temp_file));
        flush();
        readfile($temp_file); // or echo file_get_contents($temp_file);
        unlink($temp_file);  // remove temp file
        echo "<script>window.close();</script>";
    }

}
