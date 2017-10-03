<?php

use Illuminate\Routing\Router;

/** @var Router $router */
$router->group(['prefix' => 'inpatient', 'as' => 'inpatient.'], function (Router $router) {
    $router->get('admit',['uses' => 'EvaluationController@admit', 'as' => 'admit']);
    $router->get('admit/{patient_id}/{visit_id}',['uses' => 'EvaluationController@admit_patient']);
    //list wards
    $router->get('list',['uses'=>'EvaluationController@listWards']);
    $router->get('addWard',['uses'=>'EvaluationController@addWard']);
    $router->post('addwordFormPost',['uses'=>'EvaluationController@addwordFormPost']);
    //bed position 
    $router->get('bedPosition',['uses'=>'EvaluationController@bedPosition']);
    $router->post('bedPosition',['uses'=>'EvaluationController@postbedPosition']);
    $router->get('bedPosition/{ward_id}',['uses'=>'EvaluationController@deletebedPosition']);
//bed
    $router->post('postaddbed',['uses'=>'EvaluationController@postaddBed']);
    $router->get('delete_bed/{id}',['uses'=>'EvaluationController@postdelete_bed']);

    /*cancel request admission*/
    $router->get('cancel/{patient_id}/{id}',['uses'=>'EvaluationController@cancel']);
    /*nursing charges*/
    $router->get('Nursing_services',['uses'=>'EvaluationController@Nursing_services']);
    //add recurrent charge
    $router->get('add_recurrent_charge',['uses'=>'EvaluationController@add_recurrent_charge']);
    //save new reccurent charge
    $router->post('AddReccurentCharge',['uses'=>'EvaluationController@AddReccurentCharge']);

    //bed
    $router->get('bedList',['uses'=>'EvaluationController@listBeds']);
    $router->get('addBed',['uses'=>'EvaluationController@addWard']);
    $router->post('addBedFormPost',['uses'=>'EvaluationController@addBedFormPost']);
    //show available beds
    $router->get('availableBeds/{ward_id}',['uses'=>'EvaluationController@availableBeds']);
    $router->post('delete_ward',['uses'=>'EvaluationController@delete_ward']);
    $router->post('delete_bed',['uses'=>'EvaluationController@delete_bed']);

    //deposit setting
    $router->get('deposit',['uses'=>'EvaluationController@deposit']);
    $router->post('addDepositType',['uses'=>'EvaluationController@addDepositType']);
    //delete deposit type
    $router->get('delete_deposit/{deposit_id}',['uses'=>'EvaluationController@delete_deposit']);
    $router->get('admit_check',['uses'=>'EvaluationController@admit_check']);
    $router->get('topUp',['uses'=>'EvaluationController@topUp']);
    $router->post('topUpAmount',['uses'=>'EvaluationController@topUpAmount']);
    $router->get('withdraw',['uses'=>'EvaluationController@withdraw']);
    $router->post('WithdrawAmount',['uses'=>'EvaluationController@WithdrawAmount']);

    //edit bed
    $router->get('editBed/{id}',['uses'=>'EvaluationController@editBed']);
    $router->post('bedList',['uses'=>'EvaluationController@edit_bed']);
    $router->get('cancel_checkin',['uses'=>'EvaluationController@cancel_checkin']);
    //edit a deposit
    $router->get('edit_deposit/{deposit_id}',['uses'=>'EvaluationController@edit_deposit']);
    $router->post('deposit_adit',['uses'=>'EvaluationController@deposit_adit']);
    $router->post('topUpAccount',['uses'=>'EvaluationController@topUpAccount']);

    //DELETE WARD
    $router->get('delete_ward/{ward_id}',['uses'=>'EvaluationController@deleteThisWard']);
    $router->get('editWard/{ward_id}',['uses'=>'EvaluationController@getRecordWard']);
    //UPDATE WARD RECORD
    $router->post('update_ward',['uses'=>'EvaluationController@update_ward']);
    $router->get('getAvailableBedPosition/{ward}',['uses'=>'EvaluationController@getAvailableBedPosition']);
    $router->post('change_bed',['uses'=>'EvaluationController@change_bed']);
    //cancel request admissin
    $router->get('cancel_request/{visit}',['uses'=>'EvaluationController@cancel_request']);
    //delete service
    $router->get('delete_service/{service}',['uses'=>'EvaluationController@delete_service']);

    ///patient account operations
    //deposit amount..
    $router->get('account_deposit/{patient}',['uses'=>'EvaluationController@account_deposit_amount']);
    $router->post('topUpAccount',['uses'=>'EvaluationController@topUpAccountPost']);
    //withdraw an amount
    $router->get('account_withdraw/{patient}',['uses'=>'EvaluationController@account_withdraw_amount']);
    $router->post('PostWithdrawAccount',['uses'=>'EvaluationController@PostWithdrawAccount']);
    //print deposit slip
    $router->get('print',['uses'=>'EvaluationController@print']);
  
});


$router->get('patients/queue/{department}', ['uses' => 'EvaluationController@queues', 'as' => 'queues']);
$router->match(['get', 'post'], 'samples/{patient?}', ['uses' => 'EvaluationController@labotomy', 'as' => 'labotomy']);
$router->match(['get', 'post'], 'formulae/{id?}', ['uses' => 'EvaluationController@Formulae', 'as' => 'formulae']);
$router->match(['get', 'post'], 'sample/barcode/{id?}/print', ['uses' => 'EvaluationController@labotomy_print', 'as' => 'labotomy.print']);
$router->get('patients/visits/{visit}/preview/{department}', ['uses' => 'EvaluationController@preview', 'as' => 'preview']);
$router->get('patients/visit/{visit}/move',['uses'=>'EvaluationController@move_patient']);


$router->get('patients/visit/{visit}/evaluate/{department}', ['uses' => 'EvaluationController@evaluate', 'as' => 'evaluate']);
$router->get('patients/visit/{visit}/manage/{department}', ['uses' => 'EvaluationController@manage']);

$router->post('patients/evaluate/pharmacy/prescription', ['uses' => 'EvaluationController@pharmacy_prescription', 'as' => 'evaluate.pharmacy.prescription']);
$router->post('patients/evaluate/pharmacy/dispense', ['uses' => 'EvaluationController@pharmacy_dispense', 'as' => 'pharmacy.dispense']);
$router->get('patients/evaluate/pharmacy/cancel/presc/{id?}', ['uses' => 'EvaluationController@cancelPresc', 'as' => 'pharmacy.purge.presc']);

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
    $router->match(['get', 'post'], 'lab/test_categories/{id?}', ['uses' => 'SetupController@LabCategories', 'as' => 'test.categories']);

    $router->get('lab/test_title/{id?}', ['uses' => 'SetupController@TestTitles', 'as' => 'test.titles']);
    $router->post('lab/save/test_title', ['uses' => 'SetupController@TestTitles', 'as' => 'test.titles.save']);

    $router->match(['post', 'get'], 'lab/formulae/{id?}', ['uses' => 'SetupController@ManageFormulae', 'as' => 'formulae']);

    $router->match(['post', 'get'], 'lab/reference_ranges/{id?}', ['uses' => 'SetupController@ManageRanges', 'as' => 'ranges']);
    $router->match(['post', 'get'], 'lab/sample_types/{id?}', ['uses' => 'SetupController@SampleTypes', 'as' => 'sample_types']);
    $router->match(['post', 'get'], 'lab/methods/{id?}', ['uses' => 'SetupController@SampleCollectionMethods', 'as' => 'methods']);
    $router->match(['post', 'get'], 'lab/units/{id?}', ['uses' => 'SetupController@ManageUnits', 'as' => 'units']);
    $router->match(['post', 'get'], 'additives/{id?}', ['uses' => 'SetupController@ManageAdditives', 'as' => 'additives']);
    $router->match(['post', 'get'], 'lab/critical_values/{id?}', ['uses' => 'SetupController@CriticalValues', 'as' => 'critical_values']);

    $router->match(['post', 'get'], 'remarks/{id?}', ['uses' => 'SetupController@ManageRemarks', 'as' => 'remarks']);
});

$router->group(['prefix' => 'report', 'as' => 'report.'], function (Router $router) {
    $router->post('pay/{patient?}', ['as' => 'pay_receipt', 'uses' => 'ReportsController@payment_receipt']);
    $router->post('patients/sick_off/notes', ['uses' => 'ReportsController@sick_off', 'as' => 'sick_off']);
});
$router->group(['prefix' => 'externaldoctor', 'as' => 'exdoctor.'], function (Router $router) {
    $router->match(['post', 'get'], 'patients/{id?}', ['uses' => 'ExternalController@patients', 'as' => 'patients']);
    $router->match(['post', 'get'], 'order/{patient?}', ['uses' => 'ExternalController@orders', 'as' => 'order']);
    $router->match(['post', 'get'], 'makeorder/{patient?}/{results?}', ['uses' => 'ExternalController@make_order', 'as' => 'order.make']);
    $router->match(['post', 'get'], 'view/order/{id?}', ['uses' => 'ExternalController@view_order', 'as' => 'order.view']);
    $router->match(['post', 'get'], 'queue/', ['uses' => 'ExternalController@queue', 'as' => 'queue']);

    $router->match(['post', 'get'], 'ordertest/', ['uses' => 'ExternalController@p_order', 'as' => 'p_order']);
    $router->match(['post', 'get'], 'patient/results/', ['uses' => 'ExternalController@p_results', 'as' => 'p_results']);
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
