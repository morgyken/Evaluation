<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */

$eye_datas = get_eye_exams($data['visit']);
?>
<div class="row">
    <div class="col-md-12">
        <h5>Split LAMP EXAM</h5>
        <table class="table table-condensed">
            <thead>
                <tr>
                    <th></th>
                    <th>OD WNL</th>
                    <th>OS WNL</th>
                    <th>Abnormal / Comments</th>
                </tr>
            </thead>
            <tbody>
                <tr class="larger">
                    <td>ADNEXA/LIDS
                        <input name="option[]" value="adnexa" type="hidden"/></td>
                    <td><input type="text" name="od[]" value="" size="2"/></td>
                    <td><input type="text" name="os[]" value="" size="2"/></td>
                    <td><input type="text" name="comments[]" value=""/></td>
                </tr>
                <tr class="samll-size">
                    <td>Lids
                        <input name="option[]" value="lids" type="hidden"/></td>
                    <td><input type="text" name="od[]" size="2"/></td>
                    <td><input type="text" name="os[]" size="2"/></td>
                    <td><input type="text" name="comments[]"/></td>
                </tr>
                <tr class="larger">
                    <td>Conjuctiva
                        <input name="option[]" value="conjuctiva" type="hidden"/></td>
                    <td><input type="text" name="od[]" size="2"/></td>
                    <td><input type="text" name="os[]" size="2"/></td>
                    <td><input type="text" name="comments[]"/></td>
                </tr>
                <tr class="larger">
                    <td>Cornea
                        <input name="option[]" value="cornea" type="hidden"/></td>
                    <td><input type="text" name="od[]" size="2"/></td>
                    <td><input type="text" name="os[]" size="2"/></td>
                    <td><input type="text" name="comments[]"/></td>
                </tr>
                <tr class="larger">
                    <td>AC
                        <input name="option[]" value="ac" type="hidden"/></td>
                    <td><input type="text" name="od[]" size="2"/></td>
                    <td><input type="text" name="os[]" size="2"/></td>
                    <td><input type="text" name="comments[]"/></td>
                </tr>
                <tr class="larger">
                    <td>Pupil
                        <input name="option[]" value="pupil" type="hidden"/></td>
                    <td><input type="text" name="od[]" size="2"/></td>
                    <td><input type="text" name="os[]" size="2"/></td>
                    <td><input type="text" name="comments[]"/></td>
                </tr>
                <tr class="larger">
                    <td>Lens
                        <input name="option[]" value="lens" type="hidden"/></td>
                    <td><input type="text" name="od[]" size="2"/></td>
                    <td><input type="text" name="os[]" size="2"/></td>
                    <td><input type="text" name="comments[]"/></td>
                </tr>
                <tr class="larger">
                    <td>Fundus
                        <input name="option[]" value="fundus" type="hidden"/></td>
                    <td><input type="text" name="od[]" size="2"/></td>
                    <td><input type="text" name="os[]" size="2"/></td>
                    <td><input type="text" name="comments[]"/></td>
                </tr>
                <tr class="samll-size">
                    <td>C/D Ratio
                        <input name="option[]" value="cd_ration" type="hidden"/></td>
                    <td><input type="text" name="od[]" size="2"/></td>
                    <td><input type="text" name="os[]" size="2"/></td>
                    <td><input type="text" name="comments[]"/></td>
                </tr>
                <tr class="samll-size">
                    <td>Apperance
                        <input name="option[]" value="apperance" type="hidden"/></td>
                    <td><input type="text" name="od[]" size="2"/></td>
                    <td><input type="text" name="os[]" size="2"/></td>
                    <td><input type="text" name="comments[]"/></td>
                </tr>
                <tr class="samll-size">
                    <td>Nurve Fibre Layer
                        <input name="option[]" value="nurve" type="hidden"/></td>
                    <td><input type="text" name="od[]" size="2"/></td>
                    <td><input type="text" name="os[]" size="2"/></td>
                    <td><input type="text" name="comments[]"/></td>
                </tr>
                <tr class="samll-size">
                    <td>Macula
                        <input name="option[]" value="marcula" type="hidden"/></td>
                    <td><input type="text" name="od[]" size="2"/></td>
                    <td><input type="text" name="os[]" size="2"/></td>
                    <td><input type="text" name="comments[]"/></td>
                </tr>
                <tr class="samll-size">
                    <td>Periphery
                        <input name="option[]" value="adnexa" type="hidden"/></td>
                    <td><input type="text" name="od[]" size="2"/></td>
                    <td><input type="text" name="os[]" size="2"/></td>
                    <td><input type="text" name="comments[]"/></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<style>
    .larger {
        font-weight: bold;
    }

    .samll-size td:first-child {
        color: gray;
    }
</style>