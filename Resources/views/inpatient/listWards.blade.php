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
                    <br>
                    <div class="form-group">
                        <label for="" class="control-label col-lg-4">Name:</label>
                        <div class="col-lg-8">
                            <input required  type="text" name="name" class="form-control">
                        </div>
                    </div>
                    <br>
                    <br>

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
                    <br>
                    <br>
                    <div class="form-group">
                        <label for="" class="control-label col-md-4">Gender:</label>
                        <div class="col-md-8">
                            <select required  name="gender" class="form-control" id="">
                                <option value="name">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>
                    </div>
                    <br>
                    <br>
                    <div class="form-group">
                        <label for="" class="control-label col-md-4">Cost:</label>
                        <div class="col-md-8">
                            <input required  type="number" name="cost" class="form-control" placeholder="In Kshs.">
                        </div>

                    </div>
                    <br>
                    <br>
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
                                <a href="{{url('/evaluation/inpatient/delete_ward'.'/'.$ward->id)}}" class="btn btn-danger btn-xs">Delete</a>
                                <button class="btn btn-primary btn-xs edit" id="{{$ward->id}}" data-toggle="modal" data-target="#myModal" >Edit</button>


                                {{--<form action="{{url('/evaluation/inpatient/delete_ward/')}}" method="post">
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    <input type="hidden" name="ward_id" value="{{$ward->id}}">
                                    <button class="btn btn-danger btn-xs">Delete</button>
                                </form>--}}

                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
        </div>
    </div>

    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <form method="post" action="{{url('evaluation/inpatient/update_ward')}}">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Edit Ward</h4>
                    </div>
                    <div class="modal-body">
                        <div>
                            <input type="hidden" name="wardId" id="wardId">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <label for="" class="control-label">Ward Name</label>
                            <input type="text" id="name" class="form-control" name="name">

                            <label for="bed_type" class="control-label">Select Type</label>
                            <select name="category" id="category" class="form-control">
                                <option value="private">Private</option>
                                <option value="public">Public</option>
                            </select>

                            <label for="bed_type" class="control-label">Gender</label>
                            <select name="gender" id="gender" class="form-control">
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>

                            <label for="" class="control-label">Cost</label>
                            <input type="number" id="cost" class="form-control" name="cost">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit"> Save</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>

        </div>
    </div>


    <script>
        $(function () {
            $("table").dataTable();

            //edit ward
            $("button.edit").click(function () {
                // AAX FETCH RECOrd
                $("#wardId").val(this.id);
                var url = '{{url('/evaluation/inpatient/editWard')}}'+'/'+this.id;
                $.ajax({
                    url:url
                }).done(function (data) {
                    console.info(data);
                    //attach data returned...
                    $("#name").val(data.name);
                    $("#category").val(data.category);
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        $("#cost").val(data.cost);
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    })
            })

        })
    </script>
    
@endsection