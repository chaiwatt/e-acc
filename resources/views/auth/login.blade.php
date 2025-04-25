@extends('layouts.app')

@section('content')
@push('css')
    <style>
    /* The max width is dependant on the container (more info below) */
.popover{
    max-width: 100%; /* Max Width of the popover (depending on the container!) */
}
  .popover-content {
        width: 325px;
        padding: 9px 14px;
        font-size: 16px;
    }

    </style>
@endpush
<section id="wrapper" class="login-register">
    <div class="login-box">
        <div class="white-box">
            <form class="form-horizontal" id="loginform" method="post" action="{{ url('home') }}">
                {{csrf_field()}}
                {{-- <h3 class="box-title m-b-20">ลงชื่อเข้าใช้งาน</h3> --}}
                <div class="form-group ">
                    <div class="col-xs-12">
                        <div class="input-group" >
                        <input id="email" type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="session_id" value="{{ old('email') }}" required 
                        autofocus data-container="body" data-toggle="popover" data-trigger="hover" data-placement="right" data-content='เข้าใช้งานระบบด้วย "เลขประจำตัวผู้เสียภาษี" ยกเว้น ระบบขอใบรับรองระบบงานใช้ "e-Mail"'>
                        <span class="input-group-addon" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="right" data-content='เข้าใช้งานระบบด้วย "เลขประจำตัวผู้เสียภาษี" ยกเว้น ระบบขอใบรับรองระบบงานใช้ "e-Mail"'>
                            {{-- <i class="glyphicon glyphicon-user"></i> --}}
                       </span>
                    </div>
                        @if ($errors->first())
                            <span class="text-danger">
                                {{ $errors->first() }}
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-xs-12">
                        <div style="margin-bottom: 25px" class="input-group">
                            <input id="password" type="text" title="กรอกรหัสผ่าน" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="user_agent" required >
                            <span class="input-group-addon" id="eye_change">
                                {{-- <i class="glyphicon glyphicon-eye-open"></i> --}}
                            </span>
                        </div>
                        @if ($errors->has('password'))
                            <span class="text-danger">
                                {{ $errors->first('password') }}
                            </span>
                        @endif
                    </div>
                </div>
                {{-- <div class="form-group">
                    <div class="col-md-12">
                        <div class="checkbox checkbox-primary pull-left p-t-0">
                            <input type="checkbox" id="checkbox-signup" name="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label for="checkbox-signup"> จำการเข้าระบบ </label>
                        </div>
                            <div class="text-dark pull-right  dropdown-toggle" data-toggle="dropdown">
                                <a  href="#"  class="text-dark pull-right"><i class="fa fa-lock m-r-5"></i> ลืมรหัสผ่าน?</a>   
                            </div>
                            <div class="dropdown-menu" role="menu" >
                                    <a  class="btn btn-link " href="{{'https://nsw.tisi.go.th/TISINSW/email_reset.php'}}"  target="_blank" style="width:400px;text-align: left">
                                        1.รีเซตรหัสผ่าน เข้าใช้งานระบบ e-Surveillance
                                    </a> 
                                    <br>
                                    <a  class="btn btn-link " href="{{'https://appdb.tisi.go.th/bigdata/itisi-trader/public/password/reset'}}" target="_blank"  style="width:400px;text-align: left">
                                        2.รีเซตรหัสผ่าน เข้าใช้งานระบบ e-Accreditation
                                    </a> 
                            </div>
                    </div>
                </div> --}}
                <div class="form-group text-center m-t-20">
                    <div class="col-xs-12">
                        <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit"> ลงชื่อ
                        </button>
                    </div>
                </div>

                {{-- <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 m-t-10 text-center">
                        <div class="social">
                            <a href="{{url('auth/facebook')}}" class="btn  btn-facebook" data-toggle="tooltip" title="Login with Facebook"> <i aria-hidden="true" class="fa fa-facebook"></i> </a>
                            <a href="{{url('auth/google')}}" class="btn btn-googleplus" data-toggle="tooltip" title="Login with Google"> <i aria-hidden="true" class="fa fa-google-plus"></i> </a>
                        </div>
                    </div>
                </div> --}}

                {{-- <div class="form-group m-b-0">
                  @if(@HP::getConfig()->url_register!='')
                    <div class="col-sm-12 text-center">
                        <p>ยังไม่มีบัญชีผู้ใช้? <a href="{{ HP::getConfig()->url_register }}" class="text-primary m-l-5"><b>ลงทะเบียน</b></a></p> --}}
                        {{-- <p>ยังไม่มีบัญชีผู้ใช้? <a href="{{ route('register') }}" class="text-primary m-l-5"><b>ลงทะเบียน</b></a></p> --}}
                    {{-- </div>
                  @endif
                </div> --}}

                {{-- <div class="clearfix"></div>

                <div class="form-group m-b-0" style="padding-left:5px;">
                    <div class="col-sm-12" style="margin-bottom: -12px;">
                        <p><a href="{{ url('/') }}" class="text-primary m-l-5"><i class="fa fa-home m-r-5"></i> หน้าแรก</a></p>
                    </div>
                    <div class="col-sm-12" style="margin-bottom: -12px;">
                        <p><a href="{{ url('/downloads/คู่มือE-sur 31-10-62.pdf') }}" class="text-primary m-l-5"><i class="fa fa-book m-r-5"></i> คู่มือการใช้งาน</a></p>
                    </div>
                    <div class="col-sm-12" style="margin-bottom: -12px;">
                        <p><a href="{{ url('/downloads/หลักเกณฑ์การรับรองตนเอง.pdf') }}" class="text-primary m-l-5"><i class="fa fa-book m-r-5"></i> หลักเกณฑ์การรับรองตนเอง</a></p>
                    </div>
                    <div class="col-sm-12" style="margin-bottom: -12px;">
                        <p><a href="{{ url('/downloads/ประกาศ 25 ทวิ.pdf') }}" class="text-primary m-l-5"><i class="fa fa-book m-r-5"></i> ประกาศ 25 ทวิ</a></p>
                    </div>
                </div> --}}

            </form>
        </div>
    </div>
</section>


@endsection

@push('js')
    <script src="{{asset('plugins/components/toast-master/js/jquery.toast.js')}}"></script>

    <script>
        $(document).ready(function () {
            @if(\Session::has('success'))
            $.toast({
                heading: 'Success!',
                position: 'top-center',
                text: '{{session()->get('message')}}',
                loaderBg: '#70b7d6',
                icon: 'success',
                hideAfter: 3000,
                stack: 6
            });
            @elseif(\Session::has('error'))
            $.toast({
                heading: 'Error!',
                position: 'top-center',
                text: '{{session()->get('error')}}',
                loaderBg: '#ff6849',
                icon: 'error',
                hideAfter: 3000,
                stack: 6
            });
            @endif

            $('#eye_change').click(function(){
                if($($("#eye_change").find('i')).hasClass("glyphicon-eye-open")){
                    $("#eye_change").find('i').removeClass('glyphicon-eye-open').addClass('glyphicon-eye-close');
                    $('#password').attr('type', 'text');
                } else {
                    $("#eye_change").find('i').removeClass('glyphicon-eye-close').addClass('glyphicon-eye-open');
                    $('#password').attr('type', 'password');
                }
            });

 

        });

    </script>

@endpush
