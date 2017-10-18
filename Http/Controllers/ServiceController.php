<?php

namespace Ignite\Evaluation\Http\Controllers;

use Ignite\Core\Http\Controllers\AdminBaseController;
use Ignite\Evaluation\Entities\Procedures;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ServiceController extends AdminBaseController
{
    public function shopfront()
    {
        return view('evaluation::pos.shop', ['data' => $this->data]);
    }

    public function postServices(Request $request)
    {
        if ($this->inventoryRepository->record_sales()) {
            $receipt = session('receipt_id');
            if (isset($request->pharmacy)) {
                //dd($request->pharmacy);
                flash('Drugs dispensed successfully');
                return redirect()->back();
            } else {
                flash('Transaction completed');
                return redirect()->route('inventory.receipt', $receipt);
            }
        }
    }

    public function getProcedures(Request $request, $section = 'nurse')
    {
        /** @var Procedures[] $found */
        $found = Procedures::all();
        $term = $request->term['term'];
        if (!empty($term)) {
            $found = Procedures::whereHas('categories', function (Builder $query) {
                $query->where('applies_to', 5);
            })->where('name', 'like', "%$term%")->get();
        }
        $build = [];
        foreach ($found as $item) {
            $build[] = [
                'text' => $item->name,
                'id' => $item->id,
                'cash_price' => $item->cash_charge,
                'credit_price' => $item->insurance_charge,
                'o_price' => $item->cash_charge,
            ];
        }
        return response()->json(['results' => $build]);
    }
}
