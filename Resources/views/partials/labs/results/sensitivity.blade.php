<?php
/**
 * Created by PhpStorm.
 * User: bravoh
 * Date: 9/7/17
 * Time: 7:53 PM
 */
?>
<td>
    <table class="table table-striped sensitivity_table">
        <tr>
            <th>Drug</th>
            <th>Sensitivity</th>
        </tr>
        <?php try{ ?>
        @foreach($item->results->sensitivity_results as $stvt)
            <tr>
                <td>{{$stvt->drug->name}}</td>
                <td>{{$stvt->sensitivity}}</td>
            </tr>
        @endforeach
        <?php }catch (\Exception $e){
            //
        } ?>
    </table>
</td>
