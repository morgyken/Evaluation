<?php
$lab = $procedure->this_test;
?>
<div id="labs">
    <div class="form-group {{ $errors->has('parent') ? ' has-error' : '' }}">
        {!! Form::label('parent', 'Parent',['class'=>'control-label col-md-4']) !!}
        <div class="col-md-8">
            <select class="form-control" name="parent">
                <option>None</option>
                @foreach($data['procedures'] as $procedure)
                <option value="{{$procedure->id}}">{{$procedure->name}}</option>
                @endforeach
            </select>
            {!! $errors->first('parent', '<span class="help-block">:message</span>') !!}
        </div>
    </div>


    <div class="form-group {{ $errors->has('lab_category') ? ' has-error' : '' }}">
        {!! Form::label('lab_category', 'Category (Lab)',[' required class'=>'control-label col-md-4']) !!}
        <div class="col-md-8">
            <select class="form-control" name="title">
                <option>None</option>
                @foreach($data['titles'] as $tit)
                <option value="{{$tit->id}}">{{$tit->name}}</option>
                @endforeach
            </select>
            {!! $errors->first('parent', '<span class="help-block">:message</span>') !!}
        </div>
    </div>


    <div class="form-group {{ $errors->has('lab_category') ? ' has-error' : '' }}">
        {!! Form::label('lab_category', 'Title (if applicable)',[' required class'=>'control-label col-md-4']) !!}
        <div class="col-md-8">
            <select class="form-control" name="lab_category">
                <option>None</option>
                @foreach($data['lab_categories'] as $cat)
                <option value="{{$cat->id}}">{{$cat->name}}</option>
                @endforeach
            </select>
            {!! $errors->first('parent', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

    <div class="form-group {{ $errors->has('result_type') ? ' has-error' : '' }}">
        {!! Form::label('result_type', 'Result Type',['class'=>'control-label col-md-4']) !!}
        <div class="col-md-8">
            <select class="form-control" id="result_type" name="result_type">
                <option value="text">Free text</option>
                <option value="number">Number</option>
                <option value="select">Drop-down</option>
                <option value="other">Other</option>
            </select>
            {!! $errors->first('parent', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

    <div id="result_type_options" class="form-group {{ $errors->has('result_options') ? ' has-error' : '' }}">
        {!! Form::label('result_options', 'Drop-down Options',['class'=>'control-label col-md-4']) !!}
        <div class="col-md-8">
            <input type="text" placeholder="option 1" name="result_options[]"><br>
            <input type="text" placeholder="option 2" name="result_options[]"><br>
            <a href="#" onclick="add()">More</a><br/>
            <div id="options">
            </div>
        </div>
    </div>

    <div class="form-group {{ $errors->has('result_type') ? ' has-error' : '' }}">
        {!! Form::label('result_type', 'Unit of measure',['class'=>'control-label col-md-4']) !!}
        <div class="col-md-8">
            <input type="text" value="{{$lab?$lab->units:''}}" placeholder="mm, g, % etc." name="units" class="form-control">
            {!! $errors->first('unit', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

    <div class="form-group {{ $errors->has('sample_type') ? ' has-error' : '' }}">
        {!! Form::label('sample_type', 'Sample Type',['class'=>'control-label col-md-4']) !!}
        <div class="col-md-8">
            <input type="text" value="{{$lab?$lab->lab_sample_type:''}}" name="sample_type" class="form-control">
            {!! $errors->first('sample_type', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

    <div class="form-group {{ $errors->has('min_range') ? ' has-error' : '' }}">
        {!! Form::label('min_range', 'Default Range',['class'=>'control-label col-md-4']) !!}
        <div class="col-md-4">
            <input type="text" value="{{$lab?$lab->lab_min_range:''}}" placeholder="Minimum"  name="min_range" class="form-control">
            {!! $errors->first('min_range', '<span class="help-block">:message</span>') !!}
        </div>
        <div class="col-md-4">
            <input type="text" value="{{$lab?$lab->lab_max_range:''}}" placeholder="Maximum" name="max_range" class="form-control">
            {!! $errors->first('max_range', '<span class="help-block">:message</span>') !!}
        </div>
    </div>


    <div class="form-group {{ $errors->has('min_range') ? ' has-error' : '' }}">
        {!! Form::label('min_range', 'O-3 Days Range',['class'=>'control-label col-md-4']) !!}
        <div class="col-md-4">
            <input type="text" value="{{$lab?$lab->_0_3d_minrange:''}}" placeholder="Minimum"  name="_0_3d_minrange" class="form-control">
            {!! $errors->first('min_range', '<span class="help-block">:message</span>') !!}
        </div>
        <div class="col-md-4">
            <input type="text" value="{{$lab?$lab->_0_3d_maxrange:''}}" placeholder="Maximum" name="_0_3d_maxrange" class="form-control">
            {!! $errors->first('max_range', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

    <div class="form-group {{ $errors->has('min_range') ? ' has-error' : '' }}">
        {!! Form::label('min_range', '4-30 Days Range',['class'=>'control-label col-md-4']) !!}
        <div class="col-md-4">
            <input type="text" placeholder="Minimum" value="{{$lab?$lab->_4_30d_minrange:''}}"  name="_4_30d_minrange" class="form-control">
            {!! $errors->first('min_range', '<span class="help-block">:message</span>') !!}
        </div>
        <div class="col-md-4">
            <input type="text" placeholder="Maximum" value="{{$lab?$lab->_4_30d_maxrange:''}}" name="_4_30d_maxrange" class="form-control">
            {!! $errors->first('max_range', '<span class="help-block">:message</span>') !!}
        </div>
    </div>


    <div class="form-group {{ $errors->has('min_range') ? ' has-error' : '' }}">
        {!! Form::label('min_range', '1-24 Months Range',['class'=>'control-label col-md-4']) !!}
        <div class="col-md-4">
            <input type="text" placeholder="Minimum" value="{{$lab?$lab->_1_24m_minrange:''}}"  name="_1_24m_minrange" class="form-control">
            {!! $errors->first('min_range', '<span class="help-block">:message</span>') !!}
        </div>
        <div class="col-md-4">
            <input type="text" placeholder="Maximum" value="{{$lab?$lab->_1_24m_maxrange:''}}" name="_1_24m_maxrange" class="form-control">
            {!! $errors->first('max_range', '<span class="help-block">:message</span>') !!}
        </div>
    </div>


    <div class="form-group {{ $errors->has('min_range') ? ' has-error' : '' }}">
        {!! Form::label('min_range', '25-60 Months Range',['class'=>'control-label col-md-4']) !!}
        <div class="col-md-4">
            <input type="text" placeholder="Minimum" value="{{$lab?$lab->_25_60m_minrange:''}}"  name="_25_60m_minrange" class="form-control">
            {!! $errors->first('min_range', '<span class="help-block">:message</span>') !!}
        </div>
        <div class="col-md-4">
            <input type="text" placeholder="Maximum" value="{{$lab?$lab->_25_60m_maxrange:''}}" name="_25_60m_maxrange" class="form-control">
            {!! $errors->first('max_range', '<span class="help-block">:message</span>') !!}
        </div>
    </div>


    <div class="form-group {{ $errors->has('min_range') ? ' has-error' : '' }}">
        {!! Form::label('min_range', '5-19 Years Range',['class'=>'control-label col-md-4']) !!}
        <div class="col-md-4">
            <input type="text" placeholder="Minimum" value="{{$lab?$lab->_5_19y_minrange:''}}"  name="_5_19y_minrange" class="form-control">
            {!! $errors->first('min_range', '<span class="help-block">:message</span>') !!}
        </div>
        <div class="col-md-4">
            <input type="text" placeholder="Maximum" value="{{$lab?$lab->_5_19y_maxrange:''}}" name="_5_19y_maxrange" class="form-control">
            {!! $errors->first('max_range', '<span class="help-block">:message</span>') !!}
        </div>
    </div>


    <div class="form-group {{ $errors->has('min_range') ? ' has-error' : '' }}">
        {!! Form::label('min_range', 'Adult Range',['class'=>'control-label col-md-4']) !!}
        <div class="col-md-4">
            <input type="text" placeholder="Minimum" value="{{$lab?$lab->adult_minrange:''}}" name="adult_minrange" class="form-control">
            {!! $errors->first('min_range', '<span class="help-block">:message</span>') !!}
        </div>
        <div class="col-md-4">
            <input type="text" placeholder="Maximum" value="{{$lab?$lab->adult_maxrange:''}}" name="adult_maxrange" class="form-control">
            {!! $errors->first('max_range', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

    <div class="col-md-12">
        <div class="insured form-group {{ $errors->has('ordered_independently') ? ' has-error' : '' }}">
            {!! Form::label('ordered_independently', 'Ordered Independently',['class'=>'control-label col-md-4']) !!}
            <div class="col-md-8">
                <label class="radio-inline">

                    <label class="radio-inline">
                        <input type="radio" value="0" name="ordered_independently"/>
                        No
                    </label>

                    <label class="radio-inline">
                        <input type="radio" value="1" name="ordered_independently" checked=""/>
                        Yes
                    </label>
            </div>
        </div>
    </div>


    <div class="col-md-12">
        <div class="insured form-group {{ $errors->has('multiple_orders_allowed') ? ' has-error' : '' }}">
            {!! Form::label('multiple_orders_allowed', 'Multiple Orders Allowed?',['class'=>'control-label col-md-4']) !!}
            <div class="col-md-8">
                <label class="radio-inline">

                    <label class="radio-inline">
                        <input type="radio" value="0" name="multiple_orders_allowed" checked />
                        No
                    </label>

                    <label class="radio-inline">
                        <input type="radio" value="1" name="multiple_orders_allowed"/>
                        Yes
                    </label>
            </div>
        </div>
    </div>

</div>
<script>
    var numAdd = 1;
    var add = function () {
        if (numAdd >= 10)
            return;
        $('#options').append('<div><input type="text"  name="result_options[]"><a href="#" onclick="del(this)">Delete</a></div>');
        numAdd++;
    };

    var del = function (btn) {
        $(btn).parent().remove();
    };
</script>