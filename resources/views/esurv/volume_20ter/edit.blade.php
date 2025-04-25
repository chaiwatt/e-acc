@extends('layouts.master')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <h3 class="box-title pull-left">แก้ไขการแจ้งปริมาณการทำเพื่อส่งออก (20 ตรี) #{{ $volume_20ter->id }}</h3>
                    @can('view-'.str_slug('volume_20ter'))
                        <a class="btn btn-success pull-right" href="{{ url('/esurv/volume_20ter') }}">
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

                    {!! Form::model($volume_20ter, [
                        'method' => 'PATCH',
                        'url' => ['/esurv/volume_20ter', $volume_20ter->id],
                        'class' => 'form-horizontal',
                        'files' => true
                    ]) !!}

                    @include ('esurv.volume_20ter.form')

                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
@endsection
