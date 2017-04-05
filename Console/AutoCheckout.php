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
    protected $name = 'evaluation:checkout';

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
        $date = new \DateTime;
        $date->modify('-24 hours');
        $last_updated = $date->format('Y-m-d H:i:s');

        $visits = \Ignite\Evaluation\Entities\Visit::where('created_at', '<=', $last_updated)->get();

        foreach ($visits as $v) {
            $destination = \Ignite\Evaluation\Entities\VisitDestinations::whereVisit($v->id)->first();
            $destination->checkout = 1;
            $destination->update();
        }

        $this->blockMessage('Old visits have been checkout!', 'Thank you...', 'comment');
    }

}
