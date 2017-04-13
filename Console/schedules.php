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
//$schedule->command('queue:work --queue=evaluation')->everyMinute();
$schedule->command('evaluation:checkout')->everyFiveMinutes();
