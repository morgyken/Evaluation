<?php

namespace Ignite\Evaluation\Http\Controllers;

use Ignite\Core\Http\Controllers\AdminBaseController;
use Ignite\Evaluation\Repositories\EvaluationRepository;

class InvestigationsController extends AdminBaseController {

    protected $evaluation;

    public function __construct(EvaluationRepository $evaluation) {
        parent::__construct();
        $this->evaluation = $evaluation;
    }

    public function __invoke($type) {
        if ($this->evaluation->order_evaluation($type)) {
            flash()->success('Test ordered for ' . $type);
        } else {
            flash('Something wasn\'t right', 'danger');
        }
        return back();
    }

}
