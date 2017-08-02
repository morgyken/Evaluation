<?php

use Ignite\Core\Contracts\Authentication;
use Illuminate\Routing\Router;

$router->get('patients/queue/{department}', ['uses' => 'EvaluationController@queues', 'as' => 'queues']);
$router->match(['get','post'],'samples/{patient?}', ['uses' => 'EvaluationController@labotomy', 'as' => 'labotomy']);
$router->match(['get','post'],'formulae/{id?}', ['uses' => 'EvaluationController@Formulae', 'as' => 'formulae']);
$router->match(['get','post'],'sample/barcode/{id?}/print', ['uses' => 'EvaluationController@labotomy_print', 'as' => 'labotomy.print']);
$router->get('patients/visits/{visit}/preview/{department}', ['uses' => 'EvaluationController@preview', 'as' => 'preview']);
$router->get('patients/visit/{visit}/evaluate/{department}', ['uses' => 'EvaluationController@evaluate', 'as' => 'evaluate']);

$router->post('patients/evaluate/pharmacy/prescription', ['uses' => 'EvaluationController@pharmacy_prescription', 'as' => 'evaluate.pharmacy.prescription']);
$router->post('patients/evaluate/pharmacy/dispense', ['uses' => 'EvaluationController@pharmacy_dispense', 'as' => 'pharmacy.dispense']);
$router->get('patients/evaluate/pharmacy/cancel/presc/{id?}', ['uses' => 'EvaluationController@cancelPresc', 'as' => 'pharmacy.purge.presc']);
$router->get('patients/evaluate/pharmacy/prescription/cancel', ['uses' => 'ApiController@pharmacy_cancel_prescription', 'as' => 'pharmacy.prescription.cancel']);

$router->post('order/new/{type}', ['as' => 'order', 'uses' => 'InvestigationsController']);
//results
$router->post('evaluation/results', ['uses' => 'EvaluationController@investigation_result', 'as' => 'investigation_result']);
//$router->get('evaluation/results', ['uses' => 'EvaluationController@investigation_result', 'as' => 'investigation_result']);
$router->get('evaluation/show/{visit}/results', ['uses' => 'EvaluationController@view_result', 'as' => 'view_result']);
//patient review
$router->get('patients/review/all', ['uses' => 'EvaluationController@review', 'as' => 'review']);
$router->get('patients/review/{patient}', ['uses' => 'EvaluationController@review_patient', 'as' => 'review_patient']);
//signout
$router->get('patients/visit/checkout/{visit}/{section}', ['uses' => 'EvaluationController@sign_out', 'as' => 'sign_out']);
//settings
$router->group(['prefix' => 'setup', 'as' => 'setup.'], function (Router $router) {
    $router->get('procedures/show/{procedure?}', ['as' => 'procedures', 'uses' => 'SetupController@procedures']);
    $router->post('procedures/save', ['as' => 'procedures.save', 'uses' => 'SetupController@save_procedure']);

    $router->get('procedure_cat/show/{cat?}', ['as' => 'procedure_cat', 'uses' => 'SetupController@procedure_cat']);
    $router->post('procedure_cat/save', ['as' => 'procedure_cat.save', 'uses' => 'SetupController@save_procedure_cat']);

    $router->get('procedures/templates/{procedure?}', ['as' => 'template', 'uses' => 'SetupController@Templates']);
    $router->post('procedures/templates/{procedure?}', ['as' => 'template', 'uses' => 'SetupController@Templates']);
    $router->get('procedure/category/template/{category?}', ['as' => 'procedure_cat.template', 'uses' => 'SetupController@ProcedureCategoryTemplates']);
    $router->post('procedure/category/template/{category?}', ['as' => 'procedure_cat.template', 'uses' => 'SetupController@ProcedureCategoryTemplates']);

    $router->get('sub-procedures/show/{procedure?}', ['as' => 'subprocedures', 'uses' => 'SetupController@subprocedures']);
    $router->post('sub-procedures/save', ['as' => 'subprocedures.save', 'uses' => 'SetupController@savesubprocedure']);
    $router->get('temp', ['as' => 'temp', 'uses' => 'SetupController@temp']);

    $router->match(['post', 'get'], 'partners/manage/{id?}', ['uses' => 'SetupController@ManagePartnerInstitutions', 'as' => 'manage_partners']);
    $router->get('partners/{id?}', ['uses' => 'SetupController@partnerInstitutions', 'as' => 'partners']);

    $router->match(['post', 'get'], 'sampletypes/{id?}', ['uses' => 'SetupController@SampleTypes', 'as' => 'samples.types']);

    $router->get('lab/samples/{id?}', ['uses' => 'SetupController@LabSamples', 'as' => 'test.samples']);
    $router->match(['post', 'get'], 'partners/manage/{id?}', ['uses' => 'SetupController@ManagePartnerInstitutions', 'as' => 'manage_partners']);
    $router->match(['get','post'],'lab/test_categories/{id?}', ['uses' => 'SetupController@LabCategories', 'as' => 'test.categories']);

    $router->get('lab/test_title/{id?}', ['uses' => 'SetupController@TestTitles', 'as' => 'test.titles']);
    $router->post('lab/save/test_title', ['uses' => 'SetupController@TestTitles', 'as' => 'test.titles.save']);

    $router->match(['post', 'get'], 'lab/reference_ranges/{id?}', ['uses' => 'SetupController@ManageRanges', 'as' => 'ranges']);
    $router->match(['post', 'get'], 'lab/sample_types/{id?}', ['uses' => 'SetupController@SampleTypes', 'as' => 'sample_types']);
    $router->match(['post', 'get'], 'lab/methods/{id?}', ['uses' => 'SetupController@SampleCollectionMethods', 'as' => 'methods']);
    $router->match(['post', 'get'], 'lab/units/{id?}', ['uses' => 'SetupController@ManageUnits', 'as' => 'units']);
    $router->match(['post', 'get'], 'additives/{id?}', ['uses' => 'SetupController@ManageAdditives', 'as' => 'additives']);

    $router->match(['post', 'get'], 'remarks/{id?}', ['uses' => 'SetupController@ManageRemarks', 'as' => 'remarks']);
});

$router->group(['prefix' => 'report', 'as' => 'report.'], function (Router $router) {
    $router->post('pay/{patient?}', ['as' => 'pay_receipt', 'uses' => 'ReportsController@payment_receipt']);
    $router->post('patients/sick_off/notes', ['uses' => 'ReportsController@sick_off', 'as' => 'sick_off']);
});
$router->group(['prefix' => 'externaldoctor', 'as' => 'exdoctor.'], function (Router $router) {
    $router->match(['post', 'get'], 'patients/{id?}', ['uses' => 'ExternalController@patients', 'as' => 'patients']);
    $router->match(['post', 'get'], 'order/{patient?}', ['uses' => 'ExternalController@orders', 'as' => 'order']);
    $router->match(['post', 'get'], 'makeorder/{patient?}', ['uses' => 'ExternalController@make_order', 'as' => 'order.make']);
    $router->match(['post', 'get'], 'view/order/{id?}', ['uses' => 'ExternalController@view_order', 'as' => 'order.view']);
    $router->match(['post', 'get'], 'queue/', ['uses' => 'ExternalController@queue', 'as' => 'queue']);
});
$router->group(['prefix' => 'lab', 'as' => 'lab.'], function (Router $router) {
    $router->get('result/verify/{result?}', ['as' => 'verify', 'uses' => 'EvaluationController@VerifyLabResult']);
    $router->get('result/revert/{result?}', ['as' => 'revert', 'uses' => 'EvaluationController@RejectLabResult']);
    $router->get('result/publish/{result?}', ['as' => 'publish', 'uses' => 'EvaluationController@PublishLabResult']);
    $router->get('result/send/{result?}', ['as' => 'send', 'uses' => 'EvaluationController@SendLabResult']);
});
$router->get('results/{result?}/revert/', ['as' => 'res.revert', 'uses' => 'EvaluationController@RevertResult']);
//printables
$router->group(['prefix' => 'print', 'as' => 'print.'], function (Router $router) {
    $router->get('prescription/{visit}', ['uses' => 'ReportsController@print_prescription', 'as' => 'prescription']);
    Route::get('patient/notes/{no}', ['uses' => 'ReportsController@patient_notes', 'as' => 'patient_notes']);
    Route::get('patient/notes/toword/{no}', ['uses' => 'ReportsController@patient_notes_to_word', 'as' => 'to_word']);
    Route::post('patient/notes/specific/', ['uses' => 'ReportsController@pn_specific', 'as' => 'patient_notes_specific']);
    Route::post('patient/notes/toword/specific/', ['uses' => 'ReportsController@pn_towrd_specific', 'as' => 'to_word_specific']);

    Route::get('lab/results/{visit}', ['uses' => 'ReportsController@print_lab', 'as' => 'print_lab']);
    Route::get('lab/results/one/{id}/{visit}', ['uses' => 'ReportsController@print_lab_one', 'as' => 'print_lab.one']);

    Route::get('results/{visit}/{type}', ['uses' => 'ReportsController@print_results', 'as' => 'print_res']);
    Route::get('results/one/{id}/{visit}/{type}', ['uses' => 'ReportsController@print_results_one', 'as' => 'print_res.one']);
});
