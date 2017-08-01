<html>
<head>
    <title>Lab results #</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    @include('evaluation::prints.partials.style')
</head>
<body>
@include('evaluation::prints.partials.head')
<?php
$patient = $data['visit']->patients;
$dob = \Carbon\Carbon::parse($patient->dob);
$age_days = $dob->diffInDays();
$age_str = (new Date($dob))->diff(Carbon\Carbon::now())->format('%y years, %m months and %d days');
$age_years = $dob->age;
$results = $data['visit']->investigations->where('type', 'laboratory')->where('has_result', true);
?>
<div>
    @include('evaluation::prints.partials.footer')
    @foreach($results as $item)
        <table cellpadding="0" cellspacing="0">
            <tr>
                <td colspan="5">
                    {{$loop->iteration}}. {{$item->procedures->name}}
                </td>
            </tr>
            @include('evaluation::partials.labs.results.list')
        </table>
        <table>
            <tr>
                <td colspan="5"></td>
            </tr>
            <tr class="heading">
                <th colspan="5" style="text-align: left">KEY</th>
            </tr>
            <tr>
                <td>L: Low</td>
                <td>H: High</td>
                <td>C: Critical</td>
                <td>A: Abnormal</td>
            </tr>
        </table>
    @endforeach
    <hr>
</div>
</body>
</html>