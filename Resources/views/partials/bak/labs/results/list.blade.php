<?php $results = json_decode($item->results->results); ?>
@if(is_array($results))
<?php
$all_tests = array();
$their_result = array();
foreach ($results as $_r) {
    $all_tests[] = $_r[0];
    $their_result[] = $_r[1];
}
$test_res = array_combine($all_tests, $their_result);
?>
@if(!$item->procedures->children->isEmpty())

<!-- Procedure has children -->
@if(!$item->procedures->titles->isEmpty())
<!-- Procedure has titles (full haemogram) -->
@include('evaluation::partials.labs.results.with_titles')
@else
<!-- Procedure has no titles -->
@include('evaluation::partials.labs.results.without_titles')
@endif
@else
<!--Procedure has no children -->
@include('evaluation::partials.labs.results.without_children')

@endif

@else <!-- Just Display it if it is not an array -->
<tr>
    <td>{{$item->procedures->name}}</td>
    <td>{{ strip_tags($item->results->results)}}</td>
    <td>
        @if(strpos($item->procedures->name, '%'))
        %
        @endif
    </td>
    <td style="text-align:center"> - </td>
    <td> - </td>
</tr>
<!--End of  is_array If Statement -->
@endif
<!--End of  is_array If Statement -->
<tr>
    <td colspan="2">
        <strong>
            Comments
        </strong>
    </td>
    <td colspan="3">
        {{$item->results->comments?$item->results->comments:"Not Provided"}}
    </td>
</tr>