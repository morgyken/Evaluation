
@if($item->procedures)
<?php
$results = json_decode($item->results->results);
try{
    $patient = $data['visit']->patients;
}catch (\Exception $e){

}
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
    try{
        $all_tests[] = $_r[0];
        $their_result[] = $_r[1];
    }catch (\Exception $e) {
        $all_tests[] = "";
        $their_result[] = "";
    }
}
$test_res = array_combine($all_tests, $their_result);
?>
<tr class="heading">
    <td>Test</td>
    <td>Result</td>
    <td>Unit</td>
    <td style="text-align:center">Flag</td>
    <td>Ref Interval</td>
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
    @if($item->procedures->sensitivity)
        @include('evaluation::partials.labs.results.sensitivity')
    @else
        <td>{{$item->procedures->name}}</td>
        <td>{{ strip_tags($item->results->results)}}</td>
        <td>
            @if(strpos($item->procedures->name, '%'))
                %
            @endif
        </td>
        <td style="text-align:center"> - </td>
        <td>

        </td>
    @endif
</tr>
</table>
<!--End of  is_array If Statement -->
@endif
@if(!empty($item->procedures->remarks))
<table>
    <tr>
        <td colspan="5" style="font-weight: bold">
            @if(isset($item->procedures->remarks->title))
                {{ucwords($item->procedures->remarks->title)}}
            @else
                Remarks
            @endif
        </td>
    </tr>
    <tr>
        <td colspan="5" style="width: 100%; overflow: hidden;">
            <small>
                @if(isset($item->procedures->remarks->title))
                    <?php //echo html_entity_decode($item->procedures->remarks->remarks)
                    echo strip_tags($item->procedures->remarks->remarks)
                    ?>
                @else
                    <?php echo strip_tags($item->procedures->remarks->remarks) ?>
                @endif
            </small>
        </td>
    </tr>
</table>
@endif
@if(!empty($item->results->comments))
@if(isset($item->results->comments))
<!--End of  is_array If Statement -->
<table>
    <tr>
        <td colspan="5" style="font-weight: bold">Comments:</td>
    </tr>
    <tr>
        <td colspan="5">
            {{$item->results->comments?strip_tags($item->results->comments):"Not Provided"}}
        </td>
    </tr>
</table>
@endif
@endif
@endif
