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
        $date = \Carbon\Carbon::now();
        $date->modify('-24 hours');
        $date->format('Y-m-d H:i:s');

        $destinations = \Ignite\Evaluation\Entities\VisitDestinations::where('created_at', '<=', $date)->get();

        foreach ($destinations as $d) {
            $d->checkout = 1;
            $d->finish_at = new \DateTime;
            $d->update();
        }

        $this->blockMessage('Old visits have been checkout!', 'Thank you...', 'comment');
    }

}
