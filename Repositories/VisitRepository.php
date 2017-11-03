<?php

namespace Ignite\Evaluation\Repositories;

use Ignite\Evaluation\Entities\Visit;

class VisitRepository
{
    protected $visit;

    /*
    * Get a visit from the evaluation_visits table
    */
    public function findById($id)
    {
        return Visit::with(['patients'])->findOrFail($id);
    }
}