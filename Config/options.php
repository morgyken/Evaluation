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
    'card_types' => [
        'mastercard' => 'MasterCard',
        'visa' => 'VISA',
        'discovery' => 'Discovery',
    ],
    'age_groups' => [
        'all' => 'All Age Groups',
        'adult' => 'Adult',
        'child' => 'Child',
        'birth' => 'At birth',
        '0-3d' => '0-3 Days',
        '0-15d' => '<15 Days',
        '1-7d' => '1-7 Days',
        '0-13d' => '0-13 Days',
        '0-14d' => '0-14 Days',
        '6-60d' => '6 Days - 2 Months',
        '0-29d' => '29 Days and Below',
        '15-365d' => '15 Days - 1 Year',
        '14-29d' => '14-29 Days',
        '8-14d' => '8-14 Days',
        '30-90d' => '30-90 Days',
        '90-180d' => '90-180 Days',
        '6-9m' => '6-9 Months',
        '2-24m' => '2-24 Months',
        '10-11m' => '10-11 Months',
        '12-23m' => '12-23 Months',
        '15-1m' => '15 Days -1 Month',
        '4-30d' => '4-30 Days',
        '2-5m' => '2-5 Months',
        '6-12m' => '6 Months - 1 Year',
        '0-9y' => '0-9 Years',
        '1-9y' => '1-9 Years',
        '1-3y' => '1-3 Years',
        '1-10y' => '1-<10 Years',
        '1-11y' => '1-<11 Years',
        '10-13y' => '10-<13 Years',
        '13-15y' => '13-<15 Years',
        '15-17y' => '15-<15 Years',
        '17-19y' => '17-<19 Years',
        '2y' => '2 Years',
        '2-3y' => '2-3 Years',
        '2-5y' => '2-5 Years',
        '3-5y' => '3-5 Years',
        '4-9y' => '4-9 Years',
        '6-7y' => '6-7 Years',
        '8-9y' => '8-9 Years',
        '10-11y' => '10-11 Years',
        '10-13y' => '10-13 Years',
        '11-13y' => '11-13 Years',
        '13-15y' => '13-15 Years',
        '15-19y' => '15-19 Years',
        '12-13y' => '12-13 Years',
        '14-15y' => '14-15 Years',
        '14-19y' => '14-19 Years',
        '16-18y' => '16-18 Years',
        '4-5y' => '4-5 Years',
        '6-7y' => '6-7 Years',
        '6-11y' => '6-11 Years',
        '8-9y' => '8-9 Years',
        '12-15y' => '12-15 Years',
        '9-11y' => '9-11 Years',
        '10-11y' => '10-11 Years',
        '10-19y' => '10-19 Years',
        '11-12y' => '11-12 Years',
        '12-13y' => '12-13 Years',
        '12-14y' => '12-14 Years',
        '15-16y' => '15-16 Years',
        '14-15y' => '14-15 Years',
        '1-24m' => '1-24 Months',
        '25-60m' => '25-60 Months',
        '0-9y' => '0-9 Years',
        '5-19y' => '5-19 Years',
        '10-19y' => '10-19 Years',
        'over19' => '19 Years and above',
        'over15' => '15 Years and above',
        '0-50y' => '0-50 Years',
        '50-500y' => '>=50 Years',
        '51-85y' => '51-85 Years',
        'over85' => '>85 Years',
        '1-10y' => '1-<10 Years',
        '10-19y' => '10-<19 Years',
        '19-50' => '19-<50 Years',
    ],
    'range_types' => [
        'range' => 'Range',
        'less_greater' => 'Less-than or Greater-than',
        'other' => 'Other',
    ],
    'age_group_types' => [
        'range' => 'Range',
        'less_greater' => 'Less-than or Greater-than',
        'general' => 'General eg adults, children etc.',
    ],
    'sex' => [
        'both' => 'both',
        'male' => 'male',
        'female' => 'female',
    ],
    'lg_type' => [
        '<' => 'Less Than',
        '<=' => 'Less Than or Equal',
        '>' => 'Greater Than',
        '>=' => 'Greater Than or Equal',
    ],
    'critical_value_types' => [
        '=' => 'Equal (=)',
        '<' => 'Less Than (<)',
        '>' => 'Greater Than (>)',
        '<=' => 'Less than or Equal',
        '>=' => 'Greater than or Equal',
        'range' => 'Range',
        'other' => 'Other',
    ],
    'applies_to' => [
        1 => 'Doctor',
        2 => 'Pharmacy',
        3 => 'Lab',
        4 => 'Radiology',
        5 => 'Nursing',
        6 => 'UltraSound',
        7 => 'Diagnostics',
        8 => 'Theatre',
        9 => 'Physiotherapy',
    ],
    'visit_status' => [
        1 => 'Scheduled',
        2 => 'Checked In',
        3 => 'Checked Out',
        3 => 'Cancelled',
        4 => 'Rescheduled',
        5 => 'Proposed',
        6 => 'No show',
    ],
    'temperature_location' => [
        1 => 'Oral',
        2 => 'Rectal',
        3 => 'Tympanic Membrane',
        4 => 'Axilary',
        5 => 'Temporal Atery',
    ],
    'prescription_method' => [
        1 => ' b.i.d',
        2 => 't.i.d',
        3 => 'q.i.d',
        4 => 'STAT',
        5 => 'O.D',
        6 => 'q.3h',
        7 => 'q.4h',
        8 => 'q.5h',
        9 => 'q.6h',
        10 => 'q.8h',
        11 => 'q.d',
        12 => 'a.c',
        13 => 'p.c.',
        14 => 'a.m',
        15 => 'p.m',
        16 => 'anti',
        17 => 'h',
        18 => 'hs',
        19 => 'p.r.n',
        20 => 'Hourly',
        21 => 'Two Hourly',
        22 => 'Four Hourly',
        23 => 'Nocte',
        24 => 'alternate day',
        25 => 'morning',
    ],
    'prescription_duration' => [
        1 => 'day(s)',
        2 => 'week(s)',
        3 => 'month(s)',
        4 => 'year(s)',
    ],
    'age_in' => [
        'd' => 'day(s)',
        'w' => 'week(s)',
        'm' => 'month(s)',
        'y' => 'year(s)',
    ],
    'sensitivity' => [
        'R' => 'R',
        'S' => 'S',
    ],
    'lp_flags' => [
        'normal'=>'Normal',
        'desirable' => 'Desirable',
        'acceptable' => 'Acceptable',
        'low_increased_risk' => 'Low(increased risk)',
        'average_risk' => 'Average Risk',
        'high' => 'High',
        'borderline_high' => 'Borderline High',
        'borderline' => 'Borderline',
        'very_high' => 'Very High',
        'high_r_risk' => 'High (reduced risk)',
        'near_above_optimal' => 'Near/Above Optimal',
        'pre_diabetes'=>'Pre Diabetes',
        'Diabetes'=> 'Diabetes',
        'normal_melitus'=>'Normal Melitus',
        'igt'=>'IGT',
        'ifg'=>'IFG',
        'normal_mild_decrease'=>'Normal/Mild Decrease',
        'moderate_decrease'=>'Moderate Decrease',
        'severe_decrease'=>'Severe Decrease',
        'esrd'=>'ESRD',
        'follicular'=>'Follicular Phase',
        'ovulatory'=>'Ovulatory',
        'luteal'=>'Luteal',
        'postmenopause'=>'Postmenopause',
        'mid-cycle'=>'Mid-cycle',
    ],
    'prescription_whereto' => [
        1 => 'Per Oris',
        2 => 'Per Rectum',
        3 => 'To Skin',
        4 => 'To Affected area',
        5 => 'Sublingual',
        6 => 'OS',
        7 => 'OD',
        8 => 'OU',
        9 => 'SQ',
        10 => 'IM',
        11 => 'IV',
        12 => 'Per Nostril',
        13 => 'Both Ears',
        14 => 'Left Ear',
        15 => 'Right Ear',
        16 => 'Per Eye',
        17 => 'Sub-conj',
        18 => 'Intra-vitreal',
        19 => 'Both Eyes',
        20 => 'To Affected Area',
        21 => 'Oral',
    ],];
