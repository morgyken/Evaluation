
@if($orders->count()>0)
<table class="table table-striped table-condensed" id="data">
    <thead>
        <tr>
            <th>#</th>
            <th>Order Id</th>
            <th>By</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data['orders'] as $order)
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>00{{$order->id}}</td>
            <td>{{$order->users->profile->full_name}}</td>
            <td>{{$order->created_at}}</td>
            <td><a href="{{route('evaluation.exdoctor.order.view',$order->id)}}" class="btn btn-xs btn-primary">Details</a></td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
Nothing to show.
@endif