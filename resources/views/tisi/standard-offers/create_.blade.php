@extends('layouts.fontend-none')

@section('content')
    {!! Form::open(['url' => '/tisi/standard-offers/store',  'method' => 'POST', 'class' => 'form-horizontal', 'files' => true]) !!}
        @include ('tisi/standard-offers.form')
    {!! Form::close() !!}
    @include ('tisi/standard-offers.modal_department')

@endsection
