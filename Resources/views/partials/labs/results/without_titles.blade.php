<?php
$tests = get_lab_template($item->procedures->id);
?>
@foreach($tests as $test)
<tr>
    <td>{{$test->subtests->name}}</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
</tr>
@endforeach
<tr>
    <td colspan="2">
        Comment
    </td>
</tr>