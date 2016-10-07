<?php

namespace Ignite\Evaluation\Http\Controllers;

use Ignite\Core\Http\Controllers\AdminBaseController;
use Ignite\Evaluation\Entities\Prescriptions;
use Ignite\Finance\Entities\InsuranceInvoice;
use Ignite\Reception\Entities\Patients;
use Illuminate\Http\Request;

class ReportsController extends AdminBaseController {

    public function sick_off(Request $request) {
        $patient = Patients::find($request->patient);
        $name = 'Sickoff notes ' . $patient->full_name . '.docx';


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
        $info = ReceivePayments::find($request->payment);
        $pdf = \PDF::loadView('system.prints.assad', ['info' => $info]);
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
    public function prescription($visit_id) {
        $this->data['prescription'] = Prescriptions::whereVisit($visit_id)->get();
        $pdf = \PDF::loadView('system.prints.prescriptions', ['data' => $this->data]);
        $pdf->setPaper('A5', 'Landscape');
        return $pdf->stream('prescription.pdf');
    }

    public function invoice($invoice) {
        $this->data['invoice'] = InsuranceInvoice::find($invoice);
        $pdf = \PDF::loadView('system.prints.invoice', ['data' => $this->data]);
        return $pdf->stream('invoice.pdf');
    }

}
