<?php
/*
 * =============================================================================
 *
 * Collabmed Solutions Ltd
 * Project: Collabmed Health Platform
 * Author: Samuel Okoth <sodhiambo@collabmed.com>
 *
 * =============================================================================
 */
?>
@if(!$labs->isEmpty())
<div class="accordion">
    @foreach($labs as $item)
    <h4>{{$item->procedures->name}}</h4>
    <form method="POST" action="" accept-charset="UTF-8" id="results_form" enctype="multipart/form-data">
        {!! Form::hidden('visit',$visit->id)!!}
        {!! Form::token() !!}
        @if($item->procedures->this_test)
        <div>
            @if(!$item->procedures->children->isEmpty())
            <!-- Test that has children -->
            <div class="col-md-6">
                <div class="form-group">
                    <center>
                        <label>Test Results</label>
                    </center>
                    <input type="hidden" name="item{{$item->id}}" value="{{$item->id}}" />
                    <!-- Child Test Section -->
                    @foreach($item->procedures->children as $test)
                    <div class="form-group">
                        <label class="col-md-4">
                            {{$test->_procedure->name}}
                            <input type="hidden" name="item{{$item->id}}" value="{{$item->id}}" />
                            <input type="hidden" name="test{{$item->id}}[]" value="{{$test->_procedure->id}}" />
                        </label>
                        <div class="col-md-8">
                            @if ($test->lab_result_type == 'number')
                            <input type="number" name="results{{$item->id}}[]" class="form-control">
                            @elseif ($test->lab_result_type == 'select')
                            <select name="results{{$item->id}}[]" class="form-control">
                                <?php $options = json_decode($test->lab_result_options) ?>
                                @if(isset($options))
                                @foreach ($options as $option) {
                                <option value="{{$option}}">{{$option}}</option>
                                @endforeach
                                @endif
                            </select>
                            @else
                            <textarea rows="5" name="results{{$item->id}}[]" class="form-control"></textarea>
                            @endif
                        </div>
                    </div>
                    @endforeach
                    <label>Comments</label>
                    <textarea rows="5" name="comments{{$item->id}}" class="form-control"></textarea>
                </div>
            </div>
            @else
            <!-- Test that does not have children -->
            <?php
            if (isset($item->procedures->this_test->lab_result_type)) {
                $_type = $item->procedures->this_test->lab_result_type;
            }
            ?>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Test Results ({{$item->procedures->name}})</label>
                    <input type="hidden" name="item{{$item->id}}" value="{{$item->id}}" />
                    <input type="hidden" name="test{{$item->id}}[]" value="{{$item->procedures->id}}" />
                    @if ($_type == 'number')
                    <input type="number" name="results{{$item->id}}[]" class="form-control">
                    @elseif ($_type == 'select')
                    @if(isset($item->procedures->this_test->lab_result_options))
                    <select name="results{{$item->id}}[]" class="form-control">
                        <?php $_options = json_decode($item->procedures->this_test->lab_result_options) ?>
                        @if(isset($_options))
                        @foreach ($_options as $option) {
                        <option value="{{$option}}">{{$option}}</option>
                        @endforeach
                        @endif
                    </select>
                    @else
                    <input type="text" name="results{{$item->id}}[]" class="form-control">
                    @endif

                    @else
                    <textarea rows="5" name="results{{$item->id}}[]" class="form-control"></textarea>
                    @endif
                    <label>Comments</label>
                    <textarea rows="5" name="comments{{$item->id}}" class="form-control"></textarea>
                </div>
            </div>
            @endif
            <!-- File Upload -->
            <div class = "col-md-4 col-md-offset-2">
                <div class = "form-group">
                    <label>File</label>
                    <input type = "file" class = "form-control" name = "file{{$item->id}}"/>
                </div>
                <hr/>
                <dl class = "dl-horizontal">
                    <dt>Requested By:</dt><dd>{{$item->doctors->profile->full_name}}</dd>
                    <dt>Instructions:</dt><dd><p>{{$item->instructions ?? 'Not provided'}}</p></dd>
                    <dt>Charges:</dt><dd>{{$item->pesa}}</dd>
                    <dt>Date:</dt><dd>{{smart_date_time($item->created_at)}}</dd>
                </dl>
                <hr/>
            </div>
            <div class = "pull-right">
                <button type = "submit" onclick="save_results({{$item->id}})" class = "btn btn-xs btn-success">
                    <i class = "fa fa-save"></i>
                    Save
                </button>
                <button type = "reset" class = "btn btn-warning btn-xs">Cancel</button>
            </div>
        </div>
        @else


        <h4>{{$item->procedures->name}}</h4>
        <div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Results</label>
                    <input type="hidden" name="item{{$item->id}}" value="{{$item->id}}" />
                    <input type="hidden" name="test{{$item->id}}[]" value="{{$item->procedures->id}}" />
                    <textarea name="results{{$item->id}}[]" class="form-control" ></textarea>
                </div>
            </div>
            <div class="col-md-4 col-md-offset-2">
                <div class="form-group">
                    <label>File</label>
                    <input type="file" class="form-control" name="file{{$item->id}}"/>
                </div>
                <hr/>
                <dl class="dl-horizontal">
                    <dt>Requested By:</dt><dd>{{$item->doctors->profile->full_name}}</dd>
                    <dt>Instructions:</dt><dd><p>{{$item->instructions ?? 'Not provided'}}</p></dd>
                    <dt>Charges:</dt><dd>{{$item->pesa}}</dd>
                    <dt>Date:</dt><dd>{{smart_date_time($item->created_at)}}</dd>
                </dl>
                <hr/>
            </div>
            <div class="pull-right">
                <button type="submit" class="btn btn-xs btn-success">
                    <i class="fa fa-save"></i>
                    Save</button>
                <button type="reset" class="btn btn-warning btn-xs">Cancel</button>
            </div>
        </div>

        @endif
        {!!Form::close()!!}
        @endforeach
</div>
<script type="text/javascript">
    $(function () {
    CKEDITOR.replaceAll();
    });
</script>
@else
<p>No laboratory tests ordered for this patient</p>
@endif

