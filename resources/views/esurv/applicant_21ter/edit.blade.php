@extends('layouts.master')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <h3 class="box-title pull-left">แก้ไข คำขอการนำเข้าผลิตภัณฑ์เพื่อส่งออก (21 ตรี) #{{ $applicant_21ter->id }}</h3>
                    @can('view-'.str_slug('applicant-21ter'))
                        <a class="btn btn-success pull-right" href="{{ url('/esurv/applicant_21ter') }}">
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

                    {!! Form::model($applicant_21ter, [
                        'method' => 'PATCH',
                        'url' => ['/esurv/applicant_21ter', $applicant_21ter->id],
                        'class' => 'form-horizontal',
                        'files' => true
                    ]) !!}

                    @include ('esurv.applicant_21ter.form')

                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
@endsection
