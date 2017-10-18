<?php

namespace Ignite\Evaluation\Http\Controllers;

use Ignite\Core\Http\Controllers\AdminBaseController;
use Ignite\Evaluation\Entities\Procedures;
use Ignite\Evaluation\Repositories\EvaluationRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ServiceController extends AdminBaseController
{
    public function shopfront()
    {
        return view('evaluation::pos.shop', ['data' => $this->data]);
    }

    public function postServices(EvaluationRepository $repository, Request $request)
    {
        if ($repository->request_service()) {
            flash()->success('Order placed successfully');
        } else {
            flash()->error("Could not place order");
        }
        return redirect()->back();
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
