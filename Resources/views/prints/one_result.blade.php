<html>
<?php
extract($data);
$results = $visit->investigations->where('type', $type)
        ->where('has_result', true);
?>
<head>
    <title>{{ucfirst($type)}} Results</title>
    @include('evaluation::prints.partials.style')
</head>
<body>
@include('evaluation::prints.partials.head')
<h5>{{$result->investigations->procedures->name}}</h5>
{!!$result->results!!}
@include('evaluation::prints.partials.footer')
</body>
</html>