@if ($type == 'number')
<input value="<?php get_reverted_test($item->procedures->id) ?>" id="{{$item->id}}" type="number" step="any" name="results{{$item->id}}[]" class="form-control">
@elseif ($type == 'select')
@if(isset($item->procedures->this_test->lab_result_options))
 <?php
 if(isset($test)){
     $_options = json_decode($test->subtests->this_test->lab_result_options);
 }else{
     $_options = json_decode($item->procedures->this_test->lab_result_options);
 }
 ?>
<select id="{{$item->id}}" name="results{{$item->id}}[]" class="form-control">
    <option></option>
    @if(!empty($_options))
    @foreach ($_options as $option)
    <option value="{{$option}}">{{$option}}</option>
    @endforeach
    @endif
</select>
@else
<input id="{{$item->id}}" value="<?php get_reverted_test($item->procedures->id) ?>" type="text" name="results{{$item->id}}[]" class="form-control">
@endif
@else
<textarea id="{{$item->id}}" rows="5" name="results{{$item->id}}[]" class="form-control">
    <?php get_reverted_test($item->procedures->id) ?>
</textarea>
@endif