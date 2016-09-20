<?php

$params = [
    'middleware' => ['auth.admin', 'setup'],
    'prefix' => 'evaluation',
    'as' => 'evaluation.',
    'namespace' => 'Dervis\\Modules\Evaluation\Http\Controllers'];

Route::group($params, function() {
    Route::get('/', ['uses' => 'EvaluationController@index', 'as' => 'index']);
    //examinations
    Route::get('patients/preliminary_examinations/{patient}', ['uses' => 'EvaluationController@preliminary_examinations', 'as' => 'preliminary_examinations']);
    //wait list
    Route::get('patients/waiting/nurse', ['uses' => 'EvaluationController@waiting_nurse', 'as' => 'waiting_nurse']);
    Route::get('patients/waiting/doctor', ['uses' => 'EvaluationController@waiting_doctor', 'as' => 'waiting_doctor']);
    //visit  management
    Route::get('patients/visits/preliminary/{patient}/{flag?}', ['uses' => 'EvaluationController@preliminary_examinations', 'as' => 'patient_preview']);
    Route::get('patients/visits/manage/{patient}/{flag?}', ['uses' => 'EvaluationController@nurse_manage', 'as' => 'nurse_manage']);
    Route::get('patients/visits/reviews/{patient}', ['uses' => 'EvaluationController@patient_visits', 'as' => 'patient_visits']);
    //new visit
    Route::get('patients/visit/new/{patient?}', ['uses' => 'EvaluationController@new_visit', 'as' => 'new_visit']);
    //evaluate
    Route::get('patients/visits/evaluate/{visit}', ['uses' => 'EvaluationController@patient_evaluation', 'as' => 'evaluate']);
    Route::get('patients/visits/nursing/{visit}', ['uses' => 'EvaluationController@patient_nursing', 'as' => 'nursing_manage']);
    //signout
    Route::get('patients/visit/checkout/{visit}/{section}', ['uses' => 'EvaluationController@sign_out', 'as' => 'sign_out']);
    //patient review
    Route::get('patients/review/all', ['uses' => 'EvaluationController@review', 'as' => 'review']);
    Route::get('patients/review/{patient}', ['uses' => 'EvaluationController@review_patient', 'as' => 'review_patient']);
    //waiting radiology
    Route::get('patients/waiting/radiology', ['uses' => 'EvaluationController@waiting_radiology', 'as' => 'waiting_radiology']);
    Route::get('patients/radiology/evaluate/{visit}', ['uses' => 'EvaluationController@radiology', 'as' => 'evaluate.radiology']);
    //waiting labs
    Route::get('patients/waiting/labs', ['uses' => 'EvaluationController@waiting_labs', 'as' => 'waiting_laboratory']);
    Route::get('patients/laboratory/evaluate/{visit}', ['uses' => 'EvaluationController@labs', 'as' => 'evaluate.laboratory']);
    //waiting diagnostics
    Route::get('patients/waiting/diagnostics', ['uses' => 'EvaluationController@waiting_diagnostics', 'as' => 'waiting_diagnostics']);
    Route::get('patients/diagnostics/evaluate/{visit}', ['uses' => 'EvaluationController@diagnostics', 'as' => 'evaluate.diagnostics']);

    //waiting theatre
    Route::get('patients/waiting/theatre', ['uses' => 'EvaluationController@waiting_theatre', 'as' => 'waiting_theatre']);
    Route::get('patients/theatre/evaluate/{visit}', ['uses' => 'EvaluationController@theatre', 'as' => 'evaluate.theatre']);
});
