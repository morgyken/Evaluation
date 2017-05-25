<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title">My Queue</h3>
    </div><!-- /.box-header -->
    <div class="box-body no-padding">
        <table class="table table-striped">
            <tbody><tr>
                    <th style="width: 10px">#</th>
                    <th>Patient</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
                <?php if (isset($queue)): ?>
                    @foreach($queue as $item)
                    @foreach($item->visits as $visit)
                    <tr id="row_id{{$visit->id}}">
                        <td>{{$loop->iteration}}</td>
                        <td>{{$visit->patients->full_name}}</td>
                        <td>{{(new Date($visit->created_at))->format('dS M g:i a')}}</td>
                        <td>
                            <button value='{{$visit->id}}' class="btn btn-warning btn-xs checkout">
                                <i class="fa fa-sign-out"></i> Checkout</button>
                        </td>
                    </tr>
                    @endforeach
                    @endforeach
                <?php endif; ?>
            </tbody>
        </table>
    </div><!-- /.box-body -->
</div>
