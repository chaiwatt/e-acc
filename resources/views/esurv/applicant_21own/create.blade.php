@extends('layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <h3 class="box-title pull-left">เพิ่มคำขอการนำเข้าผลิตภัณฑ์เพื่อนำมาใช้เอง</h3>
                    @can('view-'.str_slug('applicant-21own'))
                        <a class="btn btn-success pull-right" href="{{url('/esurv/applicant_21own')}}">
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

                    {!! Form::open(['url' => '/esurv/applicant_21own', 'class' => 'form-horizontal', 'files' => true]) !!}

                    @include ('esurv.applicant_21own.form')

                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
@endsection
