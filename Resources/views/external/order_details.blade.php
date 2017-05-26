@extends('layouts.app')
@section('content_title','Order Details')
@section('content_description','')

@section('content')

<div class="box box-info">
    <div class="box-header">
        <h3 class="box-title">Procedures Ordered</h3>
    </div>
    <div class="box-body">
        @if($data['order_details'])
        <table class="table table-striped table-condensed">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Item</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['order_details'] as $item)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$item->procedures->name}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <p>There are no patients associated with your Institution,<a class="btn btn-xs btn-primary" href="{{route('reception.add_patient')}}">click here to create a patient</a></p>
        @endif
    </div>
    <div class="box-footer">
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        try {
            $('table').DataTable();
        } catch (e) {
        }
    });
</script>
@endsection