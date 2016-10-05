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
 * Description of EvaluationRepository
 *
 * @author samuel
 */
interface EvaluationRepository {

    /**
     * @return mixed
     */
    public function save_opnotes();

    /**
     * @return mixed
     */
    public function save_notes();

    /**
     * @return mixed
     */
    public function save_vitals();

    /**
     * @return mixed
     */
    public function get_diagnosis_codes_auto();
}
