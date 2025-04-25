@extends('layouts.master')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <h3 class="box-title pull-left">แก้ไขการแจ้งผลการนำเข้าเพื่อใช้ในราชอาณาจักรเป็นการเฉพาะคราว (21 ทวิ) #{{ $volume_21bi->id }}</h3>
                    @can('view-'.str_slug('volume_21bis'))
                        <a class="btn btn-success pull-right" href="{{ url('/esurv/volume_21bis') }}">
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

                    {!! Form::model($volume_21bi, [
                        'method' => 'PATCH',
                        'url' => ['/esurv/volume_21bis', $volume_21bi->id],
                        'class' => 'form-horizontal',
                        'files' => true
                    ]) !!}

                    @include ('esurv.volume_21bis.form')

                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
@endsection
