<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */
?>

<div class="row">
    {!! Form::open(['id'=>'eye_preview_form']) !!}
    <div class="col-md-12">
        <table class="table table-condensed">
            <thead>
                <tr>
                    <th></th>
                    <th>Right</th>
                    <th>Left</th>
                </tr>
            </thead>
            <tbody>
                <tr class="larger">
                    <td>Uncorrected Vision
                        <input name="eye_vision[]" value="uncorrected_vision" type="hidden"/></td>
                    <td><input type="text" name="right[]" value="" size="20"/></td>
                    <td><input type="text" name="left[]" value="" size="20"/></td>
                </tr>
                <tr class="samll-size">
                    <td>Present Glasses
                        <input name="eye_vision[]" value="present_glasses" type="hidden"/></td>
                    <td><input type="text" name="right[]" size="20"/></td>
                    <td><input type="text" name="left[]" size="20"/></td>
                </tr>
                <tr class="larger">
                    <td>Auto Refraction
                        <input name="eye_vision[]" value="auto_refraction" type="hidden"/></td>
                    <td><input type="text" name="right[]" size="20"/></td>
                    <td><input type="text" name="left[]" size="20"/></td>
                </tr>
                <tr class="larger">
                    <td>IOP Recording
                        <input name="eye_vision[]" value="iop_recording" type="hidden"/></td>
                    <td><input type="text" name="right[]" size="20"/></td>
                    <td><input type="text" name="left[]" size="20"/></td>
                </tr>
                <tr>
                    <td>Remarks</td>
                    <td rowspan="2">
                        <textarea name="remarks" placeholder="Remarks"></textarea>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    {!! Form::close() !!}
    <script type="text/javascript">
        var PRELIMINARY_EXAMINATION = "{{route('evaluation.ajax.save_preliminary')}}";
    </script>
</div>