<?php

namespace Ignite\Evaluation\Console;

use Carbon\Carbon;
use Ignite\Core\Console\Installers\Traits\BlockMessage;
use Ignite\Core\Console\Installers\Traits\SectionMessage;
use Ignite\Evaluation\Entities\Visit;
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
        if ((bool)m_setting('evaluation.auto_checkout')) {
            $this->blockMessage('Checking out everyone!', 'Working out...', 'comment');
            $date = Carbon::now()->subDay()->toDateTimeString();
//            $destinations = VisitDestinations::where('created_at', '<=', $date)
//                ->where('checkout', false)
//                ->get();
//            $_v = $_d = 0;
//            foreach ($destinations as $d) {
//                $d->checkout = 1;
//                $d->finish_at = Carbon::now()->toDateTimeString();
//                $d->save();
//                $_d++;
//            }
            $visits = Visit::where('status', '<>', '!!')->get();
            foreach ($visits as $visit) {
                $p = (bool)$visit->destinations->where('checkout', false)->count();
                if (!$p && !$visit->admission) {
                    $visit->status = '!!';
                    $visit->save();
                    $_v++;
                }
            }
            $this->info("Removed $_v visits and $_d destinations");
            $this->blockMessage('Old visits have been checkout!', 'Thank you...', 'comment');
        }
    }

}
