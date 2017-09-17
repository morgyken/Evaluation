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
        'view' => 'checkbox',
        'hint' => 'Click to disable doctors queue'
    ],
    'no_pharmacy' => [
        'description' => 'Disable Pharmacy Queue',
        'view' => 'checkbox',
        'hint' => 'Click to disable pharmacy'
    ],
    'no_nursing' => [
        'description' => 'Disable Nursing',
        'view' => 'checkbox',
        'hint' => 'Click to disable nursing'
    ],
];
