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
                    @if ($errors->any())
                        <ul class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                    {!! Form::model($certi_lab, [
                        'method' => 'post',
                        'url' => ['/certify/applicant/assess_update', $certi_lab->token],
                        'class' => 'form-horizontal',
                        'id'=>'app_certi_form',
                        'files' => true
                    ]) !!}
<div class="row">
    <div class="col-md-12">
        <div class="white-box" style="border: 2px solid #e5ebec;">
      <legend><h4>ประวัติบันทึกผลการตรวจประเมิน</h4></legend>
@if(count($certi_lab->LogNotice) > 0) 
    @foreach($certi_lab->LogNoticeTitle as $key => $item)
        

<div class="row">
    <div class="col-md-12">
        <div class="panel block4">
            <div class="panel-group" id="accordion{{ $key +1 }}">
                <div class="panel panel-info">

 <div class="panel-heading">
    <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion{{ $key +1 }}" href="#collapse{{ $key +1 }}"> <dd> บันทึกผลการตรวจประเมิน ครั้งที่ {{ $key +1}}</dd>  </a>
    </h4>
</div>
{{-- {{ (count($certi_lab->LogNoticeTitle) == $key +1 ) ? 'in' : ' '  }} --}}
 <div id="collapse{{ $key +1 }}" class="panel-collapse collapse ">
    <br>
 <div class="container-fluid">

 <div class="form-group">
   <div class="col-md-6">
     <label class="col-md-4 text-right"> เลขคำขอ : </label>
        <div class="col-md-8">
          {!! Form::text('', $item->applicant->app_no ?? null,  ['class' => 'form-control', 'id'=>'appDepart','disabled'=>true])!!}
        </div>
    </div>
     <div class="col-md-6">
         <label class="col-md-4 text-right">หน่วยงาน : </label>
        <div class="col-md-8">
          {!! Form::text('name',   $item->applicant->information->name ?? null,  ['class' => 'form-control', 'id'=>'appDepart','disabled'=>true])!!}
      </div>
    </div>
 </div>
 <div class="form-group">
    <div class="col-md-6">
        <label class="col-md-4 text-right"> ชื่อห้องปฏิบัติการ : </label>
        <div class="col-md-8">
             {!! Form::text('',   $item->applicant->lab_name ?? null,  ['class' => 'form-control', 'id'=>'appDepart','disabled'=>true])!!}
        </div>
    </div>
    <div class="col-md-6">
        <label class="col-md-4 text-right">วันที่ทำรายงาน : </label>
        <div class="col-md-8">
            {!! Form::text('assessment_date',   HP::DateThai($item->assessment_date) ?? null,  ['class' => 'form-control', 'id'=>'appDepart','disabled'=>true])!!}
        </div>
    </div>
</div>


  </div>


  @if(count($item->CertificateHistorys) > 0) 
 @foreach($item->CertificateHistorys as $key1 => $item1)
 {{-- @if(!is_null($item1->date) ||  (count($item->CertificateHistorys) ==  ($key1 +1)) )  --}}

 <div class="row form-group">
     <div class="col-md-12">
        <div class="white-box" style="border: 2px solid #e5ebec;">
   {{-- <legend><h3> ครั้งที่ {{ $key1 +1}} </h3></legend> --}}

   <div class="container-fluid">
    @if(!is_null($item1->details_table))
    @php 
        $details_table = json_decode($item1->details_table);
    @endphp 
     @if(!is_null($details_table))
    <table class="table color-bordered-table primary-bordered-table table-bordered">
        <thead>
            <tr>
                <th class="text-center" width="2%">ลำดับ</th>
                <th class="text-center" width="20%">ผลการประเมินที่พบ</th>
                <th class="text-center" width="10%">ประเภท</th>
                <th class="text-center" width="30%">แนวทางการแก้ไข</th>

                @if($key1 > 0) 
                <th class="text-center" width="28%" >หลักฐาน</th>
                @endif
            </tr>
        </thead>
        <tbody id="table-body">
            @foreach($details_table as $key2 => $item2)
            @php
             $type =   ['1'=>'ข้อบกพร่อง','2'=>'ข้อสังเกต'];
            @endphp
            <tr>
                <td class="text-center">{{ $key2+1 }}</td>
                <td>
                     {{ $item2->remark ?? null }}
                </td>
                <td>
                    {{  array_key_exists($item2->type,$type) ? $type[$item2->type] : '-' }}  
                </td>
                <td>
                    {{ @$item2->details ?? null }}
                    <br>
                    @if($item2->status == 1) 
                      <label for="app_name">ผลแนวทาง : <span> <i class="fa fa-check-square" style="font-size:20px;color:rgb(0, 255, 42)"></i></span> ผ่าน </label> 
                    @elseif(!is_null($item2->comment)) 
                    <label for="app_name"><span>ผลแนวทาง : <i class="fa  fa-close" style="font-size:20px;color:rgb(255, 0, 0)"></i> {{  'ไม่ผ่าน:'.$item2->comment ?? null   }}</span> </label>
                    @endif
                </td>

                @if($key1 > 0) 
                  <td>
                        @if($item2->status == 1) 
                                    @if($item2->file_status == 1)
                                    <span> <i class="fa fa-check-square" style="font-size:20px;color:rgb(0, 255, 42)"></i> ผ่าน</span>  
                                     @elseif(isset($item2->comment_file))
                                            @if(!is_null($item2->comment_file))
                                              <span> <i class="fa  fa-close" style="font-size:20px;color:rgb(255, 0, 0)"></i> ไม่ผ่าน </span> 
                                                  {!!   " : ".$item2->comment_file ?? null  !!}
                                            @endif
 
                                    @endif
                                <label for="app_name">
                                    <span>
                                        @if(!is_null($item2->attachs) && isset($item2->attachs) )
                                            <a href="{{ url('certify/check/files/'.$item2->attachs) }}" title=" {{basename($item2->attachs)}}" target="_blank">
                                                {!! HP::FileExtension($item2->attachs)  ?? '' !!}
                                            </a>
                                         @endif
                                    </span> 
                                </label> 
                        @endif
                 </td>
                @endif
              
            </tr>
            @endforeach 
        </tbody>
    </table>
    @endif

    @if(!is_null($item1->file)) 
    <div class="row">
    <div class="col-md-3 text-right">
        <p class="text-nowrap">รายงานการตรวจประเมิน :</p>
    </div>
    <div class="col-md-9">
        <p>
            <a href="{{url('certify/check/file_client/'.$item1->file.'/'.( !empty($item1->file_client_name) ? $item1->file_client_name : basename($item1->file) ))}}" 
                title=" {{ !empty($item1->file_client_name) ? $item1->file_client_name : basename($item1->file)}}"   target="_blank">
                {!! HP::FileExtension($item1->file)  ?? '' !!}
            </a>
        </p>
    </div>
    </div>
    @endif

    @if(!is_null($item1->attachs)) 
    <div class="row">
    <div class="col-md-3 text-right">
        <p class="text-nowrap">ไฟล์แนบ :</p>
    </div>
    <div class="col-md-9">
            @php 
                $attachs = json_decode($item1->attachs);
            @endphp  
            @foreach($attachs as  $key => $item2)
                <p>
                    <a href="{{url('certify/check/file_client/'.$item2->attachs.'/'.( !empty($item2->attachs_client_name) ? $item2->attachs_client_name :  basename($item2->attachs) ))}}" 
                        title=" {{ !empty($item2->attachs_client_name) ? $item2->attachs_client_name : basename($item2->attachs)}}"   target="_blank">
                        {!! HP::FileExtension($item2->attachs)  ?? '' !!}
                    </a>
               </p>
            @endforeach
    </div>
    </div>
    @endif


    @if(!is_null($item1->date)) 
    <div class="row">
    <div class="col-md-3 text-right">
        <p class="text-nowrap">วันที่บันทึก :</p>
    </div>
    <div class="col-md-9">
        {{ @HP::DateThai($item1->date) ?? '-' }}
    </div>
    </div>
    @endif



  </div>


        </div>
    </div>
</div>

@endif
@endforeach 
 @endif

 </div>
                   
                </div>
            </div>
        </div>
    </div>
</div>
        

    @endforeach
@endif

   
     
     
        {{-- <div class="form-group">
            <div class="col-md-6">
                <label class="col-md-5 text-right"><span class="text-danger">*</span> รายงานข้อบกพร่อง : </label>
                <div class="col-md-7">
                    <div class="row">
                        <label class="col-md-6">
                            {!! Form::radio('report_status', '1', isset($find_notice)  && !empty($find_notice->report_status ==1) ? true:false , ['class'=>'check check-readonly', 'data-radio'=>'iradio_square-green','required'=>'required']) !!}  มี
                        </label>
                        <label class="col-md-6">
                            {!! Form::radio('report_status', '2', isset($find_notice) && !empty($find_notice->report_status ==1) ? false: true, ['class'=>'check check-readonly', 'data-radio'=>'iradio_square-red','required'=>'required']) !!} ไม่มี
                        </label>
                    </div>
                </div>
            </div>
        </div> --}}

        </div>
    </div>
</div>


@if(!is_null($find_notice) && $find_notice->step == 1 )
<div class="row">
    <div class="col-md-12">
        <div class="white-box" style="border: 2px solid #e5ebec;">
      <legend><h4>บันทึกการแก้ไขข้อบกพร่อง / ข้อสังเกต</h4></legend>

       <div class="row">
            <div class="col-sm-12 m-t-15" v-if="isTable">
                <table class="table color-bordered-table primary-bordered-table">
                    <thead>
                    <tr>
                        <th class="text-center" width="2%">ลำดับ</th>
                        <th class="text-center" width="48%">ผลการประเมินที่พบ</th>
                        <th class="text-center" width="10%">ประเภท</th>
                        <th class="text-center" width="48%" >แนวทางการแก้ไข</th>
                    </tr>
                    </thead>
                    <tbody id="table-body">
                        @if(count($find_notice->items) > 0)
                        @foreach($find_notice->items as $key => $item)
                        @php
                            $type =   ['1'=>'ข้อบกพร่อง','2'=>'ข้อสังเกต'];
                        @endphp
                        <tr>
                            <td class="text-center">
                                {{$key+1}}
                            </td>
                            <td>
                                {!! Form::hidden('id[]',!empty($item->id)?$item->id:null, ['class' => 'form-control'])  !!}
                                {!! Form::text('notice[]', $item->remark ?? null,  ['class' => 'form-control','disabled'=>true])!!}
                            </td>
                            <td>
                                {!! Form::text('type[]',  $type[$item->type] ?? null,  ['class' => 'form-control','disabled'=>true])!!}
                            </td>
                            <td>
                                {!! Form::textarea('details[]', null, [ 'class' => 'form-control','rows' => 1,'cols'=>'40','required'=>true]) !!}
                            </td>
                         </tr>
                           @endforeach
                          @endif
                         </tbody>
                        </table>
                    </div>
                </div>



         </div>
    </div>
</div>
<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        <button class="btn btn-primary" type="submit"  onclick="submit_form();return false">
           <i class="fa fa-paper-plane"></i> บันทึก
        </button>
        <a class="btn btn-default" href="{{url('/certify/applicant')}}">
            <i class="fa fa-rotate-left"></i> ยกเลิก
         </a>
    </div>
 </div>
@elseif(!is_null($find_notice) && ($find_notice->step == 3 || $find_notice->status == 4))


<div class="row">
    <div class="col-md-12">
        <div class="white-box" style="border: 2px solid #e5ebec;">
      <legend><h4>บันทึกการแก้ไขข้อบกพร่อง / ข้อสังเกต</h4></legend>
            @if(count($find_notice->items) > 0)

                    <table class="table color-bordered-table primary-bordered-table">
                        <thead>
                            <tr>
                                <th class="text-center" width="2%">ลำดับ</th>
                                <th class="text-center" width="30%">ผลการประเมินที่พบ</th>
                                <th class="text-center" width="20%">ประเภท</th>
                                <th class="text-center" width="20%">ผลการประเมิน</th>
                                <th class="text-center" width="36%" >แนวทางการแก้ไข/หลักฐาน</th>
                            </tr>
                        </thead>
                        <tbody id="table-body">
                            @foreach($find_notice->items as $key => $item)
                            @php
                                $type =   ['1'=>'ข้อบกพร่อง','2'=>'ข้อสังเกต'];
                            @endphp
                            <tr>
                                <td class="text-center">
                                    {{$key+1}}
                                </td>
                                <td>
                                    {!! Form::hidden('id[]',!empty($item->id)?$item->id:null, ['class' => 'form-control'])  !!}
                                    {!! Form::text('notice[]', $item->remark ?? null,  ['class' => 'form-control','disabled'=>true])!!}
                                </td>
                                <td>
                                    {!! Form::text('type[]',   array_key_exists($item->type,$type) ? $type[$item->type] :  null,  ['class' => 'form-control','disabled'=>true])!!}
                                </td>
                                <td>  
                                      {{ $item->details ?? null }}    <br>
                                      @if($item->status == 1) 
                                            <label for="app_name">ผลแนวทาง : <span> <i class="fa fa-check-square" style="font-size:20px;color:rgb(0, 255, 42)"></i> </span> </label> 
                                       @else 
                                            <label for="app_name">ผลแนวทาง : <span>  <i class="fa  fa-close" style="font-size:20px;color:rgb(255, 0, 0)"></i> {{  $item->comment ?? null   }}</span> </label>
                                       @endif
                           
                                </td>
                                <td>
      
                                         @if($item->status == 1) 
                                                 @if(!is_null($item->comment_file)) 
                                                 <label for="app_name">หลักฐาน :  <i class="fa  fa-close" style="font-size:20px;color:rgb(255, 0, 0)"></i>   {!!   $item->comment_file ?? null  !!} </label> 
                                                 @endif
                                                @if($item->file_status != 1) 
									
												 @php
													$required = ($item->type==2)?"":"required";
												@endphp
												
                                                <div class="fileinput fileinput-new input-group " data-provides="fileinput">
                                                    <div class="form-control" data-trigger="fileinput">
                                                        <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                                        <span class="fileinput-filename"></span>
                                                    </div>
                                                    <span class="input-group-addon btn btn-default btn-file">
                                                        <span class="fileinput-new">เลือกไฟล์</span>
                                                        <span class="fileinput-exists">เปลี่ยน</span>
                                                        <input type="file" name="attachs[{{$key}}]" {{ $required }}  class="  check_max_size_file">
                                                    </span>
                                                    <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
                                                </div>
                                                @else 
                                                   <label for="app_name">หลักฐาน : 
                                                     <span>
                                                        @if(!is_null($item->attachs) && isset($item->attachs) )
                                                        <i class="fa fa-check-square" style="font-size:20px;color:rgb(0, 255, 42)"></i> 
                                                        <a href="{{ url('certify/check/files/'.$item->attachs) }}" title=" {{basename($item->attachs)}}" target="_blank">
                                                            {!! HP::FileExtension($item->attachs)  ?? '' !!}
                                                            </a>
                                                        @endif
                                                     </span> 
                                                  </label> 
                                                @endif
                                        @else 
                                             {!! Form::textarea('details['.$key.']', null, [ 'rows' => 1,'cols'=>'40','required'=>true]) !!}
                                        @endif
                                    
                                
                                </td>
                             </tr>
                               @endforeach
                        </tbody>
                    </table>
     
            @endif
        </div>
    </div>
</div>
  <div class="form-group">
    <div class="col-md-offset-4 col-md-4">
            <button class="btn btn-primary" type="submit"  onclick="submit_form();return false">
            <i class="fa fa-paper-plane"></i> บันทึก
            </button>
                <a class="btn btn-default" href="{{url('/certify/applicant')}}">
                    <i class="fa fa-rotate-left"></i> ยกเลิก
                </a>
      </div>
  </div>

@else 
    <a  href="{{ url("certify/applicant") }}">
        <div class="alert alert-dark text-center" role="alert">
            <i class="icon-arrow-left-circle"></i>
            <b>กลับ</b>
        </div>
    </a>
@endif

                    {!! Form::close() !!}
                </div>
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
     <script src="{{asset('plugins/components/sweet-alert2/sweetalert2.all.min.js')}}"></script>
     <script type="text/javascript">
        jQuery(document).ready(function() {
                    $('.check-readonly').prop('disabled', true);//checkbox ความคิดเห็น
                    $('.check-readonly').parent().removeClass('disabled');
                    $('.check-readonly').parent().css('margin-top', '8px');//checkbox ความคิดเห็น

            //เพิ่มไฟล์แนบ
            $('#attach-add').click(function(event) {
                $('.other_attach_item:first').clone().appendTo('#other_attach-box');
                $('.other_attach_item:last').find('input').val('');
                $('.other_attach_item:last').find('a.fileinput-exists').click();
                $('.other_attach_item:last').find('a.view-attach').remove();
                $('.other_attach_item:last').find('.label_other_attach').remove();
                $('.other_attach_item:last').find('button.attach-add').remove();
                $('.other_attach_item:last').find('.button_remove').html('<button class="btn btn-danger btn-sm attach-remove" type="button"> <i class="icon-close"></i>  </button>');
            });

            //ลบไฟล์แนบ
            $('body').on('click', '.attach-remove', function(event) {
                $(this).parent().parent().parent().remove();
            });

            //เพิ่มไฟล์แนบ
            $('#attach-add1').click(function(event) {
                $('.other_attach_item1:first').clone().appendTo('#other_attach-box1');
                $('.other_attach_item1:last').find('input').val('');
                $('.other_attach_item1:last').find('a.fileinput-exists').click();
                $('.other_attach_item1:last').find('a.view-attach').remove();
                $('.other_attach_item1:last').find('.label_other_attach1').remove();
                $('.other_attach_item1:last').find('button.attach-add1').remove();
                $('.other_attach_item1:last').find('.button_remove1').html('<button class="btn btn-danger btn-sm attach-remove1" type="button"> <i class="icon-close"></i>  </button>');
            });

            //ลบไฟล์แนบ
            $('body').on('click', '.attach-remove1', function(event) {
                $(this).parent().parent().parent().remove();
            });
        });

        function submit_form() {
            Swal.fire({
                    title: 'ยืนยันการทำรายการ !',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'บันทึก',
                    cancelButtonText: 'ยกเลิก'
                    }).then((result) => {
                        if (result.value) {
                            $('#app_certi_form').submit();
                        }
                    })
            }
    </script>
           <script type="text/javascript">
            jQuery(document).ready(function() {
                   //Validate
                   $('#app_certi_form').parsley().on('field:validated', function() {
                            var ok = $('.parsley-error').length === 0;
                            $('.bs-callout-info').toggleClass('hidden', !ok);
                            $('.bs-callout-warning').toggleClass('hidden', ok);
                            })
                            .on('form:submit', function() {
                                // Text
                                $.LoadingOverlay("show", {
                                    image       : "",
                                    text        : "กำลังบันทึก กรุณารอสักครู่..."
                                });
                            return true; // Don't submit form for this demo
                 });
                });
        </script>
    
  @endpush
