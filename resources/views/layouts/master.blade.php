<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="base-url" content="{{ url('/') }}">
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
    <link href="{{asset('bootstrap/dist/css/bootstrap.min.css?v=').str_random()}}" rel="stylesheet">
    <!-- ===== Plugin CSS ===== -->
    <link href="{{asset('plugins/components/chartist-js/dist/chartist.min.css')}}" rel="stylesheet">
    <link href="{{asset('plugins/components/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css')}}" rel="stylesheet">
    <link href="{{asset('plugins/components/toast-master/css/jquery.toast.css')}}" rel="stylesheet">

    <!-- ===== Select2 CSS ===== -->
    <link href="{{asset('plugins/components/bootstrap-select/bootstrap-select.min.css')}}" rel="stylesheet" />
    <link href="{{asset('plugins/components/custom-select/custom-select.css')}}" rel="stylesheet" type="text/css" />

    <!-- ===== Animation CSS ===== -->
    <link href="{{asset('css/animate.css')}}" rel="stylesheet">
    <!-- ===== Custom CSS ===== -->
    <link href="{{asset('css/common.css')}}" rel="stylesheet">

    <!-- ===== jQuery UI ===== -->
    <link href="{{asset('plugins/components/jqueryui/jquery-ui.min.css')}}" rel="stylesheet" />

    <!-- ===== Parsley js ===== -->
    <link href="{{asset('plugins/components/parsleyjs/parsley.css?20200630')}}" rel="stylesheet" />

    <!--====== Dynamic theme changing =====-->



    <?php
    $theme_name = 'default';
    $fix_header = false;
    $fix_sidebar = false;
    $theme_layout = 'normal';

    if (auth()->user()) {

        $user = auth()->user();

        $params = (object)json_decode($user->params);

        if (!empty($params->theme_name)) {
            if (is_file('css/colors/' . $params->theme_name . '.css')) {
                $theme_name = $params->theme_name;
            }
        }

        if (!empty($params->fix_header) && $params->fix_header == "true") {
            $fix_header = true;
        }

        if (!empty($params->fix_sidebar) && $params->fix_sidebar == "true") {
            $fix_sidebar = true;
        }

        if (!empty($params->theme_layout)) {
            $theme_layout = $params->theme_layout;;
        }

        //i industry service
        if ($user->reg_industry === '0' && @HP::getConfig()->active_check_iindustry == '1') { //สถานะยังไม่ได้ลงทะเบียน และตั้งค่า url เช็คเอาไว้
            $response = HP_WS::getiJuristicID($user->trader_id); //เช็คใหม่อีกรอบว่าลงแล้วหรือยัง
            if ($response->IsExist === 'True') { //ถ้าลงแล้ว
                HP_WS::update_reg_industry($user->trader_autonumber);
            } else if ($response->IsExist === 'False') { //ถ้ายังไม่ลง
    ?>
                @include('users.industry')
    <?php
            }
        }
    }

    ?>

    @if($theme_layout == 'fix-header')
    <link href="{{asset('css/style-fix-header.css')}}" rel="stylesheet">
    <link href="{{asset('css/colors/'.$theme_name.'.css')}}" id="theme" rel="stylesheet">

    @elseif($theme_layout == 'mini-sidebar')
    <link href="{{asset('css/style-mini-sidebar.css')}}" rel="stylesheet">
    <link href="{{asset('css/colors/'.$theme_name.'.css')}}" id="theme" rel="stylesheet">
    @else
    <link href="{{asset('css/style-normal.css')}}" rel="stylesheet">
    <link href="{{asset('css/colors/'.$theme_name.'.css')}}" id="theme" rel="stylesheet">
    @endif

    @stack('css')

    <link href="{{ asset('plugins/components/bootstrap-iconpicker/bootstrap-iconpicker.min.css') }}" rel="stylesheet">

    <!-- ===== Color CSS ===== -->
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        div.required label.control-label:after {
            content: " *";
            color: red;
        }

        label.required:after {
            color: red;
            content: " *";
        }

        .ui-front {
            z-index: 1000 !important;
        }

        @media (min-width: 768px) {
            .extra.collapse li a span.hide-menu {
                display: block !important;
            }

            .extra.collapse.in li a.waves-effect span.hide-menu {
                display: block !important;
            }

            .extra.collapse li.active a.active span.hide-menu {
                display: block !important;
            }

            ul.side-menu li:hover+.extra.collapse.in li.active a.active span.hide-menu {
                display: block !important;
            }
        }

        legend {
            width:inherit; /* Or auto */
            padding:0 10px; /* To give a bit of padding on the left and right */
            border-bottom:none;
        }

        fieldset {
            border: 1px groove #ddd !important;
            padding: 0 1.4em 1.4em 1.4em !important;
            margin: 0 0 1.5em 0 !important;
            -webkit-box-shadow:  0px 0px 0px 0px #000;
                    box-shadow:  0px 0px 0px 0px #000;
        }
    </style>
</head>

<body class="
  {{ $theme_layout }}
  @if($fix_header===true) fix-header @endif
  @if($fix_sidebar===true) fix-sidebar @endif">
    <!-- ===== Main-Wrapper ===== -->
    <div id="wrapper">
        <div class="preloader">
            <div class="cssload-speeding-wheel"></div>
        </div>
        <!-- ===== Top-Navigation ===== -->
        @include('layouts.partials.navbar')
        <!-- ===== Top-Navigation-End ===== -->

        <!-- ===== Left-Sidebar ===== -->
        @include('layouts.partials.sidebar')
        @include('layouts.partials.right-sidebar')

        <!-- ===== Left-Sidebar-End ===== -->
        <!-- ===== Page-Content ===== -->
        <div class="page-wrapper">
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

    <!-- ============================== Required JS Files =============================== -->
    <!-- ===== jQuery ===== -->
    <script src="{{asset('plugins/components/jquery/dist/jquery.min.js')}}"></script>
    <script src="{{asset('plugins/components/jqueryui/jquery-ui.min.js')}}"></script>

    <!-- ===== Bootstrap JavaScript ===== -->
    <script src="{{asset('bootstrap/dist/js/bootstrap.min.js')}}"></script>

    <!-- ===== Slimscroll JavaScript ===== -->
    <script src="{{asset('js/jquery.slimscroll.js')}}"></script>

    <!-- ===== Wave Effects JavaScript ===== -->
    <script src="{{asset('js/waves.js')}}"></script>

    <!-- ===== Menu Plugin JavaScript ===== -->
    <script src="{{asset('js/sidebarmenu.js')}}"></script>

    <!-- ===== Custom JavaScript ===== -->
    @if($theme_layout == 'fix-header')
    <script src="{{asset('js/custom-fix-header.js')}}"></script>
    @elseif($theme_layout == 'mini-sidebar')
    <script src="{{asset('js/custom-mini-sidebar.js')}}"></script>
    @else
    <script src="{{asset('js/custom-normal.js')}}"></script>
    @endif

    <!-- ===== Custom JS ===== -->
    <script src="{{asset('js/function.js')}}"></script>

    <!-- ===== PARSLEY JS Validation ===== -->
    <script src="{{asset('plugins/components/parsleyjs/parsley.min.js')}}"></script>
    <script src="{{asset('plugins/components/parsleyjs/language/th.js')}}"></script>

    <!-- ===== Plugin JS ===== -->
    <script src="{{asset('plugins/components/chartist-js/dist/chartist.min.js')}}"></script>
    <script src="{{asset('plugins/components/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.min.js')}}"></script>
    <script src="{{asset('plugins/components/sparkline/jquery.sparkline.min.js')}}"></script>
    <script src="{{asset('plugins/components/sparkline/jquery.charts-sparkline.js')}}"></script>
    <script src="{{asset('plugins/components/knob/jquery.knob.js')}}"></script>
    <script src="{{asset('plugins/components/easypiechart/dist/jquery.easypiechart.min.js')}}"></script>

    <!-- ===== Style Switcher JS ===== -->
    <script src="{{asset('plugins/components/styleswitcher/jQuery.style.switcher.js')}}"></script>

    <!-- ===== ICON JS ===== -->
    <script src="{{asset('plugins/components/bootstrap-iconpicker/bootstrap-iconpicker-iconset-all.min.js')}}"></script>
    <script src="{{asset('plugins/components/bootstrap-iconpicker/bootstrap-iconpicker.min.js')}}"></script>

    <!-- ===== select 2  ===== -->
    <script src="{{ asset('plugins/components/custom-select/custom-select.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('plugins/components/bootstrap-select/bootstrap-select.min.js') }}" type="text/javascript"></script>
    <!-- ====== Loading ====== -->
    <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>
    <script src="{{asset('plugins/components/sweet-alert2/sweetalert2.all.min.js')}}"></script>


    <script>
        var baseUrl = $('meta[name="base-url"]').attr('content') + '/';
    
        $.ajaxSetup({
            beforeSend: function(xhr, settings) {
                // ป้องกัน baseUrl ซ้ำซ้อน
                if (!settings.url.startsWith('http') && !settings.url.startsWith(baseUrl)) {
                    settings.url = baseUrl + settings.url;
                }
            }
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {

            // Stuff to do as soon as the DOM is ready
            $("select:not(.not_select2)").select2();

            //Validate
            if ($('form').length > 0 && $('form:first:not(.not_validated)').length > 0) {
                $('form:first:not(.not_validated)').parsley({
                    excluded: "input[type=button], input[type=submit], input[type=reset], [disabled], input[type=hidden]"
                }).on('field:validated', function() {
                    var ok = $('.parsley-error').length === 0;
                    $('.bs-callout-info').toggleClass('hidden', !ok);
                    $('.bs-callout-warning').toggleClass('hidden', ok);
                }).on('form:submit', function() {

                    $('form').find('button, input[type=button], input[type=submit], input[type=reset]').prop('disabled', true);
                    $('form').find('a').removeAttr('href');

                    return true;

                });
            }

            check_max_size_file();

        });

        function check_max_size_file() {
            var max_size = "{{ ini_get('upload_max_filesize') }}";
            var res = max_size.replace("M", "");
            $('.check_max_size_file').bind('change', function() {
                if ($(this).val() != '') {
                    var size = (this.files[0].size) / 1024 / 1024; // หน่วย MB
                    console.log(this.files[0]);
                    if (size > res) {
                        Swal.fire(
                            'ขนาดไฟล์เกินกว่า ' + res + ' MB',
                            '',
                            'info'
                        )
                        //  this.value = '';
                        $(this).parent().parent().find('.fileinput-exists').click();
                        return false;
                    }
                }
            });
        }

        //ตัดเอาเฉพาะภาษาไทยไว้
        function filterThaiOnly(obj){
            var orgi_text     = "ๅภถุึคตจขชๆไำพะัีรนยบลฃฟหกดเ้่าสวงผปแอิืทมใฝ๑๒๓๔ู฿๕๖๗๘๙๐ฎฑธํ๊ณฯญฐฅฤฆฏโฌ็๋ษศซฉฮฺ์ฒฬฦ ";
            var str           = $(obj).val();
                str           = ltrim(str);
            var str_length    = str.length;
            var Result = "";
            for(i=0;i<str_length;i++){
                var Char_At = str.charAt(i);
                if(orgi_text.indexOf(Char_At)!==-1){//อักษรเป็นภาษาไทย
                    Result += Char_At;
                }
            }
            $(obj).val(Result);
        }

        function filterEngOnly(obj){
            var orgi_text     = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-";
            var str           = $(obj).val();
            var str_length    = str.length;
            var Result = "";
            for(i=0;i<str_length;i++){
                var Char_At = str.charAt(i);
                if(orgi_text.indexOf(Char_At)!==-1){//อักษรเป็นภาษาไทย
                    Result += Char_At;
                }
            }
            $(obj).val(Result);
        }

        function filterEngAndNumberOnly(obj){
            var orgi_text     = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ\/,':;_-0123456789 ";
            var str           = $(obj).val();
            var str_length    = str.length;
            var Result = "";
            for(i=0;i<str_length;i++){
                var Char_At = str.charAt(i);
                if(orgi_text.indexOf(Char_At)!==-1){//อักษรเป็นภาษาไทย
                    Result += Char_At;
                }
            }
            $(obj).val(Result);
        }
    </script>

    @stack('js')

</body>

</html>