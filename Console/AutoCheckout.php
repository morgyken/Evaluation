<?php

namespace Ignite\Evaluation\Console;

use Carbon\Carbon;
use Ignite\Core\Console\Installers\Traits\BlockMessage;
use Ignite\Core\Console\Installers\Traits\SectionMessage;
use Ignite\Evaluation\Entities\VisitDestinations;
use Ignite\Evaluation\Repositories\EvaluationRepository;
use Illuminate\Console\Command;

class AutoCheckout extends Command
{

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
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $this->blockMessage('Checking out everyone!', 'Working out...', 'comment');
        $date = Carbon::now()->subDay()->toDateTimeString();
        $destinations = VisitDestinations::where('created_at', '<=', $date)->get();
        foreach ($destinations as $d) {
            $d->checkout = 1;
            $d->finish_at = Carbon::now()->toDateTimeString();
            $d->save();
        }
        $this->blockMessage('Old visits have been checkout!', 'Thank you...', 'comment');
    }

}
