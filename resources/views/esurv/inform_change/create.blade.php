@extends('layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <h3 class="box-title pull-left">เพิ่มการเปลี่ยนแปลงที่มีผลกระทบต่อคุณภาพ</h3>
                    @can('view-'.str_slug('inform_change'))
                        <a class="btn btn-success pull-right" href="{{url('/esurv/inform_change')}}">
                            <i class="icon-arrow-left-circle"></i> กลับ
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

                    {!! Form::open(['url' => '/esurv/inform_change', 'class' => 'form-horizontal', 'files' => true]) !!}

                    @include ('esurv.inform_change.form')

                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
@endsection
