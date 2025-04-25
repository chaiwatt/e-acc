@extends('layouts.master')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <h3 class="box-title pull-left">แจ้งข้อมูลใบอนุญาต #{{ $license->id }}</h3>
                    @can('view-'.str_slug('other'))
                        <a class="btn btn-success pull-right" href="{{ url('/esurv/tisi_license_notification') }}">
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

                    {!! Form::model($license, [
                        'method' => 'PATCH',
                        'url' => ['/esurv/tisi_license_notification', $license->id],
                        'class' => 'form-horizontal',
                        'files' => true
                    ]) !!}

                       @include ('esurv.tisi-license-notification.form')

                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
@endsection