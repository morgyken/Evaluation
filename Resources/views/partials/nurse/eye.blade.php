<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */
?>

<div class="row">
    {!! Form::open(['id'=>'eye_preview_form']) !!}
    {!! Form::hidden('visit',$visit->id) !!}
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
                        <input type="hidden" name="entity[]" value="uncorrected_vision" /></td>
                    <td><input type="text" name="right[]"  size="20"/></td>
                    <td><input type="text" name="left[]"  size="20"/></td>
                </tr>
                <tr class="small-size">
                    <td>Present Glasses
                        <input type="hidden" name="entity[]" value="present_glasses" /></td>
                    <td><input type="text" name="right[]" size="20"/></td>
                    <td><input type="text" name="left[]" size="20"/></td>
                </tr>
                <tr class="larger">
                    <td>Auto Refraction
                        <input type="hidden" name="entity[]" value="auto_refraction" /></td>
                    <td><input type="text" name="right[]" size="20"/></td>
                    <td><input type="text" name="left[]" size="20"/></td>
                </tr>
                <tr class="larger">
                    <td>IOP Recording
                        <input  type="hidden" name="entity[]" value="iop_recording"/></td>
                    <td><input type="text" name="right[]" size="20"/></td>
                    <td><input type="text" name="left[]" size="20"/></td>
                </tr>
                <!--
                <tr>
                    <td>Remarks</td>
                    <td rowspan="2">
                        <textarea name="remarks" placeholder="Remarks"></textarea>
                    </td>
                </tr>-->
            </tbody>
            <tfoot>
                <tr>
                    <th><button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button></th>
                </tr>
            </tfoot>
        </table>
    </div>
    {!! Form::close() !!}
</div>