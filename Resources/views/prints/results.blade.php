<html>
<?php
extract($data);
$results = $visit->investigations->where('type', $type)->where('has_result', true);
?>
<head>
    <title>{{ucfirst($type)}} Results</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    @include('evaluation::prints.partials.style')
</head>
<body>
@include('evaluation::prints.partials.head')
<div>
    @include('evaluation::prints.partials.footer')
    @foreach($results as $item)
        <table cellpadding="0" cellspacing="0">
            <tr>
                <td colspan="5">
                    {{$loop->iteration}}. {{$item->procedures->name}}
                </td>
            </tr>
        </table>
        {!!$item->results->results!!}
        <hr>
    @endforeach
</div>
</body>
</html>