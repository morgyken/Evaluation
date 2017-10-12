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

/** @var \Illuminate\Routing\Router $router */
$router->delete('cancel_checkin', ['uses' => 'ApiController@cancel_checkin', 'as' => 'cancel_checkin']);
$router->get('checkout_patient', ['uses' => 'ApiController@checkout_patient', 'as' => 'checkout_patient']);
$router->get('diagnosis/{regex?}', ['uses' => 'ApiController@diagnosis_codes', 'as' => 'diagnosis_auto']);
$router->post('auto_save_vitals', ['uses' => 'ApiController@save_vitals', 'as' => 'save_vitals']);
$router->post('auto_save_notes', ['uses' => 'ApiController@save_notes', 'as' => 'save_notes']);
$router->post('auto_save_diagnosis', ['uses' => 'ApiController@save_diagnosis', 'as' => 'save_diagnosis']);

$router->post('auto_save_external_order', ['uses' => 'ApiController@save_external_order', 'as' => 'save_external_order']);
$router->get('auto_save_external_order', ['uses' => 'ApiController@save_external_order', 'as' => 'save_external_order']);
$router->get('prescription/cancel', ['uses' => 'ApiController@pharmacy_cancel_prescription', 'as' => 'prescription.cancel']);

$router->post('save_prescription', ['uses' => 'ApiController@save_prescription', 'as' => 'save_prescription']);
$router->post('save_opnotes', ['uses' => 'ApiController@save_opnotes', 'as' => 'save_opnotes']);
$router->post('set_next_date', ['as' => 'set_next_date', 'uses' => 'ApiController@set_next_date']);
$router->post('set_visit_date', ['as' => 'set_visit_date', 'uses' => 'ApiController@set_visit_date']);
$router->get('report_cashier', ['as' => 'cashier_report', 'uses' => 'ApiController@cashier_report']);
$router->post('save_drawings', ['as' => 'save_drawings', 'uses' => 'ApiController@save_drawings']);
$router->get('delete_procedure_category', ['as' => 'delete_procedure_cat', 'uses' => 'ApiController@delete_procedure_cat']);
$router->post('save_visit_metas', ['uses' => 'ApiController@save_visit_metas', 'as' => 'save_visit_metas']);
$router->post('auto_order_diagnosis', ['uses' => 'ApiController@order_diagnosis', 'as' => 'order_diagnosis']);
$router->post('save_preliminary', ['uses' => 'ApiController@save_preliminary', 'as' => 'save_preliminary']);

$router->any('auto_save_results', ['uses' => 'ApiController@investigation_result', 'as' => 'investigation_result']);
//$router->post('auto_save_results', ['uses' => 'ApiController@save_sensitivity', 'as' => 'save_sensitivity']);

$router->get('save_sensitivity', ['uses' => 'ApiController@save_sensitivity', 'as' => 'save_sensitivity']);

$router->get('get_procedures/{type}/{visit?}', ['uses' => 'ApiController@get_procedures', 'as' => 'get_procedures']);
$router->get('get_all_procedures/', ['uses' => 'ApiController@get_all_procedures', 'as' => 'get_all_procedures']);
$router->get('get_products/', ['uses' => 'ApiController@get_drugs', 'as' => 'get_products']);

$router->get('manage/inventory_items/', ['uses' => 'ApiController@manage_inventory_items', 'as' => 'manage_inventory_items']);
$router->get('delete/title/lab', ['uses' => 'ApiController@delete_title_lab', 'as' => 'del.title']);
$router->get('delete/critical_value}', ['uses' => 'ApiController@delete_critical_value', 'as' => 'del.critical_value']);
//delete_lab_template_test
$router->get('delete/template/test', ['uses' => 'ApiController@delete_lab_template_test', 'as' => 'delete_lab_template_test']);

$router->get('delete/range/', ['uses' => 'ApiController@delete_range', 'as' => 'delete_range']);
$router->get('delete/formula/', ['uses' => 'ApiController@delete_formulae', 'as' => 'delete_formulae']);
$router->get('delete/critical_value/', ['uses' => 'ApiController@del_critical_value', 'as' => 'del_critical_value']);
$router->get('delete/procedure', ['uses' => 'ApiController@delete_procedure', 'as' => 'delete_procedure']);

$router->get('performed/treatment/{visit_id}/evaluation', ['as' => 'performed_treatment', 'uses' => 'ApiController@getDoneTreatment']);
$router->get('performed/prescriptions/{visit_id}/evaluation', ['as' => 'performed_prescriptions', 'uses' => 'ApiController@getPrescriptions']);
$router->post('performed/pres/deleter/evaluation', ['as' => 'drug.delete', 'uses' => 'ApiController@deletePrescription']);
$router->get('performed/pres/info/evaluation', ['as' => 'drug.info', 'uses' => 'ApiController@drugInfo']);
$router->get('performed/investigations/{visit_id}/evaluation', ['as' => 'performed_investigations', 'uses' => 'ApiController@getDoneInvestigations']);
