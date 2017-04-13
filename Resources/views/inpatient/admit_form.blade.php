@extends('layouts.app')
@section('content_title','Admit Patient')
@section('content_description','Action to admitting a patient')

@section('content')

    <div class="box box-info">
        <div class="box-body">
            <div class="col-md-6">
                <h4>Patient Information</h4>
                <dl class="dl-horizontal">
                    <dt>Name:</dt><dd>{{$patient->full_name}}</dd>
                    <dt>Date of Birth:</dt><dd>{{(new Date($patient->dob))->format('m/d/y')}}
                        <strong>({{(new Date($patient->dob))->age}} years old)</strong></dd>
                    <dt>Gender:</dt><dd>{{$patient->sex}}</dd>
                    <dt>Mobile Number:</dt><dd>{{$patient->mobile}}</dd>
                    <dt>ID number:</dt><dd>{{$patient->id_no}}</dd>
                    <dt>Email:</dt><dd>{{$patient->email}}</dd>
                    <dt>Telephone:</dt><dd>{{$patient->telephone}}</dd>
                    <dt>Admission Time:</dt><dd id="time"><?php echo new Date() ?></dd>

                </dl>
                @if(!empty($patient->image))
                    <hr/>
                    <h5>Patient Image</h5>
                    <img src="{{$patient->image}}"  alt="Patient Image" height="100px"/>
                @else
                    <strong class="text-info">No image</strong>
                @endif
            </div>
            <!-- TODO Work on this-->

        <div class="col-md-6">
            <h4>Check-in details</h4>
            <div class="form-horizontal">
                {!! Form::open(['url'=>['/evaluation/inpatient/admit_patient']])!!}
                <input type="hidden" name="patient_id" value="{{$patient->id}}"/>
                <input type="hidden" name="visit_id" value="{{$visit->id}}"/>
                <div class="form-group req {{ $errors->has('admission_doctor') ? ' has-error' : '' }}">
                    {!! Form::label('Admission Doctor', 'Admission Doctor'
                    ,['class'=>'control-label col-md-4']) !!}
                    <div class="col-md-8">
                        <select name="admission_doctor" class="form-control" id="admission_doc">
                            @foreach($doctors as $doc)
                                <option value="{{$doc->id}}">
                                    {{\Ignite\Users\Entities\UserProfile::where('user_id',$doc->id)->first()->last_name}}
                                    {{\Ignite\Users\Entities\UserProfile::where('user_id',$doc->id)->first()->first_name}}
                                </option>
                                @endforeach
                                <option value="other">Other</option>
                        </select>
                        {!! $errors->first('admission_doctor', '<span class="help-block">:message</span>') !!}

                    </div>
                </div>
                <div class="form-group external_doc">
                    <label class="control-label">External Doc</label>
                    <div class="col-md-8 col-md-offset-4">
                        <input type="text" class="form-control" placeholder="Name of the doctor" name="external_doc" id="specify_doc">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-8 col-md-offset-4">
                        <label class="checkbox-inline"><input  type="checkbox" name="to_nurse" value="1" checked/> Also check in patient to Nurse </label>
                    </div>
                </div>

                <div class="form-group req {{ $errors->has('clinic') ? ' has-error' : '' }}">
                    {!! Form::label('clinic', 'Clinic',['class'=>'control-label col-md-4']) !!}
                    <div class="col-md-8">
                        <p class="form-control-static">{{get_clinic_name()}}</p>
                    </div>
                </div>

                <div class="form-group req {{ $errors->has('purpose') ? ' has-error' : '' }}">
                    {!! Form::label('selectedWard', 'Ward',['class'=>'control-label col-md-4']) !!}
                    <div class="col-md-8">
                        <select name="ward_id" required id="selectedWard" class="form-control">
                            @foreach($wards as $ward)
                                <option value="{{$ward->id}}">{{$ward->name}} @Kshs. {{$ward->cost}} </option>
                            @endforeach
                        </select>
                        {!! $errors->first('ward', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>


                <div class="form-group req {{ $errors->has('bed') ? ' has-error' : '' }}">
                    {!! Form::label('Bed', 'bed',['class'=>'control-label col-md-4']) !!}
                    <div class="col-md-8">
                        <select name="bed_id" id="selectBed" required class="form-control">
                            <option value="">Option one</option>
                        </select>
                        {!! $errors->first('bed', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>

                <div class="form-group {{ $errors->has('payment_mode') ? ' has-error' : '' }}">
                    {!! Form::label('name', 'Payment Mode',['class'=>'control-label col-md-4']) !!}
                    <div class="col-md-8" id="mode">
                        <input checked name="payment_mode" type="radio" value="cash" id="cash_option"> Cash
                        @if($patient->insured>0)
                            <input name="payment_mode" type="radio" value="insurance" id="insurance_option"> Insurance
                        @endif
                        {!! $errors->first('payment_mode', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
                <div class="ins form-group {{ $errors->has('scheme') ? ' has-error' : '' }}" id="schemes">
                    {!! Form::label('scheme', 'Insurance Scheme',['class'=>'control-label col-md-4']) !!}
                    <div class="col-md-8">
                        {!! Form::select('scheme',get_patient_insurance_schemes($patient->id), old('scheme'), ['class' => 'form-control', 'placeholder' => 'Choose...']) !!}
                        {!! $errors->first('scheme', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>


                <div class="ins form-group {{ $errors->has('scheme') ? ' has-error' : '' }}" id="schemes">
                    {!! Form::label('scheme', 'Upload Authorization Letter',['class'=>'control-label col-md-4']) !!}
                    <div class="col-md-8">
                        <input type="file" class="form-control">
                    </div>
                </div>

                <div class="ins form-group {{ $errors->has('max-allowed') ? ' has-error' : '' }}" id="schemes">
                    {!! Form::label('scheme', 'Maximum Amount Allowed By Insurance:',['class'=>'control-label col-md-4']) !!}
                    <div class="col-md-8">
                        <input type="number" name="max-allowed" class="form-control">
                    </div>
                </div>
                <div class="form-group {{ $errors->has('deposit') ? ' has-error' : '' }}" id="schemes">
                    {!! Form::label('deposit', 'Charge Deposit',['class'=>'control-label col-md-4']) !!}
                    <div class="col-md-8">
                        <select name="deposit" id="depositSel" class="form-control">
                            @foreach($deposits as $deposit)
                                <option value="{{$deposit->id}}">{{$deposit->name}} @Kshs. {{$deposit->cost}}</option>
                                @endforeach
                        </select>
                        <div id="errorRe"></div>
                        {!! $errors->first('deposit', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
                <div class="pull-right">
                    <button type="submit" class="btn btn-success"><i class="fa fa-user-plus"></i> Admit Patient</button>
                </div>
                {!! Form::close()!!}
            </div>
        </div>
    </div>

        <script>
            var checkPayment = function(){
                var pay = $('input[name=payment_mode]:checked').val();
                 if(pay == 'cash'){
                     $(".ins").hide();
                 }else{
                     $('.ins').show();
                 }
            };
            var checkOther = function () {
                if($("#admission_doc").val() == 'other'){
                    $("div.external_doc").show();
                }else{
                    $("div.external_doc").hide();
                }
            };
            $('input[name=payment_mode]').change(function () {
                checkPayment();
            });
            $(function () {
                checkBalance();
                checkPayment();
                checkOther();
                setInterval(setTime,1000);

                function setTime(){
                    var dt = new Date();
                    var h =  dt.getHours(), m = dt.getMinutes(), s = dt.getSeconds();
                    (h<10 == 1) ? (h = '0'+h):(h=h);
                    (m<10 == 1) ? (m ='0'+m):(m=m);
                    (s<10 == 1) ? (s ='0'+s):(s=s);

                    var time = (h > 12) ? (h-12 + ':' + m +':' + s +' pm') : (h + ':' + m +':' + s +' am');
                    $("#time").text(time)
                }

                var loadBeds = function(){
                    var urlAvailableBeds = '{{url('/evaluation/inpatient/availableBeds/')}}';
                    urlAvailableBeds = urlAvailableBeds + '/' + ($("#selectedWard").val());
                    $.ajax({
                        url:urlAvailableBeds,
                        method:'Get'
                    }).done(function (data) {
                        $("#selectBed").html("");
                        $.each(data, function (index,value) {
                            console.info("index=>"+index+'value=>'+value.number);
                            $("#selectBed").append("<option value='"+value.id+"'>"+value.number+"</option>")
                        })

                    })
                };
                loadBeds();
                $("#selectedWard").change(function () {
                    loadBeds();
                    checkBalance();
                })

            });
            $("#admission_doc").change(function () {
                checkOther();
            });
            $("#depositSel").change(function () {
                checkBalance();
            });

            var checkBalance = function () {
                var url = '{{url('/evaluation/inpatient/admit_check')}}';
                var deposit_type =  ($("#depositSel").val());
                var patient_id = '{{$patient->id}}';
                var ward = $("select#selectedWard").val();

                $.ajax({
                    url:url+'?depositTypeId='+deposit_type+'&patient_id='+patient_id+'&ward_id='+ward,
                    method:'GET'
                }).done(function (data) {
                    if(data.status == 'insufficient'){
                        $("#errorRe").html('');
                        $("#errorRe").removeClass('text-success').addClass('text-error').html(data.description);
                        $("button.btn").addClass('disabled');
                    }else{
                        $("#errorRe").html('');
                        $("button.btn").removeClass('disabled');
                        $("#errorRe").removeClass('text-error').addClass('text-success').html(data.description);
                    }
                })
            }



        </script>

@endsection