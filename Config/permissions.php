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
$original = [
    'evaluation.examination' => [
        'preliminary' => 'Nursing and preliminary',
        'doctor' => 'Doctor Evaluation',
        'theatre' => 'Theatre Evaluation',
        'laboratory' => 'Laboratory Evaluation',
        'diagnostics' => 'Diagnostics Evaluation',
        'radiology' => 'Radiology Evaluation',
        'pharmacy' => 'Pharmacy Evaluation',
        'review' => 'Review patient information',
        'ultrasound' => 'Ultrasound Evaluation',
        'dental' => 'Dental Evaluation',
        'optical' => 'Optical Queue',
    ],
    'evaluation.settings' => [
        'procedure_categories' => 'View procedures categories',
        'manage_procedures_cat' => 'Manage procedure categories',
        'procedures' => 'View procedures',
        'manage_procedures' => 'Manage procedures',
    ],
    'external' => [
        'external' => 'External user dashboard',
    ]
];

$_c = [
    'mch' => 'MCH',
    'hpd' => 'Hypertension and Diabetes',
    'orthopeadic' => 'Orthopeadic',
    'popc' => 'Pedeatrics',
    'mopc' => 'Medical',
    'sopc' => 'Sergical',
    'gopc' => 'Gyenecology',
    'physio' => 'Physiotherapy',
];
foreach ($_c as $k => $v) {
    $original['evaluation.clinics'][$k] = $v;
}
return $original;