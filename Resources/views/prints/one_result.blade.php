<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xml:lang="en" xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
    <?php
    extract($data);
    $results = $visit->investigations->where('type', $type)
            ->where('has_result', true);
    ?>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <title>{{ucfirst($type)}} Result</title>
    @include('evaluation::prints.partials.style')
</head>
<body>
@include('evaluation::prints.partials.head')
@include('evaluation::prints.partials.footer')
<h2 style="color: white">Section</h2>
<h5>{{$result->investigations->procedures->name}}</h5>
{!!$result->results!!}
<hr/>
</body>
</html>
