<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */
?>
<div>
    <label>Diagnosis</label><input type="text" name="diag"><br><br>
    <p style="font-weight: 900">Counselling</p>
    <input type="checkbox" name="procedure"><label>Procedure not for visual rehabilitation</label><br><br>
    <input type="checkbox" name="sterile"><label>Under sterile conditions in Operating theatre</label><br><br>

    <p style="font-weight: 900">PROTOCOL:</p>
    <label style="font-weight: 900;">Operated Eye:</label>RE <input type="checkbox" name="RE">
    LE<input type="checkbox" name="LE">BE<input type="checkbox" name="BE"><br><br>
    <label style="font-weight: 900;">Epithelium Debridement</label><input type="text" name="deb">% Alcohol<br><br>
    <input type="checkbox" name="mm"><label> Complete -7 mm zone</label>
    <input type="checkbox" name="central"><label> Intact Central Island 3x3mm</label><br><br>
    <label style="font-weight: 900;">Riboflavin</label>0.1% in 20% dextran:<br><br>
    <input type="checkbox" name="2by30"><label>1 drop every 2 min x 30 min</label>
    <input type="checkbox" name="3by30"><label>1 drop every 3 min x 30 min</label><br><br>
    <label style="font-weight: 900;">Xylocain</label>1%:<br><br>
    <input type="checkbox" name="5by30"><label>1 drop every 5 min x 30 min</label><br><br>
    <label style="font-weight: 900;">Normal saline wash</label>1%:<br><br>
    <input type="checkbox" name="10by30"><label>1 drop every 10 min x 30 min</label><br><br>

    <p style="font-weight: 900">UV-A IRRADIATION INTRODUCED X 15 mins:</p>
    <label style="font-weight: 900;">Riboflavin</label>
    <input type="checkbox" name="2min"><label>1 drop every 2 min </label><br><br>
    <input type="checkbox" name="3min"><label>1 drop every 3 min </label><br><br>

    <label style="font-weight: 900;">Xylocain 1%:</label><br><br>
    <input type="checkbox" name="two"><label>1 drop every 2 min </label><br><br>
    <input type="checkbox" name="three"><label>1 drop every 3 min </label><br><br>
    Post-Operative: <label>Refresh eye drops</label><input type="checkbox" name="eyedrops">
    <label>Steroid/Antibiotic eye drop</label><input type="checkbox" name="steroid">
    <label>Bandage contact lens</label> <input type="checkbox" name="contactlens"><br><br>

    <label style="font-weight: 900;"> Remarks:</label><input type="text" name="remarks">
</div>