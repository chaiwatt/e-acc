@extends('layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <h3 class="box-title pull-left">แก้ไขลำดับรายละเอียดผลิตภัณฑ์</h3>
                    @can('view-'.str_slug('license_detail_edit'))
                        <a class="btn btn-success pull-right" href="{{ url()->previous() }}">
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

                    {!! Form::open(['url' => '/esurv/license_detail_edit', 'class' => 'form-horizontal', 'files' => true]) !!}

                    @include ('esurv.tisi_license_detail.form')

                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
@endsection
