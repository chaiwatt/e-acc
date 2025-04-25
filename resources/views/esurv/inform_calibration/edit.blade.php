@extends('layouts.master')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <h3 class="box-title pull-left">แก้ไขผลการสอบเทียบเครื่องมือวัด #{{ $inform_calibration->id }}</h3>
                    @can('view-'.str_slug('inform_calibration'))
                        <a class="btn btn-success pull-right" href="{{ url('/esurv/inform_calibration') }}">
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

                    {!! Form::model($inform_calibration, [
                        'method' => 'PATCH',
                        'url' => ['/esurv/inform_calibration', $inform_calibration->id],
                        'class' => 'form-horizontal',
                        'files' => true
                    ]) !!}

                    @include ('esurv.inform_calibration.form')

                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
@endsection
