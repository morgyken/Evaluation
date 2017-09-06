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
$item = $data['results'];
?>
@include('evaluation::prints.partials.footer')
<h1 style="text-align: center">1. <?php echo ucwords($item->procedures->name) ?></h1>
<table id="results" class="data" cellpadding="0" cellspacing="0">
    @include('evaluation::partials.labs.results.list')
</table>
@include('evaluation::prints.partials.key')
<hr/>
</body>
</html>
