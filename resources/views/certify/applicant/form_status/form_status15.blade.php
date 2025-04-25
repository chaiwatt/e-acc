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
           <h3 class="box-title pull-left"> </h3>
           <h3 class="box-title pull-left">ใบรับรองระบบงาน (LAB)</h3>
                <a class="btn btn-danger text-white pull-right" href="{{ app('url')->previous() }}">
                        <i class="icon-arrow-left-circle"></i> กลับ
                </a>
                {{--  --}}
                <div class="clearfix"></div>
                <hr>  
  
                
  
@if(count($find_notice->CertificateHistorys) > 0)               
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
@foreach($find_notice->CertificateHistorys as $key1 => $item)

<div class="row form-group">
    <div class="col-md-12">
        <div class="white-box" style="border: 2px solid #e5ebec;">
 
            @if(!is_null($item->details_table))
            @php 
                $details_table = json_decode($item->details_table);
                $type =   ['1'=>'ข้อบกพร่อง','2'=>'ข้อสังเกต'];
            @endphp 
            @if(!is_null($details_table))
            <table class="table color-bordered-table primary-bordered-table table-bordered">
                <thead>
                    <tr>
                        <th class="text-center" width="2%">ลำดับ</th>
                        <th class="text-center" width="20%">ผลการประเมินที่พบ</th>
                        <th class="text-center" width="10%">ประเภท</th>
                        <th class="text-center" width="38%">แนวทางการแก้ไข</th>
        
                        @if($key1 > 0) 
                        <th class="text-center" width="20%" >หลักฐาน</th>
                        @endif
                    </tr>
                </thead>
                <tbody id="table-body">
                    @foreach($details_table as $key2 => $item2)
 
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
                                             @elseif(!is_null($item2->attachs) && isset($item2->attachs) )
                                            <span> <i class="fa  fa-close" style="font-size:20px;color:rgb(255, 0, 0)"></i> ไม่ผ่าน </span> 
                                            @endif
                                        <label for="app_name">
                                            <span>
                                                @if(!is_null($item2->attachs) && isset($item2->attachs) )
                                                    <a href="{{url('certify/check/file_client/'.$item2->attachs.'/'.( !empty($item2->attachs_client_name) ? $item2->attachs_client_name :  basename($item2->attachs) ))}}" target="_blank">
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
            @endif
        
            
            @if(!is_null($item->file)) 
            <div class="row">
            <div class="col-md-3 text-right">
                <p class="text-nowrap">รายงานการตรวจประเมิน :</p>
            </div>
            <div class="col-md-9">
                <p>
                    <a href="{{url('certify/check/file_client/'.$item->file.'/'.( !empty($item->file_client_name) ? $item->file_client_name : basename($item->file) ))}}" 
                        title=" {{ !empty($item->file_client_name) ? $item->file_client_name : basename($item->file)}}"   target="_blank">
                        {!! HP::FileExtension($item->file)  ?? '' !!}
                    </a>
                </p>
            </div>
            </div>
            @endif
        
            @if(!is_null($item->attachs)) 
            <div class="row">
            <div class="col-md-3 text-right">
                <p class="text-nowrap">ไฟล์แนบ :</p>
            </div>
            <div class="col-md-9">
                    @php 
                        $attachs = json_decode($item->attachs);
                    @endphp  
                    
                    @if(!is_null($attachs)) 
                    @foreach($attachs as  $key => $item2)
                         <p>
                            <a href="{{url('certify/check/file_client/'.$item2->attachs.'/'.( !empty($item2->attachs_client_name) ? $item2->attachs_client_name : basename($item2->attachs) ))}}" 
                                title=" {{ !empty($item2->attachs_client_name) ? $item2->attachs_client_name :  basename($item2->attachs)}}"  target="_blank">
                                {!! HP::FileExtension($item2->attachs)  ?? '' !!}
                            </a>
                         </p>
                    @endforeach
                    @endif
            </div>
            </div>
            @endif
        
            @if(!is_null($item->date)) 
            <div class="row">
            <div class="col-md-3 text-right">
                <p class="text-nowrap">วันที่บันทึก :</p>
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
        <a data-toggle="collapse" data-parent="#accordion" href="#inspection"> <dd>ประวัติบันทึกผลการตรวจประเมิน</dd>  </a>
    </h4>
</div>

 <div id="inspection" class="panel-collapse collapse  in">
    <br> 


@if(count($find_notice->LogNotice) > 0) 
@foreach($find_notice->LogNotice as $key1 => $item1)

<div class="row form-group">
    <div class="col-md-12">
       <div class="white-box" style="border: 2px solid #e5ebec;">
 

<div class="container-fluid">

<div class="row ">
    @if(!is_null($item1->file))
        <div class="col-md-6">
            <label class="col-md-6 text-right"> รายงานการตรวจประเมิน : </label>
            <div class="col-md-6">
                 <p>
                    <a href="{{url('certify/check/file_client/'.$item1->file.'/'.( !empty($item1->file_client_name) ? $item1->file_client_name : basename($item1->file) ))}}" 
                        title="{{  !empty($item1->file_client_name) ? $item1->file_client_name :  basename($item1->file)}}"  target="_blank">
                        {!! HP::FileExtension($item1->file)  ?? '' !!}
                    </a>
                </p>
            </div>
        </div>
     @endif
     @if(!is_null($item1->details_date))
      <div class="col-md-6">
            <label class="col-md-6 text-right"> รายงานปิด Car : </label>
            <div class="col-md-6">
                <a href="{{url('certify/check/file_client/'.$item1->details_date.'/'.( !empty($item1->attach_client_name) ? $item1->attach_client_name : basename($item1->details_date)  ))}}" 
                    title="{{  !empty($item1->attach_client_name) ? $item1->attach_client_name :  basename($item1->details_date)}}"  target="_blank">
                {!! HP::FileExtension($item1->details_date)  ?? '' !!}

            </a> 
         </div>
    </div>
    @endif
    @if(!is_null($item1->details_table))
    <div class="col-md-6">
        <label class="col-md-6 text-right">Scope : </label>
        <div class="col-md-6">
                @php
                $details_table = json_decode($item1->details_table);
                @endphp
                @if(!is_null($details_table))
                    @foreach ($details_table as $item2)
                        <p>
                            <a href="{{url('certify/check/file_client/'.$item2->attachs.'/'.( !empty($item2->attachs_client_name) ? $item2->attachs_client_name : basename($item2->attachs) ))}}" 
                                title="{{  !empty($item2->attachs_client_name) ? $item2->attachs_client_name :  basename($item2->attachs)}}"  target="_blank">
                                {!! HP::FileExtension($item2->attachs)  ?? '' !!}
   
                            </a>
                        </p>
                    @endforeach
                @endif
        </div>
    </div>
    @endif
    @if(!is_null($item1->attachs))
    <div class="col-md-6">
        <label class="col-md-6 text-right"> ไฟล์แนบ : </label>
        <div class="col-md-6">
            @php
                $attachs = json_decode($item1->attachs);
            @endphp
            @if(!is_null($attachs))
            @foreach ($attachs as $item3)
                <p>
                    <a href="{{url('certify/check/file_client/'.$item3->attachs.'/'.( !empty($item3->attachs_client_name) ? $item3->attachs_client_name : basename($item3->attachs) ))}}" 
                        title="{{  !empty($item3->attachs_client_name) ? $item3->attachs_client_name :  basename($item3->attachs)}}"  target="_blank">
                    {!! HP::FileExtension($item3->attachs)  ?? '' !!}

                    </a>
                </p>
            @endforeach
            @endif
        </div>
    </div>
    @endif
</div>

<hr>
@if(!is_null($item1->status_scope))
<div class="form-group">
    <div class="col-md-12">
        <label class="col-md-3 text-right">  เห็นชอบกับ Scope : </label>
        <div class="col-md-7">
            <label>   <input type="radio" class="check check-readonly" data-radio="iradio_square-green" {{ ($item1->status_scope == 1 ) ? 'checked' : ' '  }}>  &nbsp;ยืนยัน Scope &nbsp;</label>
            <label>   <input type="radio" class="check check-readonly" data-radio="iradio_square-red" {{ ($item1->status_scope == 2 ) ? 'checked' : ' '  }}>  &nbsp; แก้ไข Scope &nbsp;</label>
        </div>
    </div>
</div>
@endif

@if(!is_null($item1->remark))
<div class="form-group">
    <div class="col-md-12">
        <label class="col-md-3 text-right"> หมายเหตุ : </label>
        <div class="col-md-7">
                {{ $item1->remark ?? null }}
        </div>
    </div>
</div>
@endif

<div class="form-group">
    <div class="col-md-12">
        @if(!is_null($item1->evidence))
        <label class="col-md-3 text-right"> ไฟล์แนบ : </label>
        <div class="col-md-7">
                @php
                      $evidence = json_decode($item1->evidence);
                @endphp
                @foreach ($evidence as $item13)
                    <p>
                        <p>
                            {{ @$item13->file_desc_text }}
                          <a href="{{url('certify/check/file_client/'.$item13->attachs.'/'.( !empty($item13->attachs_client_name) ? $item13->attachs_client_name : basename($item13->attachs)  ))}}" target="_blank">
                            {!! HP::FileExtension($item13->attachs)  ?? '' !!}
                         </a>
                          
                       </p>
                    </p>
                @endforeach
         
        </div>
         @endif
    </div>
</div>
@if(!is_null($item1->date)) 
<div class="row">
<label class="col-md-3 text-right">
    วันที่บันทึก :
</label>
<div class="col-md-9">
    {{ @HP::DateThai($item1->date) ?? '-' }}
</div>
</div>
@endif
 
</div>

        </div>
    </div>
</div>
 
@endforeach
@endif




</div>             
              </div>
           </div>
        </div>
    </div>
</div>


       </div>
    </div>
</div>

 {!! Form::open(['url' => 'certify/applicant/inspection/assess_update/'.$find_notice->id,
                'class' => 'form-horizontal',
                'method' => 'post',
                'id'=>'form_auditor', 
                'files' => true])
 !!}
@if($find_notice->degree == 4 || $find_notice->degree == 6)

<div class="row">
    <div class="form-group">
        <div class="col-md-offset-5 col-md-6">
                <button class="btn btn-primary" type="submit"  onclick="submit_form();return false">
                <i class="fa fa-paper-plane"></i> บันทึก
                </button>
                    <a class="btn btn-default" href="{{ app('url')->previous() }}">
                        <i class="fa fa-rotate-left"></i> ยกเลิก
                    </a>
        </div>
    </div>
</div> 

<div class="row" style="visibility: hidden">
    <div class="col-md-12">
        <div class="white-box" style="border: 2px solid #e5ebec;">
    <legend><h3>เหตุผล / หมายเหตุ ขอแก้ไข</h3></legend>
    <div class="container-fluid">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-3 text-right">
                     <p class="text-nowrap">เห็นชอบกับ Scope</p>
                </div>
                <div class="col-md-9">
                        <label>{!! Form::radio('status_scope', '1', true, ['class'=>'check', 'data-radio'=>'iradio_square-green']) !!} &nbsp;ยืนยัน Scope &nbsp;</label>
                        <label>{!! Form::radio('status_scope', '2', false, ['class'=>'check', 'data-radio'=>'iradio_square-red']) !!} &nbsp;ขอแก้ไข Scope &nbsp;</label>
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




@else 
<a  href="{{ app('url')->previous() }}">
    <div class="alert alert-dark text-center" role="alert">
        <i class="fa fa-close"></i>
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
