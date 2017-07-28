<html>
<head>
    <title>Results</title>
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
<br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    @foreach($results as $item)
        <h5>{{$loop->iteration}}. {{$item->procedures->name}}</h5>
        <table>
            @include('evaluation::partials.labs.results.list')
        </table>
        <br/>
    @endforeach
    <table>
        <tr>
            <td>
                <b>L:</b> Low,
                <b>N:</b>Normal,
                <b>H:</b>High.
            </td>
        </tr>
    </table>
@include('evaluation::prints.partials.footer')
</body>
</html>