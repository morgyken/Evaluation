<?php

namespace Ignite\Evaluation\Http\Controllers;

use Ignite\Core\Http\Controllers\AdminBaseController;
use Ignite\Evaluation\Entities\ProcedureCategories;
use Ignite\Evaluation\Entities\Procedures;
use Ignite\Evaluation\Http\Requests\ProcedureCategoriesRequest;
use Ignite\Evaluation\Http\Requests\ProcedureRequest;
use Ignite\Evaluation\Repositories\EvaluationRepository;

class SetupController extends AdminBaseController {

    /**
     * @var EvaluationRepository
     */
    protected $evaluationRepository;

    /**
     * SetupController constructor.
     * @param EvaluationRepository $evaluationRepository
     */
    public function __construct(EvaluationRepository $evaluationRepository) {
        parent::__construct();
        $this->evaluationRepository = $evaluationRepository;
    }

    public function save_procedure(ProcedureRequest $request) {
        if ($this->evaluationRepository->add_procedure()) {
            flash()->success('Procedure saved');
        } else {
            flash('Could not save that one', 'danger');
        }
        return redirect()->route('evaluation.setup.procedures');
    }

    public function procedures($id = null) {
        $this->data['procedure'] = Procedures::findOrNew($id);
        $this->data['procedures'] = Procedures::all();
        return view('evaluation::setup.procedures', ['data' => $this->data]);
    }

    public function save_procedure_cat(ProcedureCategoriesRequest $request) {
        if ($this->evaluationRepository->add_procedure_category()) {
            flash()->success('Procedure category saved');
        } else {
            flash('There was an error', 'danger');
        }
        return redirect()->route('evaluation.setup.procedure_cat');
    }

    public function procedure_cat($id = null) {
        $this->data['categories'] = ProcedureCategories::all();
        $this->data['model'] = ProcedureCategories::findOrNew($id);
        return view('evaluation::setup.procedure_cat', ['data' => $this->data]);
    }

}
