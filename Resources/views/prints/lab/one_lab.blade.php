<?php
$item = $data['results'];
?>
@include('evaluation::prints.partials.head')
<br><br/>
@include('evaluation::prints.partials.footer')
<div id="content">
    <center><strong>{{$item->procedures->name}}</strong><br/></center>
    <table class="table table-stripped">
        @include('evaluation::partials.labs.results.list')
    </table>
    <table class="table table-stripped">
        <tr style="font-weight: bold">
            <td>Key:</td>
            <td>L:Low</td>
            <td>N:Normal</td>
            <td>H:High</td>
            <td></td>
        </tr>
    </table>
    <p style="page-break-before: always;"></p>
</div>
</body>
</html>