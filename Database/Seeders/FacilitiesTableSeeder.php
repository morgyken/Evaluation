<?php

namespace Ignite\Evaluation\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Ignite\Evaluation\Entities\Facility;

class FacilitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $facilites = array(
            ['name' => 'outpatient', 'description' => 'indicates that the marked item was used at outpatient'],
            ['name' => 'inpatient', 'description' => 'indicates that the marked item was used at inpatient']
        );

        foreach($facilites as $facility)
        {
            Facility::create($facility);
        }
    }
}
