<?php

namespace Ignite\Evaluation\Jobs;

use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Artisan;

class DiagnosisCodeSeeder implements ShouldQueue {

    use InteractsWithQueue,
        SerializesModels,
        Queueable;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct() {

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {
        Artisan::call('db:seed', ['class' => '\Ignite\Evaluation\Database\Seeders\DiagnosisCodeTableSeeder']);
    }

}
