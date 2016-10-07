<?php

namespace Ignite\Evaluation\Console;

use Ignite\Core\Console\Installers\Traits\BlockMessage;
use Ignite\Core\Console\Installers\Traits\SectionMessage;
use Ignite\Evaluation\Repositories\EvaluationRepository;
use Illuminate\Console\Command;

class AutoCheckout extends Command {

    use BlockMessage,
        SectionMessage;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'evaluation:mass';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check out  patient automatically.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(EvaluationRepository $evaluationRepository) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire() {
        $this->blockMessage('Checking out everyone!', 'Working out...', 'comment');
        /* $visits = \Ignite\Evaluation\Entities\Visit::where('created_at', '<', new \Date('today'))->update();
          dd($visits);
         */
    }

}
