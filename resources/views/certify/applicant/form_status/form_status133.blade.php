@extends('layouts.master')
@push('css')
<link href="{{asset('plugins/components/icheck/skins/all.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('plugins/components/bootstrap-datepicker-thai/css/datepicker.css')}}" rel="stylesheet" type="text/css" />
@endpush
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <h3 class="box-title pull-left">ยื่นคำขอรับใบรับรองระบบงาน</h3>

                    <a class="btn btn-danger text-white pull-right" href="{{url('certify/applicant')}}">
                        <i class="icon-arrow-left-circle"></i> กลับ
                    </a>

                    <div class="clearfix"></div>
                    <hr>

                 @if(count($auditor) > 0) 
                    @foreach($auditor as $key => $itme)
                    
                    <div class="row form-group">
                        <div class="col-md-12">
                            <div class="white-box" style="border: 2px solid #e5ebec;">
                            <legend><h3>ขอความเห็นแต่งตั้งคณะผู้ตรวจประเมิน ครั้งที่ {{ $key +1}}</h3></legend>
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-md-4 text-right">
                                           <label for="#">ชื่อคณะผู้ตรวจประเมิน : </label> 
                                        </div>
                                        <div class="col-md-8">
                                            <span style="color:Black">{{ $itme->no ?? '-' }}</span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 text-right">
                                           <label for="#">วันที่ตรวจประเมิน : </label> 
                                        </div>
                                        <div class="col-md-8">
                                            <span style="color:Black"> {!! !empty($itme->DataBoardAuditorDateTitle)  ? $itme->DataBoardAuditorDateTitle : '-' !!}</span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 text-right">
                                           <label for="#">หนังสือแต่งตั้งคณะผู้ตรวจประเมิน : </label> 
                                        </div>
                                        <div class="col-md-8">
                                            <span style="color:Black">
                                                @foreach ($itme->auditors as $audit)
                                                <a href="{{ url('certify/auditor/') . '/' . $audit->auditor->file}}" target="_blank">
                                                    <i class="fa fa-file-pdf-o" style="font-size:38px; color:red"
                                                    aria-hidden="true"></i>
                                                </a>
                                                @endforeach
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @endforeach
                @endif
            </div>
        </div>
    </div>
@endsection
@push('js')
        <script src="{{ asset('plugins/components/icheck/icheck.min.js') }}"></script>
        <script src="{{ asset('plugins/components/icheck/icheck.init.js') }}"></script>
     <!-- input calendar thai -->
     <script src="{{ asset('plugins/components/bootstrap-datepicker-thai/js/bootstrap-datepicker.js') }}"></script>
     <!-- thai extension -->
     <script src="{{ asset('plugins/components/bootstrap-datepicker-thai/js/bootstrap-datepicker-thai.js') }}"></script>
     <script src="{{ asset('plugins/components/bootstrap-datepicker-thai/js/locales/bootstrap-datepicker.th.js') }}"></script>
     <script src="{{asset('js/jasny-bootstrap.js')}}"></script>
     <script type="text/javascript">
        jQuery(document).ready(function() {
                    $('.check-readonly').prop('disabled', true);//checkbox ความคิดเห็น
                    $('.check-readonly').parent().removeClass('disabled');
                    $('.check-readonly').parent().css('margin-top', '8px');//checkbox ความคิดเห็น

            //เพิ่มไฟล์แนบ
            $(".attach-add").unbind();
            $('.attach-add').click(function(event) {
                var box = $(this).next();
                console.log(box);
                
                box.find('.other_attach_item:first').clone().appendTo('#attach-box');

                box.find('.other_attach_item:last').find('input').val('');
                box.find('.other_attach_item:last').find('a.fileinput-exists').click();
                box.find('.other_attach_item:last').find('a.view-attach').remove();

                ShowHideRemoveBtn94(box);

            });

            //ลบไฟล์แนบ
            $('body').on('click', '.attach-remove', function(event) {
                var box = $(this).parent().parent().parent().parent();
                $(this).parent().parent().remove();
                ShowHideRemoveBtn94(box);
             
            });

            $('.attach-add').each(function(index,eve){
                var box = $(eve).next();
                ShowHideRemoveBtn94(box);
            });
           
            $("input[name=check_status]").on("ifChanged",function(){
                 status_checkStatus();
            });
           status_checkStatus();

         });


         function status_checkStatus(){
                 var row = $("input[name=check_status]:checked").val();
                 $('#notAccept').hide();
            if(row == "2"){
                $('#notAccept').fadeIn();
              }else{
                $('#notAccept').hide();
              }
          }
  
          function ShowHideRemoveBtn94(box) { //ซ่อน-แสดงปุ่มลบ
            if (box.find('.other_attach_item').length > 1) {
                box.find('.attach-remove').show();
            } else {
                box.find('.attach-remove').hide();
            }
        }
        </script>
  @endpush