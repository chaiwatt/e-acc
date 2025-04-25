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
           <h3 class="box-title pull-left">ใบรับรองระบบงาน (IB)  </h3>

                <a class="btn btn-danger text-white pull-right" href="{{  app('url')->previous()  }}">
                        <i class="icon-arrow-left-circle"></i> กลับ
                </a>

                <div class="clearfix"></div>
                <hr>     


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
@foreach($assessment->history_ib_many as $key1 => $item)

<div class="row form-group">
    <div class="col-md-12">
        <div class="white-box" style="border: 2px solid #e5ebec;">
 
    @if(!is_null($item->details_two))
    @php 
        $details_two = json_decode($item->details_two);
    @endphp 
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
     @if (!is_null($details_two))
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
        @endif
        </tbody>
       </table>
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




 {!! Form::open(['url' => 'certify/tracking-ib/assessment/update/'.$assessment->id,
                'class' => 'form-horizontal',
                'id'=>'form_auditor', 
                'method' => 'POST',
                'files' => true])
 !!}
<div id="box-readonly">
@if($assessment->degree == 1)
 <div class="row form-group">
    <div class="col-md-12">
       <div class="white-box" style="border: 2px solid #e5ebec;">
  <legend><h3>   แก้ไขข้อบกพร่อง/ข้อสังเกต   </h3></legend>

<div class="container-fluid">
        <table class="table color-bordered-table primary-bordered-table table-bordered">
        <thead>
            <tr>
                <th class="text-center" width="2%">ลำดับ</th>
                <th class="text-center" width="40%">ผลการประเมินที่พบ</th>
                <th class="text-center" width="58%">แนวทางการแก้ไข</th>  
            </tr>
        </thead>
        <tbody id="table-body">
            @foreach($assessment->tracking_assessment_bug_many as $key => $item)
            <tr>
                <td class="text-center">{{ $key+1 }}</td>
                <td>
                    {!! Form::hidden('detail[id][]',!empty($item->id)?$item->id:null, ['class' => 'form-control '])  !!}
                    {{ $item->remark ?? null }}
               </td>
                <td>
                    {!! Form::textarea('detail[details][]',!empty($item->details)?$item->details:null, [ 'class' => 'form-control','rows' => 3,'required'=>true]) !!} 
                </td>
            </tr>
           @endforeach 
        </tbody>
    </table>
</div>

        </div>
    </div>
</div>
@elseif($assessment->degree == 3)
<div class="row">
    <div class="col-md-12">
        <div class="white-box" style="border: 2px solid #e5ebec;">
      <legend><h4>บันทึกการแก้ไขข้อบกพร่อง / ข้อสังเกต</h4></legend>
            @if(count($assessment->tracking_assessment_bug_many) > 0)

                    <table class="table color-bordered-table primary-bordered-table">
                        <thead>
                            <tr>
                                <th class="text-center" width="2%">ลำดับ</th>
                                <th class="text-center" width="30%">ผลการประเมินที่พบ</th>
                                <th class="text-center" width="20%">ผลการประเมิน</th>
                                <th class="text-center" width="46%" >แนวทางการแก้ไข/หลักฐาน</th>
                            </tr>
                        </thead>
                        <tbody id="table-body">
                            @foreach($assessment->tracking_assessment_bug_many as $key => $item)
                            @php
                                $type =   ['1'=>'ข้อบกพร่อง','2'=>'ข้อสังเกต'];
                            @endphp
                            <tr>
                                <td class="text-center">
                                    {{$key+1}}
                                </td>
                                <td>
                                    {!! Form::hidden('detail[id][]',!empty($item->id)?$item->id:null, ['class' => 'form-control '])  !!}
                                    {!! Form::text('notice[]', $item->remark ?? null,  ['class' => 'form-control','disabled'=>true])!!}
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
                                                 @if(!is_null($item->file_comment)) 
                                                        <label for="app_name">หลักฐาน :  <i class="fa  fa-close" style="font-size:20px;color:rgb(255, 0, 0)"></i>   {!!   $item->file_comment ?? null  !!} </label> 
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
                                                            <input type="file" name="attachs[{{$key}}]"  {{ $required }} class="check_max_size_file">
                                                        </span>
                                                        <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
                                                    </div>
                                                @else 
                                                   <label for="app_name">หลักฐาน : 
                                                     <span>
                                                        @if(!empty($item->FileAttachAssessmentBugTo->url))
                                                        <i class="fa fa-check-square" style="font-size:20px;color:rgb(0, 255, 42)"></i> 
                                                              <a href="{{url('funtions/get-view/'.$item->FileAttachAssessmentBugTo->url.'/'.( !empty($item->filename) ? $item->attach_client_name :   basename($item->FileAttachAssessmentBugTo->url) ))}}" 
                                                                        title="{{ !empty($item->FileAttachAssessmentBugTo->filename) ? $item->FileAttachAssessmentBugTo->filename :  basename($item->FileAttachAssessmentBugTo->url) }}" target="_blank">
                                                                       {!! HP::FileExtension($item->FileAttachAssessmentBugTo->url)  ?? '' !!}
                                                            </a>
                                                        @endif
                                                     </span> 
                                                  </label> 
                                                @endif
                                        @else 
                                             {!! Form::textarea('detail[details]['.$key.']',null , ['class' => 'form-control', 'rows' => 1,'cols'=>'40','required'=>true]) !!}
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
@endif
</div>

@if(in_array($assessment->degree,[1,3,4,6]))
<div class="row">
    <div class="form-group">
        <div class="col-md-offset-5 col-md-6">
                <button class="btn btn-primary" type="submit"  onclick="submit_form();return false">
                <i class="fa fa-paper-plane"></i> บันทึก
                </button>
                <a class="btn btn-default" href="{{  app('url')->previous() }}">
                    <i class="fa fa-rotate-left"></i> ยกเลิก
                </a>
        </div>
    </div>
</div> 
@else 
<a  href="{{  app('url')->previous() }}">
    <div class="alert alert-dark text-center" role="alert">
        <i class="fa fa-rotate-left"></i> ยกเลิก
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
    $('.check-readonly').prop('disabled', true); 
    $('.check-readonly').parent().removeClass('disabled');
    $('.check-readonly').parent().css({"background-color": "rgb(238, 238, 238);","border-radius":"50%", "cursor": "not-allowed"});

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


    $("input[name=status]").on("ifChanged",function(){
         status_checkStatus();
    });
   status_checkStatus();

   });

   function ShowHideRemoveBtn94(box) { //ซ่อน-แสดงปุ่มลบ
    if (box.find('.other_attach_item').length > 1) {
        box.find('.attach-remove').show();
    } else {
        box.find('.attach-remove').hide();
    }
   }
   
   function status_checkStatus(){
         var row = $("input[name=status]:checked").val();
         $('#notAccept').hide();  
    if(row == "2"){
        $('#notAccept').fadeIn();
      }else{
        $('#notAccept').hide();
      }
  }
  function  submit_form(){
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