<?php

/*
 * =============================================================================
 *
 * Collabmed Solutions Ltd
 * Project: iClinic
 * Author: Samuel Okoth <sodhiambo@collabmed.com>
 *
 * =============================================================================
 */


$ajax = [
    'namespace' => 'Dervis\Modules\Evaluation\Http\Controllers',
    'as' => 'evaluation.ajax.',
    'prefix' => 'evaluation/ajax',
    'middleware' => ['ajax'],
];
//AJAX ONLY routes
Route::group($ajax, function() {
    Route::delete('cancel_checkin', ['uses' => 'ApiController@cancel_checkin', 'as' => 'cancel_checkin']);
    Route::get('checkout_patient', ['uses' => 'ApiController@checkout_patient', 'as' => 'checkout_patient']);
    Route::get('diagnosis/{regex?}', ['uses' => 'ApiController@diagnosis_codes', 'as' => 'autocoplete_diagnosis']);
    Route::post('auto_save_vitals', ['uses' => 'ApiController@save_vitals', 'as' => 'save_vitals']);
    Route::post('auto_save_notes', ['uses' => 'ApiController@save_notes', 'as' => 'save_notes']);
    Route::post('auto_save_treatment', ['uses' => 'ApiController@save_treatment', 'as' => 'save_treatment']);
    Route::post('auto_save_diagnosis', ['uses' => 'ApiController@save_diagnosis', 'as' => 'save_diagnosis']);
    Route::post('save_prescription', ['uses' => 'ApiController@save_prescription', 'as' => 'save_prescription']);
    Route::post('save_opnotes', ['uses' => 'ApiController@save_opnotes', 'as' => 'save_opnotes']);
    Route::post('set_next_date', ['as' => 'set_next_date', 'uses' => 'ApiController@set_next_date']);
    Route::post('set_visit_date', ['as' => 'set_visit_date', 'uses' => 'ApiController@set_visit_date']);
    Route::get('report_cashier', ['as' => 'cashier_report', 'uses' => 'ApiController@cashier_report']);
    Route::post('save_drawings', ['as' => 'save_drawings', 'uses' => 'ApiController@save_drawings']);
    Route::get('delete_procedure_category', ['as' => 'delete_procedure_cat', 'uses' => 'ApiController@delete_procedure_cat']);
    Route::post('save_visit_metas', ['uses' => 'ApiController@save_visit_metas', 'as' => 'save_visit_metas']);
    Route::post('auto_order_diagnosis', ['uses' => 'ApiController@order_diagnosis', 'as' => 'order_diagnosis']);
    Route::post('save_preliminary', ['uses' => 'ApiController@save_preliminary', 'as' => 'save_preliminary']);
    Route::post('auto_save_results', ['uses' => 'ApiController@investigation_result', 'as' => 'investigation_result']);
});
