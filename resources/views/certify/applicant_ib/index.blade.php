{{-- ApplicantIBController --}}
@extends('layouts.master')

@push('css')

<style>
  /*
	Max width before this PARTICULAR table gets nasty. This query will take effect for any screen smaller than 760px and also iPads specifically.
	*/
	@media only screen
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
		/*td:nth-of-type(1):before { content: "Column Name"; }*/

	}
</style>

@endpush

@section('content')
    <div class="container-fluid">
        <!-- .row -->
        <div class="row">
            <div class="col-sm-12">
                <div class="white-box">
                    <h3 class="box-title pull-left">คำขอรับบริการหน่วยตรวจ (IB) check</h3>

                    <div class="pull-right">
 
                        @if( HP::CheckPermission('add-'.str_slug('applicantibs')))
                            <a class="btn btn-success btn-sm waves-effect waves-light" href="{{ url('/certify/applicant-ib/create') }}">
                                <span class="btn-label"><i class="fa fa-plus"></i></span><b>ยื่นคำขอ</b>
                            </a>
                        @endif

                    </div>

                    <div class="clearfix"></div>
                    <hr>
                    {!! Form::model($filter, ['url' => 'certify/applicant-ib', 'method' => 'get', 'id' => 'myFilter']) !!}

                        <div class="row">
                            <div class="col-md-4 form-group">
                                {!! Form::label('filter_tb3_Tisno', 'สถานะ:', ['class' => 'col-md-2 control-label label-filter text-right']) !!}
                                <div class="form-group col-md-10">
                                    {!! Form::select('filter_status', App\Models\Certify\ApplicantIB\CertiIBStatus::pluck('title','id'),  null, ['class' => 'form-control','id'=>'filter_status', 'placeholder'=>'-เลือกสถานะ-']) !!}
                            </div>
                            </div>
                        
                            <div class="col-md-6">
                                {!! Form::label('filter_tb3_Tisno', 'เลขที่คำขอ:', ['class' => 'col-md-3 control-label label-filter text-right']) !!}
                                <div class="form-group col-md-5">
                                    {!! Form::text('filter_search', null, ['class' => 'form-control', 'placeholder'=>'','id'=>'filter_search']); !!}
                                </div>
                                <div class="form-group col-md-4">
                                    {!! Form::label('perPage', 'Show', ['class' => 'col-md-4 control-label label-filter']) !!}
                                    <div class="col-md-8">
                                        {!! Form::select('perPage', ['10'=>'10', '20'=>'20', '50'=>'50', '100'=>'100','500'=>'500'], null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                            </div><!-- /.col-lg-5 -->
                            <div class="col-md-2">
                                <div class="form-group  pull-left">
                                    <button type="submit" class="btn btn-info waves-effect waves-light" style="margin-bottom: -1px;">ค้นหา</button>
                                </div>
                                <div class="form-group  pull-left m-l-15">
                                    <button type="button" class="btn btn-warning waves-effect waves-light" id="filter_clear">
                                        ล้าง
                                    </button>
                                </div>
                            </div><!-- /.col-lg-1 -->
                        </div><!-- /.row -->

                        <input type="hidden" name="sort" value="{{ Request::get('sort') }}" />
                        <input type="hidden" name="direction" value="{{ Request::get('direction') }}" />

					{!! Form::close() !!}

                    <div class="clearfix"></div>
                    <div class="table-responsive">

                        <table class="table table-borderless" id="myTable">
                            <thead>
                                <tr>
                                    <th  class="text-center" width="2%">#</th>
                                    <th  class="text-center" width="20%">เลขที่คำขอ</th>
                                    <th  class="text-center"  width="15%">หน่วยตรวจประเภท</th>
                                    <th  class="text-center"  width="15%">วันที่รับคำขอ</th>
                                    <th  class="text-center"  width="15%">สถานะ</th>
                                    <th  class="text-center"  width="15%">เครื่องมือ</th>
                                </tr>
                            </thead>
                            <tbody>

                                @if( count($certiIbs ) == 0 )
                                    <tr>
                                        <td class="text-center" colspan="6">
                                            ไม่พบข้อมูล
                                        </td>
                                    </tr>
                                @endif
                                @php
                                    $type_unit =  ['1'=>'A','2'=>'B','3'=>'C'] ;
                                @endphp
                                 @foreach($certiIbs as $item)
                                 {{-- @php
                                     dd($item);
                                 @endphp --}}
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration + ( ((request()->query('page') ?? 1) - 1) * $certiIbs->perPage() ) }}</td>
                                        <td>
                                            {{ @$item->app_no }}
                                            <p style="font-style:italic;font-size:14px" >{{ optional($item->purposeType)->name }}</p>
                                        </td>
                                        <td>
                                            {{ array_key_exists($item->type_unit,$type_unit) ? $type_unit[$item->type_unit]  :'-' }}
                                            
                                        </td>
                                        <td>
                                            
                                            @if ($item->status != 3)
                                                {{ $item->AcceptDateShow }}
                                            @endif
                                        </td>
                                        <td>
                                            {{-- (ID:{{$item->status}}) --}}
                                            @php
                                                $data_status =$item->TitleStatus->title ?? '-' ;
                                                 if ($item->require_scope_update == 1){
                                                    $data_status = "ให้แก้ไขขอบข่าย";
                                                }
                                            @endphp
                                            @if($item->status == 3) <!-- ขอเอกสารเพิ่มเติม  -->
                                                <button style="border: none" data-toggle="modal" data-target="#actionThree{{$loop->iteration}}"  >
                                                    <i class="mdi mdi-magnify"></i>    {{ $data_status  }}
                                                </button>
                                                @include ('certify.applicant_ib.modal.modalstatus3',  array('id' => $loop->iteration,
                                                                                                'details' => $item->details ?? null,
                                                                                                'token'=>$item->token ,
                                                                                                'file' => $item->FileAttach9 ))
                                            @elseif($item->status == 4)
                                                <button style="border: none;background-color: #ffffff;" data-toggle="modal"  data-target="#actionFour{{$loop->iteration}}" data-id="{{ $item->token }}"  >
                                                    <i class="fa fa-close text-danger"></i> {{ $data_status  }}
                                                </button>
                                                @include ('certify.applicant_ib.modal.modalstatus4', array('id' => $loop->iteration,
                                                                                                    'desc' => $item->desc_delete ?? null ,
                                                                                                    'token'=> $item->token,
                                                                                                    'files' => $item->FileAttach8
                                                                                                  ))
                                            @elseif($item->status == 5)
                                                <button style="border: none;background-color: #ffffff;" data-toggle="modal"  data-target="#NotValidated{{$loop->iteration}}"data-id="{{ $item->token }}"  >
                                                    <i class="fa fa-close text-danger"></i> {{ $data_status  }}
                                                </button>
                                                @include ('certify.applicant_ib.modal.modalstatus5',array('id' => $loop->iteration,
                                                                                                                  'desc' => $item->desc_delete ?? null ,
                                                                                                                  'token'=> $item->token,
                                                                                                                  'files' => $item->FileAttach10
                                                                                                    ))
                                            @elseif($item->status == 8) <!-- ขอความเห็นประมาณการค่าใช้จ่าย  -->
                                                <a class="btn  btn-sm" style="background-color: rgb(235, 235, 235)" href="{{url('certify/applicant-ib/cost/'.$item->token)}}">
                                                    <i class="mdi mdi-magnify"></i>  {{ $data_status  }}
                                                </a>

                                                @elseif($item->status == 9) <!-- ขอความเห็นผู้ตรวจประเมินเอกสาร  -->
                                

                                                @if ($item->ibDocReviewAuditor != null)

                                                @php
                                                    $isAllDocSigned = false;
                                                    // dd( $item->cbDocReviewAuditor);
                                                    $board_auditor_id = $item->ibDocReviewAuditor->app_certi_ib_id;
                                                    // $app_id = $item->app_no;
                                                    $job_type = "ib-doc-review-assessment";
                                                    $isAllDocSigned = $item->isAllDocReviewSign($board_auditor_id,$job_type);
                                                    // dd($board_auditor_id,$isAllDocSigned);
                                                @endphp

                                                            
                                                    @if ($item->ibDocReviewAuditor->status == 0)
                                                        {{-- <button style="border: none" data-toggle="modal"  data-target="#TakeAction{{$loop->iteration}}" data-id="{{ $item->token }}"  > --}}
                                                            @if ($isAllDocSigned)
                                                                <button type="button" style="border: none" data-ib_id="{{ $item->id }}" data-id="{{ $item->token }}" id="show_ib_doc_review_auditor" >
                                                                    <i class="mdi mdi-magnify"></i>เห็นชอบการแต่งตั้งคณะผู้ตรวจประเมินเอกสาร
                                                                </button>
                                                            @endif
                                                    

                                                        <div class="modal fade text-left" id="ib_doc_review_auditor_modal" tabindex="-1" role="dialog" >
                                                            <div class="modal-dialog " style="width:900px !important">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title" id="exampleModalLabel1"> เห็นชอบการแต่งตั้งคณะผู้ตรวจเอกสาร
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                        </h4>
                                                                    </div>
                                                                    <div class="modal-body"> 
                                                                        @php 
                                                                            $auditors_btn =  '';
                                                                            if($item->CertiAuditorsStatus == "statusInfo"){
                                                                                $auditors_btn = 'btn-info';
                                                                            }elseif($item->CertiAuditorsStatus == "statusSuccess"){
                                                                                $auditors_btn =  'btn-success';
                                                                            }else{
                                                                                $auditors_btn = 'btn-danger';
                                                                            }
                                                                        @endphp
                                                        
                                                                        <table  class="table color-bordered-table primary-bordered-table" id="ib_doc_review_auditor_wrapper">
                                                                            <thead>
                                                                                    <tr>
                                                                                        <th width="10%" >ลำดับ</th>
                                                                                        <th width="45%">ชื่อผู้ตรวจประเมิน</th>
                                                                                        <th width="45%">หน่วยงาน</th>
                                                                                    </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                    
                                                        
                                                                            
                                                                            </tbody>
                                                                        </table>
                                                                        
                                                                        <div class="form-group">
                                                                            <input type="hidden" value="{{$item->id}}" id="certi_ib_id">
                                                                            <div class="col-md-3">
                                                                                <input type="radio" name="agree" value="1" id="agree" checked>
                                                                                <label for="agree" class="control-label">เห็นชอบ</label>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <input type="radio" name="agree" value="2" id="not_agree">
                                                                                <label for="not_agree" class="control-label">ไม่เห็นชอบ</label>
                                                                            </div>
                                                                        </div>
                                                                        
                                                                        <div class="form-group" style="margin-top: 25px">
                                                                            <div class="row">
                                                                                <div class="col-sm-12" id="text-area-wrapper" style="display: none;">
                                                                                    <label> หมายเหตุ : </label>
                                                                                    <textarea class="form-control" name="remark_map" id="remark" rows="4" ></textarea>
                                                                                </div>
                                                                                <div class="col-sm-12" >
                                                                                    <button type="button" data-ib_id="{{$item->id}}" class="btn btn-info waves-effect waves-light " style="margin-top:15px; float:right" id="agree_doc_review_tream">
                                                                                        บันทึก
                                                                                    </button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                        
                                                        
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        


                                                        {{-- @include ('certify.applicant_cb.modal.modalstatus9',['id'=> $loop->iteration,'token'=> $item->token,'auditors' => $item->CertiAuditorsMany,'certi' => $item ]) --}}
                                                    @elseif($item->ibDocReviewAuditor->status == 2 )
                                                        ไม่เห็นชอบการแต่งตั้งคณะผู้ตรวจประเมินเอกสาร
                                                    @endif
                                                @endif

                                   
                                                {{-- {{$item->ibDocReviewAuditor->status}} --}}
                                              @if ($item->doc_review_reject != null && $item->ibDocReviewAuditor->status == 1)
                                                            
                                                <button style="border: none" data-toggle="modal"  data-target="#TakeAction{{$loop->iteration}}" data-id="{{ $item->token }}"  >
                                                        <i class="mdi mdi-magnify"></i>แก้ไขเอกสาร
                                                    </button>
                                                    @include ('certify.applicant_ib.modal.modalstatus9_1',['id'=> $loop->iteration,'token'=> $item->token,'auditors' => $item->CertiAuditorsMany,'certi' => $item ])
    
                                                @endif



                                            @elseif($item->status == 10 || $item->status == 11) 
                                                <button style="border: none" data-toggle="modal"  data-target="#TakeAction{{$loop->iteration}}"  data-id="{{ $item->token }}"  >
                                                    <i class="mdi mdi-magnify"></i> อยู่ระหว่างดำเนินการ 
                                                </button>
                                                @include ('certify.applicant_ib.modal.modalstatus10',['id'=> $loop->iteration,
                                                                                                       'token'=> $item->token,
                                                                                                       'auditors' => $item->CertiIBAuditorsMany,
                                                                                                       'certi' => $item

                                                                                                       ])
                                           @elseif($item->status == 12) <!-- แจ้งรายละเอียดค่าตรวจประเมิน  -->
                                                @php
                                                    $payin1 = $item->CertiIBPayInOneMany;
                                                    $payinRemark = $item->CertiIBPayInOneRemarkNotNullMany;
                                                @endphp

                                                <button type="button"  style="border: none"  data-toggle="modal" data-target="#PayIn1Modal">
                                                    <i class="mdi mdi-magnify"></i>  {{ $data_status  }}
                                                </button>

                                                @include ('certify.applicant_ib.modal.modalstatus12',[
                                                                                                    'id' => $item->id,
                                                                                                    'status' => $item->CertiIBPayInOneStatus ?? null,
                                                                                                    'appNo' => $item->app_no,
                                                                                                    'name' =>  $item->name ?? null,
                                                                                                    'payin1' => $payin1,
                                                                                                    'payinRemark' => $payinRemark
                                                                                                  ])
                                            @elseif($item->status == 13) <!-- 	 	รอยืนยันคำขอ   -->
                                            
                                                <button type="button"  style="border: none;"  data-toggle="modal" data-target="#ReportModal{{$item->id}}">
                                                    <i class="mdi mdi-magnify"></i>  {{ $data_status  }}
                                                </button>
                                                @include ('certify.applicant_ib.modal.modalstatus18',[
                                                                                                        'id' =>$item->id,
                                                                                                        'report' => $item->CertiIBReportTo ?? null,
                                                                                                        'certi' => $item
                                                                                                    ])
                                                                                                    
                                            @elseif($item->status == 15) <!--  	แจ้งรายละเอียดการชำระค่าใบรับรอง   -->
                                                <button type="button"  style="border: none;"  data-toggle="modal" data-target="#PayIn2Modal{{$item->id}}">
                                                    <i class="mdi mdi-magnify"></i>  {{ $data_status  }}
                                                </button>

                                                @php
                                                    $PayIn2 = $item->CertiIBPayInTwoTo;
                                                @endphp

                                                @include ('certify.applicant_ib.modal.modalstatus20',[
                                                                                                    'id' =>$item->id,
                                                                                                    'PayIn2' => $PayIn2 ?? null,
                                                                                                    'app_no' => $item->app_no ?? '-',
                                                                                                    // 'name' => $item->EsurvTrader->trader_operater_name ?? '-',
                                                                                                    'name' => $item->name ?? '-',
                                                                                                    'files1' => $PayIn2->FileAttachPayInTwo1To->file ?? null,
                                                                                                    'file_client_name' => $PayIn2->FileAttachPayInTwo1To->file_client_name ?? null,
                                                                                                    'save_date' => $item->save_date
                                                                                                   ])
                                            {{-- @elseif($item->status == 17) 

                                            @else
                                                {{$data_status}}
                                            @endif

                                                (ID:{{$item->status}}) --}}
                                                @elseif($item->status == 17)  

                                                    @if ($item->CertiIBReportTo !== null)
                                                            @if ($item->CertiIBReportTo->ability_confirm == null)
                                                                <button style="border: none" data-toggle="modal" data-target="#action20{{$loop->iteration}}"  data-id="{{ $item->token }}"  id="action20">
                                                                    <i class="mdi mdi-magnify"></i>   ยืนยันความสามารถ
                                                                </button>
                                                                @include ('certify.applicant_ib.modal.modalstatus_ability_confirm',array('id'=>$loop->iteration,  'token'=>$item->token, 'certificate' => $item->CertiIBReportTo))
                                                            @else
                                                                {{ $data_status  }}
                                                            @endif
                                                        @else
                                                        {{ $data_status  }}
                                                    @endif
                                                @else
                                                    
                                                    @if ($item->status == 12 && $item->require_scope_update == "1")
                                                            
                                                            <span>แก้ไขขอบข่าย</span>
                                                        @else
                                                        {{ $data_status ?? '-' }} 
                                                    @endif
                                                @endif
                                                (ID:{{$item->status}})
                                        </td>
                                        <td>
                                          
                                            @if ($item->require_scope_update == 1)
                                                <a href="{{ url('/certify/applicant-ib/' . $item->token . '/edit_scope') }}"
                                                    title="Edit ApplicantCB" class="btn btn-warning btn-xs">
                                                        <i class="fa fa-pencil-square-o" aria-hidden="true"> </i>
                                                </a>
                                            @endif

                                            @if( HP::CheckPermission('view-'.str_slug('applicantcbs')))
                                                <a href="{{ url('/certify/applicant-ib/' . $item->token) }}"
                                                  title="View ApplicantCB" class="btn btn-info btn-xs">
                                                      <i class="fa fa-eye" aria-hidden="true"></i>
                                                </a>
                                            @endif

                                            @if($item->status != 4 &&  $item->status != 5  )

                                                @if($item->status < 6 || $item->status == 25 )
                                                    @if( HP::CheckPermission('edit-'.str_slug('applicantcbs')))
                                                        <a href="{{ url('/certify/applicant-ib/' . $item->token . '/edit') }}"
                                                            title="Edit ApplicantCB" class="btn btn-primary btn-xs">
                                                                <i class="fa fa-pencil-square-o" aria-hidden="true"> </i>
                                                        </a>
                                                    @endif

                                                @endif
                                                @if( HP::CheckPermission('delete-'.str_slug('applicantcbs')))
                                                    <button class="btn btn-xs btn-danger" data-toggle="modal" data-target="#modalDelete{{$loop->iteration}}" data-no="{{ $item->app_no }}" data-id="{{ $item->token }}" >
                                                        <i class="fa fa-trash-o" aria-hidden="true"></i> 
                                                    </button>
                                                    @include ('certify.applicant_ib.modal.modaldelete',['id'=>$loop->iteration,
                                                                                                    'token'=>$item->token,
                                                                                                    'app_no'=>$item->app_no
                                                                                                   ])
                                                @endif
                                            @endif

                                            @if (count($item->DataCertiIbHistory) > 0)
                                                <a class="btn btn-xs btn-warning"  href="{{url('certify/applicant-ib/Log-IB/'.$item->token)}}">
                                                    <i class="mdi mdi-magnify"></i>
                                                </a>
                                            @endif
                                        
                                            @if(!empty($item->app_certi_ib_export->certificate_newfile))
                                                <a href="{{ url('funtions/get-view').'/'.@$item->app_certi_ib_export->certificate_path.'/'.@$item->app_certi_ib_export->certificate_newfile.'/'.@$item->app_certi_ib_export->certificate_no.'_'.date('Ymd_hms').'.pdf' }}" target="_blank">
                                                    <img src="{{ asset('images/icon-certification.jpg') }}" width="20px" style="margin-top: 4px;">
                                                </a>

                                            @elseif(!empty($item->certificate_exports_to->attachs))
                                                <a href="{{ url('certify/check/file_ib_client/'.$item->certificate_exports_to->attachs.'/'.( !empty($item->certificate_exports_to->attach_client_name) ? $item->certificate_exports_to->attach_client_name :  basename($item->certificate_exports_to->attachs)  )) }}" target="_blank">
                                                    {!! HP::FileExtension($item->certificate_exports_to->attachs)  ?? '' !!}
                                                </a>
                                                
                                            @endif

                                                 {{-- <a href="{{ url('/certify/applicant-ib/' . $item->token . '/edit') }}"
                                                            title="Edit ApplicantCB" class="btn btn-primary btn-xs">
                                                                <i class="fa fa-pencil-square-o" aria-hidden="true"> </i> ปุ่มทดสอบ
                                                        </a> --}}

                                        </td>
                                    </tr>
                                 @endforeach
                            </tbody>
                        </table>

                        <div class="pagination-wrapper">
                          {!!
                              $certiIbs->appends(['search' => Request::get('search'),
                                                      'sort' => Request::get('sort'),
                                                      'direction' => Request::get('direction')
                                                    ])->render()
                          !!}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection



@push('js')
    <script src="{{asset('plugins/components/toast-master/js/jquery.toast.js')}}"></script>
    <script src="{{asset('plugins/components/sweet-alert2/sweetalert2.all.min.js')}}"></script>
    <script>
            $(document).ready(function () {
            $( "#filter_clear" ).click(function() {
                $('#filter_status').val('').select2();
                $('#filter_search').val('');

                $('#filter_state').val('').select2();
                $('#filter_start_date').val('');
                $('#filter_end_date').val('');
                $('#filter_branch').val('').select2();
                window.location.assign("{{url('/certify/applicant-ib')}}");
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
         });


        $(document).ready(function () {

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
      function submit_form_pay1() {
           Swal.fire({
                   title: 'ยืนยันทำรายการ !',
                   icon: 'warning',
                   showCancelButton: true,
                   confirmButtonColor: '#3085d6',
                   cancelButtonColor: '#d33',
                   confirmButtonText: 'บันทึก',
                   cancelButtonText: 'ยกเลิก'
                   }).then((result) => {
                       if (result.value) {
                           $.LoadingOverlay("show", {
                               image       : "",
                               text        : "กำลังบันทึก กรุณารอสักครู่..."
                           });
                           $('.pay_in1_form').submit();
                       }
                   })
           }


    $('input[name="agree"]').change(function() {
        if ($('#not_agree').is(':checked')) {
                    $('#text-area-wrapper').show(); // แสดงทันที
                } else {
                    $('#text-area-wrapper').hide(); // ซ่อนทันที
                    $("#remark").val("");
                }
    });

    $('#agree_doc_review_tream').click(function(){
        
        const _token = $('input[name="_token"]').val();
        let certiIbId = $(this).data('ib_id');
        
        // ดึงค่าของ radio ที่ถูกเลือก
        let agreeValue = $("input[name='agree']:checked").val();

        // ดึงค่าของ textarea
        let remarkText = $("#remark").val();


        $.ajax({
        url: "{{route('applicant_ib.update_doc_review_team')}}",
        // url: "/certify/applicant/api/test_parameter",
        method: "POST",
        data: {
            certiIbId: certiIbId,
            agreeValue: agreeValue,
            remarkText: remarkText,
            _token: _token
        },
        success: function(result) {
            location.reload();

        }
        });
   
    });

    $('#show_ib_doc_review_auditor').click(function(){
        
        const _token = $('input[name="_token"]').val();
        let certiIbId = $(this).data('ib_id');

        $.ajax({
            url: "{{route('applicant_ib.ge_ib_doc_review_auditor')}}",
            method: "POST",
            data: {
                certiIbId: certiIbId,
                _token: _token
            },
            success: function(result) {
                console.log(result);
                // location.reload();
                let auditors = result.ibDocReviewAuditors;
                let tbody = $('#ib_doc_review_auditor_wrapper tbody');
                tbody.empty(); // Clear existing rows

                let count = 1; // Initialize row counter
                auditors.forEach(function(auditor) {
                    auditor.temp_users.forEach(function(user, index) {
                        let department = auditor.temp_departments[index] !== 'ไม่มีรายละเอียดหน่วยงานโปรดแก้ไข' 
                            ? auditor.temp_departments[index] 
                            : '';

                        let row = `
                            <tr>
                                <td>${count}</td>
                                <td>${user}</td>
                                <td>${department}</td>
                            </tr>
                        `;
                        tbody.append(row);
                        count++;
                    });
                });
                $('#ib_doc_review_auditor_modal').modal('show');

            }
        });

   
    });

   </script>
@endpush
