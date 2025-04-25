{{-- work on Certify\ApplicantController --}}
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
                    <h3 class="box-title pull-left">ยื่นคำขอรับใบรับรองระบบงาน</h3>

                    <div class="pull-right">

                        @if( HP::CheckPermission('add-'.str_slug('applicantcbs')))
                            <a class="btn btn-success btn-sm waves-effect waves-light" href="{{url('certify/applicant/create')}}">
                                <span class="btn-label"><i class="fa fa-plus"></i></span><b>ยื่นคำขอ</b>
                            </a>
                        @endif

{{--                        @can('delete-'.str_slug('committee'))--}}
                            {{-- <a class="btn btn-danger btn-sm waves-effect waves-light" href="#" onclick="Delete();">
                                <span class="btn-label"><i class="fa fa-trash-o"></i></span><b>ลบ</b>
                            </a> --}}
{{--                        @endcan--}}

                    </div>

                    <div class="clearfix"></div>
                    <hr>

                    {!! Form::model($filter, ['url' => 'certify/applicant', 'method' => 'get', 'id' => 'myFilter']) !!}
                        <div class="row">
                            <div class="col-md-3 form-group">
                                    {!! Form::label('filter_tb3_Tisno', 'สถานะ:', ['class' => 'col-md-2 control-label label-filter']) !!}
                                    <div class="form-group col-md-10">
                                        {!! Form::select('filter_status', HP::DataStatusCertify(),   null,  ['class' => 'form-control',  'id'=>'filter_status', 'placeholder'=>'-เลือกสถานะ-']) !!}
                                </div>
                            </div><!-- /form-group -->
                            <div class="col-md-2">
                                <div class="form-group">
                                    <button type="button" class="btn btn-primary waves-effect waves-light" data-parent="#capital_detail" href="#search-btn" data-toggle="collapse" id="search_btn_all">
                                        <small>เครื่องมือค้นหา</small> <span class="glyphicon glyphicon-menu-up"></span>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group  pull-left"><button type="submit" class="btn btn-info waves-effect waves-light" style="margin-bottom: -1px;">ค้นหา</button></div>
                                <div class="form-group  pull-left m-l-15"><button type="button" class="btn btn-warning waves-effect waves-light" id="filter_clear">ล้าง</button> </div>
                            </div><!-- /.col-lg-1 -->
                            <div class="col-md-5">
                                {!! Form::label('filter_tb3_Tisno', 'search:', ['class' => 'col-md-2 control-label label-filter']) !!}
                                <div class="form-group col-md-5">
                                    {!! Form::text('filter_search', null, ['class' => 'form-control', 'placeholder'=>'search','id'=>'filter_search']); !!}
                                </div>
                                <div class="form-group col-md-5">
                                    {!! Form::label('perPage', 'Show', ['class' => 'col-md-4 control-label label-filter']) !!}
                                    <div class="col-md-8">
                                        {!! Form::select('perPage',   ['10'=>'10', '20'=>'20', '50'=>'50', '100'=>'100','500'=>'500'],  null,  ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                            </div><!-- /.col-lg-5 -->
                        </div><!-- /.row -->

                        <div id="search-btn" class="panel-collapse collapse">
                            <div class="white-box" style="display: flex; flex-direction: column;">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        {!! Form::label('filter_state', 'ความสามารถห้องปฏิบัติการ:', ['class' => 'col-md-5 control-label label-filter']) !!}
                                        <div class="col-md-7">
                                            {!! Form::select('filter_state',   ['3'=>'ทดสอบ', '4'=>'สอบเทียบ'],   null, ['class' => 'form-control', 'id'=>'filter_state','placeholder'=>"-เลือกความสามารถห้องปฏิบัติการ-"]) !!}
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        {!! Form::label('filter_start_date', 'วันที่มีคำสั่ง:', ['class' => 'col-md-3 control-label label-filter']) !!}
                                        <div class="col-md-8">
                                            <div class="input-daterange input-group" id="date-range">
                                            {!! Form::text('filter_start_date', null, ['class' => 'form-control','id'=>'filter_start_date']) !!}
                                            <span class="input-group-addon bg-info b-0 text-white"> ถึง </span>
                                            {!! Form::text('filter_end_date', null, ['class' => 'form-control','id'=>'filter_end_date']) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-6">
                                        {!! Form::label('c', 'สาขา:', ['class' => 'col-md-5 control-label label-filter']) !!}
                                        <div class="col-md-7">
                                            {!! Form::select('filter_branch', 
                                            [], 
                                            null,
                                            ['class' => 'form-control',
                                            'id'=>'filter_branch','placeholder'=>"-เลือกสาขา-"]) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

						<input type="hidden" name="sort" value="{{ Request::get('sort') }}" />
						<input type="hidden" name="direction" value="{{ Request::get('direction') }}" />

					{!! Form::close() !!}

                    <div class="clearfix"></div>

                    <div class="table-responsive m-t-15">

                        <form id="myForm" class="hide" action="#" method="post">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                        </form>

                        {!! Form::open(['url' => '#', 'method' => 'put', 'id' => 'myFormState', 'class'=>'hide']) !!}
                            <input type="hidden" name="state" id="state" />
                        {!! Form::close() !!}

                        <table class="table table-borderless" id="myTable">
                            <thead>
                                <tr>
                                    <th class="text-center" width="2%">#</th>
                                    <th class="text-left"  width="5%"><input type="checkbox" id="checkall"></th>
                                    <th class="text-left" width="10%">เลขที่คำขอ</th>
                                    <th class="text-left" width="10%">ห้องปฏิบัติการ</th>
                                    <th class="text-left" width="10%">ความสามารถ</th>
                                    <th class="text-left" width="10%">สาขา</th>
                                    <th class="text-left" width="10%">วันที่รับคำขอ</th>
                                    <th class="text-left" width="10%">สถานะ</th>
                                    <th class="text-center"width="10%">เครื่องมือ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if( count($applicants ) == 0 )
                                    <tr>
                                        <td class="text-center" colspan="8">
                                            ไม่พบข้อมูล
                                        </td>
                                    </tr>
                                @endif
                                
                                @php
                                    $count = 1;
                                    $statusShow = 0;
                                @endphp 

                                @foreach($applicants as $applicant)

                                    <tr>
                                        <td class="text-center">
                                            {{ $loop->iteration + ( ((request()->query('page') ?? 1) - 1) * $applicants->perPage() ) }}
                                        </td>
                                        <td>
                                            @if(in_array($applicant->status,['0','1']))
                                              <input type="checkbox" name="cb[]" class="cb" value="">
                                            @endif
                                        </td>

                                        <td>
                                            {{ $applicant->app_no }}
                                        </td>
                                        <td>
                                            {{ $applicant->lab_name }}
                                            <p style="font-style:italic;font-size:14px" >{{$applicant->purposeType->name}}</p>
                                        </td>
                                            @if ($applicant->lab_type == 3)
                                                <td>ทดสอบ</td>
                                            @elseif ($applicant->lab_type == 4)
                                                <td>สอบเทียบ</td>
                                            @else
                                                <td></td>
                                            @endif
                                        <td>
                                            @if ($applicant->lab_type == 3)
                                                   {{-- {{$applicant->BranchTitle ?? null}} --}}
                                                   {{$applicant->allLabTestTransactionCategories()}}
                                               @elseif ($applicant->lab_type == 4)
                                                {{-- {{ $applicant->ClibrateBranchTitle ?? null }} --}}
                                                {{$applicant->allLabCalTransactionCategories()}}
                                            @endif
                                            
                                        </td>

                                        <td> 
                                               {{ $applicant->AcceptDateShow }}
                                        </td>

                                         <td> 
                                            {{-- column สถานะ --}}
                                            @php 
                                                $data_status =  !empty($applicant->certi_lab_status_to->title)   ? $applicant->certi_lab_status_to->title : '-'  ;
                                                if ($applicant->require_scope_update == 1){
                                                    $data_status = "ให้แก้ไขขอบข่าย";
                                                }
                                            @endphp
                                            {{-- {{$data_status}} --}}

                                            @if($applicant->status == 3) <!-- ขอเอกสารเพิ่มเติม  -->

                                                <button style="border: none" data-toggle="modal"  data-target="#actionThree{{$loop->iteration}}"  > <i class="mdi mdi-magnify"></i>    {{ $data_status  }} </button>
                                                @include ('certify.applicant.modal.modalstatus3',array(
                                                                                                        'id'         => $loop->iteration,
                                                                                                        'desc'     =>  !empty($applicant->check->desc) ? $applicant->check->desc : null,
                                                                                                        'token'       =>  $applicant->token ,
                                                                                                        'attach_path' => $attach_path ,
                                                                                                        'file'        => !empty($applicant->check->files3) ? $applicant->check->files3 : []
                                                                                                    ))
                                            @elseif($applicant->status == 4) <!-- ยกเลิกคำขอ  -->   
                                                <button style="border: none" data-toggle="modal"   data-target="#actionFour{{$loop->iteration}}"    data-id="{{ $applicant->token }}"  >
                                                    <i class="mdi mdi-magnify"></i>    {{ $data_status  }}
                                                </button>

                                                @include ('certify.applicant.modal.modalstatus4',  array(
                                                                                                            'id' => $loop->iteration,
                                                                                                            'desc' => !empty($applicant->desc_delete) ? $applicant->desc_delete : @$applicant->check->desc ,
                                                                                                            'token'=>$applicant->token,
                                                                                                            'file' => $applicant->check->files4,
                                                                                                            'delete_file' => $applicant->certiLab_delete_file
                                                                                                        ))
                                            @elseif($applicant->status == 11)  <!-- ขอความเห็นประมาณการค่าใช้จ่าย  -->

                                                <a class="btn  btn-sm" style="background-color: rgb(235, 235, 235)" href="{{url('certify/applicant/cost/'.$applicant->token)}}">
                                                    <i class="mdi mdi-magnify"></i>  {{ $data_status  }}
                                                </a>

                                            @elseif($applicant->status == 7) <!-- อยู่ระหว่างดำเนินการ  -->
                                                {{-- {{$loop->iteration}} --}}
                                                {{-- {{$applicant->certi_auditors}} --}}
                                                <button style="border: none" data-toggle="modal"  data-target="#TakeAction{{$loop->iteration}}"    >
                                                    <i class="mdi mdi-magnify"></i>อยู่ระหว่างดำเนินการ
                                                </button>
                                                @include ('certify.applicant.modal.modalstatus10',['id'=> $loop->iteration,'certi' => $applicant ,'token' => $applicant->token ])

                                            @elseif($applicant->status == 21 && !is_null($applicant->report_to)) <!-- สรุปรายงานและเสนออนุกรรมการฯ  -->
                                                   
                                                <button style="border: none" data-toggle="modal"   data-target="#action27{{$loop->iteration}}"    data-id="{{ $applicant->token }}"  id="btn19">
                                                    <i class="mdi mdi-magnify"></i>     {{ $data_status  }}
                                                </button>
                                                @include ('certify.applicant.modal.modalstatus21',array('id'=>$loop->iteration, 'token'=>$applicant->token, 'report'=> $applicant->report_to, 'applicant'=> $applicant))

                                            @elseif($applicant->status == 23 && !is_null($applicant->CostCertificateTo)) <!-- แจ้งรายละเอียดการชำระค่าใบรับรอง  -->
                           
                                                <button style="border: none" data-toggle="modal" data-target="#action19{{$loop->iteration}}"  data-id="{{ $applicant->token }}"  id="btn19">
                                                    <i class="mdi mdi-magnify"></i>   {{ $data_status  }}
                                                </button>

                                                @include ('certify.applicant.modal.modalstatus23',array('id'=>$loop->iteration,  'token'=>$applicant->token, 'certificate' => $applicant->CostCertificateTo))
                                            
                                            @elseif($applicant->status == 25) 
                                                @if ($applicant->report_to !== null)
                                                      @if ($applicant->report_to->ability_confirm == null)
                                                            <button style="border: none" data-toggle="modal" data-target="#action19{{$loop->iteration}}"  data-id="{{ $applicant->token }}"  id="action19">
                                                                <i class="mdi mdi-magnify"></i>   ยืนยันความสามารถ
                                                            </button>
                                                            @include ('certify.applicant.modal.modalstatus_ability_confirm',array('id'=>$loop->iteration,  'token'=>$applicant->token, 'certificate' => $applicant->CostCertificateTo))
                                                          @else
                                                            {{ $data_status  }}
                                                      @endif
                                                    @else
                                                    {{ $data_status  }}
                                                @endif
                                               
                                            @else 
                                            
                                                {{ $data_status  }}
                                            @endif
                                       (ID:{{$applicant->status}})
                                        </td>
                                        <td class="text-nowrap text-left">

                                            @if ($applicant->require_scope_update == 1)
                                            <a href="{{ route('applicant.edit_scope',['token'=>$applicant->token]) }}"
                                                class="btn btn-warning btn-xs">
                                                 <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                             </a>
                                            @endif
                                             
                
                                            <a href="{{ route('applicant.show',['token'=>$applicant->token]) }}"
                                               title="View committee" class="btn btn-info btn-xs">
                                                <i class="fa fa-eye" aria-hidden="true"></i>
                                            </a>

                                            @if( in_array($applicant->status,['0','1']) && empty($applicant->get_date) )
                                                <a href="{{ route('applicant.edit',['token'=>$applicant->token]) }}"  title="Edit committee" class="btn btn-primary btn-xs">
                                                    <i class="fa fa-pencil-square-o" aria-hidden="true"> </i>
                                                </a>
                                            @endif



                                             @if(!in_array($applicant->status,['4']) && $applicant->status == 0)
                                                <button class="btn btn-xs btn-danger" data-toggle="modal"  data-target="#modalDelete{{$loop->iteration}}"   data-no="{{ $applicant->app_no }}" data-id="{{ $applicant->token }}"> <i class="fa fa-trash-o" aria-hidden="true"></i></button>
                                                @include ('certify.applicant.modal.modaldelete',array(
                                                                                                        'id'=>$loop->iteration,
                                                                                                        'lab_id'=>$applicant->id,
                                                                                                        'token'=>$applicant->token,
                                                                                                        'app_no'=>$applicant->app_no
                                                                                                    ))
                                            @endif
                                            @if ($applicant->status >= 10)
                                                <a class="btn btn-xs btn-warning"  href="{{url('certify/applicant/Log-Lab/'.$applicant->token)}}">
                                                    <i class="mdi mdi-magnify"></i> 
                                                </a>
                                            @endif

                                        {{-- @if ($applicant->getCertificateExport() != null)
                                            @if ($applicant->getCertificateExport()->certificate_newfile != null)
                                                <a href="{{ url('funtions/get-view').'/'.@$applicant->getCertificateExport()->certificate_path.'/'.@$applicant->getCertificateExport()->certificate_newfile.'/'.@$applicant->getCertificateExport()->certificate_no.'_'.date('Ymd_hms').'.pdf' }}" target="_blank">
                                                    <img src="{{ asset('images/icon-certification.jpg') }}" width="20px" style="margin-top: 4px;">
                                                </a>
                                                @elseif($applicant->getCertificateExport()->attachs != null)
                                                <a href="{{ url('certify/check/file_client/'.$applicant->getCertificateExport()->attachs.'/'.( !empty($applicant->getCertificateExport()->attachs_client_name) ? $applicant->getCertificateExport()->attachs_client_name :  basename($applicant->getCertificateExport()->attachs)  )) }}" target="_blank">
                                                    {!! HP::FileExtension($applicant->getCertificateExport()->attachs)  ?? '' !!}
                                                </a>
                                            @endif
                                        @endif --}}

                                            @if(!empty($applicant->certificate_exports_to->certificate_newfile))
                                                <a href="{{ url('funtions/get-view').'/'.@$applicant->certificate_exports_to->certificate_path.'/'.@$applicant->certificate_exports_to->certificate_newfile.'/'.@$applicant->certificate_exports_to->certificate_no.'_'.date('Ymd_hms').'.pdf' }}" target="_blank">
                                                    <img src="{{ asset('images/icon-certification.jpg') }}" width="20px" style="margin-top: 4px;">
                                                </a>
                                            @elseif(!empty($applicant->certificate_exports_to->attachs))
                                                <a href="{{ url('certify/check/file_client/'.$applicant->certificate_exports_to->attachs.'/'.( !empty($applicant->certificate_exports_to->attachs_client_name) ? $applicant->certificate_exports_to->attachs_client_name :  basename($applicant->certificate_exports_to->attachs)  )) }}" target="_blank">
                                                    {!! HP::FileExtension($applicant->certificate_exports_to->attachs)  ?? '' !!}
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                    @php $count ++ @endphp
                                @endforeach
 
                            </tbody>
                        </table>

                        <div class="pull-right">
                            {{$applicants->links()}}
                        </div>

                        @include ('certify.applicant.modal.modalstatus7')

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
