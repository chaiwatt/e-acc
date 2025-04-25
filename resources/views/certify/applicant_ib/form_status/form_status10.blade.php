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
           <h3 class="box-title pull-left">ใบรับรองระบบงาน (IB)  landing


            @if ($certi_ib->CertiAuditors->count() > $certi_ib->fullyApprovedAuditorNoCancels->count())
            <span class="text-danger">(รอดำเนินการ {{$certi_ib->CertiAuditors->count() - $certi_ib->fullyApprovedAuditorNoCancels->count()}} คณะ)</span> 
            @endif
            
           
           </h3>

                <a class="btn btn-danger text-white pull-right " href="{{url('certify/applicant-ib')}}">
                        <i class="icon-arrow-left-circle"></i> กลับ
                </a>

                <div class="clearfix"></div>
                <hr>

 
 {!! Form::open(['url' => 'certify/applicant-ib/update/status/auditor/'.$certi_ib->token,
                'class' => 'form-horizontal form_loading',
                'id'=>'form_auditor', 
                'files' => true])
 !!}
 <div class="row form-group">
     <div class="col-md-12">
         <div class="white-box" style="border: 2px solid #e5ebec;">
                 <legend><h3>ขอความเห็นแต่งตั้งคณะผู้ตรวจประเมิน</h3></legend>
         <div class="container-fluid">

    @php
            // สร้างตัวแปรเก็บรายการที่ status == 1
            $approvedAuditors = $certi_ib->fullyApprovedAuditorNoCancels->filter(function ($item) {
                return $item->status != 1;
            })->values()->all(); // filter เฉพาะรายการที่ status == 1 และ reset keys
        @endphp


  {{-- @if(count($certi_ib->CertiIBAuditorsMany) > 0)  --}}

  {{-- @foreach($certi_ib->CertiIBAuditorsMany  as $key => $item) --}}
  {{-- {{$certi_ib->fullyApprovedAuditorNoCancels->count()}}
  {{count($certi_ib->CertiIBAuditorsMany)}} --}}
  @foreach($certi_ib->fullyApprovedAuditorNoCancels as $key => $item)
  
        <div class="row">
            <div class="col-md-12">
                <div class="white-box" style="border: 2px solid #e5ebec;">
                    <legend><h3>{{ $item->auditor ?? null }}</h3></legend>
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
                    <div  style="display: none" class="notAccept hide" >
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
                        
                    <div id="collapse{{ $key +1 }}" class="panel-collapse collapse ">   {{-- {{ $item->status == 1 ? '' : 'in' }} --}}
        <br>
        @foreach($item->CertiIbHistorys as $key1 => $item1)
        @php 
                $details_one = json_decode($item1->details_one);
        @endphp
            <div class="row form-group">
            <div class="col-md-1"></div>
            <div class="col-md-10">
            <div class="white-box" style="border: 2px solid #e5ebec;">
                <legend><h3> คณะผู้ตรวจประเมินที่ {{ $key1 +1}} </h3></legend>
                <div class="container-fluid">


                @if(isset($details_one->no))
                <div class="row">
                <div class="col-md-5 text-right">
                        <p class="text-nowrap">ชื่อคณะผู้ตรวจประเมิน</p>
                </div>
                <div class="col-md-7">
                    <span>{{$details_one->no ?? '-'}}</span>
                </div>
                </div>
                @endif

                <div class="row">
                <div class="col-md-5 text-right">
                        <p class="text-nowrap">วันที่ตรวจประเมิน</p>
                </div>
                <div class="col-md-7">
                    <span>{!! $item1->DataBoardAuditorDateTitle ?? '-'!!}</span>
                </div>
                </div>

                    @if(!is_null($item1->attachs))
                    <div class="row">
                    <div class="col-md-5 text-right">
                        <p class="text-nowrap">กำหนดการตรวจประเมิน</p>
                    </div>
                    <div class="col-md-7">
                        <a href="{{url('certify/check/file_ib_client/'.$item1->attachs.'/'.( !empty($item1->attach_client_name) ? $item1->attach_client_name :  basename($item1->attachs)  ))}}" 
                            title="{{  !empty($item1->attach_client_name) ? $item1->attach_client_name : basename($item1->attachs) }}" target="_blank">
                            {!! HP::FileExtension($item1->attachs)  ?? '' !!}
                        </a>    
                    </div>
                    </div>
                    @endif

            @if(!is_null($item1->details_two))
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
            @php
            $details_three = json_decode($item1->details_three);
            @endphp
            @foreach($details_three as $key3 => $three)
            @php
                $status = App\Models\Bcertify\StatusAuditor::where('id',$three->status)->first(); 
            @endphp
            <tr>
            <td  class="text-center">{{ $key3 +1 }}</td>
            <td> {{ $status->title ??  '-'  }}</td>
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

        @if(!is_null($item1->details_four))
        @php
        $details_four = json_decode($item1->details_four);
        @endphp
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
            $details =  App\Models\Bcertify\StatusAuditor::where('id',$four->detail)->first();
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

<hr>

@if(!is_null($item1->status))
<div class="row">
<div class="col-md-4 text-right">
<p class="text-nowrap">กำหนดการตรวจประเมิน</p>
</div>
<div class="col-md-7">
<label>   <input type="radio" class="check check-readonly" data-radio="iradio_square-green" {{ ($item1->status == 1 ) ? 'checked' : ' '  }}>  &nbsp;เห็นชอบดำเนินการแต่งตั้งคณะผู้ตรวจประเมินต่อไป &nbsp;</label>
<br>
<label>   <input type="radio" class="check check-readonly" data-radio="iradio_square-red" {{ ($item1->status == 2 ) ? 'checked' : ' '  }}>  &nbsp;ไม่เห็นชอบ เพราะ  &nbsp;</label>
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

@if(!is_null($item1->attachs_file))
@php 
$attachs_file = json_decode($item1->attachs_file);
@endphp 
<div class="col-md-12">
{!! Form::label('no', 'หลักฐาน :', ['class' => 'col-md-4 control-label text-right']) !!}
<div class="col-md-8">
@foreach($attachs_file as $files)
      <p> 
          {{  @$files->file_desc  }}
           <a href="{{url('certify/check/file_ib_client/'.$files->file.'/'.( !empty($files->file_client_name) ? $files->file_client_name :  basename($files->file)  ))}}" 
            title="{{  !empty($files->file_client_name) ? $files->file_client_name : basename($files->file) }}" target="_blank">
              {!! HP::FileExtension($files->file)  ?? '' !!}
          </a>
      </p>
  @endforeach
</div>
</div>
@endif


@if(!is_null($item1->date))
<div class="row">
<div class="col-md-4 text-right">
  <p class="text-nowrap">วันที่บันทึก</p>
</div>
<div class="col-md-7">
  {{ HP::DateThai($item1->date)  ?? '-'}}
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
  {{-- @endif --}}

 
  @if(count($certi_ib->CertiAuditorsNullMany) > 0 && $certi_ib->CertiAuditorsStatus != "statusInfo")        
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
               
  <input type="hidden" name="previousUrl" id="previousUrl" value="{{ $previousUrl ?? null}}">
    @if (count($approvedAuditors) != 0)
        <div class="form-group">
            <div class="col-md-offset-4 col-md-4">
                <button class="btn btn-primary" type="submit"  onclick="submit_form();return false;">
                    <i class="fa fa-paper-plane"></i>  บันทึก
                </button>
                <a class="btn btn-default" href="{{url("$previousUrl") }}">
                    <i class="fa fa-rotate-left"></i> ยกเลิก
                </a>
            </div>
        </div>
    @endif

   @else 
   <a  href="{{ url("$previousUrl") }}">
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
            $('.check-readonly').parent().css({"background-color": "rgb(238, 238, 238);","border-radius":"50%"});

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
                         $('#form_auditor').find('input').prop('readonly', true);
                        $('#form_auditor').submit();
                    }
                })
           }
        </script> 
         <script type="text/javascript">
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
         
  @endpush