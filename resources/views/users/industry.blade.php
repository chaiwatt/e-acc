<link href="{{asset('css/style-normal.css')}}" rel="stylesheet">
</head>

<body>

  <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel">ประกาศ</h4>
        </div>
        <div class="modal-body">
          <h4>ข้อความจากระบบ</h4>
          <p>ก่อนเข้าใช้งานระบบของสำนักงานมาตรฐานผลิตภัณฑ์อุตสาหกรรม(สมอ.) กรุณาลงทะเบียนในระบบ i-industry ก่อน</p>
        </div>
        <div class="modal-footer">
          <a href="{{ url('logout') }}" type="button" class="btn btn-danger waves-effect">
            <i class="icon-logout"></i> ออกจากระบบ
          </a>
          <a href="http://www.industry.go.th/ict/index.php/iindustry" type="button" class="btn btn-info waves-effect">
            <i class="icon-direction"></i> ไปหน้าลงทะเบียน i-industry
          </a>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>

  <!-- ===== jQuery ===== -->
  <script src="{{asset('plugins/components/jquery/dist/jquery.min.js')}}"></script>
  <!-- ===== Bootstrap JavaScript ===== -->
  <script src="{{asset('bootstrap/dist/js/bootstrap.min.js')}}"></script>

  <script type="text/javascript">

    $(window).on('load',function(){
       $('#myModal').modal('show');
    });

  </script>

</body>

</html>
@php
exit;
@endphp
