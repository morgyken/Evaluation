
@if ($type == 'number')
<input value="<?php get_reverted_test($test->subtests->id) ?>" id="{{$test->subtests->id}}" type="number" step="any" name="results{{$test->subtests->id}}[]" class="form-control">
@elseif ($type == 'select')
@if(isset($test->subtests->this_test->lab_result_options))
<select id="{{$test->subtests->id}}" name="results{{$test->subtests->id}}[]" class="form-control">
    <option></option>
    <?php
    $_options = json_decode($test->subtests->this_test->lab_result_options);
    ?>
    @if(isset($_options))
    @foreach ($_options as $option)
    <option value="{{$option}}">{{$option}}</option>
    @endforeach
    @endif
</select>
@else
<input id="{{$test->subtests->id}}" value="<?php get_reverted_test($test->subtests->id) ?>" type="text" name="results{{$test->subtests->id}}[]" class="form-control">
@endif
@else
<textarea id="{{$test->subtests->id}}" rows="5" name="results{{$test->subtests->id}}[]" class="form-control">
    <?php get_reverted_test($test->subtests->id) ?>
</textarea>
@endif