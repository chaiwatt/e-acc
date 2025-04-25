@extends('layouts.master')

@push('css')
    <link href="{{asset('plugins/components/icheck/skins/all.css')}}" rel="stylesheet" type="text/css" />
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <h3 class="box-title pull-left">ทดสอบอีเมล</h3>

                    <div class="clearfix"></div>
                    <hr>
                    @if ($errors->any())
                        <ul class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif

                    {!! Form::model($config, [
                        'method' => 'POST',
                        'url' => ['/basic/send_mail'],
                        'class' => 'form-horizontal',
                        'files' => true
                    ]) !!}

                        <div class="form-group">
                            <label class="col-md-4 control-label m-r-10"><b>ตั้งค่าจากระบบ</b></label>
                            <div class="col-md-6"></div>
                        </div>

                        <div class="form-group required {{ $errors->has('driver') ? 'has-error' : ''}}">
                            {!! Form::label('driver', 'driver', ['class' => 'col-md-4 control-label']) !!}
                            <div class="col-md-6">
                                {!! Form::text('driver', null, ['class' => 'form-control', 'required' => 'required', 'disabled' => true]) !!}
                                {!! $errors->first('driver', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>

                        <div class="form-group required {{ $errors->has('host') ? 'has-error' : ''}}">
                            {!! Form::label('host', 'host', ['class' => 'col-md-4 control-label']) !!}
                            <div class="col-md-6">
                                {!! Form::text('host', null, ['class' => 'form-control', 'required' => 'required', 'disabled' => true]) !!}
                                {!! $errors->first('host', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>

                        <div class="form-group required {{ $errors->has('port') ? 'has-error' : ''}}">
                            {!! Form::label('port', 'port', ['class' => 'col-md-4 control-label']) !!}
                            <div class="col-md-6">
                                {!! Form::text('port', null, ['class' => 'form-control', 'required' => 'required', 'disabled' => true]) !!}
                                {!! $errors->first('port', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>

                        <div class="form-group required {{ $errors->has('username') ? 'has-error' : ''}}">
                            {!! Form::label('username', 'username', ['class' => 'col-md-4 control-label']) !!}
                            <div class="col-md-6">
                                {!! Form::text('username', null, ['class' => 'form-control', 'required' => 'required', 'disabled' => true]) !!}
                                {!! $errors->first('username', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>

                        <div class="form-group required {{ $errors->has('password') ? 'has-error' : ''}}">
                            {!! Form::label('password', 'password', ['class' => 'col-md-4 control-label']) !!}
                            <div class="col-md-6">
                                {!! Form::text('password', null, ['class' => 'form-control', 'required' => 'required', 'disabled' => true]) !!}
                                {!! $errors->first('password', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>

                        <div class="form-group required {{ $errors->has('encryption') ? 'has-error' : ''}}">
                            {!! Form::label('encryption', 'encryption', ['class' => 'col-md-4 control-label']) !!}
                            <div class="col-md-6">
                                {!! Form::text('encryption', null, ['class' => 'form-control', 'required' => 'required', 'disabled' => true]) !!}
                                {!! $errors->first('encryption', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>

                        <div class="form-group required {{ $errors->has('from_address') ? 'has-error' : ''}}">
                            {!! Form::label('from_address', 'from_address', ['class' => 'col-md-4 control-label']) !!}
                            <div class="col-md-6">
                                {!! Form::text('from_address', null, ['class' => 'form-control', 'required' => 'required']) !!}
                                {!! $errors->first('from_address', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>

                        <div class="form-group required {{ $errors->has('from_name') ? 'has-error' : ''}}">
                            {!! Form::label('from_name', 'from_name', ['class' => 'col-md-4 control-label']) !!}
                            <div class="col-md-6">
                                {!! Form::text('from_name', null, ['class' => 'form-control', 'required' => 'required']) !!}
                                {!! $errors->first('from_name', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label m-r-10"><b>ข้อมูลทดสอบ</b></label>
                            <div class="col-md-6"></div>
                        </div>

                        <div class="form-group required {{ $errors->has('send_to') ? 'has-error' : ''}}">
                            {!! Form::label('send_to', 'อีเมลผู้รับเมลตัวอย่าง', ['class' => 'col-md-4 control-label']) !!}
                            <div class="col-md-6">
                                {!! Form::text('send_to', null, ['class' => 'form-control', 'required' => 'required']) !!}
                                {!! $errors->first('send_to', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>

                        <div class="form-group required {{ $errors->has('subject') ? 'has-error' : ''}}">
                            {!! Form::label('subject', 'เรื่อง', ['class' => 'col-md-4 control-label']) !!}
                            <div class="col-md-6">
                                {!! Form::text('subject', null, ['class' => 'form-control', 'required' => 'required']) !!}
                                {!! $errors->first('subject', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>

                        <div class="form-group required {{ $errors->has('body') ? 'has-error' : ''}}">
                            {!! Form::label('body', 'เนื้อหา', ['class' => 'col-md-4 control-label']) !!}
                            <div class="col-md-6">
                                {!! Form::textarea('body', null, ['class' => 'form-control', 'required' => 'required', 'rows' => 3]) !!}
                                {!! $errors->first('body', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('attach') ? 'has-error' : ''}}">

                            {!! Form::label('attach', 'ไฟล์แนบ', ['class' => 'col-md-4 control-label']) !!}
                            <div class="col-md-6">
                                <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                    <div class="form-control" data-trigger="fileinput">
                                        <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                        <span class="fileinput-filename"></span>
                                    </div>
                                    <span class="input-group-addon btn btn-default btn-file">
                                        <span class="fileinput-new">เลือกไฟล์</span>
                                        <span class="fileinput-exists">เปลี่ยน</span>
                                        <input type="file" name="attach" id="attach">
                                    </span>
                                    <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
                                </div>
                            </div>

                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-4 col-md-4">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fa fa-paper-plane"></i> ส่ง
                                </button>
                                <a class="btn btn-default" href="{{url('/home')}}">
                                    <i class="fa fa-rotate-left"></i> ยกเลิก
                                </a>
                            </div>
                        </div>

                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{!! asset('js/jasny-bootstrap.js') !!}"></script>
    <script>

        $(document).ready(function() {

            @if(\Session::has('flash_message'))
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: '{{ session()->get('flash_message') }}',
                    showConfirmButton: true
                });
            @endif

            //เปลี่ยนะ type text เป็น password
            $('#password').prop('type', 'password');
        });

    </script>
@endpush
