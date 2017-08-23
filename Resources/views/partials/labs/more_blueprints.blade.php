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
                </div><br/>
                <div class="form-group {{ $errors->has('title') ? ' has-error' : '' }}">
                    {!! Form::label('title', 'Title (Optional)',['class'=>'control-label col-md-4']) !!}
                    <div class="col-md-8">
                        {!! Form::select('title[]',get_lab_titles(),null, ['id' => 'title_select','class' => 'form-control', 'placeholder' => 'Choose...']) !!}
                        {!! $errors->first('title', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
            </div>
        </div>

        <button class="add_button btn btn-xs btn-primary">
            <i class="fa fa-plus-square-o"></i> Add Record
        </button>
    </div>
</div>
<script src="{{m_asset('evaluation:js/lab_template_rows.js')}}"></script>