<?php

namespace Ignite\Evaluation\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the package's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        parent::schedule($schedule);
        if ((bool)m_setting('evaluation.auto_checkout')) {
            $schedule->command('evaluation:checkout')->everyThirtyMinutes();
        }
    }
}