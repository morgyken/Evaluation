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

$settings = [
    'auto_checkout' => [
        'description' => 'Auto - checkout after 24 hours',
        'view' => 'checkbox',
        'hint' => 'This will auto-checkout after 24 hours'
    ],
    'enable_templates' => [
        'description' => 'Enable laboratory templates',
        'view' => 'checkbox',
        'hint' => 'Default templates to be enabled'
    ],
    'eye_exam' => [
        'description' => 'Enable Eye',
        'view' => 'checkbox',
        'hint' => 'This will allow you to perform eye examination in doctor evaluation'
    ],
    'op_notes' => [
        'description' => 'Enable OP notes',
        'view' => 'checkbox',
        'hint' => 'Enable the OP Notes section in doctors section'
    ],
    'drawings' => [
        'description' => 'Enable Drawings',
        'view' => 'checkbox',
        'hint' => 'Enable the Drawings section in doctors section'
    ],
    'discount' => [
        'description' => 'Allow Discounts At',
        'view' => 'evaluation::fields.discount',
        'hint' => 'Select places where discount is applicable'
    ],
    'doctor_see_all' => [
        'description' => 'Allow Doctors to see patients in other Doctor\'s queue',
        'view' => 'checkbox',
    ],
    'request_checkout' => [
        'description' => 'Ask me to checkout after evaluating a patient',
        'view' => 'checkbox'
    ],
    'pos_all' => [
        'description' => 'Charge all procedures to walkins',
        'view' => 'checkbox'
    ],
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
$clinics = [];
foreach ($_c as $k => $v) {
    $clinics['with_clinic_' . $k] = [
        'description' => 'Enable ' . $v . ' clinic',
        'view' => 'checkbox',
    ];
}
$_d = [
    'doctor',
    'pharmacy',
    'nursing',
    'radiology',
    'ultrasound',
    'dental',
    'theatre',
    'laboratory',
    'diagnostics',
];
$departments = [];
foreach ($_d as $d) {
    $departments['no_' . $d] = [
        'description' => 'Disable ' . ucfirst($d),
        'view' => 'checkbox',
    ];
}
return array_merge($settings, $departments, $clinics);