@extends('layouts.master')
@push('css')
<link href="{{asset('plugins/components/icheck/skins/all.css')}}" rel="stylesheet" type="text/css" />
@endpush
@section('content')
 <div class="container-fluid">
     <div class="row">
        <div class="col-md-12">
           <div class="white-box">
           <h3 class="box-title pull-left">ใบรับรองระบบงาน (IB)  </h3>

                <a class="btn btn-danger text-white pull-right" href="{{ app('url')->previous()  }}">
                        <i class="icon-arrow-left-circle"></i> กลับ
                </a>

                <div class="clearfix"></div>
                <hr>
 
    


 
 {!! Form::open(['url' => 'certify/tracking-ib/update/tracking-auditor/'.$tracking->id,
                'class' => 'form-horizontal',
                'method' => 'post',
                'id'=>'form_auditor', 
                'files' => true])
 !!}
 <div class="row form-group">
     <div class="col-md-12">
         <div class="white-box" style="border: 2px solid #e5ebec;">
         <legend><h3>ขอความเห็นแต่งตั้งคณะผู้ตรวจประเมิน</h3></legend>
         <div class="container-fluid">
          
 @foreach($tracking->AuditorsManyBy as $key => $item)
       

<div class="row">
     <div class="col-md-12">
        <div class="white-box" style="border: 2px solid #e5ebec;">
        <legend><h3>{{ $item->auditor ?? null }}</h3></legend>
        <hr>

 @if($item->status == null)   
 <input type="hidden" name="auditors_id[]" id="auditors_id" value="{{ $item->id ?? null}}">                 
<div class="row">
    <div class="col-md-5 text-right">
         <p >เห็นชอบกับการแต่งตั้งคณะผู้ตรวจประเมินที่เสนอมา :</p>
    </div>
    <div class="col-md-7">
        <label>{!! Form::radio('status['.$item->id.']', '1', true, ['class'=>'check status', 'data-radio'=>'iradio_square-green']) !!} &nbsp;เห็นชอบดำเนินการแต่งตั้งคณะผู้ตรวจประเมินต่อไป &nbsp;</label>
         <br>
        <label>{!! Form::radio('status['.$item->id.']', '2', false, ['class'=>'check status', 'data-radio'=>'iradio_square-red']) !!} &nbsp;ไม่เห็นชอบ เพราะ  &nbsp;</label>
    </div>
</div>
<div  style="display: none" class="notAccept hide"  id="notAccept">
    <div class="row">
        <div class="col-md-5"></div>
        <div class="col-md-7">
            <label for="remark">หมายเหตุ :</label>
            <textarea name="remark[{{$item->id}}]" id="remark" cols="30" rows="3" class="form-control"></textarea>
        </div>
    </div>
    <div class="row m-t-20">
        <div class="col-md-5"></div>
        <div class="col-md-7">
            {!! Form::label('another_modal_attach_files', 'ไฟล์แนบ (ถ้ามี):', ['class' => 'm-t-5']) !!}
            <button type="button" class="btn btn-sm btn-success m-l-10  form-group attach-add" data-attach="{{$item->id}}">
                 <i class="icon-plus"></i>&nbsp;เพิ่ม
            </button>
                                
            <div id="attach-box{{$item->id}}">
                <div class="form-group other_attach_item">
                    <div class="col-md-5">
                        {!! Form::text('file_desc['.$item->id.'][]', null, ['class' => 'form-control ', 'placeholder' => 'ชื่อไฟล์']) !!}
                    </div>
                    <div class="col-md-6">
                        <div class="fileinput fileinput-new input-group " data-provides="fileinput">
                            <div class="form-control" data-trigger="fileinput">
                                <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                <span class="fileinput-filename"></span>
                            </div>
                            <span class="input-group-addon btn btn-default btn-file">
                            <span class="fileinput-new">เลือกไฟล์</span>
                            <span class="fileinput-exists">เปลี่ยน</span>
                                <input type="file" name="another_modal_attach_files[{{$item->id}}][]" class="  check_max_size_file">
                            </span>
                             <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
                        </div>
                    </div>
                     <div class="col-md-1 text-left " style="margin-top: 3px">
                        <div class="button_remove"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
 </div>
 <hr>
 @endif

<div class="row">
    <div class="col-md-12">
        <div class="panel block4">
            <div class="panel  {{ $item->status == 1 ? 'panel-info' : 'panel-danger'  }}">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion{{ $key +1 }}" href="#collapse{{ $key +1 }}"> <dd>รายละเอียด {{ $item->auditor ?? null }}  </dd>  </a>
                        </h4>
                    </div>
                  
<div id="collapse{{ $key +1 }}" class="panel-collapse collapse">  
<br>
@foreach($item->history_ib_many as $key1 => $log)
@php 
$details_one = json_decode($log->details_one);
@endphp
<div class="row form-group">
    <div class="col-md-12">
       <div class="white-box" style="border: 2px solid #e5ebec;">
           <legend><h3> ครั้งที่ {{ $key1 +1}} </h3></legend>
           <div class="container-fluid">

@if(isset($details_one->no))
<div class="row">
<div class="col-md-4 text-right">
   <p >ชื่อคณะผู้ตรวจประเมิน :</p>
</div>
<div class="col-md-8">
   <span>{{$details_one->no ?? '-'}}</span>
</div>
</div>
@endif

<div class="row">
<div class="col-md-4 text-right">
   <p >วันที่ตรวจประเมิน</p>
</div>
<div class="col-md-8">
   <span>{!! $log->DataBoardAuditorDateTitle ?? '-'!!}</span>
</div>
</div>

@if(!is_null($log->attachs))
@php 
$attachs = json_decode($log->attachs);
@endphp
 
@if(!is_null($attachs))
<div class="row">
    <div class="col-md-4 text-right">
      <p >กำหนดการตรวจประเมิน</p>
    </div>
    <div class="col-md-8">
            <a href="{{url('funtions/get-view/'.$attachs->url.'/'.( !empty($attachs->filename) ? $attachs->filename : basename($attachs->new_filename) ))}}" target="_blank">
                {{  !empty($attachs->filename) ? $attachs->filename :  basename($attachs->new_filename)   }} 
            </a>
    </div>
</div>
@endif
@endif

@if(!is_null($log->details_three))
@php
    $details_three = json_decode($log->details_three);
 @endphp
 @if(!is_null($details_three))
<div class="col-md-12">
<label>โดยคณะผู้ตรวจประเมิน มีรายนามดังต่อไปนี้</label>
</div>
<div class="col-md-12">
    <table class="table table-bordered">
        <thead class="bg-primary">
            <tr>
                <th class="text-center text-white" width="2%">ลำดับ</th>
                <th class="text-center text-white" width="30%">สถานะผู้ตรวจประเมิน</th>
                <th class="text-center text-white" width="40%">ชื่อผู้ตรวจประเมิน</th>
                <th class="text-center  text-white" width="26%">หน่วยงาน</th>
            </tr>
        </thead>
        <tbody>

  
          @foreach($details_three as $key3 => $three)
         
          <tr>
                    <td  class="text-center">{{ $key3 +1 }}</td>
                    <td> 
                        @if (!empty($three->status_id)) 
                            @php
                                $auditor_title = App\Models\Bcertify\StatusAuditor::where('id',$three->status_id)->value('title');
                            @endphp
                            {{ !empty($auditor_title) ? $auditor_title : '-'  }}
                       @endif
                    </td>
                    <td>
                              {{ $three->temp_users ?? '-'  }}
                    </td>
                    <td>
                              {{ $three->temp_departments ?? '-'  }}
                    </td>
          </tr>
          @endforeach
        </tbody>
    </table>
</div>
@endif
@endif

@if(!is_null($log->details_four))
@php
$details_four = json_decode($log->details_four);
@endphp
@if(!is_null($details_four))
<div class="col-md-12">
<label>ค่าใช้จ่าย</label>
</div>
<div class="col-md-12">
<table class="table table-bordered">
<thead class="bg-primary">
<tr>
 <th class="text-center text-white" width="2%">ลำดับ</th>
 <th class="text-center text-white" width="38%">รายละเอียด</th>
 <th class="text-center text-white" width="20%">จำนวนเงิน (บาท)</th>
 <th class="text-center text-white" width="20%">จำนวนวัน (วัน)</th>
 <th class="text-center text-white" width="20%">รวม (บาท)</th>
</tr>
</thead>
<tbody>
  @php    
          $SumAmount = 0;
@endphp
@foreach($details_four as $key4 => $four)
          @php     
          $amount_date = !empty($four->amount_date) ? $four->amount_date : 0 ;
          $amount = !empty($four->amount) ? $four->amount : 0 ;
          $sum =   $amount*$amount_date;
          $SumAmount  +=  $sum;
          $details =  App\Models\Bcertify\StatusAuditor::where('id',$four->status_id)->first();
          @endphp
          <tr>
          <td class="text-center">{{ $key4+1 }}</td>
          <td>{{ !is_null($details) ? $details->title : null  }}</td>
          <td class="text-right">{{ number_format($amount, 2) }}</td>
          <td class="text-right">{{ $amount_date }}</td>
          <td class="text-right">{{ number_format($sum, 2) ?? '-'}}</td>
          </tr>
@endforeach 
</tbody>
<footer>
 <tr>
     <td colspan="4" class="text-right">รวม</td>
     <td class="text-right">
           {{ !empty($SumAmount) ?  number_format($SumAmount, 2) : '-' }} 
     </td>
 </tr>
</footer>
</table>
</div>
@endif
@endif

<hr>

@if(!is_null($log->status))
<div class="row">
<div class="col-md-4 text-right">
<p class="text-nowrap">กำหนดการตรวจประเมิน</p>
</div>
<div class="col-md-7">
<label>   <input type="radio" class="check check-readonly" data-radio="iradio_square-green" {{ ($log->status == 1 ) ? 'checked' : ' '  }}>  &nbsp;เห็นชอบดำเนินการแต่งตั้งคณะผู้ตรวจประเมินต่อไป &nbsp;</label>
<br>
<label>   <input type="radio" class="check check-readonly" data-radio="iradio_square-red" {{ ($log->status == 2 ) ? 'checked' : ' '  }}>  &nbsp;ไม่เห็นชอบ เพราะ  &nbsp;</label>
</div>
</div>
@endif
@if(isset($details_one->remark) &&  !is_null($details_one->remark))
<div class="row">
<div class="col-md-4 text-right">
<p class="text-nowrap">หมายเหตุ</p>
</div>
<div class="col-md-7">
 {{ @$details_one->remark  ?? '-'}}
</div>
</div>
@endif

@if(!is_null($log->attachs_file))
@php 
$attachs_file = json_decode($log->attachs_file);
@endphp 
@if(!is_null($attachs_file))
<div class="col-md-12">
{!! Form::label('no', 'หลักฐาน :', ['class' => 'col-md-4 control-label text-right']) !!}
<div class="col-md-8">
@foreach($attachs_file as $files)
       <p> 
           {{  @$files->caption  }}
           <a href="{{url('funtions/get-view/'.$files->url.'/'.( !empty($attachs->filename) ? $files->filename : basename($files->new_filename) ))}}" target="_blank">
                    {{  !empty($files->filename) ? $files->filename :  basename($files->new_filename)   }} 
           </a>
       </p>
   @endforeach
</div>
</div>
@endif
@endif


@if(!is_null($log->date))
<div class="row">
<div class="col-md-4 text-right">
   <p class="text-nowrap">วันที่บันทึก</p>
</div>
<div class="col-md-7">
   {{ HP::DateThai($log->date)  ?? '-'}}
</div>
</div>
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

 @endforeach
        
 @if(count($tracking->CertiAuditorsNullMany) > 0)        
<div class="col-md-12">
    <div class="row">
        <div class="col-md-5 text-right">
            <p >วันที่บันทึก :</p>
        </div>
        <div class="col-md-7" >
            {{ HP::DateThai(date('Y-m-d')) }}
        </div>
    </div>
 </div> 
             
<input type="hidden" name="previousUrl" id="previousUrl" value="{{  app('url')->previous()  }}">
 <div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        <button class="btn btn-primary" type="submit"  onclick="submit_form();return false;">
            <i class="fa fa-paper-plane"></i>  บันทึก
        </button>
        <a class="btn btn-default" href="{{ app('url')->previous()  }}">
             <i class="fa fa-rotate-left"></i> ยกเลิก
        </a>
    </div>
</div>
 
 @else 
 <a  href="{{ app('url')->previous()  }}">
 <div class="alert alert-dark text-center" role="alert">
    <i class="icon-arrow-left-circle"></i>
     <b>กลับ</b>
 </div>
 </a>
 @endif          

           </div>
        </div>
    </div>
 </div>
 {!! Form::close() !!}

            </div>  
         </div>  
    </div>
</div>   
@endsection
@push('js')
        <script src="{{ asset('plugins/components/icheck/icheck.min.js') }}"></script>
        <script src="{{ asset('plugins/components/icheck/icheck.init.js') }}"></script>

        <script src="{{asset('js/jasny-bootstrap.js')}}"></script>
        <script src="{{asset('plugins/components/sweet-alert2/sweetalert2.all.min.js')}}"></script>
 <script type="text/javascript">
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
            $(document).ready(function() {
              //Validate
                 $('#form_auditor').parsley().on('field:validated', function() {
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
<script type="text/javascript">
        jQuery(document).ready(function() {
            $('.check-readonly').prop('disabled', true); 
            $('.check-readonly').parent().removeClass('disabled');
            $('.check-readonly').parent().css({"background-color": "rgb(238, 238, 238);","border-radius":"50%", "cursor": "not-allowed"});
        //เพิ่มไฟล์แนบ
 
            $('.attach-add').click(function(event) {
                var box = $(this).next();
                let attach = $(this).data('attach');
                box.find('.other_attach_item:first').clone().appendTo('#attach-box'+attach);
                box.find('.other_attach_item:last').find('input').val('');
                box.find('.other_attach_item:last').find('a.fileinput-exists').click();
                box.find('.other_attach_item:last').find('a.view-attach').remove();
                box.find('.other_attach_item:last').find('.button_remove').html('<button class="btn btn-danger btn-sm attach-remove" type="button"> <i class="icon-close"></i>  </button>');
                check_max_size_file();
            });
            
           //ลบไฟล์แนบ
            $('body').on('click', '.attach-remove', function(event) {
                $(this).parent().parent().parent().remove();
            });
 
           $(".status").on("ifChanged",function(){
 
               if($(this).is(':checked') && $(this).val() == 2){
                let row = $(this).parent().parent().parent().parent().parent();
                    row.find('.notAccept').removeClass('hide').addClass('show');
               }else{
                let row = $(this).parent().parent().parent().parent().parent();
                    row.find('.notAccept').removeClass('show').addClass('hide');
               }
            
            });  
  });
</script>       
  @endpush