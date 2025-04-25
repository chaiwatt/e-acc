@extends('layouts.master')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <h3 class="box-title pull-left">แก้ไขคำขอการนำเข้าผลิตภัณฑ์เพื่อใช้ในประเทศ #{{ $applicant21bi->id }}</h3>
                    @can('view-'.str_slug('applicant-21bis'))
                        <a class="btn btn-success pull-right" href="{{ url('/esurv/applicant_21bis') }}">
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

                    {!! Form::model($applicant21bi, [
                        'method' => 'PATCH',
                        'url' => ['/esurv/applicant_21bis', $applicant21bi->id],
                        'class' => 'form-horizontal',
                        'files' => true
                    ]) !!}

                    @include ('esurv.applicant_21bis.form')

                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
@endsection
