@extends('layouts.master')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <h3 class="box-title pull-left">แก้ไข คำขอการทำผลิตภัณฑ์เพื่อส่งออก (20 ตรี) #{{ $applicant_20ter->id }}</h3>
                    @can('view-'.str_slug('applicant-20ter'))
                        <a class="btn btn-success pull-right" href="{{ url('/esurv/applicant_20ter') }}">
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

                    {!! Form::model($applicant_20ter, [
                        'method' => 'PATCH',
                        'url' => ['/esurv/applicant_20ter', $applicant_20ter->id],
                        'class' => 'form-horizontal',
                        'files' => true
                    ]) !!}

                    @include ('esurv.applicant_20ter.form')

                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
@endsection
