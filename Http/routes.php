<?php

use Illuminate\Routing\Router;

$router->get('patients/queue/{department}', ['uses' => 'EvaluationController@queues', 'as' => 'queues']);
$router->get('patients/visits/{visit}/preview/{department}', ['uses' => 'EvaluationController@preview', 'as' => 'preview']);
$router->get('patients/visit/{visit}/evaluate/{department}', ['uses' => 'EvaluationController@evaluate', 'as' => 'evaluate']);

$router->post('patients/evaluate/pharmacy/prescription', ['uses' => 'EvaluationController@pharmacy_prescription', 'as' => 'evaluate.pharmacy.prescription']);
$router->post('patients/evaluate/pharmacy/dispense', ['uses' => 'EvaluationController@pharmacy_dispense', 'as' => 'pharmacy.dispense']);
$router->get('patients/evaluate/pharmacy/prescription/cancel', ['uses' => 'ApiController@pharmacy_cancel_prescription', 'as' => 'pharmacy.prescription.cancel']);

$router->post('order/new/{type}', ['as' => 'order', 'uses' => 'InvestigationsController']);
//results
$router->post('evaluation/results', ['uses' => 'EvaluationController@investigation_result', 'as' => 'investigation_result']);
$router->get('evaluation/show/{visit}/results', ['uses' => 'EvaluationController@view_result', 'as' => 'view_result']);
//patient review
$router->get('patients/review/all', ['uses' => 'EvaluationController@review', 'as' => 'review']);
$router->get('patients/review/{patient}', ['uses' => 'EvaluationController@review_patient', 'as' => 'review_patient']);
//settings
$router->group(['prefix' => 'setup', 'as' => 'setup.'], function (Router $router) {
    $router->get('procedures/show/{procedure?}', ['as' => 'procedures', 'uses' => 'SetupController@procedures']);
    $router->post('procedures/save', ['as' => 'procedures.save', 'uses' => 'SetupController@save_procedure']);
    $router->get('procedure_cat/show/{cat?}', ['as' => 'procedure_cat', 'uses' => 'SetupController@procedure_cat']);
    $router->post('procedure_cat/save', ['as' => 'procedure_cat.save', 'uses' => 'SetupController@save_procedure_cat']);
});

$router->group(['prefix' => 'report', 'as' => 'report.'], function (Router $router) {
    $router->post('pay/{patient?}', ['as' => 'pay_receipt', 'uses' => 'ReportsController@payment_receipt']);
    $router->post('patients/sick_off/notes', ['uses' => 'ReportsController@sick_off', 'as' => 'sick_off']);
});

//printables

$router->group(['prefix' => 'print', 'as' => 'print.'], function (Router $router) {
    $router->get('prescription/{visit}', ['uses' => 'ReportsController@print_prescription', 'as' => 'prescription']);
});
