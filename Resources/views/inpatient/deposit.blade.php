@extends('layouts.app')
@section('content_title','Add Bed')
@section('content_description','Allocate more beds to Existing wards')

@section('content')
    @include('Evaluation::inpatient.success')

<div class="box box-info">
    <div class="box-body">
        <form action="{{url('/evaluation/inpatient/addDepositType')}}" method="post">
            <div class="col-lg-6">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <label for="" class="control-label">Deposit Name</label>
                <input type="text" name="name" class="form-control">

                <label for="" class="control-label">Cost</label>
                <input type="number" name="cost" class="form-control">
                <br>
                <button class="btn btn-primary" type="submit">Add Deposit</button>
            </div>
        </form>
    </div>

    <div class="box-body">
        <table id="DepositTable" class="table table-stripped condensed">
            <caption>The Beds List: All The Beds</caption>
            <thead>
            <th>Deposit</th>
            <th>Cost</th>
            <th>Actions</th>
            </thead>
            <tbody>
            @foreach($deposits as $deposit)
                <tr>
                    <td>{{$deposit->name}}</td>
                    <td>{{$deposit->cost}}</td>
                    <td>

                        <div class="input-group">
                            <form action="{{url('/evaluation/inpatient/delete_deposit')}}" class="btn btn-danger btn-xs" method="post">
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                <input type="hidden" name="deposit_id" value="{{$deposit->id}}">
                                <button class="btn btn-danger btn-xs">Delete</button>
                            </form>
                            <button class="btn btn-primary btn-xs delete"  value="{{$deposit->id}}">Edit</button>
                        </div>
                    </td>

                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="modal fade"  id="myModal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Edit Deposit</h4>
                    </div>
                    <form action="{{url('/evaluation/inpatient/deposit_adit')}}" method="post">
                    <div class="modal-body">

                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <input type="hidden" name="deposit_id" id="deposit_id">
                                <label for="" class="control-label">Deposit:</label>
                                    <input type="text" name="deposit" id="deposit" class="form-control">

                                <label for="" class="control-label">Deposit:</label>
                                    <input type="text" name="cost" id="amount" class="form-control">


                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-warning" id="checkout" >Update</button>
                        <button class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div></form>
                </div>
            </div>
        </div>
    </div>

</div>
    <script>
        $(function () {
            $("#DepositTable").dataTable();

            $(".delete").click(function () {
                vl = this.value;
                $('#myModal').modal('show');
                $("#deposit_id").value= vl;
                url = '{{url('/evaluation/inpatient/edit_deposit')}}'+'/'+vl;
                $.ajax({
                    url:url
                }).done(function (data) {
                    $("#deposit").val(data.name);
                    $("#deposit_id").val(data.id);
                    $("#amount").val(data.cost);
                })
            })
        })
    </script>

@endsection