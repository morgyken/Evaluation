<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$v1 = v1_history($visit->patient);
?>
<div class="row">
    <div class="col-md-12">
        <div class="accordion">
            <h3>History from previous system</h3>
            <div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-default">
                            <div class="box-header">
                                <h3 class="box-title">Treatment</h3>
                            </div>
                            <div class="box-body">
                                <table class="table table-striped">
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>Procedure</th>
                                        <th>Diagnosis</th>
                                    </tr>
                                    <?php try { ?>
                                        @foreach($v1['treatment'] as $h)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$h->Date}}</td>
                                            <td>{{$h->Procedure_Name}}</td>
                                            <td></td>
                                        </tr>
                                        @endforeach
                                        <?php
                                    } catch (\Exception $ex) {

                                    }
                                    ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('.accordion').accordion({heightStyle: "content"});
    });
</script>