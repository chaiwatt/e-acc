@extends('layouts.app')

@section('content')

    <section id="wrapper" class="login-register">
        <div class="login-box">
            <div class="white-box">
                <form class="form-horizontal form-material" method="post" action="{{ route('password.request') }}">
                    {{csrf_field()}}
                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="form-group ">
                        <div class="col-xs-12">
                            <h3>{{ __('Reset Password') }}</h3>
                        </div>
                    </div>

                    <div class="form-group ">

                        <div class="col-xs-12">
                            <input placeholder="อีเมล" id="email" type="email"
                                   class="form-control{{ $errors->has('agent_email') ? ' is-invalid' : '' }}" name="agent_email"
                                   value="{{ old('agent_email') }}" required autofocus>

                            @if ($errors->has('agent_email'))
                                <span class="text-danger">
                                        {{ $errors->first('agent_email') }}
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input id="password" placeholder="รหัสผ่าน" type="password"
                                   class="form-control{{ $errors->has('trader_password') ? ' is-invalid' : '' }}"
                                   name="trader_password" required>

                            @if ($errors->has('trader_password'))
                                <span class="text-danger">
                                        {{ $errors->first('trader_password') }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-xs-12">
                            <input placeholder="ยืนยันรหัสผ่าน" id="password-confirm" type="password" class="form-control"
                                   name="trader_password_confirmation" required>
                        </div>
                    </div>
                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light"
                                    type="submit">รีเซต
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
