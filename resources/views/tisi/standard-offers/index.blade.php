@extends('layouts.master')

@push('css')
    <link href="{{asset('plugins/components/icheck/skins/all.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('plugins/components/bootstrap-datepicker-thai/css/datepicker.css')}}" rel="stylesheet" type="text/css" />

    <style type="text/css">
        .img{
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 5px;
        }

        .label-filter{
            margin-top: 7px;
        }
        /*
          Max width before this PARTICULAR table gets nasty. This query will take effect for any screen smaller than 760px and also iPads specifically.
          */
        @media
        only screen
        and (max-width: 760px), (min-device-width: 768px)
        and (max-device-width: 1024px)  {

            /* Force table to not be like tables anymore */
            table, thead, tbody, th, td, tr {
                display: block;
            }

            /* Hide table headers (but not display: none;, for accessibility) */
            thead tr {
                position: absolute;
                top: -9999px;
                left: -9999px;
            }

            tr {
                margin: 0 0 1rem 0;
            }

            tr:nth-child(odd) {
                background: #eee;
            }

            td {
                /* Behave  like a "row" */
                border: none;
                border-bottom: 1px solid #eee;
                position: relative;
                padding-left: 50%;
            }

            td:before {
                /* Now like a table header */
                /*position: absolute;*/
                /* Top/left values mimic padding */
                top: 0;
                left: 6px;
                width: 45%;
                padding-right: 10px;
                white-space: nowrap;
            }

            /*
            Label the data
        You could also use a data-* attribute and content for this. That way "bloats" the HTML, this way means you need to keep HTML and CSS in sync. Lea Verou has a clever way to handle with text-shadow.
            */
            td:nth-of-type(1):before { content: "No.:"; }
            td:nth-of-type(2):before { content: "เลือก:"; }
            td:nth-of-type(3):before { content: "ชื่อ-สกุล:"; }
            td:nth-of-type(4):before { content: "เลขประจำตัวประชาชน:"; }
            td:nth-of-type(5):before { content: "หน่วยงาน:"; }
            td:nth-of-type(6):before { content: "สาขา:"; }
            td:nth-of-type(7):before { content: "ประเภทของคณะกรรมการ:"; }
            td:nth-of-type(8):before { content: "ผู้สร้าง:"; }
            td:nth-of-type(9):before { content: "วันที่สร้าง:"; }
            td:nth-of-type(10):before { content: "สถานะ:"; }
            td:nth-of-type(11):before { content: "จัดการ:"; }

        }
    </style>

@endpush

@section('content')
    <div class="container-fluid">
        <!-- .row -->
        <div class="row">
            <div class="col-sm-12">
                <div class="white-box">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                    <h3 class="box-title pull-left">ยื่นเสนอความเห็นการกำหนดมาตรฐานการตรวจสอบและรับรอง</h3>

                    <div class="pull-right">

                        @if( HP::CheckPermission('add-'.str_slug('applicantcbs')))
                            <a class="btn btn-success btn-sm waves-effect waves-light" href="{{url('tisi/standard-offers/create')}}">
                                <span class="btn-label"><i class="fa fa-plus"></i></span><b>เสนอความเห็น</b>
                            </a>
                        @endif


                    </div>

                    <div class="clearfix"></div>
                    <hr>


                    <div class="clearfix"></div>

                    <div class="table-responsive m-t-15">

                        <form id="myForm" class="hide" action="#" method="post">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                        </form>

     

                        <table class="table table-borderless" id="myTable">
                            <thead>
                                <tr>
                                    <th class="text-center" width="2%">#</th>
                                    <th class="text-left" width="10%">ชื่อเรื่อง</th>
                                    <th class="text-left" width="10%">วันที่รับคำขอ</th>
                                    <th class="text-left" width="10%">สถานะ</th>
                                    <th class="text-right"width="10%">จัดการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($offers as $offer)

                                <tr>
                                    <td class="text-center">
                                        {{ $loop->iteration + ( ((request()->query('page') ?? 1) - 1) * $offers->perPage() ) }}
                                    </td>
                                    

                                    <td> 
                                           {{ $offer->title }} {{ $offer->title_eng }}
                                    </td>

                                    <td> 

                                     {{ HP::DateThai($offer->created_at) }}
                                 </td>
                                    <td> 
                                         ID:{{$offer->state}} {{ HP::StateEstandardOffers()[$offer->state] ?? 'ไม่พบข้อมูล' }}
                                 </td>
                                   
{{-- 
                                <td class="text-nowrap text-right">
                                    @if(HP::CheckPermission('edit-'.str_slug('applicantcbs')))
                                        <a href="{{ route('tisi.standard-offers.edit', $offer->id) }}" class="btn btn-warning btn-xs"> <i class="fa fa-edit"></i>  </a>
                                    @endif
                                </td> --}}
                                <td class="text-nowrap text-right">
                                    
                                    @if(HP::CheckPermission('view-'.str_slug('applicantcbs')))
                                        <a href="{{ route('tisi.standard-offers.view', $offer->id) }}" class="btn btn-info btn-xs">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    @endif
                                   
                                    @if ($offer->id == 1)
                                         @if(HP::CheckPermission('edit-'.str_slug('applicantcbs')))
                                            <a href="{{ route('tisi.standard-offers.edit', $offer->id) }}" class="btn btn-warning btn-xs">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        @endif
                                    @endif
                                </td>
                                </tr>
                               
                            @endforeach
 
                            </tbody>
                        </table>

                        <div class="pull-right">
                            
                        </div>

                        {{-- @include ('certify.applicant.modal.modalstatus7') --}}

                        <div class="pagination-wrapper">
 
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>             
@endsection


@push('js')
    <script src="{{asset('plugins/components/toast-master/js/jquery.toast.js')}}"></script>
  <!-- input calendar thai -->
  <script src="{{ asset('plugins/components/bootstrap-datepicker-thai/js/bootstrap-datepicker.js') }}"></script>
  <!-- thai extension -->
  <script src="{{ asset('plugins/components/bootstrap-datepicker-thai/js/bootstrap-datepicker-thai.js') }}"></script>
  <script src="{{ asset('plugins/components/bootstrap-datepicker-thai/js/locales/bootstrap-datepicker.th.js') }}"></script>

    <script>
            $(document).ready(function () {
            $( "#filter_clear" ).click(function() {
                $('#filter_status').val('').select2();
                $('#filter_search').val('');

                $('#filter_state').val('').select2();
                $('#filter_start_date').val('');
                $('#filter_end_date').val('');
                $('#filter_branch').val('').select2();
                window.location.assign("{{url('/certify/applicant')}}");
            });

            if( checkNone($('#filter_state').val()) ||  checkNone($('#filter_start_date').val()) || checkNone($('#filter_end_date').val()) || checkNone($('#filter_branch').val())   ){
                // alert('มีค่า');
                $("#search_btn_all").click();
                $("#search_btn_all").removeClass('btn-primary').addClass('btn-success');
                $("#search_btn_all > span").removeClass('glyphicon-menu-up').addClass('glyphicon-menu-down');
            }

            $("#search_btn_all").click(function(){
                $("#search_btn_all").toggleClass('btn-primary btn-success', 'btn-success btn-primary');
                $("#search_btn_all > span").toggleClass('glyphicon-menu-up glyphicon-menu-down', 'glyphicon-menu-down glyphicon-menu-up');
            });
            function checkNone(value) {
            return value !== '' && value !== null && value !== undefined;
             }
 
            @if(\Session::has('message'))
                $.toast({
                    heading: 'Success!',
                    position: 'top-center',
                    text: '{{session()->get('message')}}',
                    loaderBg: '#70b7d6',
                    icon: 'success',
                    hideAfter: 3000,
                    stack: 6
                });
            @endif

            @if(\Session::has('message_error'))
                $.toast({
                    heading: 'Error!',
                    position: 'top-center',
                    text: '{{session()->get('message_error')}}',
                    loaderBg: '#ff6849',
                    icon: 'error',
                    hideAfter: 3000,
                    stack: 6
                });
            @endif

            //ปฎิทิน
            jQuery('#date-range').datepicker({
              toggleActive: true,
              language:'th-th',
              format: 'dd/mm/yyyy'
            });


            //เลือกทั้งหมด
            $('#checkall').change(function(event) {

                if($(this).prop('checked')){//เลือกทั้งหมด
                    $('#myTable').find('input.cb').prop('checked', true);
                }else{
                    $('#myTable').find('input.cb').prop('checked', false);
                }

            });


    });

        function Delete(){

            if($('#myTable').find('input.cb:checked').length > 0){//ถ้าเลือกแล้ว
                if(confirm_delete()){
                    $('#myTable').find('input.cb:checked').appendTo("#myForm");
                    $('#myForm').submit();
                }
            }else{//ยังไม่ได้เลือก
                alert("กรุณาเลือกข้อมูลที่ต้องการลบ");
            }

        }

        function confirm_delete() {
            return confirm("ยืนยันการลบข้อมูล?");
        }

        function UpdateState(state){

            if($('#myTable').find('input.cb:checked').length > 0){//ถ้าเลือกแล้ว
                $('#myTable').find('input.cb:checked').appendTo("#myFormState");
                $('#state').val(state);
                $('#myFormState').submit();
            }else{//ยังไม่ได้เลือก
                if(state=='1'){
                    alert("กรุณาเลือกข้อมูลที่ต้องการเปิด");
                }else{
                    alert("กรุณาเลือกข้อมูลที่ต้องการปิด");
                }
            }

        }

    </script>


    <script>
        $('#filter_state').on('change',function () {

            const select = $(this).text();
            const _token = $('input[name="_token"]').val();
            $('#filter_branch').empty();
            $('#filter_branch').append('<option value="-1" >- เลือกสาขา -</option>').select2();
            if ($(this).val() === '3') {
                $.ajax({
                    url:"{{route('api.test')}}",
                    method:"POST",
                    data:{select:select,_token: _token},
                    success:function (result){
                        $.each(result,function (index,value) {
                            $('#filter_branch').append('<option value='+value.id+' >'+value.title+'</option>');
                        });
                    }
                });
            }
            else if ($(this).val() === '4') {
                $.ajax({
                    url:"{{route('api.calibrate')}}",
                    method:"POST",
                    data:{select:select,_token: _token},
                    success:function (result){
                        $.each(result,function (index,value) {
                            $('#filter_branch').append('<option value='+value.id+' >'+value.title+'</option>');
                        })
                    }
                });
            }
        });
    </script>

@endpush
