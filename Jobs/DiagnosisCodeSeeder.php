<?php

namespace Ignite\Evaluation\Jobs;

use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;

class DiagnosisCodeSeeder implements ShouldQueue {

    use InteractsWithQueue,
        SerializesModels,
        Queueable;

    public $seed_class;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($seed_class) {
        $this->seed_class = $seed_class;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {

    }

}
