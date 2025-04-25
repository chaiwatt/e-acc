@extends('layouts.master')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <h3 class="box-title pull-left">ข้อมูลผู้ตรวจประเมิน   </h3>
                    @can('view-'.str_slug('acc-auditors'))
                        <a class="btn btn-success pull-right" href="{{ url('/home') }}">
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
 
                    {!! Form::open(['url' => 'gta-auditors/store', 'method' => 'POST', 'class' => 'form-horizontal', 'files' => true,'id'=>'commentForm']) !!}
                        @include ('auditors.form')
                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
@endsection
