<?php
/**
 * Created by PhpStorm.
 * User: bravo
 * Date: 7/9/17
 * Time: 3:48 AM
 */
$samples = get_patient_samples($visit->patient);
?>
<script src="{{m_asset('evaluation:js/JsBarcode.all.js')}}"></script>
<script>
    function textToBase64Barcode(text){
        var canvas = document.createElement("canvas");
        JsBarcode(canvas, text, {format: "CODE39"});
        return canvas.toDataURL("image/png");
    }
</script>
<div class="row show-grid">
    <div class="col-md-6">
        {!! Form::open(['route'=>'evaluation.labotomy']) !!}
        {!! Form::hidden('visit',$visit->id) !!}
        {!! Form::hidden('patient',$visit->patient) !!}
        <div class="box-body">
            <table id="sample_form" style="float: left" class="table">
                <tr>
                    <td><label>Type</label></td>
                    <td>
                        <div class="form-group">
                            {!! Form::select('type',get_sample_types(), ['id' => 'types', 'class' => 'types form-control', 'placeholder' => 'Choose...']) !!}
                            {!! $errors->first('type', '<span class="help-block">:message</span>') !!}
                        </div>
                    </td>
                </tr>
                <tr>
                    <td> <label>Method</label></td>
                    <td>
                        <div class="form-group">
                            {!! Form::select('collection_method',get_sample_methods(), ['size'=>'50','id' => 'methods', 'class' => 'methods form-control', 'placeholder' => 'Choose...']) !!}
                            {!! $errors->first('type', '<span class="help-block">:message</span>') !!}
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><label>Other deatils</label></td>
                    <td>
                        <!-- textarea -->
                        <div class="form-group">
                            <textarea class="form-control" name="details" rows="3" placeholder="Enter ..."></textarea>
                            {!! $errors->first('details', '<span class="help-block">:message</span>') !!}
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <div class="pull-right">
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
    <div class="col-md-6">
        <table class="table table-striped">
            <thead>
                <tr><th colspan="6">Samples collected for this patient</th></tr>
                <tr>
                    <th>#</th>
                    <th>Serial</th>
                    <th>Sample Type</th>
                    <th>Method</th>
                    <th>Barcode</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @foreach($samples as $s)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>00{{$s->id}}</td>
                <td>{{$s->type->name}}</td>
                <td>{{$s->method->name}}</td>
                <td>
                    <div>
                        <img height="50" id="barcode{{$s->id}}"/>
                        <script>JsBarcode("#barcode{{$s->id}}", "00{{$s->id}}");
                        </script>
                    </div>
                </td>
                <td>
                    <a id="printBC{{$s->id}}" class="btn btn-xs btn-primary">Print Barcode</a>
                    <script>
                        document.querySelector("#printBC{{$s->id}}").href = textToBase64Barcode("00{{$s->id}}");
                    </script>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
    <script type="text/javascript">
        $(document).ready(function () {
           // $('#sample_form select').select2();
        });
    </script>