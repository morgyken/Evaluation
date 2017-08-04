<html>
<head>
    <title>Lab results #</title>
    @include('evaluation::prints.partials.style')
</head>
<body>
@include('evaluation::prints.partials.head')
<?php
$item = $data['results'];
?>
@include('evaluation::prints.partials.footer')
<table class="data" cellpadding="0" cellspacing="0">
    <tr>
        <td colspan="5">
            <?php echo ucwords($item->procedures->name) ?>
        </td>
    </tr>
    @include('evaluation::partials.labs.results.list')
</table>
<table>
    <tr class="heading">
        <th colspan="5" style="text-align: left">Requesting Pathologist</th>
    </tr>
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
<i></i>
</body>
</html>