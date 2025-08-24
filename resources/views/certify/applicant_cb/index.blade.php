@extends('layouts.master')

@push('css')

<style>
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
                    <h3 class="box-title pull-left">ใบรับรองระบบงาน (CB)</h3>

                    <div class="pull-right">

                        @if( HP::CheckPermission('add-'.str_slug('applicantcbs')))
                            <a class="btn btn-success btn-sm waves-effect waves-light" href="{{ url('/certify/applicant-cb/create') }}">
                                <span class="btn-label"><i class="fa fa-plus"></i></span><b>ยื่นคำขอ</b>
                            </a>
                        @endif

                    </div>

                    <div class="clearfix"></div>
                    <hr>
                    {!! Form::model($filter, ['url' => 'certify/applicant-cb', 'method' => 'get', 'id' => 'myFilter']) !!}

                        <div class="row">
                            <div class="col-md-4 form-group">
                                {!! Form::label('filter_tb3_Tisno', 'สถานะ:', ['class' => 'col-md-2 control-label label-filter']) !!}
                                <div class="form-group col-md-10">
                                    {!! Form::select('filter_status', App\Models\Certify\ApplicantCB\CertiCBStatus::pluck('title','id'),null, ['class' => 'form-control','id'=>'filter_status','placeholder'=>'-เลือกสถานะ-']) !!}
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
                                        {!! Form::select('perPage', ['10'=>'10', '20'=>'20', '50'=>'50', '100'=>'100','500'=>'500'],null,['class' => 'form-control']) !!}
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

                        <div id="search-btn" class="panel-collapse collapse">
                            <div class="white-box" style="display: flex; flex-direction: column;">

                                <div class="row">
                                    <div class="form-group col-md-6">
                                        {!! Form::label('filter_state', 'ความสามารถห้องปฏิบัติการ:', ['class' => 'col-md-5 control-label label-filter']) !!}
                                        <div class="col-md-7">
                                            {!! Form::select('filter_state', ['3'=>'ทดสอบ', '4'=>'สอบเทียบ'], null,    ['class' => 'form-control',  'id'=>'filter_state','placeholder'=>"-เลือกความสามารถห้องปฏิบัติการ-"]) !!}
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
                                            {!! Form::select('filter_branch', [],   null, ['class' => 'form-control',  'id'=>'filter_branch','placeholder'=>"-เลือกสาขา-"]) !!}
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <input type="hidden" name="sort" value="{{ Request::get('sort') }}" />
                        <input type="hidden" name="direction" value="{{ Request::get('direction') }}" />

                    {!! Form::close() !!}

                    <div class="clearfix"></div>

                    <table class="table table-borderless" id="myTable">
                        <thead>
                            <tr>
                                <th  class="text-center" width="2%">#</th>
                                <th  class="text-center" width="10%">เลขที่คำขอ</th>
                                <th  class="text-center" width="10%">ชื่อผู้ยื่น</th>
                                <th  class="text-center" width="10%">เลขที่มาตรฐาน</th>
                                <th  class="text-center" width="10%">สาขา</th>
                                <th  class="text-center"  width="10%">วันที่รับคำขอ</th>
                                <th  class="text-center"  width="10%">สถานะ</th>
                                <th  class="text-center"  width="10%">เครื่องมือ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if( count($certiCbs ) == 0 )
                                <tr>
                                    <td class="text-center" colspan="8">
                                        ไม่พบข้อมูล
                                    </td>
                                </tr>
                            @endif
                            @foreach($certiCbs as $item)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration + ( ((request()->query('page') ?? 1) - 1) * $certiCbs->perPage() ) }}</td>
                                    <td> {{  @$item->app_no }}
                                        <p style="font-style:italic;font-size:14px" >{{optional($item->purposeType)->name}}</p>
                                    </td>
                                    <td>{{ $item->name ?? null  }}
                                        
                                    </td>
                                    <td>{{ !empty($item->FormulaTo->title) ? $item->FormulaTo->title  : null   }}</td>
                                    <td>{{ $item->CertificationBranchName }}</td>
                                    <td>{{ $item->AcceptDateShow }}</td>
                                    <td>
                                        @php
                                            $data_status =$item->TitleStatus->title ?? '-' ;
                                            if ($item->require_scope_update == 1){
                                                    $data_status = "ให้แก้ไขขอบข่าย";
                                                }
                                        @endphp

                                        @if($item->status == 3) <!-- ขอเอกสารเพิ่มเติม  -->
                                            <button style="border: none" data-toggle="modal"  data-target="#actionThree{{$loop->iteration}}"  > <i class="mdi mdi-magnify"></i>    {{ $data_status  }} </button>
                                            @include ('certify.applicant_cb.modal.modalstatus3',array('id'    => $loop->iteration,
                                                                                                'details'     => $item->details ?? null,
                                                                                                'token'       =>  $item->token ,
                                                                                                'attach_path' => $attach_path ,
                                                                                                'file'        => $item->FileAttach6 ))
                                        @elseif($item->status == 4)
                                            <button style="border: none" data-toggle="modal"  data-target="#actionFour{{$loop->iteration}}"  data-id="{{ $item->token }}"  >
                                                <i class="mdi mdi-magnify"></i>      {{ $data_status ?? '-' }}
                                            </button>
                                            @include ('certify.applicant_cb.modal.modalstatus4', array('id' => $loop->iteration,'desc' => !empty($item->desc_delete) ? $item->desc_delete :  '-' , 'file'=>  $item->FileAttach5  ))
                                        @elseif($item->status == 8) <!-- ขอความเห็นประมาณการค่าใช้จ่าย  -->
                                            <a class="btn  btn-sm" style="background-color: rgb(235, 235, 235)" href="{{url('certify/applicant-cb/cost/'.$item->token)}}">
                                                <i class="mdi mdi-magnify"></i>  {{ $data_status  }}
                                            </a>
                                        @elseif($item->status == 9) <!-- ขอความเห็นผู้ตรวจประเมินเอกสาร  -->
                                      
                   
                                        @if ($item->cbDocReviewAuditor != null)
                                            @php
                                                $isAllDocSigned = false;
                                                // dd( $item->cbDocReviewAuditor);
                                                $board_auditor_id = $item->cbDocReviewAuditor->app_certi_cb_id;
                                                // $app_id = $item->app_no;
                                                $job_type = "cb-doc-review-assessment";
                                                $isAllDocSigned = $item->isAllDocReviewSign($board_auditor_id,$job_type);
                                                // dd($board_auditor_id,$isAllDocSigned);
                                            @endphp
                                            @if ($item->cbDocReviewAuditor->status == 0)
                                                @if ($isAllDocSigned)
                                                    <button type="button" style="border: none" data-cb_id="{{ $item->id }}"  data-id="{{ $item->token }}" id="show_cb_doc_review_auditor" >
                                                        <i class="mdi mdi-magnify"></i>เห็นชอบการแต่งตั้งคณะผู้ตรวจประเมินเอกสาร
                                                    </button>
                                                @endif
                                                {{-- <button style="border: none" data-toggle="modal"  data-target="#TakeAction{{$loop->iteration}}" data-id="{{ $item->token }}"  > --}}
                                            


                                                            <!-- Modal เลข 3 -->
                                                            {{-- <div class="modal fade text-left" id="TakeAction{{$id}}" tabindex="-1" role="dialog" aria-labelledby="addBrand"> --}}
                                                                <div class="modal fade text-left" id="cb_doc_review_auditor_modal" tabindex="-1" role="dialog" >
                                                                <div class="modal-dialog " role="document" style="width:800px">
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

                                                                            <table  class="table color-bordered-table primary-bordered-table" id="cb_doc_review_auditor_wrapper">
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
                                                                                <input type="hidden" value="{{$item->id}}" id="certi_cb_id">
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
                                                                                        <button type="button" class="btn btn-info waves-effect waves-light " style="margin-top:15px; float:right" id="agree_doc_review_tream">
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
                                            @elseif($item->cbDocReviewAuditor->status == 2)
                                                ไม่เห็นชอบการแต่งตั้งคณะผู้ตรวจประเมินเอกสาร
                                            @endif
                                        @endif
                                        @if ($item->doc_review_reject != null)
                                                    
                                            <button style="border: none" data-toggle="modal"  data-target="#TakeAction{{$loop->iteration}}" data-id="{{ $item->token }}"  >
                                                <i class="mdi mdi-magnify"></i>แก้ไขเอกสาร
                                            </button>
                                            @include ('certify.applicant_cb.modal.modalstatus9_1',['id'=> $loop->iteration,'token'=> $item->token,'auditors' => $item->CertiAuditorsMany,'certi' => $item ])

                                        @endif

                                            {{-- @if ($item->certiAuditorsManyDocReview->count() > 0 )
                                            <button style="border: none" data-toggle="modal"  data-target="#TakeAction{{$loop->iteration}}" data-id="{{ $item->token }}"  >
                                                <i class="mdi mdi-magnify"></i>เห็นชอบการแต่งตั้งคณะผู้ตรวจประเมินเอกสาร
                                            </button>
                                                @include ('certify.applicant_cb.modal.modalstatus9',['id'=> $loop->iteration,'token'=> $item->token,'auditors' => $item->CertiAuditorsMany,'certi' => $item ])

                                            @elseif($item->more_doc_require == 1)
                                         
                                                <button style="border: none" data-toggle="modal"  data-target="#actionThree{{$loop->iteration}}"  > <i class="mdi mdi-magnify"></i>   ขอเอกสารเพิ่มเติมเน่อ </button>
                                              
                                                @include ('certify.applicant_cb.modal.modalstatus9docreview',array(
                                                    'id'    => $loop->iteration,
                                                    'details'     => $item->details ?? null,
                                                    'token'       =>  $item->token ,
                                                    'attach_path' => $attach_path ,
                                                    'file'        => $item->FileAttach6 ,
                                                    'app_certi_cb_id' => $item->id
                                                ))
                                            @else
                                                
                                                อยู่ระหว่างดำเนินการ
                                            @endif
                                             --}}


                                        @elseif($item->status == 10 || $item->status == 11) <!-- อยู่ระหว่างดำเนินการ  -->
                                       
                                        {{-- {{$item->fullyApprovedAuditorNoCancels()->count() }} --}}
                                            <button style="border: none" data-toggle="modal"  data-target="#TakeAction{{$loop->iteration}}" data-id="{{ $item->token }}"  >
                                                <i class="mdi mdi-magnify"></i>อยู่ระหว่างดำเนินการ
                                            </button>

                                            @include ('certify.applicant_cb.modal.modalstatus10',['id'=> $loop->iteration,'token'=> $item->token,'auditors' => $item->CertiAuditorsMany,'certi' => $item ])

                                        @elseif($item->status == 13) <!-- รอยืนยันคำขอ  -->
                                            <button type="button"  style="border: none;"  data-toggle="modal" data-target="#ReportModal{{$item->id}}">
                                                <i class="mdi mdi-magnify"></i>  {{ $data_status  }}
                                            </button>
                                            @include ('certify.applicant_cb.modal.modalstatus18',[ 'id' =>$item->id, 'report' => $item->CertiCBReportTo ?? null  ])
                                        @elseif($item->status == 15) <!-- 	 	แจ้งรายละเอียดการชำระค่าใบรับรอง   -->
                                            <button type="button"  style="border: none;"  data-toggle="modal" data-target="#PayIn2Modal{{$item->id}}">
                                                <i class="mdi mdi-magnify"></i>  {{ $data_status  }}
                                            </button>
                                            @php
                                                $PayIn2 = $item->CertiCBPayInTwoTo;
                                            @endphp
                                            
                                            @include ('certify.applicant_cb.modal.modalstatus20',[
                                                                                                    'id' =>$item->id,
                                                                                                    'PayIn2' => $PayIn2 ?? null,
                                                                                                    'app_no' => $item->app_no ?? '-',
                                                                                                    'name' => $item->name ?? '-',
                                                                                                    'files1' => $PayIn2->FileAttachPayInTwo1To->file ?? null,
                                                                                                    'file_client_name' => $PayIn2->FileAttachPayInTwo1To->file_client_name ?? null,
                                                                                                    'std_name' => $item->FormulaTo->title,
                                                                                                    'save_date' => $item->save_date
                                                                                                   ])

                                        @elseif($item->status == 17)  

                                            @if ($item->CertiCBReportTo !== null)
                                                    @if ($item->CertiCBReportTo->ability_confirm == null)
                                                        <button style="border: none" data-toggle="modal" data-target="#action20{{$loop->iteration}}"  data-id="{{ $item->token }}"  id="action20">
                                                            <i class="mdi mdi-magnify"></i>   ยืนยันความสามารถ
                                                        </button>
                                                        @include ('certify.applicant_cb.modal.modalstatus_ability_confirm',array('id'=>$loop->iteration,  'token'=>$item->token, 'certificate' => $item->CertiCBReportTo))
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

                                        @if ($item->require_scope_update == "1")
                                            <a href="{{ url('/certify/applicant-cb/' . $item->token . '/edit_scope') }}"  title="Edit ApplicantCB" class="btn btn-warning btn-xs">
                                                <i class="fa fa-pencil-square-o" aria-hidden="true"> </i>
                                            </a>
                                        @endif
                                       
                                        
                                        @if( HP::CheckPermission('view-'.str_slug('applicantcbs')))
                                            <a href="{{ url('/certify/applicant-cb/' . $item->token) }}"  title="View ApplicantCB" class="btn btn-info btn-xs">
                                                <i class="fa fa-eye" aria-hidden="true"></i>
                                            </a>

                                    
                                        @endif

                                        @if($item->status != 4 &&  $item->status != 5  )
                                            @if( in_array($item->status ,[0,3]) )
                                                @if( HP::CheckPermission('edit-'.str_slug('applicantcbs')))
                                                    <a href="{{ url('/certify/applicant-cb/' . $item->token . '/edit') }}"  title="Edit ApplicantCB" class="btn btn-primary btn-xs">
                                                        <i class="fa fa-pencil-square-o" aria-hidden="true"> </i>
                                                    </a>
                                                @endif
                                            @endif

                                            @if( HP::CheckPermission('delete-'.str_slug('applicantcbs')) )

                                                @if( empty($item->app_certi_cb_export->certificate_newfile) || (!empty($item->app_certi_cb_export->certificate_newfile) && ( ( !empty($item->app_certi_cb_export) && !in_array($item->app_certi_cb_export->status, [4]) ) && !in_array($item->status, [20]) ))  )
                                                    {{-- <button class="btn btn-xs btn-danger" data-toggle="modal" data-target="#modalDelete{{$loop->iteration}}"data-no="{{ $item->app_no }}"data-id="{{ $item->token }}" >
                                                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                                                    </button> --}}
                                                    @include ('certify.applicant_cb.modal.modaldelete',['id'=>$loop->iteration, 'token'=>$item->token, 'app_no'=>$item->app_no])
                                                @endif
                                     
                                            @endif
                                        @endif

                                        @if (count($item->DataCertiCbHistory) > 0)
                                            <a class="btn btn-xs btn-warning"  href="{{url('certify/applicant-cb/Log-CB/'.$item->token)}}">
                                                <i class="mdi mdi-magnify"></i>
                                            </a>
                                        @endif
                                     
                                        {{-- @php
                                            dd($item->app_certi_cb_export->certificate_newfile,$item->app_certi_cb_export->status);
                                        @endphp --}}
                                        {{-- @if( !empty($item->app_certi_cb_export->certificate_newfile) && ( ( !empty($item->app_certi_cb_export) && in_array($item->app_certi_cb_export->status, [4]) ) || in_array($item->status, [20]) ) ) --}}
                                        @if( !empty($item->app_certi_cb_export->certificate_newfile) )
                                            <a href="{{ url('funtions/get-view').'/'.@$item->app_certi_cb_export->certificate_path.'/'.@$item->app_certi_cb_export->certificate_newfile.'/'.@$item->app_certi_cb_export->certificate_no.'_'.date('Ymd_hms').'.pdf' }}" target="_blank">
                                                <img src="{{ asset('images/icon-certification.jpg') }}" width="20px" style="margin-top: 4px;">
                                            </a>
                                        @elseif(!empty($item->app_certi_cb_export->attachs) && ( ( !empty($item->app_certi_cb_export) && in_array($item->app_certi_cb_export->status, [4]) ) || in_array($item->status, [20]) ))
                                            <a href="{{ url('certify/check/file_cb_client/'.$item->app_certi_cb_export->attachs.'/'.( !empty($item->app_certi_cb_export->attach_client_name) ? $item->app_certi_cb_export->attach_client_name :  basename($item->app_certi_cb_export->attachs)  )) }}" target="_blank">
                                                {!! HP::FileExtension($item->app_certi_cb_export->attachs)  ?? '' !!}
                                            </a>
                                        @endif

                                    </td>
                                </tr>
                              @endforeach
                            </tbody>
                        </table>

                        <div class="pagination-wrapper">
                          {!!
                              $certiCbs->appends(['search' => Request::get('search'),
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
                window.location.assign("{{url('/certify/applicant-cb')}}");
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

    // agree_doc_review_tream

    


    $('#agree_doc_review_tream').click(function(){
   
        const _token = $('input[name="_token"]').val();
        let certiCbId = $('#certi_cb_id').val();
        
        // ดึงค่าของ radio ที่ถูกเลือก
        let agreeValue = $("input[name='agree']:checked").val();

        // ดึงค่าของ textarea
        let remarkText = $("#remark").val();


        $.ajax({
            url: "{{route('applicant_cb.update_doc_review_team')}}",
            // url: "/certify/applicant/api/test_parameter",
            method: "POST",
            data: {
                certiCbId: certiCbId,
                agreeValue: agreeValue,
                remarkText: remarkText,
                _token: _token
            },
            success: function(result) {
                location.reload();

            }
        });
        
    });

    $('#show_cb_doc_review_auditor').click(function(){
        
        const _token = $('input[name="_token"]').val();
        let certiCbId = $(this).data('cb_id');

        $.ajax({
            url: "{{route('applicant_cb.ge_cb_doc_review_auditor')}}",
            method: "GET",
            data: {
                certiCbId: certiCbId,
                _token: _token
            },
            success: function(result) {
                console.log(result);
                // location.reload();
                let auditors = result.cbDocReviewAuditors;
                let tbody = $('#cb_doc_review_auditor_wrapper tbody');
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
                $('#cb_doc_review_auditor_modal').modal('show');

            }
        });

   
    });

   </script>
@endpush
