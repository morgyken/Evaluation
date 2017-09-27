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
return [
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
    'no_doctor' => [
        'description' => 'Disable Doctor Queue',
        'view' => 'checkbox'
    ],
    'no_pharmacy' => [
        'description' => 'Disable Pharmacy Queue',
        'view' => 'checkbox'
    ],
    'no_nursing' => [
        'description' => 'Disable Nursing',
        'view' => 'checkbox'
    ],

    'no_radiology' => [
        'description' => 'Disable Radiology Queue',
        'view' => 'checkbox'
    ],
    'no_ultrasound' => [
        'description' => 'Disable Ultrasound Queue',
        'view' => 'checkbox'
    ],
    'no_dental' => [
        'description' => 'Disable Dental',
        'view' => 'checkbox',
    ],
    'no_physiotherapy' => [
        'description' => 'Disable Physiotherapy',
        'view' => 'checkbox'
    ],
    'no_theatre' => [
        'description' => 'Disable Theatre',
        'view' => 'checkbox'
    ],
    'no_laboratory' => [
        'description' => 'Disable Lab',
        'view' => 'checkbox'
    ],
    'no_diagnostics' => [
        'description' => 'Disable Diagnostics',
        'view' => 'checkbox',
        'hint' => 'Click to disable'
    ],
    'doctor_see_all' => [
        'description' => 'Allow Doctors to see patients in other Doctor\'s queue',
        'view' => 'checkbox',
        'hint' => 'Click to enable'
    ],
];
