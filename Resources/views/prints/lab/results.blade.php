<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xml:lang="en" xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <title>Lab Result</title>
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
@include('evaluation::prints.partials.footer')
@foreach($results as $item)
    <h2 style="color: white">Section</h2>
    <h2 style="color: white">Section</h2>
    <h2 style="color: white">Section</h2>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <td colspan="5">
                {{$loop->iteration}}. {{$item->procedures->name}}
            </td>
        </tr>
        @include('evaluation::partials.labs.results.list')
    </table>
    @include('evaluation::prints.partials.key')
    <hr/>
@endforeach
</body>
</html>
