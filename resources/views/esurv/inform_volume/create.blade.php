@extends('layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <h3 class="box-title pull-left">เพิ่มการแจ้งปริมาณการผลิตตามเงื่อนไขใบอนุญาต</h3>
                    @can('view-'.str_slug('inform_volume'))
                        <a class="btn btn-success pull-right" href="{{url('/esurv/inform_volume')}}">
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

                    {!! Form::open(['url' => '/esurv/inform_volume', 'class' => 'form-horizontal', 'files' => true,'id'=>'form_inform_volume']) !!}

                    @include ('esurv.inform_volume.form')

                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
@endsection
