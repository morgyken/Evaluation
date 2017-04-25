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
            <h3>V1 History</h3>
            <div>
                <div class="row">
                    <div class="col-md-4">
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
                    <div class="col-md-8">
                        <div class="box box-default">
                            <div class="box-header">
                                <h3 class="box-title">Investigation Notes</h3>
                            </div>
                            <div class="box-body">
                                <table class="table table-striped">
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>Procedure</th>
                                    </tr>
                                    <?php try { ?>
                                        @foreach($v1['notes'] as $notes)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$notes->Investigation_Date}}</td>
                                            <td>{{$notes->Procedure_Name}}</td>
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
                    <div class="col-md-12">
                        <!--
                        <div class="box box-default">
                            <div class="box-header">
                                <h3 class="box-title">OP Notes</h3>
                            </div>
                            <div class="box-body">
                                @if(!empty($_visit->opnotes))
                                <p><strong>Surgery Indications</strong><br/>
                                    {{$_visit->opnotes->surgery_indication}}</p>
                                <p><strong>Implants</strong><br/>
                                    {{$_visit->opnotes->implants}}</p>
                                <p><strong>Post OP</strong><br/>
                                    {{$_visit->opnotes->postop}}</p>
                                <p><strong>Indication + procedure</strong><br/>
                                    {{$_visit->opnotes->indication}}</p>
                                @else
                                <p><i class="fa fa-info-circle"></i> No records</p>
                                @endif
                            </div>
                        </div>
                        -->
                        <div class="box box-success">
                            <div class="box-header">
                                <h3 class="box-title">General Exam</h3>
                            </div>
                            <div class="box-body">

                                <table class="table table-striped table-condensed">
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>plan of management</th>
                                        <th>Presenting Complaints</th>
                                        <th>History Of Presenting Complaints</th>
                                        <th>Past Medical History</th>
                                        <th>Social And Professional History</th>
                                        <th>Investigations</th>
                                    </tr>
                                    <?php try { ?>
                                        @foreach($v1['gexam'] as $exam)
                                        <?php try { ?>
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$exam->Visit_Stamp}}</td>
                                                <td>{{$exam->plan_of_management}}</td>
                                                <td>{{$exam->Presenting_Complaints}}</td>
                                                <td>{{$exam->History_Of_Presenting_Complaints}}</td>
                                                <td>{{$exam->Past_Medical_History}}</td>
                                                <td>{{$exam->Social_And_Professional_History}}</td>
                                                <td>{{$exam->Investigations}}</td>
                                            </tr>
                                            <?php
                                        } catch (\Exception $ex) {

                                        }
                                        ?>
                                        @endforeach
                                        <?php
                                    } catch (\Exception $ex) {

                                    }
                                    ?>
                                </table>

                                <br>
                                <hr>
                                continued...

                                <table class="table table-striped table-condensed">
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>Notes</th>
                                        <th>Drug History</th>
                                        <th>Social History</th>
                                        <th>Investigations History</th>
                                        <th>Hp illness</th>
                                    </tr>
                                    <?php try { ?>
                                        @foreach($v1['gexam'] as $exam)
                                        <?php try { ?>
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$exam->Visit_Stamp}}</td>
                                                <td>{{$exam->GeneralExamNotes}}</td>
                                                <td>{{$exam->drug_history}}</td>
                                                <td>{{$exam->social_history}}</td>
                                                <td>{{$exam->investigations_history}}</td>
                                                <td>{{$exam->hp_illness}}</td>
                                            </tr>
                                            <?php
                                        } catch (\Exception $ex) {

                                        }
                                        ?>
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
                <div class="row">
                    <div class="col-md-8">
                        <div class="box box-success">
                            <div class="box-header">
                                <h3 class="box-title">General History</h3>
                            </div>
                            <div class="box-body">

                                <table class="table table-striped">
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>Marital Status</th>
                                        <th>Number of Childrean</th>
                                        <th>Current Illness</th>
                                        <th>Medical History</th>
                                    </tr>
                                    <?php try { ?>
                                        @foreach($v1['ghistory'] as $h)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$h->Date}}</td>
                                            <td>{{$h->Marital_Status}}</td>
                                            <td>{{$h->NumberOfChildren}}</td>
                                            <td>{{$h->Current_Illness}}</td>
                                            <td>{{$h->Medical_History}}</td>
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
                    <!--
                    <div class="col-md-4">
                        <div class="box box-success">
                            <div class="box-header">
                                <h3 class="box-title">Complaints</h3>
                            </div>
                            <div class="box-body">
                                <p></p>
                            </div>
                        </div>
                    </div>
                    -->
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