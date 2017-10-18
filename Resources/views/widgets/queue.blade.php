<?php
$department = 'doctor';
?>
<div class="col-md-12">
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">Patients Seen Today</h3>
        </div><!-- /.box-header -->
        <div class="box-body no-padding" style="max-height: 250px; overflow-y: scroll;">
            <table class="table table-striped">
                <tbody>
                    @if(isset($seen))
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Patient</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                    @foreach($seen as $visit)
                    <tr id="row_id{{$visit->id}}">
                        <td>{{$loop->iteration}}</td>
                        <td>{{$visit->patients->full_name}}</td>
                        <td>{{$visit->created_at->format('dS M g:i a')}}</td>
                        <td>
                            <a href="{{route('evaluation.review_patient',[$visit->patient])}}" class="btn btn-primary btn-xs"> <i class="fa fa-eye"></i> Review</a>
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="4">
                            Nothing to show
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div><!-- /.box-body -->
        <div class="box-footer">
        </div><!-- /.box-header -->
    </div>

</div>