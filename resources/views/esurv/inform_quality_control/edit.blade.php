@extends('layouts.master')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <h3 class="box-title pull-left">แก้ไขผลการประเมิน QC #{{ $inform_quality_control->id }}</h3>
                    @can('view-'.str_slug('inform_quality_control'))
                        <a class="btn btn-success pull-right" href="{{ url('/esurv/inform_quality_control') }}">
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

                    {!! Form::model($inform_quality_control, [
                        'method' => 'PATCH',
                        'url' => ['/esurv/inform_quality_control', $inform_quality_control->id],
                        'class' => 'form-horizontal',
                        'files' => true
                    ]) !!}

                    @include ('esurv.inform_quality_control.form')

                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
@endsection
