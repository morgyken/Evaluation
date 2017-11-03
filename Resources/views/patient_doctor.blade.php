@extends('layouts.app')
@section('content_title','Patient Evaluation')
@section('content_description','Patient evaluation and Treatment')

@section('content')
    @include('evaluation::partials.common.patient_details')
    
@endsection