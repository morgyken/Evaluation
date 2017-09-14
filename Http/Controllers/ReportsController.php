<?php

namespace Ignite\Evaluation\Http\Controllers;

use Dompdf\Dompdf;
use Ignite\Evaluation\Entities\EvaluationPayments;
use Ignite\Evaluation\Entities\PageCount;
use Ignite\Evaluation\Entities\Prescriptions;
use Ignite\Finance\Entities\InsuranceInvoice;
use Ignite\Reception\Entities\Patients;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Ignite\Evaluation\Entities\Visit;

class ReportsController extends Controller
{

    public function sick_off(Request $request)
    {
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

    public function payment_receipt(Request $request)
    {
        $info = \Ignite\Finance\Entities\EvaluationPayments::find($request->payment);
        $pdf = \PDF::loadView('evaluation::prints.print_receipts', ['data' => $info]);
        $pdf->setPaper('a4');
        return $pdf->download($info->receipt . '.pdf');
    }

    public function cashier(Request $request)
    {
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
    public function print_prescription(Request $request)
    {
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

    public function print_lab(Request $request)
    {
        try {
            $this->data['visit'] = Visit::find($request->visit);
            $this->data['test_id'] = null;
            $this->data['results'] = \Ignite\Evaluation\Entities\Investigations::find($request->id);
            \PDF::setOptions(['isPhpEnabled' => true]);
            $pdf = new Dompdf();
            $pdf->setPaper('A4', 'potrait');
            $html = view('evaluation::prints.lab.results', ['data' => $this->data])->render();
            $pdf->loadHtml($html);
            $pdf->render();$font = $pdf->getFontMetrics()->get_font("helvetica", "bold");
            $this->save_page_count($request,$pdf->getCanvas()->get_page_count());
            //$pdf->getCanvas()->page_text(72, 18, "Header: {PAGE_NUM} of {PAGE_COUNT}", $font, 10, array(0,0,0));
            return $pdf->stream('LabResults.pdf',array("Attachment" => false));
      } catch (\Exception $exc) {
           flash('Something went wrong', 'error');
           return back();
       }
    }

    public function print_lab_one(Request $request)
    {
        try {
            $this->data['visit'] = Visit::find($request->visit);
            $this->data['test_id'] = $request->id;
            $this->data['results'] = \Ignite\Evaluation\Entities\Investigations::find($request->id);
            \PDF::setOptions(['isPhpEnabled' => true]);
            $pdf = new Dompdf();
            $pdf->setPaper('A4', 'potrait');
            $html = view('evaluation::prints.lab.one_lab', ['data' => $this->data])->render();
            $pdf->loadHtml($html);
            $pdf->render();$font = $pdf->getFontMetrics()->get_font("helvetica", "bold");
            $this->save_page_count($request,$pdf->getCanvas()->get_page_count());
            return $pdf->stream('LabResults.pdf',array("Attachment" => false));
        } catch (\Exception $ex) {
            flash('Something went wrong', 'error');
            return back();
        }
    }

    public function save_page_count(Request $request, $page_count){
        $count = PageCount::firstOrNew([
            'visit_id'=>$request->visit,
            'test_id'=>$request->id
        ]);
        $count->visit_id = $request->visit;
        $count->test_id = $request->id;
        $count->pages = $page_count;
        return $count->save();
    }

    public function print_results(Request $request)
    {
        try {
            //dd($request->server());
            $this->data['visit'] = Visit::find($request->visit);
            $this->data['test_id'] = null;
            $this->data['type'] = $request->type;
            \PDF::setOptions(['isPhpEnabled' => true]);
            $pdf = new Dompdf();
            $pdf->setPaper('A4', 'potrait');
            $html = view('evaluation::prints.results', ['data' => $this->data])->render();
            $pdf->loadHtml($html);
            $pdf->render();$font = $pdf->getFontMetrics()->get_font("helvetica", "bold");
            $this->save_page_count($request,$pdf->getCanvas()->get_page_count());
            return $pdf->stream('Results.pdf',array("Attachment" => false));
        } catch (\Exception $exc) {
            return back();
        }
    }

    public function print_results_one(Request $request)
    {
       try {
            $this->data['visit'] = Visit::find($request->visit);
            $this->data['result'] = $res = \Ignite\Evaluation\Entities\InvestigationResult::find($request->id);
            $this->data['type'] = $request->type;
            //dd($res);
            $this->data['test_id'] = $res->investigation;

            \PDF::setOptions(['isPhpEnabled' => true]);
            $pdf = new Dompdf();
            $data['page_count'] = $pdf->getCanvas()->get_page_count();
            $pdf->setPaper('A4', 'potrait');
            $html = view('evaluation::prints.one_result', ['data' => $this->data])->render();
            $pdf->loadHtml($html);
            $pdf->render();$font = $pdf->getFontMetrics()->get_font("helvetica", "bold");

            $count = PageCount::firstOrNew([
               'visit_id'=>$request->visit,
               'test_id'=>$res->investigation
            ]);
            $count->visit_id = $request->visit;
            $count->test_id = $res->investigation;
            $count->pages = $pdf->getCanvas()->get_page_count();
            $count->save();

            return $pdf->stream('Results.pdf',array("Attachment" => false));
      } catch (\Exception $ex) {
           return back();
      }
    }

    public function invoice($invoice)
    {
        $this->data['invoice'] = InsuranceInvoice::find($invoice);
        $pdf = \PDF::loadView('system.prints.invoice', ['data' => $this->data]);
        return $pdf->stream('invoice.pdf');
    }

    public function pn_specific(Request $request)
    {
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

    public function pn_towrd_specific(Request $request)
    {
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

    public function patient_notes($visit)
    {
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

    public function patient_notes_to_word($visit)
    {
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
