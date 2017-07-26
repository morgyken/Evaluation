<?php
$lab = $procedure->this_test;
$parent = null;
$subtest = null;
$cat = null;
$title = null;
$type = null;
if (isset($lab->parent)) {
    $parent = $lab->parent;
}
if (isset($lab->category)) {
    $cat = $lab->category;
}

if (isset($lab->title)) {
    $title = $lab->title;
}

if (isset($lab->lab_result_type)) {
    $type = $lab->lab_result_type;
}
?>
<hr/>
<div class="col-md-12">
    <div class="clearfix"></div>
    <div id="templates"  class="templates hidden">
        <div id="wrapper1">
            <div class="col-md-12">
                <input type="hidden" name="lab" value="1">
                <div class="form-group {{ $errors->has('subtest') ? 'has-error' : '' }} req">
                    {!! Form::label('subtest', 'Subtest',['class'=>'control-label col-md-4']) !!}
                    <div class="col-md-8">
                        {!! Form::select('subtest[]',get_parent_procedures(),$subtest, ['id' => 'test_select','class' => 'form-control test_select', 'placeholder' => 'Choose...']) !!}
                        {!! $errors->first('subtest', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
                <!--
                <div class="form-group {{ $errors->has('Sort Order') ? 'has-error' : '' }}">
                    {!! Form::label('sort_order', 'Sort Order',['class'=>'control-label col-md-4']) !!}
                    <div class="col-md-8">
                        <input type="text" value="" placeholder="Sort Order"  name="sort_order[]" class="form-control">
                        {!! $errors->first('sort_order', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
                -->
                <div class="form-group {{ $errors->has('title') ? ' has-error' : '' }}">
                    {!! Form::label('title', 'Title',['class'=>'control-label col-md-4']) !!}
                    <div class="col-md-8">
                        {!! Form::select('title[]',get_lab_titles(),$title, ['class' => 'form-control', 'placeholder' => 'Choose...']) !!}
                        {!! $errors->first('title', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>

                <div class="form-group {{ $errors->has('title') ? ' has-error' : '' }}">
                    {!! Form::label('title', 'Alias',['class'=>'control-label col-md-4']) !!}
                    <div class="col-md-8">
                        <small>One word or letter to be used in formulae</small>
                        <input type="text" value="" placeholder="Alias"  name="alias[]" class="form-control">
                        {!! $errors->first('alias', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>

                <!--
                                <div class="form-group {{ $errors->has('min_range') ? ' has-error' : '' }}">
                                    {!! Form::label('min_range', 'Default Range',['class'=>'control-label col-md-4']) !!}
                                    <div class="col-md-4">
                                        <input type="text" value="{{$lab?$lab->lab_min_range:''}}" placeholder="Minimum"  name="min_range[]" class="form-control">
                                        {!! $errors->first('min_range', '<span class="help-block">:message</span>') !!}
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" value="{{$lab?$lab->lab_max_range:''}}" placeholder="Maximum" name="max_range[]" class="form-control">
                                        {!! $errors->first('max_range', '<span class="help-block">:message</span>') !!}
                                    </div>
                                </div>


                                <div class="form-group {{ $errors->has('min_range') ? ' has-error' : '' }}">
                                    {!! Form::label('min_range', 'O-3 Days Range',['class'=>'control-label col-md-4']) !!}
                                    <div class="col-md-4">
                                        <input type="text" value="{{$lab?$lab->_0_3d_minrange:''}}" placeholder="Minimum"  name="_0_3d_minrange[]" class="form-control">
                                        {!! $errors->first('min_range', '<span class="help-block">:message</span>') !!}
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" value="{{$lab?$lab->_0_3d_maxrange:''}}" placeholder="Maximum" name="_0_3d_maxrange[]" class="form-control">
                                        {!! $errors->first('max_range', '<span class="help-block">:message</span>') !!}
                                    </div>
                                </div>

                                <div class="form-group {{ $errors->has('min_range') ? ' has-error' : '' }}">
                                    {!! Form::label('min_range', '4-30 Days Range',['class'=>'control-label col-md-4']) !!}
                                    <div class="col-md-4">
                                        <input type="text" placeholder="Minimum" value="{{$lab?$lab->_4_30d_minrange:''}}"  name="_4_30d_minrange[]" class="form-control">
                                        {!! $errors->first('min_range', '<span class="help-block">:message</span>') !!}
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" placeholder="Maximum" value="{{$lab?$lab->_4_30d_maxrange:''}}" name="_4_30d_maxrange[]" class="form-control">
                                        {!! $errors->first('max_range', '<span class="help-block">:message</span>') !!}
                                    </div>
                                </div>

                                <div class="form-group {{ $errors->has('min_range') ? ' has-error' : '' }}">
                                    {!! Form::label('min_range', '1-24 Months Range',['class'=>'control-label col-md-4']) !!}
                                    <div class="col-md-4">
                                        <input type="text" placeholder="Minimum" value="{{$lab?$lab->_1_24m_minrange:''}}"  name="_1_24m_minrange[]" class="form-control">
                                        {!! $errors->first('min_range', '<span class="help-block">:message</span>') !!}
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" placeholder="Maximum" value="{{$lab?$lab->_1_24m_maxrange:''}}" name="_1_24m_maxrange[]" class="form-control">
                                        {!! $errors->first('max_range', '<span class="help-block">:message</span>') !!}
                                    </div>
                                </div>

                                <div class="form-group {{ $errors->has('min_range') ? ' has-error' : '' }}">
                                    {!! Form::label('min_range', '25-60 Months Range',['class'=>'control-label col-md-4']) !!}
                                    <div class="col-md-4">
                                        <input type="text" placeholder="Minimum" value="{{$lab?$lab->_25_60m_minrange:''}}"  name="_25_60m_minrange[]" class="form-control">
                                        {!! $errors->first('min_range', '<span class="help-block">:message</span>') !!}
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" placeholder="Maximum" value="{{$lab?$lab->_25_60m_maxrange:''}}" name="_25_60m_maxrange[]" class="form-control">
                                        {!! $errors->first('max_range', '<span class="help-block">:message</span>') !!}
                                    </div>
                                </div>


                                <div class="form-group {{ $errors->has('min_range') ? ' has-error' : '' }}">
                                    {!! Form::label('min_range', '5-19 Years Range',['class'=>'control-label col-md-4']) !!}
                                    <div class="col-md-4">
                                        <input type="text" placeholder="Minimum" value="{{$lab?$lab->_5_19y_minrange:''}}"  name="_5_19y_minrange[]" class="form-control">
                                        {!! $errors->first('min_range', '<span class="help-block">:message</span>') !!}
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" placeholder="Maximum" value="{{$lab?$lab->_5_19y_maxrange:''}}" name="_5_19y_maxrange[]" class="form-control">
                                        {!! $errors->first('max_range', '<span class="help-block">:message</span>') !!}
                                    </div>
                                </div>


                                <div class="form-group {{ $errors->has('min_range') ? ' has-error' : '' }}">
                                    {!! Form::label('min_range', 'Adult Range',['class'=>'control-label col-md-4']) !!}
                                    <div class="col-md-4">
                                        <input type="text" placeholder="Minimum" value="{{$lab?$lab->adult_minrange:''}}" name="adult_minrange[]" class="form-control">
                                        {!! $errors->first('min_range', '<span class="help-block">:message</span>') !!}
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" placeholder="Maximum" value="{{$lab?$lab->adult_maxrange:''}}" name="adult_maxrange[]" class="form-control">
                                        {!! $errors->first('max_range', '<span class="help-block">:message</span>') !!}
                                    </div>
                                </div>
                -->


            </div>
        </div>

        <button class="add_button btn btn-xs btn-primary">
            <i class="fa fa-plus-square-o"></i> Add Record
        </button>
    </div>
</div>
<script src="{{m_asset('evaluation:js/lab_template_rows.js')}}"></script>