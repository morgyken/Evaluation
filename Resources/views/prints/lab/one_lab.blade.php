<html>
<head>
    <title>Results</title>
    @include('evaluation::prints.partials.style')
</head>
<body>
@include('evaluation::prints.partials.head')
<?php
$item = $data['results'];
?>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<main>
    <center><strong>{{$item->procedures->name}}</strong><br/></center>
    <table class="table table-stripped">
        @include('evaluation::partials.labs.results.list')
    </table>
    <div id="notices">
        <div>KEY:</div>
        <div class="notice">
            <b>L:</b> Low,
            <b>N:</b>Normal,
            <b>H:</b>High.
        </div>
    </div>
</main>
@include('evaluation::prints.partials.footer')
</body>
</html>