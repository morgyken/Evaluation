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
<h2 style="color: white">Section</h2>
<table class="data" cellpadding="0" cellspacing="0">
    <tr>
        <td colspan="5">
            <?php echo ucwords($item->procedures->name) ?>
        </td>
    </tr>
    @include('evaluation::partials.labs.results.list')
</table>
@include('evaluation::prints.partials.key')
<hr/>
</body>
</html>
