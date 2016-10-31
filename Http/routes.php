<?php

use Illuminate\Routing\Router;

$router->get('/', ['uses' => 'EvaluationController@index', 'as' => 'index']);
//examinations
$router->get('patients/preliminary_examinations/{patient}', ['uses' => 'EvaluationController@preliminary_examinations', 'as' => 'preliminary_examinations']);
//wait list
$router->get('patients/waiting/nurse', ['uses' => 'EvaluationController@waiting_nurse', 'as' => 'waiting_nurse']);
$router->get('patients/waiting/doctor', ['uses' => 'EvaluationController@waiting_doctor', 'as' => 'waiting_doctor']);
//visit  management
$router->get('patients/visits/preliminary/{patient}/{flag?}', ['uses' => 'EvaluationController@preliminary_examinations', 'as' => 'patient_preview']);
$router->get('patients/visits/manage/{patient}/{flag?}', ['uses' => 'EvaluationController@nurse_manage', 'as' => 'nurse_manage']);
$router->get('patients/visits/reviews/{patient}', ['uses' => 'EvaluationController@patient_visits', 'as' => 'patient_visits']);
//new visit
$router->get('patients/visit/new/{patient?}', ['uses' => 'EvaluationController@new_visit', 'as' => 'new_visit']);
//evaluate
$router->get('patients/visits/evaluate/{visit}', ['uses' => 'EvaluationController@patient_evaluation', 'as' => 'evaluate']);
$router->get('patients/visits/nursing/{visit}', ['uses' => 'EvaluationController@patient_nursing', 'as' => 'nursing_manage']);
//signout
$router->get('patients/visit/checkout/{visit}/{section}', ['uses' => 'EvaluationController@sign_out', 'as' => 'sign_out']);
//patient review
$router->get('patients/review/all', ['uses' => 'EvaluationController@review', 'as' => 'review']);
$router->get('patients/review/{patient}', ['uses' => 'EvaluationController@review_patient', 'as' => 'review_patient']);
//waiting radiology
$router->get('patients/waiting/radiology', ['uses' => 'EvaluationController@waiting_radiology', 'as' => 'waiting_radiology']);
$router->get('patients/radiology/evaluate/{visit}', ['uses' => 'EvaluationController@radiology', 'as' => 'evaluate.radiology']);
//waiting labs
$router->get('patients/waiting/labs', ['uses' => 'EvaluationController@waiting_labs', 'as' => 'waiting_laboratory']);
$router->get('patients/evaluate/{visit}/laboratory', ['uses' => 'EvaluationController@labs', 'as' => 'evaluate.laboratory']);
//waiting diagnostics
$router->get('patients/waiting/diagnostics', ['uses' => 'EvaluationController@waiting_diagnostics', 'as' => 'waiting_diagnostics']);
$router->get('patients/evaluate/{visit}/diagnostics', ['uses' => 'EvaluationController@diagnostics', 'as' => 'evaluate.diagnostics']);

//waiting theatre
$router->get('patients/waiting/theatre', ['uses' => 'EvaluationController@waiting_theatre', 'as' => 'waiting_theatre']);
$router->get('patients/theatre/evaluate/{visit}', ['uses' => 'EvaluationController@theatre', 'as' => 'evaluate.theatre']);

$router->group(['prefix' => 'reports', 'as' => 'reports.'], function(Router $router) {
    $router->post('patients/sick_off/notes', ['uses' => 'ReportsController@sick_off', 'as' => 'sick_off']);
});

//new orders
$router->post('order/new/{type}', ['as' => 'order', 'uses' => 'InvestigationsController']);

//settings
$router->group(['prefix' => 'setup', 'as' => 'setup.'], function (Router $router) {
    $router->get('procedures/show/{procedure?}', ['as' => 'procedures', 'uses' => 'SetupController@procedures']);
    $router->post('procedures/save', ['as' => 'procedures.save', 'uses' => 'SetupController@save_procedure']);
    $router->get('procedure_cat/show/{cat?}', ['as' => 'procedure_cat', 'uses' => 'SetupController@procedure_cat']);
    $router->post('procedure_cat/save', ['as' => 'procedure_cat.save', 'uses' => 'SetupController@save_procedure_cat']);
});

$router->group(['prefix' => 'report', 'as' => 'report.'], function(Router $router) {
    $router->post('pay/{patient?}', ['as' => 'pay_receipt', 'uses' => 'ReportsController@payment_receipt']);
});
