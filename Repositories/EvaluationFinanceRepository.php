<?php

/*
 * =============================================================================
 *
 * Collabmed Solutions Ltd
 * Project: Collabmed Health Platform
 * Author: Samuel Okoth <sodhiambo@collabmed.com>
 *
 * =============================================================================
 */

namespace Ignite\Evaluation\Repositories;

/**
 * Description of FinanceRepository
 *
 * @author samuel
 */
interface EvaluationFinanceRepository {

    /**
     * Record payment
     * @return bool
     */
    public function record_payment();
}
