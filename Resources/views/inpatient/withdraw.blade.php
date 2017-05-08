@extends('layouts.app')
@section('content_title','Withdraw')
@section('content_description','Withdraw from patient account')

@section('content')
    @include('Evaluation::inpatient.success')



<div class="box box-info">
      <div class="box-body">
        <form action="{{url('/evaluation/inpatient/WithdrawAmount')}}" method="post">
            <div class="col-lg-6">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <div class="form-group">
                    <label for="" class="control-label col-md-4">Select Patient:</label>
                    <div class="col-md-8">
                        <select required name="patient_id" id="" class="form-control">
                            @foreach($patients as $patient)
                                <option value="{{$patient->id}}">{{$patient->first_name}} {{$patient->last_name}} </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="" class="control-label col-md-4">Amount</label>
                    <div class="col-md-8">
                        <input required type="number" name="amount" class="form-control">
                    </div>
                </div>

                @if($errors->any())
                    <div class="alert text-warning">
                        <span class="text-error">{{$errors->first('amount')}}</span>
                    </div>
                    @endif
                <br>
                <button class="btn btn-primary" type="submit">Withdraw</button>
            </div>
        </form>
    </div>

    <div class="box-body">
        <table class="table table-stripped condensed">
            <thead>
            <th>Account Name</th>
            <th>Amount Withdrawn</th>
            <th>Patient</th>
            <th>Date</th>
            </thead>
            <tbody>
            @foreach($deposits as $deposit)
                <tr>
                    <td>{{$deposit->reference}}</td>
                    <td>Kshs. {{$deposit->debit}}</td>
                    <td>
                        {{\Ignite\Reception\Entities\Patients::find($deposit->patient)->first_name}}
                    </td>
                    <td>{{$deposit->created_at}}</td>
                </tr>
            @endforeach            </tbody>
        </table>
    </div>


</div>
    <script>
        $(function () {
            $("table").dataTable();
            $('select').select2();
        })
    </script>

@endsection