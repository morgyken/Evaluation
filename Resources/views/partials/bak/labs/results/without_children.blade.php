<tr>
    <td>{{$item->procedures->name}}</td>
    <td>
        <?php
        $res2 = GuzzleHttp\json_decode($item->results->results);
        echo strip_tags($res2[0][1]);
        ?>
    </td>
    <td>
        @if(strpos($item->procedures->name, '%'))
        %
        @endif
    </td>
    <td></td>
    <td></td>
</tr>