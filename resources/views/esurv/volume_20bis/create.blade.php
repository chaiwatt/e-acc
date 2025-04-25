@extends('layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <h3 class="box-title pull-left">เพิ่มการแจ้งปริมาณการทำผลิตภัณฑ์เพื่อใช้ในประเทศเป็นการเฉพาะคราว (20 ทวิ)</h3>
                    @can('view-'.str_slug('volume_20bis'))
                        <a class="btn btn-success pull-right" href="{{url('/esurv/volume_20bis')}}">
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

                    {!! Form::open(['url' => '/esurv/volume_20bis', 'class' => 'form-horizontal', 'files' => true]) !!}

                    @include ('esurv.volume_20bis.form')

                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
@endsection
