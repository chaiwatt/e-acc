<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('plugins/images/favicon.png')}}">
    <title>{{env('APP_NAME')}}</title>
    <!-- ===== Bootstrap CSS ===== -->
    <link href="{{asset('bootstrap/dist/css/bootstrap.min.css?v=').str_random()}}" rel="stylesheet">
  
    <link href="{{asset('css/style-normal.css')}}" rel="stylesheet">
    <link href="{{asset('plugins/components/toast-master/css/jquery.toast.css')}}" rel="stylesheet">
    <style>
       .login-register {
        background: url("{{asset('plugins/images/login-register.jpg')}}") center center/cover no-repeat !important;
        height: 100%;
        /* position: static; */
    }
   </style>
</head>
<body class="normal ">
 
<section id="wrapper" class="login-register">
<div class="row form-group" style="padding-top:50px;">
   <div class="col-md-1"></div>
   <div class="col-md-10">
      <div class="white-box" style="border: 2px solid #e5ebec;">
         <legend><b>เสนอความเห็นการกำหนดมาตรฐานการตรวจสอบและรับรอง</b></legend>
         <div class="row">
            <div class="col-md-12 text-center">
                     <p style="font-size: 50px"><b>ขอขอบคุณ</b></p>
                     <p style="font-size: 25px"><b>สำหรับการเสนอความเห็นการกำหนดมาตรฐานการตรวจสอบและรับรอง</b></p>
                     @if (\Session::has('message'))
                     <a href="{{session()->get('message')}}" class="btn  btn-primary">หน้าหลัก</a>
                  @else
                        <a href="{{ url('home') }}" class="btn  btn-primary">หน้าหลัก</a>
                     @endif
                  
            </div>
         </div>
      </div>
   </div>
</div>

</section>

   {!! Form::close() !!}
   
     <!-- ===== jQuery ===== -->
     <script src="{{asset('plugins/components/jquery/dist/jquery.min.js')}}"></script>
     <script src="{{asset('plugins/components/jqueryui/jquery-ui.min.js')}}"></script>
 
     <!-- ===== Bootstrap JavaScript ===== -->
     <script src="{{asset('bootstrap/dist/js/bootstrap.min.js')}}"></script>


     <script src="{{asset('plugins/components/toast-master/js/jquery.toast.js')}}"></script>
    <script type="text/javascript">
       $(document).ready(function() {
            @if(\Session::has('message'))
                     $.toast({
                            heading: 'Success!',
                            position: 'top-center',
                            text: 'เรียบร้อยแล้ว!',
                            loaderBg: '#70b7d6',
                            icon: 'success',
                            hideAfter: 3000,
                            stack: 6
                     });
            @else
               // window.location.assign("{{url('/tisi/standard-offers/create')}}");
            @endif
 
       });

 
   </script>
</body>

</html>