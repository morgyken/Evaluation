<?php

namespace Ignite\Evaluation\Database\Seeders;

use Ignite\Evaluation\Jobs\DiagnosisCodeSeeder;
use Illuminate\Database\Seeder;

class EvaluationDatabaseSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        // $this->call("OthersTableSeeder");
        $this->call(ProceduresTableSeeder::class);
        /*
         * @todo THis takes long add to dispatch in background
         */
        //  $this->call(DiagnosisCodeTableSeeder::class);
        /* $job = (new DiagnosisCodeSeeder())->onQueue('evaluation'); //->delay(new \Date('+3 minutes'));
          dispatch($job); */
    }

}
