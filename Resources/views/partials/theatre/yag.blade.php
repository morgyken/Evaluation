<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */
?>
<div>
    <table>
        <tr>
            <td>Indication: </td>
            <td>P.I </td>
            <td>Post-Capsulotomy</td> <br><br>
        </tr>
        <tr>
            <td><label>R.E:</label></td><td><input type="checkbox" name="pi1" ></td><td><input type="checkbox" name="post1" ></td>
        </tr><tr><td><label>L.E:</label> </td><td><input type="checkbox" name="pi2"></td><td><input type="checkbox" name="post2"</td>
        </tr>
    </table>
    <p style="font-weight: 900;">Before Laser Procedure:</p>
    <ol>
        <li><label> Informed consent taken</label> <input type="checkbox" name="consent"></li>
        <li><label> Appropriate contact lens cleaned.</label> <input type="checkbox" name="approp"></li>
        <li><label> Tetracaine/ amethocaine drops instilled.</label> <input type="checkbox" name="tetra"></li>
        <li><label> Viscoeslastic availed.</label> <input type="checkbox" name="visc"></li>
        <li><label> Laser setting set to anterior.</label> <input type="checkbox" name="laser"></li>
    </ol>

    <table border="1">
        <tr>
            <th style="padding: 10px;">RE</th>
            <th style="padding: 10px;">PARAMETER</th>
            <th style="padding: 10px">LE</thead>
        </tr>
        <tr>
            <td>  <input type="text" name="t1">     </td></pre> <td> Spot Size</td><td><input type="text" name="tt1"> </td></tr>
        <tr><td>  <input type="text" name="t2">       </td><td> Power</td><td><input type="text" name="tt2"> </td></tr>
        <tr> <td> <input type="text" name="t3">      </td><td> Shots/ pulse</td><td><input type="text" name="tt3"> </td></tr>
        <tr><td>  <input type="text" name="t4">       </td><td> Number of spots</td><td> <input type="text" name="tt4"></td>
        </tr>
    </table>
</div>