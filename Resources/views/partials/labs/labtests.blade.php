
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
        {!! Form::label('lab_category', 'Category (Lab)',['class'=>'control-label col-md-4']) !!}
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
            <select class="form-control" name="result_type">
                <option value="text">Free text</option>
                <option value="number">Number</option>
                <option value="select">Drop-down</option>
                <option value="other">Other</option>
            </select>
            {!! $errors->first('parent', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

    <div class="form-group {{ $errors->has('result_options') ? ' has-error' : '' }}">
        {!! Form::label('result_options', 'Result Options',['class'=>'control-label col-md-4']) !!}
        <div class="col-md-8">
            <input type="text" class="form-control" name="result_options[]" multiple>
        </div>
    </div>

    <div class="form-group {{ $errors->has('sample_type') ? ' has-error' : '' }}">
        {!! Form::label('sample_type', 'Sample Type',['class'=>'control-label col-md-4']) !!}
        <div class="col-md-8">
            <input type="text" name="sample_type" class="form-control">
            {!! $errors->first('sample_type', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

    <div class="form-group {{ $errors->has('min_range') ? ' has-error' : '' }}">
        {!! Form::label('min_range', 'Minimum Range',['class'=>'control-label col-md-4']) !!}
        <div class="col-md-8">
            <input type="text" name="min_range" class="form-control">
            {!! $errors->first('min_range', '<span class="help-block">:message</span>') !!}
        </div>
    </div>


    <div class="form-group {{ $errors->has('max_range') ? ' has-error' : '' }}">
        {!! Form::label('max_range', 'Maximum Range',['class'=>'control-label col-md-4']) !!}
        <div class="col-md-8">
            <input type="text" name="max_range" class="form-control">
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