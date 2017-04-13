@extends('layouts.app')
@section('content_title','Admit Patient')
@section('content_description','Action to admitting a patient')

@section('content')
    @if(! count($patients))
    <div class="alert alert-danger">
        <span>The are no patient recorded</span>
    </div>

        @else

    <table class="table table-hover table-bordered">
        <caption>The Patient List: All The Patients</caption>
        <thead>
        <th>ID/Passport</th>
        <th>Name</th>
        <th>Options</th>
        </thead>
        <tbody>
        @foreach($patients as $patient)
            <tr>
                <td>{{$patient->id_no}}</td>
                <td>{{$patient->first_name}} {{$patient->middle_name}} {{$patient->last_name}}</td>
                <td>
                    <a class="btn btn-primary" href="{{url('evaluation/inpatient/admit/'.$patient->id)}}">Admit</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
    <script>
        $(function () {
            $("table").dataTable();
        })
    </script>

@endsection