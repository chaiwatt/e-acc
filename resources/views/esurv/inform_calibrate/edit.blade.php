@extends('layouts.master')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">

                    <h3 class="box-title pull-left">แก้ไขผลการสอบเทียบ #{{ $inform_calibrate->id }}</h3>
                    <div class="clearfix"></div>
                    <div class="pull-left" style="margin-top: -15px;">(แจ้งแยกตามโรงงานของผู้รับใบอนุญาต)</div>

                    @can('view-'.str_slug('inform_calibrate'))
                        <a class="btn btn-success pull-right" href="{{ url('/esurv/inform_calibrate') }}">
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

                    {!! Form::model($inform_calibrate, [
                        'method' => 'PATCH',
                        'url' => ['/esurv/inform_calibrate', $inform_calibrate->id],
                        'class' => 'form-horizontal',
                        'files' => true
                    ]) !!}

                    @include ('esurv.inform_calibrate.form')

                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
@endsection
