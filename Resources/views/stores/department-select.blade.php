@extends('layouts.app')
@section('content_title',"Department and store selection")
@section('content_description',"choose your preferred department and store")

@section('content')
    <div class="panel panel-info">
        <div class="panel-heading">
            <h5>Select department and store</h5>
        </div>
        <div class="panel-body">
            <form action="{{ route('evaluation.authenticated.store') }}" method="post">
                {{ csrf_field() }}
                <div class="form-group">
                    <div class="col-md-6">
                        <label for="department">Choose a department</label>
                        <select name="department" id="department" class="form-control">
                            <option value="" selected disabled>Select a department</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6">
                        <label for="department">Choose a store</label>
                        <select name="store" id="store" class="form-control">
                            <option value="" selected disabled>Select a store</option>
                            @foreach($stores as $store)
                                <option value="{{ $store->id }}">{{ $store->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6" style="margin-top: 20px;">
                        <button class="btn btn-primary">Save Selections</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection