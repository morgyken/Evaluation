<?php
$lab = $procedure->this_test;
$parent = null;
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
<div id="labs">

    <div class="form-group {{ $errors->has('parent') ? ' has-error' : '' }}">
        {!! Form::label('parent', 'Parent Procedure',['class'=>'control-label col-md-4']) !!}
        <div class="col-md-8">
            {!! Form::select('parent',get_parent_procedures(),$parent, ['id' => 'parent_select','class' => 'form-control', 'placeholder' => 'Choose...']) !!}
            {!! $errors->first('parent', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

    <div class="form-group {{ $errors->has('lab_category') ? ' has-error' : '' }}">
        {!! Form::label('lab_category', 'Lab Category',['class'=>'control-label col-md-4']) !!}
        <div class="col-md-8">
            {!! Form::select('lab_category',get_lab_cats(),$cat, ['class' => 'form-control lab_cat', 'placeholder' => 'Choose...']) !!}
            {!! $errors->first('lab_category', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

    <div class="form-group {{ $errors->has('result_type') ? ' has-error' : '' }}">
        {!! Form::label('result_type', 'Result Type',['class'=>'control-label col-md-4']) !!}
        <div class="col-md-8">
            {!!Form::select('result_type', array(
            'text' => 'Text',
            'number' => 'Number',
            'select' => 'Drop Down',
            'other' => 'Other'
            ), $type,['id'=>'result_type','class'=>'form-control'])!!}
            {!! $errors->first('parent', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

    <div id="result_type_options" class="form-group {{ $errors->has('result_options') ? ' has-error' : '' }}">
        {!! Form::label('result_options', 'Drop-down Options',['class'=>'control-label col-md-4']) !!}
        <div class="col-md-8">
            <?php try { ?>
                @if(isset($lab->lab_result_options))
                Saved Dropdown Entries <br/>
                @foreach(json_decode($lab->lab_result_options) as $option)
                <div>
                    <input type="text" value="{{$option}}"  name="result_options[]"><a href="#" onclick="del(this)"><i style="color:red" class="fa fa-trash"></i></a>
                </div>
                @endforeach
                @endif
                <?php
            } catch (\Exception $e) {

            }
            ?>
            <input type="text" placeholder="option 1" name="result_options[]">
            <input type="text" placeholder="option 2" name="result_options[]">
            <a href="#" onclick="add()"><i class="fa fa-plus"></i></a><br/>
            <div id="options">
            </div>
        </div>
    </div>

    <div class="form-group {{ $errors->has('result_type') ? ' has-error' : '' }}">
        {!! Form::label('result_type', 'Unit of measure',['class'=>'control-label col-md-4']) !!}
        <div class="col-md-8">
            {!! Form::select('units',get_units(),$lab?$lab->units:'', ['class' => 'form-control unit', 'placeholder' => 'Choose...']) !!}
            {!! $errors->first('unit', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

    <div class="form-group {{ $errors->has('sample_type') ? ' has-error' : '' }}">
        {!! Form::label('sample_type', 'Sample Type',['class'=>'control-label col-md-4']) !!}
        <div class="col-md-8">
            {!! Form::select('sample_type',get_sample_types(),$lab?$lab->lab_sample_type:'', ['class' => 'form-control lab_cat', 'placeholder' => 'Choose...']) !!}
            {!! $errors->first('sample_type', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

    <div class="form-group {{ $errors->has('sample_type') ? ' has-error' : '' }}">
        {!! Form::label('Additive/Container', 'Additive',['class'=>'control-label col-md-4']) !!}
        <div class="col-md-8">
            {!! Form::select('additive',get_additives(),$procedure->additive?$procedure->additive:'', ['class' => 'form-control lab_cat', 'placeholder' => 'Choose...']) !!}
            {!! $errors->first('additive', '<span class="help-block">:message</span>') !!}
        </div>
    </div>
    <div class="form-group {{ $errors->has('turn_around_time') ? ' has-error' : '' }}">
        {!! Form::label('turn_around_time', 'Turn Around Time',['class'=>'control-label col-md-4']) !!}
        <div class="col-md-8">
            <input type="text" value="{{$lab?$lab->turn_around_time:''}}" placeholder="Turn around time" name="turn_around_time" class="form-control">
            {!! $errors->first('turn_around_time', '<span class="help-block">:message</span>') !!}
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
    $('#lg').hide();
    $('#range').hide();

    $("#refs").change(function () {
        show_ranges()
    });

    $("#refs").click(function () {
        show_ranges()
    });

    function show_ranges() {
        var selected = $("#refs").val();
        if (selected == 'range') {
            $("#range").show();
        }else {
            $("#range").hide();
            if(selected == 'lg'){
                $("#lg").show();
            }else {
                $("#lg").hide();
            }
        }
    }

    var numAdd = 1;
    var add = function () {
        if (numAdd >= 100)
            return;
        $('#options').append('<div><input type="text"  name="result_options[]"><a href="#" onclick="del(this)"><i style="color:red" class="fa fa-trash"></i></a></div>');
        numAdd++;
    };

    var del = function (btn) {
        $(btn).parent().remove();
    };
</script>