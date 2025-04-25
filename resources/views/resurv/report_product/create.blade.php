@extends('layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <h3 class="box-title pull-left">เพิ่มreport_product</h3>
                    @can('view-'.str_slug('report_product'))
                        <a class="btn btn-success pull-right" href="{{url('/report_product/report_product')}}">
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

                    {!! Form::open(['url' => '/report_product/report_product', 'class' => 'form-horizontal', 'files' => true]) !!}

                    @include ('resurv.report_product.form')

                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
@endsection
