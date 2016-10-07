/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


/*
 * =========================================================================
 * eye preview
 * =========================================================================
 */
/* global PRELIMINARY_EXAMINATION, USER_ID, VISIT_ID */

$('#eye_preview_form input').blur(function (e) {
    save_eye_preview();
});
$('#eye_preview_form').submit(function (e) {
    e.preventDefault();
    save_eye_preview();
});
function save_eye_preview() {
    var form_data = $('#eye_preview_form').append('<input type="hidden" name="visit" value="' + VISIT_ID + '" /> ');
    form_data = $('#eye_preview_form').append('<input type="hidden" name="user" value="' + USER_ID + '" /> ');
    console.log(form_data);
    $.ajax({type: "POST", url: PRELIMINARY_EXAMINATION, data: form_data.serialize()});
}