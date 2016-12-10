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

use Ignite\Evaluation\Entities\VisitMeta;

/**
 * Interface EvaluationRepository
 *
 * Contain base class functions for evaluation
 * @package Ignite\Evaluation\Repositories
 */
interface EvaluationRepository {

    /**
     * Create a central management for preemptive patient evaluation route
     * @param $patient_visit
     * @param bool $flag Switch to determine if we use the parameter patient_visit as either patient id or schedule id
     * @return array The associative array for patient record
     */
    public function patient_management($patient_visit, $flag = null);

    /**
     * Create a new visit incase it has not been setup yet
     * @param $schedule
     * @deprecated since version 1.4 The current model does not require to create an new visit. Can implement by type-hinting
     * @return int
     */
    public function create_new_visit($schedule);

    /**
     * Save patient vitals
     * @param
     */
    public function save_vitals();

    /**
     * @return mixed
     */
    public function get_diagnosis_codes_auto();

    /**
     * @param
     */
    public function save_notes();

    /**
     * @return mixed
     */
    public function save_results_investigations();

    /**
     * @return mixed
     */
    public function save_eye_exam();

    /**
     * @return mixed
     */
    public function save_drawings();

    /**
     * @return mixed
     */
    public function save_diagnosis();

    /**
     * @param
     * @return bool
     */
    public function save_prescriptions();

    /**
     * Save the op notes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function save_opnotes();

    /**
     * @return mixed
     */
    public function set_visit_date();

    /**
     * @return mixed
     */
    public function update_visit_meta();

    /**
     * @param VisitMeta $meta
     * @return mixed
     */
    public function book_for_theatre(VisitMeta $meta);

    /**
     * @param null $data
     * @return mixed
     */
    public function checkout($data = null);

    /**
     * Saves a new procedure category model. Updates a model if ID is supplied in param
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function add_procedure_category();

    /**
     * Save procedure model instance
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function add_procedure();

    /**
     * @param $type
     * @return mixed
     */
    public function order_evaluation($type);

    /**
     * @return mixed
     */
    public function save_preliminary_eye();

    /**
     * @return bool Description
     */
    public function checkout_patient();
}
