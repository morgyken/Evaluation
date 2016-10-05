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

    public function __invoke() {
        dd($this->evaluation);
    }

}
