@if(isset($external))
@if($item->results->status==3)
<a class="btn btn-info btn-xs" target="blank" href="{{route('evaluation.print.print_lab.one', ['id'=>$item->id,'visit'=>$data['visit']->id])}}">
    Print<i class="fa fa-print"></i>
</a>
@endif
@else
<!--Action Pane -->
@if($item->results->status==0) <!--pending -->
<a class="btn btn-primary btn-xs" href="{{route('evaluation.lab.verify', $item->results->id)}}">
    Verify<i class="fa fa-send"></i>
</a>
<a title="Note this will delete these results and revert back to test phase" class="btn btn-danger btn-xs" href="{{route('evaluation.lab.revert', $item->results->id)}}">
    Revert<i class="fa fa-trash"></i>
</a>
@elseif($item->results->status==1)<!--verified -->
<a class="btn btn-success btn-xs" href="{{route('evaluation.lab.publish', $item->results->id)}}">
    Accept and Publish <i class="fa fa-send"></i>
</a>
@elseif($item->results->status==2)<!--accepted and published -->
<span class="btn btn-success btn-xs">
    <i class="fa fa-check"></i>Published
</span>
<a class="btn btn-info btn-xs" target="blank" href="{{route('evaluation.print.print_lab.one', ['id'=>$item->id,'visit'=>$data['visit']->id])}}">
    Print<i class="fa fa-print"></i>
</a>
<a class="btn btn-warning btn-xs" href="{{route('evaluation.lab.send', $item->results->id)}}">
    Send <i class="fa fa-send"></i>
</a>
@elseif($item->results->status==3)<!--sent -->
<span class="btn btn-success btn-xs">
    <i class="fa fa-send"></i>Sent
</span>
<a class="btn btn-info btn-xs" target="blank" href="{{route('evaluation.print.print_lab.one', ['id'=>$item->id,'visit'=>$data['visit']->id])}}">
    Print<i class="fa fa-print"></i>
</a>
@endif
@endif
