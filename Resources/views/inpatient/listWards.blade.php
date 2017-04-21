@extends('layouts.app')
@section('content_title','Admit Patient')
@section('content_description','Action to admitting a patient')

@section('content')
    @include('Evaluation::inpatient.success')
    <div class="box box-info">
        <div class="box-body">


            <form action="{{url('/evaluation/inpatient/addwordFormPost')}}" method="post">
                <div class="col-lg-6">
                    <div class="form-group">
                        <input type="hidden" name="_token" value="{{csrf_token()}}" class="">
                        <label class="control-label col-lg-4">Ward Number:</label>
                        <div class="col-lg-8">
                            <input required type="text" name="number" class="form-control">
                        </div>

                    </div>
                    <br>
                    <div class="form-group">
                        <label for="" class="control-label col-lg-4">Name:</label>
                        <div class="col-lg-8">
                            <input required  type="text" name="name" class="form-control">
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="" class="control-label col-md-4">Category:</label>
                        <div class="col-md-8">
                            <select required  name="category" class="form-control" id="">
                                <option value="private">Private</option>
                                <option value="general">General</option>
                            </select>
                        </div>
                    </div>

                </div>

                <div class="col-lg-6">

                    <div class="form-group">
                        <label for="" class="control-label col-lg-4">Age Group:</label>
                        <div class="col-md-8">
                            <select required  name="age_group" class="form-control" id="">
                                <option value="Adults">Adults</option>
                                <option value="Children">Children</option>
                            </select>
                        </div>
                    </div>



                    <div class="form-group">
                        <label for="" class="control-label col-md-4">Gender:</label>
                        <div class="col-md-8">
                            <select required  name="gender" class="form-control" id="">
                                <option value="name">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="" class="control-label col-md-4">Cost:</label>
                        <div class="col-md-8">
                            <input required  type="number" name="cost" class="form-control" placeholder="In Kshs.">
                        </div>

                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary btn-xs" type="submit">Add Ward</button>
                    </div>
                    <br>

                </div>
            </form>

            <hr>

                <table class="table table-stripped">
                    <caption>The Ward List: All The Wards</caption>
                    <thead>
                    <th>No.</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Cost</th>
                    <th>Added At</th>
                    <th>Actions</th>
                    </thead>
                    <tbody>
                    @foreach($wards as $ward)
                        <tr>
                            <td>{{$ward->number}}</td>
                            <td>{{$ward->name}}</td>
                            <td>{{$ward->category}}</td>
                            <td>Ksh.{{$ward->cost}}</td>
                            <td>{{$ward->created_at}}</td>
                            <td>
                                <form action="{{url('/evaluation/inpatient/delete_ward/')}}" method="post">
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    <input type="hidden" name="ward_id" value="{{$ward->id}}">
                                    <button class="btn btn-danger btn-xs">Delete</button>
                                </form>
                                <button class="btn btn-primary btn-xs">Edit</button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
        </div>
    </div>
    <script>
        $(function () {
            $("table").dataTable();
        })
    </script>

@endsection