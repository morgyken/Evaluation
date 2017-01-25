<?php
$v1 = $data['v1_hst'];
$cmplnt = $data['v1_cmplnts'];
?>
<h3>1. Procedures</h3>
@if(!$v1->isEmpty())
<table class="table table-stripped">
    <thead>
        <tr><th>Date</th><th>Procedure</th></tr>
    <thead>
    <tbody>
        @foreach($v1 as $v)
        <tr>
            <td>{{$v->Date}}</td>
            <td>
                <?php if (strlen($v->history) > 1) { ?>
                    {{$v->history}}
                    <?php
                } else {
                    echo 'Nothing to show';
                }
                ?>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
No records to show.
@endif


<h3>1. Complaints</h3>
@if(!$cmplnt->isEmpty())
<table class="table table-stripped">
    <thead>
        <tr><th>Date</th><th>Complaint</th></tr>
    <thead>
    <tbody>
        @foreach($cmplnt as $c)
        <tr>
            <td>{{$c->date}}</td>
            <td>
                <?php if (strlen($c->complaint) > 1) { ?>
                    {{$c->complaint}}
                    <?php
                } else {
                    echo 'Nothing to show';
                }
                ?>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
No records to show.
@endif

