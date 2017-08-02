<?php
$results = json_decode($item->results->results);

$patient = $data['visit']->patients;
$dob = \Carbon\Carbon::parse($patient->dob);
$age_days = $dob->diffInDays();
$age_str = (new Date($dob))->diff(Carbon\Carbon::now())->format('%y years, %m months and %d days');
$age_years = $dob->age;
?>
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
<tr class="heading">
    <td>Test</td>
    <td>Result</td>
    <td>Unit</td>
    <td style="text-align:center">Flag</td>
    <td>Ref Range</td>
</tr>
    @if(!empty($item->procedures->templates_lab))
        @if(has_headers($item->procedures->id))
             <!-- Procedure has pre-defined template -->
            @include('evaluation::partials.labs.results.preload')
        @else
            <!-- Procedure has pre-defined template -->
            @include('evaluation::partials.labs.results.preload_no_headers')
        @endif
    @else
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
    @endif
@else
<!-- Just Display it if it is not an array -->
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
@if(!empty($item->procedures->remarks))
<br/>
<br/>
<tr>
    <td colspan="5" style="font-weight: bold">Remarks:</td>
</tr>
<tr>
    <td colspan="5">
        <small>
            <?php echo html_entity_decode($item->procedures->remarks->remarks) ?>
        </small>
    </td>
</tr>
@endif
@if(!empty($item->results->comments))
@if(isset($item->results->comments))
<!--End of  is_array If Statement -->
<tr>
    <td colspan="5" style="font-weight: bold">Comments:</td>
</tr>
<tr>
    <td colspan="5">
        {{$item->results->comments?$item->results->comments:"Not Provided"}}
    </td>
</tr>
@endif
@endif
<br/>
