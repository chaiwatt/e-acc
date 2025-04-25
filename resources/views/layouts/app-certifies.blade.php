<!DOCTYPE html>
<html lang="en">
 <?php
    $theme_name = 'default';
    $fix_header = false;
    $fix_sidebar = false;
    $theme_layout = 'normal';

?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    {{-- <link rel="icon" type="image/png" sizes="16x16" href="{{asset('plugins/images/favicon.png')}}">
    <title>{{env('APP_NAME')}}</title> --}}
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('images/logo01.png')}}">
    <title>
        บริการอิเล็กทรอนิกส์ สมอ.
    </title>
    <!-- ===== Bootstrap CSS ===== -->
    <link href="{{asset('bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- ===== Plugin CSS ===== -->
    <link href="{{asset('plugins/components/chartist-js/dist/chartist.min.css')}}" rel="stylesheet">
    <link href="{{asset('plugins/components/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css')}}" rel="stylesheet">
    <link href="{{asset('plugins/components/toast-master/css/jquery.toast.css')}}" rel="stylesheet">

    <!-- ===== Select2 CSS ===== -->
    <link href="{{asset('plugins/components/bootstrap-select/bootstrap-select.min.css')}}" rel="stylesheet" />
    <link href="{{asset('plugins/components/custom-select/custom-select.css')}}" rel="stylesheet" type="text/css" />
 
    <!-- ===== Custom CSS ===== -->
    <link href="{{asset('css/style-mini-sidebar.css?20190823')}}" rel="stylesheet">
 
    <link href="{{asset('css/colors/default.css')}}" id="theme" rel="stylesheet">
 
 
    <style>
     
        .login_register {
                    background: url("{{asset('plugins/images/login-register.jpg')}}") center center/cover no-repeat !important;
                    height: 100%;
                }
         
        </style>
 
    @stack('css')
</head>




<body  class="normal">

<div id="wrapper"  >
  
<!-- ===== Main-Wrapper ===== -->
@include('layouts.partials.navbar-certifies')
 
 
        
        <!-- ===== Page-Content =====  -->
        <div class="page-wrapper ">
            @yield('content')
            <footer class="footer t-a-c">
                <?php
                $yearBuddhist = date('Y') + 543;
                echo "ระบบรับรองระบบงาน(e-Accreditation) และระบบงานมาตรฐาน(e-Standard) ©$yearBuddhist ";
                ?>
            </footer>
        </div>
    
        <!-- ===== Page-Content-End ===== -->
</div>
<!-- ===== Main-Wrapper-End ===== -->
<!-- ==============================
    Required JS Files
=============================== -->
<!-- ===== jQuery ===== -->
<script src="{{asset('plugins/components/jquery/dist/jquery.min.js')}}"></script>
<!-- ===== Bootstrap JavaScript ===== -->
<script src="{{asset('bootstrap/dist/js/bootstrap.min.js')}}"></script>
<!-- ===== Slimscroll JavaScript ===== -->
<script src="{{asset('js/jquery.slimscroll.js')}}"></script>
<!-- ===== Wave Effects JavaScript ===== -->
<script src="{{asset('js/waves.js')}}"></script>
<!-- ===== Menu Plugin JavaScript ===== -->

<script src="{{asset('js/custom-mini-sidebar.js')}}"></script>
<!-- ===== Plugin JS ===== -->
<script src="{{asset('plugins/components/chartist-js/dist/chartist.min.js')}}"></script>
<script src="{{asset('plugins/components/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.min.js')}}"></script>
<script src="{{asset('plugins/components/sparkline/jquery.sparkline.min.js')}}"></script>
<script src="{{asset('plugins/components/sparkline/jquery.charts-sparkline.js')}}"></script>
<script src="{{asset('plugins/components/knob/jquery.knob.js')}}"></script>
<script src="{{asset('plugins/components/easypiechart/dist/jquery.easypiechart.min.js')}}"></script>
<!-- ===== Style Switcher JS ===== -->
<script src="{{asset('plugins/components/styleswitcher/jQuery.style.switcher.js')}}"></script>
    <!-- ===== select 2  ===== -->
<script src="{{ asset('plugins/components/custom-select/custom-select.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('plugins/components/bootstrap-select/bootstrap-select.min.js') }}" type="text/javascript"></script>

<script type="text/javascript">
    $(document).ready(function() {

        // Stuff to do as soon as the DOM is ready
        $("select:not(.not_select2)").select2();
     });
   </script>
@stack('js')
</body>

</html>
