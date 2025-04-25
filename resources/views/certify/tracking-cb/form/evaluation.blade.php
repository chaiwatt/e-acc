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
           <h3 class="box-title pull-left">ใบรับรองระบบงาน (CB)  </h3>

                <a class="btn btn-danger text-white pull-right" href="{{ app('url')->previous()}}">
                        <i class="icon-arrow-left-circle"></i> กลับ
                </a>
                {{--  --}}
                <div class="clearfix"></div>
                <hr>  
  
                
  
@if(count($evaluation->history_cb_many) > 0)               
<div class="row">
    <div class="col-md-12">
        <div class="white-box" style="border: 2px solid #e5ebec;">
    <legend><h3>ข้อบกพร่อง/ข้อสังเกต</h3></legend>                

<div class="row">
    <div class="col-md-12">
        <div class="panel block4">
            <div class="panel-group" id="accordion">
                <div class="panel panel-info">

 <div class="panel-heading">
    <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapse"> <dd> ข้อบกพร่อง/ข้อสังเกต</dd>  </a>
    </h4>
</div>
<div id="collapse" class="panel-collapse collapse ">
    <br>
 <div class="container-fluid">
@foreach($evaluation->history_cb_many as $key1 => $item)

<div class="row form-group">
    <div class="col-md-12">
        <div class="white-box" style="border: 2px solid #e5ebec;">
      
    @if(!is_null($item->details_two))
    @php 
        $details_two = json_decode($item->details_two);
    @endphp 
  
@if(!is_null($details_two))
    <table class="table color-bordered-table primary-bordered-table table-bordered">
        <thead>
            <tr>
                <th class="text-center" width="2%">ลำดับ</th>
                <th class="text-center" width="15%">รายงานที่</th>
                <th class="text-center" width="15%">ผลการประเมินที่พบ</th>
                <th class="text-center" width="15%">  มอก. 17025 : ข้อ  </th>
                <th class="text-center" width="10%">ประเภท</th>
                <th class="text-center" width="20%">แนวทางการแก้ไข</th>
                @if($key1 > 0) 
                <th class="text-center" width="25%" >หลักฐาน</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach($details_two as $key2 => $item2)
            @php
             $type =   ['1'=>'ข้อบกพร่อง','2'=>'ข้อสังเกต'];
            @endphp
            <tr>
                <td class="text-center">{{ $key2+ 1 }}</td>
                <td>
                    {{ $item2->report ?? null }}
                </td>
                <td>
                     {{ $item2->remark ?? null }}
                </td>
                <td>
                    {{ $item2->no ?? null }}
                </td>
                <td>
                    {{  array_key_exists($item2->type,$type) ? $type[$item2->type] : '-' }}  
                </td>
              
                <td>
                    {{ @$item2->details ?? null }}
                    <br>
                    @if($item2->status == 1) 
                      <label for="app_name"> <span> <i class="fa fa-check-square" style="font-size:20px;color:rgb(0, 255, 42)"></i></span> ผ่าน </label> 
                    @elseif(!is_null($item2->comment)) 
                    <label for="app_name"><span>  <i class="fa  fa-close" style="font-size:20px;color:rgb(255, 0, 0)"></i> {{  'ไม่ผ่าน:'.$item2->comment ?? null   }}</span> </label> 
                   @endif
                </td>
                @if($key1 > 0) 
                  <td>
                         @if($item2->status == 1) 
                                     @if($item2->file_status == 1)
                                              <span> <i class="fa fa-check-square" style="font-size:20px;color:rgb(0, 255, 42)"></i> ผ่าน</span>  
                                     @elseif(isset($item2->file_comment))
                                            @if(!is_null($item2->file_comment))
                                              <span> <i class="fa  fa-close" style="font-size:20px;color:rgb(255, 0, 0)"></i> ไม่ผ่าน </span> 
                                              {!!   " : ".$item2->file_comment ?? null  !!}
                                            @endif
                                    @endif
                                <label for="app_name">
                                    <span>
                                        @if(!empty($item2->attachs))
                                            @php 
                                                $attachs =  $item2->attachs;
                                            @endphp 
                                             @if (!is_null($attachs))
                                                <a href="{{url('funtions/get-view/'.$attachs->url.'/'.( !empty($attachs->filename) ? $attachs->filename :  basename($attachs->url) ))}}" 
                                                    title="{{ !empty($attachs->filename) ? $attachs->filename :  basename($attachs->url) }}" target="_blank">
                                                    {!! HP::FileExtension($attachs->url)  ?? '' !!}
                                                </a>
                                           @endif 
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
 @endif


 @if(!is_null($item->details_three)) 
 @php
      $details_three = json_decode($item->details_three);    
 @endphp
  @if(!is_null($details_three)) 
 <div class="row">
 <div class="col-md-3 text-right">
     <p class="text-nowrap">รายงานการตรวจประเมิน :</p>
 </div>
 <div class="col-md-9">
          <p>
          <a href="{{url('funtions/get-view/'.$details_three->url.'/'.( !empty($details_three->filename) ? $details_three->filename :  basename($details_three->url) ))}}" 
                    title="{{ !empty($details_three->filename) ? $details_three->filename :  basename($details_three->url) }}" target="_blank">
                    {!! HP::FileExtension($details_three->url)  ?? '' !!}
          </a>
          </p>
 </div>
 </div>
 @endif
 @endif

 @if(!is_null($item->file)) 
@php 
          $files = json_decode($item->file);
@endphp  
@if(!is_null($files)) 
 <div class="row">
 <div class="col-md-3 text-right">
     <p class="text-nowrap">ไฟล์แนบ :</p>
 </div>
 <div class="col-md-9">

         @foreach($files as  $key => $item2)
                    <a href="{{url('funtions/get-view/'.$item2->url.'/'.( !empty($item2->filename) ? $item2->filename :  basename($item2->url) ))}}" 
                              title="{{ !empty($item2->filename) ? $item2->filename :  basename($item2->url) }}" target="_blank">
                              {!! HP::FileExtension($item2->url)  ?? '' !!}
                    </a>
         @endforeach
 </div>
 </div>
 @endif
 @endif

 @if(!is_null($item->created_at)) 
 <div class="row">
 <div class="col-md-3 text-right">
     <p class="text-nowrap">วันที่เจ้าหน้าที่บันทึก :</p>
 </div>
 <div class="col-md-9">
     {{ @HP::DateThai($item->created_at) ?? '-' }}
 </div>
 </div>
 @endif

 @if(!is_null($item->date)) 
 <div class="row">
 <div class="col-md-3 text-right">
     <p class="text-nowrap">วันที่ผู้ประกอบการบันทึก :</p>
 </div>
 <div class="col-md-9">
     {{ @HP::DateThai($item->date) ?? '-' }}
 </div>
 </div>
 @endif

        </div>
    </div>
 </div>   
 
 @endforeach  

    </div>
</div>
                </div>
            </div>
        </div>
    </div>
</div>

       </div>
    </div>
</div>
@endif



@if(count($evaluation->log_tracking_cb_assessment_bug_many) > 0) 
<div class="row">
    <div class="col-md-12">
        <div class="white-box" style="border: 2px solid #e5ebec;">
    <legend><h3>ผลการตรวจประเมิน</h3></legend>    
<div class="row">
    <div class="col-md-12">
        <div class="panel block4">
            <div class="panel-group" id="accordion">
            <div class="panel panel-info">
  
 <div class="panel-heading">
    <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#evaluation"> <dd> ประวัติบันทึกผลการตรวจประเมิน</dd>  </a>
    </h4>
</div>

 <div id="evaluation" class="panel-collapse collapse  in">
    <br> 
@foreach($evaluation->log_tracking_cb_assessment_bug_many as $key1 => $item1)

<div class="row form-group">
    <div class="col-md-12">
       <div class="white-box" style="border: 2px solid #e5ebec;">
 

<div class="container-fluid">

 @if(!is_null($item1->details_one))
@php 
    $details_one = json_decode($item1->details_one);
@endphp 
@if(!is_null($details_one))

@php 
    $auditors = App\Models\Certificate\TrackingAuditors::where('id',$details_one->auditors_id)->first();
@endphp 
@if(!is_null($auditors))
<div class="row form-group">
    <div class="col-md-12">
        <div class=" {{ $errors->has('name') ? 'has-error' : ''}}">
            {!! HTML::decode(Form::label('name',' เลขคำขอ'.' :', ['class' => 'col-md-3 control-label text-right'])) !!}
            <div class="col-md-7">
                {!! Form::text('', (!empty($auditors->reference_refno) ? $auditors->reference_refno : null), [ 'class' => 'form-control',  'disabled' => true]); !!}
            </div>
        </div>
    </div>
</div>
<div class="row form-group">
    <div class="col-md-12">
        <div class=" {{ $errors->has('name') ? 'has-error' : ''}}">
            {!! HTML::decode(Form::label('name','ชื่อผู้ยื่นคำขอ'.' :', ['class' => 'col-md-3 control-label text-right'])) !!}
            <div class="col-md-7">
                {!! Form::text('', (!empty($details_one->name) ? $details_one->name : null), [ 'class' => 'form-control',  'disabled' => true]); !!}
            </div>
        </div>
    </div>
</div>
<div class="row form-group">
    <div class="col-md-12">
        <div class=" {{ $errors->has('name') ? 'has-error' : ''}}">
            {!! HTML::decode(Form::label('name','ชื่อหน่วยรับรอง'.' :', ['class' => 'col-md-3 control-label text-right'])) !!}
            <div class="col-md-7">
                {!! Form::text('', (!empty($details_one->laboratory_name) ? $details_one->laboratory_name : null), [ 'class' => 'form-control',  'disabled' => true]); !!}
            </div>
        </div>
    </div>
</div>
<div class="row form-group">
    <div class="col-md-12">
        <div class=" {{ $errors->has('name') ? 'has-error' : ''}}">
            {!! HTML::decode(Form::label('name','ชื่อคณะผู้ตรวจประเมิน'.' :', ['class' => 'col-md-3 control-label text-right'])) !!}
            <div class="col-md-7">
                {!! Form::text('', (!empty($auditors->auditor) ? $auditors->auditor : null), [ 'class' => 'form-control',  'disabled' => true]); !!}
            </div>
        </div>
    </div>
</div>
<div class="row form-group">
    <div class="col-md-12">
        <div class=" {{ $errors->has('name') ? 'has-error' : ''}}">
            {!! HTML::decode(Form::label('name','วันที่ตรวจประเมิน'.' :', ['class' => 'col-md-3 control-label text-right'])) !!}
            <div class="col-md-7">
                {!! Form::text('', (!empty($auditors->CertiAuditorsDateTitle) ? $auditors->CertiAuditorsDateTitle : null), [ 'class' => 'form-control',  'disabled' => true]); !!}
            </div>
        </div>
    </div>
</div>

@if (!empty($auditors->FileAuditors2))
@php 
    $file = $auditors->FileAuditors2;
@endphp 
<div class="row form-group">
    <div class="col-md-12">
        <div class=" {{ $errors->has('name') ? 'has-error' : ''}}">
            {!! HTML::decode(Form::label('name','กำหนดการตรวจประเมิน'.' :', ['class' => 'col-md-3 control-label text-right'])) !!}
            <div class="col-md-7">
                <a href="{{url('funtions/get-view/'.$file->url.'/'.( !empty($file->filename) ? $file->filename :  basename($file->url) ))}}" 
                    title="{{ !empty($file->filename) ? $file->filename :  basename($file->url) }}" target="_blank">
                    {!! HP::FileExtension($file->url)  ?? '' !!}
                 </a>
            </div>
        </div>
    </div>
</div> 
@endif

@endif

<hr/>
<div class="row form-group">
    <div class="col-md-12">
        <div class=" {{ $errors->has('name') ? 'has-error' : ''}}">
            {!! HTML::decode(Form::label('name','รายงานข้อบกพร่อง'.' :', ['class' => 'col-md-3 control-label text-right'])) !!}
            <div class="col-md-7">
                <label>{!! Form::radio('', '1', false , ['class'=>'check check-readonly', 'data-radio'=>'iradio_square-green']) !!} &nbsp;มี &nbsp;</label>
                <label>{!! Form::radio('', '2',true , ['class'=>'check check-readonly', 'data-radio'=>'iradio_square-red']) !!} &nbsp;ไม่มี &nbsp;</label>
            </div>
        </div>
    </div>
</div>
<div class="row form-group">
    <div class="col-md-12">
        <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
            {!! HTML::decode(Form::label('name',' วันที่ทำรายงาน'.' :', ['class' => 'col-md-3 control-label text-right'])) !!}
            <div class="col-md-7">
                {!! Form::text('', (!empty($details_one->report_date) ? HP::DateThai($details_one->report_date) : null), [ 'class' => 'form-control',  'disabled' => true]); !!}
            </div>
        </div>
    </div>
</div>

@if(!is_null($item1->details_three))
@php 
  $details_three = json_decode($item1->details_three);
@endphp 
@if(!is_null($details_three))
<div class="row form-group">
    <div class="col-md-12">
        <div class=" {{ $errors->has('name') ? 'has-error' : ''}}">
            {!! HTML::decode(Form::label('name',' รายงานการตรวจประเมิน'.' :', ['class' => 'col-md-3 control-label text-right'])) !!}
            <div class="col-md-7">
                    <a href="{{url('funtions/get-view/'.$details_three->url.'/'.( !empty($details_three->filename) ? $details_three->filename :  basename($details_three->url) ))}}" 
                              title="{{ !empty($details_three->filename) ? $details_three->filename :  basename($details_three->url) }}" target="_blank">
                              {!! HP::FileExtension($details_three->url)  ?? '' !!}
                    </a>
            </div>
        </div>
    </div>
</div>
@endif
@endif

@if(!is_null($item1->attachs_car))
@php 
  $attachs_car = json_decode($item1->attachs_car);
@endphp 
@if(!is_null($attachs_car))
<div class="row form-group">
    <div class="col-md-12">
        <div class=" {{ $errors->has('name') ? 'has-error' : ''}}">
            {!! HTML::decode(Form::label('name','รายงานปิด Car '.' :', ['class' => 'col-md-3 control-label text-right'])) !!}
            <div class="col-md-7">
                    <a href="{{url('funtions/get-view/'.$attachs_car->url.'/'.( !empty($attachs_car->filename) ? $attachs_car->filename :  basename($attachs_car->url) ))}}" 
                              title="{{ !empty($attachs_car->filename) ? $attachs_car->filename :  basename($attachs_car->url) }}" target="_blank">
                              {!! HP::FileExtension($attachs_car->url)  ?? '' !!}
                    </a>
            </div>
        </div>
    </div>
</div>
@endif
@endif

@if(!is_null($item1->file))
@php 
  $files = json_decode($item1->file);
@endphp 
@if(!is_null($files) && count($files) > 0)
<div class="row form-group">
    <div class="col-md-12">
        <div class=" {{ $errors->has('name') ? 'has-error' : ''}}">
            {!! HTML::decode(Form::label('name','ไฟล์แนบ '.' :', ['class' => 'col-md-3 control-label text-right'])) !!}
            <div class="col-md-7">
                    @foreach($files as  $key => $item2)
                        <a href="{{url('funtions/get-view/'.$item2->url.'/'.( !empty($item2->filename) ? $item2->filename :  basename($item2->url) ))}}" 
                                title="{{ !empty($item2->filename) ? $item2->filename :  basename($item2->url) }}" target="_blank">
                                {!! HP::FileExtension($item2->url)  ?? '' !!}
                        </a>
                    @endforeach
            
            </div>
        </div>
    </div>
</div>
@endif
@endif

@endif
@endif
 
 

</div>

        </div>
    </div>
</div>
 
@endforeach




</div>             
              </div>
           </div>
        </div>
    </div>
</div>


       </div>
    </div>
</div>
@endif


 {{-- {!! Form::open(['url' => 'certify/tracking-cb/evaluation/update/'.$evaluation->id,
                'class' => 'form-horizontal',
                'id'=>'form_auditor', 
                'method' => 'POST',
                'files' => true])
 !!}
@if($evaluation->degree == 4 || $evaluation->degree == 6)
<div class="row">
    <div class="col-md-12">
        <div class="white-box" style="border: 2px solid #e5ebec;">
    <legend><h3>เหตุผล / หมายเหตุ ขอแก้ไข</h3></legend>
    <div class="container-fluid">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-3 text-right">
                     <p class="text-nowrap">ผลการตรวจประเมิน   </p>
                </div>
                <div class="col-md-9">
                        <label>{!! Form::radio('status_scope', '1', true, ['class'=>'check', 'data-radio'=>'iradio_square-green']) !!} &nbsp;ยืนยันผลการตรวจประเมิน &nbsp;</label>
                        <label>{!! Form::radio('status_scope', '2', false, ['class'=>'check', 'data-radio'=>'iradio_square-red']) !!} &nbsp;แก้ไขผลการตรวจประเมิน &nbsp;</label>
                </div>
            </div>
            <div  style="display: none" id="DivStatusScope">
                <div class="row">
                    <div class="col-md-3"></div>
                     <div class="col-md-7">
                        <label for="details">หมายเหตุ :</label>
                         <textarea name="details" id="details" cols="30" rows="3" class="form-control"></textarea>
                    </div>
                    <div class="col-md-2"></div>
                </div>
                 <div class="row m-t-20">
                    <div class="col-md-3"></div>
                    <div class="col-md-7">
                           {!! Form::label('attach_files', 'ไฟล์แนบ (ถ้ามี):', ['class' => 'm-t-5']) !!}
                               <button type="button" class="btn btn-sm btn-success m-l-10 attach_add_scope" id="attach_add_scope">
                                     <i class="icon-plus"></i>&nbsp;เพิ่ม
                                 </button>
                                   
                                 <div id="modal_attach_box">
                                      <div class="form-group attach_item">
                                        <div class="col-md-5">
                                             {!! Form::text('file_desc_text[]', null, ['class' => 'form-control m-t-10', 'placeholder' => 'ชื่อไฟล์']) !!}
                                        </div>
                                        <div class="col-md-6">
                                             <div class="fileinput fileinput-new input-group m-t-10" data-provides="fileinput">
                                                    <div class="form-control" data-trigger="fileinput">
                                                        <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                                        <span class="fileinput-filename"></span>
                                                    </div>
                                                    <span class="input-group-addon btn btn-default btn-file">
                                                        <span class="fileinput-new">เลือกไฟล์</span>
                                                        <span class="fileinput-exists">เปลี่ยน</span>
                                                         <input type="file" name="attach_files[]" class="  check_max_size_file">
                                                     </span>
                                                    <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
                                            </div>
                                        </div>
                                        <div class="col-md-1 text-left m-t-15" style="margin-top: 3px">
                                            <button class="btn btn-danger btn-sm attach_remove_scope" type="button" >
                                                <i class="icon-close"></i>
                                            </button>
                                        </div>
                                    </div>
                                 </div>
                        <div class="col-md-2"></div>
                    </div>
                </div>
            </div>

        <div class="col-md-12">
            <div class="row">
                 <div class="col-md-3 text-right">
                         <p class="text-nowrap">วันที่บันทึก</p>
                  </div>
                    <div class="col-md-9" >
                        {{ HP::DateThai(date('Y-m-d')) }}
                   </div>
             </div>
         </div>

         </div>
        </div>
     </div>
    </div>
</div>

<div class="row">
    <div class="form-group">
        <div class="col-md-offset-5 col-md-6">
                <button class="btn btn-primary" type="submit"  onclick="submit_form();return false">
                <i class="fa fa-paper-plane"></i> บันทึก
                </button>
                    <a class="btn btn-default" href="{{ app('url')->previous()}}">
                        <i class="fa fa-rotate-left"></i> ยกเลิก
                    </a>
        </div>
    </div>
</div> 


@else  --}}
<a  href="{{  app('url')->previous() }}">
    <div class="alert alert-dark text-center" role="alert">
        <i class="fa fa-close"></i>
        <b>กลับ</b>
    </div>
</a>

{{-- @endif
{!! Form::close() !!}    --}}


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
        $('.check-readonly').parent().css({"background-color": "rgb(238, 238, 238);","border-radius":"50%", "cursor": "not-allowed"});

        $(".attach_add_scope").unbind();
    $('.attach_add_scope').click(function(event) {
        var box = $(this).next();
        box.find('.attach_item:first').clone().appendTo('#modal_attach_box');
        box.find('.attach_item:last').find('input').val('');
        box.find('.attach_item:last').find('a.fileinput-exists').click();
        box.find('.attach_item:last').find('a.view-attach').remove();

        ShowHideRemoveBtnScope(box);

    });
          //ลบไฟล์แนบ
    $('body').on('click', '.attach_remove_scope', function(event) {
        var box = $(this).parent().parent().parent().parent();
        $(this).parent().parent().remove();
        ShowHideRemoveBtnScope(box);
     
    });
    $('.attach_add_scope').each(function(index,eve){
        var box = $(eve).next();
        ShowHideRemoveBtnScope(box);
    });

    $("input[name=status_scope]").on("ifChanged",function(){
         status_status_scope();
    });
    status_status_scope();

});

function status_status_scope(){
         var row = $("input[name=status_scope]:checked").val();
         $('#DivStatusScope').hide();
    if(row == "2"){
        $('#DivStatusScope').fadeIn();
      }else{
        $('#DivStatusScope').hide();
      }
  }
  
function ShowHideRemoveBtnScope(box) { //ซ่อน-แสดงปุ่มลบ
    if (box.find('.attach_item').length > 1) {
        box.find('.attach_remove_scope').show();
    } else {
        box.find('.attach_remove_scope').hide();
    }
}
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
                    $('#form_auditor').submit();
                }
            })
    }
    jQuery(document).ready(function() {
    $('#form_auditor').parsley().on('field:validated', function() {
                        var ok = $('.parsley-error').length === 0;
                        $('.bs-callout-info').toggleClass('hidden', !ok);
                        $('.bs-callout-warning').toggleClass('hidden', ok);
         }) 
         .on('form:submit', function() {
                            // Text
                            $.LoadingOverlay("show", {
                            image       : "",
                            text  : "กำลังบันทึก กรุณารอสักครู่..."
                            });
                        return true; // Don't submit form for this demo
          });
     });
</script>
@endpush
