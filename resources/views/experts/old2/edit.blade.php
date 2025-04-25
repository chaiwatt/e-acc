@extends('layouts.master')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <h3 class="box-title pull-left">แก้ไขExpert #{{ $expert->id }}</h3>
                    @can('view-'.str_slug('experts'))
                        <a class="btn btn-success pull-right" href="{{ url('/experts') }}">
                            <i class="icon-arrow-left-circle" aria-hidden="true"></i> กลับ
                        </a>
                    @endcan
                    <div class="clearfix"></div>
                    <hr>

                    @if ($errors->any())
                        <ul class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif

                    {!! Form::model($expert, [
                        'method' => 'PATCH',
                        'url' => ['/experts', $expert->id],
                        'class' => 'form-horizontal',
                        'files' => true
                    ]) !!}

                    @include ('experts.form')

                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
@endsection
