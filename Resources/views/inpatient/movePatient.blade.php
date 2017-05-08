@extends('layouts.app')
@section('content_title','top up')
@section('content_description','Credit the patient\'s account')

@section('content')
    @include('Evaluation::inpatient.success')


    <div class="box box-info">
        <div class="box-body">
            <h2>Patient Details</h2>
            <div class="col-lg-6">
                <strong> Name: </strong> {{$patient->full_name}}<br>
                <strong>Number:</strong>  {{$patient->id}}<br>

                <strong> Current Bed Number: </strong> {{$bed}}<br>
              
              <br>
                <strong>Bed Position:</strong>  {{$bed}}<br>
              
                <strong>Current Ward:</strong> {{$ward->name}}  <br>
            </div>
        
        </div>

    </div>
    <hr>


<div class="box box-info">
      <div class="col-lg-7 box-body">
        <div class="form-horizontal">
        {!! Form::open(['url'=>'evaluation/inpatient/change_bed']) !!}
        <div class="col-md-12">
    <h3>Deposit</h2>
       <input type="hidden" name="admission_id" value='{{$admission->id}}'>
            <div class="col-md-12">
                <div class="form-group {{ $errors->has('cash') ? ' has-error' : '' }}">
                    <label class="control-label col-md-4">Ward:</label>
                    <div class="col-md-8">
                        <select name="ward_id" class="form-control" id="ward">
                            @foreach($wards as $ward)
                                <option value="{{$ward->id}}">
                                    {{$ward->name}} / No: {{$ward->number}} @ Kshs. {{number_format($ward->cost,2)}}
                                </option>
                                @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group {{ $errors->has('cheque') ? ' has-error' : '' }}">
                    <label class="control-label col-md-4">Bed Position:</label>
                    <div class="col-md-8">
                         <select name="bedposition_id" class="form-control" id="bedPosition">
                        </select>
                    </div>
                </div>
                <div class="form-group {{ $errors->has('chequenumber') ? ' has-error' : '' }}">
                    <label class="control-label col-md-4">Select Bed:</label>
                    <div class="col-md-8">
                        <select name="bed_id" class="form-control" id="bed">
                            @foreach($beds as $ward)
                                <option value="{{$ward->id}}">
                                    {{$ward->number}}
                                </option>
                                @endforeach
                        </select>
                    </div>
                </div>
                

                <div class="pull-right">
                    <button class="btn btn-success pull-right" type="submit"> <i class="fa fa-share"></i> Move</button>
                </div>
            </div>
        </div> 
        {!! Form::close() !!}
    </div>



    

</div>
    <script>

        $(function () {
            $("table").dataTable();

           var getbedp = function () {
                var ward = $("#ward").val();
            $("#bedPosition").html('');
        
                var url = '{{url('/evaluation/inpatient/getAvailableBedPosition')}}'+'/'+ward;
                $.ajax({
                    url:url
                }).done(function (data) {
                   $.each(data, function (index,value) {
                            console.info("index=>"+index+'value=>'+value.number);
                            $("#bedPosition").append("<option value='"+value.id+"'>"+value.name+"</option>")
                        })

           })
               }
               getbedp();
               $("#ward").change(function () {
                   getbedp();
               })
           }) 
           

    </script>

@endsection