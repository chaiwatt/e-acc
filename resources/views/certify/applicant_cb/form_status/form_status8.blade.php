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
           <h3 class="box-title pull-left">ใบรับรองระบบงาน (CB) #{{$certi_cb->id}} </h3>

                <a class="btn btn-danger text-white pull-right" href="{{url('certify/applicant-cb')}}">
                        <i class="icon-arrow-left-circle"></i> กลับ
                </a>

                <div class="clearfix"></div>
                <hr>
 @if(count($certi_cb->CertiCBCosts) > 0) 
    @foreach($certi_cb->CertiCBCosts as $key => $item)
    @if(count($item->CertiCbHistorys) > 0) 
  <div class="row">
    <div class="col-md-12">
         <div class="panel block4">
            <div class="panel-group" id="accordion{{ $key +1 }}">
               <div class="panel panel-info">
                <div class="panel-heading">
                    <h4 class="panel-title">
                         <a data-toggle="collapse" data-parent="#accordion{{ $key +1 }}" href="#collapse{{ $key +1 }}"> <dd> การประมาณค่าใช้จ่าย ครั้งที่ {{ $key +1}}</dd>  </a>
                    </h4>
                </div> 

 <div id="collapse{{ $key +1 }}" class="panel-collapse collapse {{ (count($certi_cb->CertiCBCosts) == $key +1 ) ? 'in' : ' '  }}">
 <br>
 @foreach($item->CertiCbHistorys as $key1 => $item1)
 @if(!is_null($item1->details_one))
   @php 
       $details_one = json_decode($item1->details_one);
   @endphp
<div class="row form-group">
    <div class="col-md-1"></div>
        <div class="col-md-10">
        <div class="white-box" style="border: 2px solid #e5ebec;">
                 <legend><h3> ครั้งที่ {{ $key1 +1}} </h3></legend>
              
                 @if(!is_null($item1->details_two))
                 @php 
                     $details_two =json_decode($item1->details_two);
                 @endphp              
                    <h4>1. จำนวนวันที่ใช้ตรวจประเมินทั้งหมด <span>{{ $item1->MaxAmountDate  ?? '-' }}</span> วัน</h4>
                    <h4>2. ค่าใช้จ่ายในการตรวจประเมินทั้งหมด <span>{{ $item1->SumAmount ?? '-' }}</span> บาท </h4>
                     <table class="table table-bordered" id="myTable_labTest">
                         <thead class="bg-primary">
                         <tr>
                             <th class="text-center text-white" width="2%">ลำดับ</th>
                             <th class="text-center text-white" width="38%">รายละเอียด</th>
                             <th class="text-center text-white" width="20%">จำนวนเงิน (บาท)</th>
                             <th class="text-center text-white" width="20%">จำนวนวัน (วัน)</th>
                             <th class="text-center text-white" width="20%">รวม (บาท)</th>
                         </tr>
                         </thead>
                         <tbody id="costItem">
                             @foreach($details_two as $key2 => $item2)
                                 @php     
                                 $amount_date = !empty($item2->amount_date) ? $item2->amount_date : 0 ;
                                 $amount = !empty($item2->amount) ? $item2->amount : 0 ;
                                 $sum =   $amount*$amount_date;
                                 $details =  App\Models\Bcertify\StatusAuditor::where('id',$item2->detail)->first();
                                 @endphp
                                 <tr>
                                     <td class="text-center">{{ $key1+1 }}</td>
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
                                      {{ $item1->SumAmount ?? '-' }} 
                                 </td>
                             </tr>
                         </footer>
                     </table>
                @endif

                @if(!is_null($item1->attachs)) 
                @php 
                $attachs = json_decode($item1->attachs);
                @endphp
                <div class="row">
                <div class="col-md-3 text-right">
                <p class="text-nowrap">ขอบข่าย:</p>
                </div>
                <div class="col-md-9">
                    @foreach($attachs as $scope)
                    <p>     
                        {{-- @if($scope->file!='' && HP::checkFileStorage($attach_path.$scope->file)) --}}
                            <a href="{{url('certify/check/file_cb_client/'.$scope->file.'/'.( !empty($scope->file_client_name) ? $scope->file_client_name : 'null' ))}}" target="_blank">
                                 {{  !empty($scope->file_client_name) ? $scope->file_client_name :  basename($scope->file)   }} 
                            </a>
                       {{-- @endif   --}}
                    </p>
                    @endforeach
                </div>
                </div>
                @endif
                
                

            @if($details_one->check_status != null && $details_one->status_scope != null) 
                <legend><h3>เหตุผล / หมายเหตุ ขอแก้ไข</h3></legend>

                <div class="row">
                   <div class="col-md-3 text-right">
                            <p class="text-nowrap">เห็นชอบกับค่าใช้จ่ายที่เสนอมา</p>
                    </div>
                    <div class="col-md-9">
                        <label>   <input type="radio" class="check check-readonly" data-radio="iradio_square-green" {{ ($details_one->check_status == 1 ) ? 'checked' : ' '  }}>  &nbsp;ยืนยัน &nbsp;</label>
                        <label>   <input type="radio" class="check check-readonly" data-radio="iradio_square-red" {{ ($details_one->check_status == 2 ) ? 'checked' : ' '  }}>  &nbsp;แก้ไข &nbsp;</label>
                    </div>
                </div>
            
                @if(isset($details_one->remark) && $details_one->check_status == 2) 
                    <div class="row">
                    <div class="col-md-3 text-right">
                    <p class="text-nowrap">หมายเหตุ</p>
                    </div>
                    <div class="col-md-9">
                       {{ @$details_one->remark ?? ''}}
                    </div>
                    </div>
                @endif

                @if(!is_null($item1->attachs_file))
                        @php 
                        $attachs_file = json_decode($item1->attachs_file);
                        @endphp 
                        <div class="row">
                        <div class="col-md-3 text-right">
                        <p class="text-nowrap">หลักฐาน:</p>
                        </div>
                        <div class="col-md-9">
                        @foreach($attachs_file as $files)
                            <p> 
                                @if(isset($files->file))
                                {{  @$files->file_desc  }}
 
                                   {{-- @if($files->file!='' && HP::checkFileStorage($attach_path.$files->file)) --}}
                                         <a href="{{url('certify/check/file_cb_client/'.$files->file.'/'.( !empty($files->file_client_name) ? $files->file_client_name : 'null' ))}}" target="_blank">
                                            {{  !empty($files->file_client_name) ? $files->file_client_name :  basename($files->file)   }} 
                                        </a>
                                    {{-- @endif  --}}
                                @endif
                            </p>
                        @endforeach
                        </div>
                        </div>
                 @endif


                <div class="row">
                   <div class="col-md-3 text-right">
                       <p class="text-nowrap">เห็นชอบกับ Scope</p>
                    </div>
                    <div class="col-md-9">
                        <label>   <input type="radio" class="check check-readonly" data-radio="iradio_square-green" {{ ($details_one->status_scope == 1 ) ? 'checked' : ' '  }}>  &nbsp;ยืนยัน Scope &nbsp;</label>
                        <label>   <input type="radio" class="check check-readonly" data-radio="iradio_square-red" {{ ($details_one->status_scope == 2 ) ? 'checked' : ' '  }}>  &nbsp; แก้ไข Scope &nbsp;</label>
                    </div>
                </div>
            
                @if(isset($details_one->remark_scope) && $details_one->status_scope == 2) 
                    <div class="row">
                    <div class="col-md-3 text-right">
                    <p class="text-nowrap">หมายเหตุ</p>
                    </div>
                    <div class="col-md-9">
                       {{ @$details_one->remark_scope ?? ''}}
                    </div>
                    </div>
                @endif

                
                @if(!is_null($item1->evidence))
                @php 
                $evidence = json_decode($item1->evidence);
                @endphp 
                <div class="row">
                <div class="col-md-3 text-right">
                <p class="text-nowrap">หลักฐาน:</p>
                </div>
                <div class="col-md-9">
                @foreach($evidence as $files)
                    <p> 
                        @if(isset($files->attach_files))
                          {{  @$files->file_desc_text  }}
                          <a href="{{url('certify/check/file_cb_client/'.$files->attach_files.'/'.( !empty($files->file_client_name) ? $files->file_client_name : 'null' ))}}" target="_blank">
                                {{  !empty($files->file_client_name) ? $files->file_client_name :  basename($files->file)   }} 
                            </a>
                        @endif
                    </p>
                @endforeach
                </div>
                </div>
                @endif
            
                @if(!is_null($item->date)) 
                   <div class="row">
                       <div class="col-md-3 text-right">
                           <p class="text-nowrap">วันที่บันทึก</p>
                       </div>
                       <div class="col-md-9">
                           {{ @HP::DateThai($item->date) ?? '-' }}
                       </div>
                   </div>
                @endif
           @endif


        </div>  
    </div>  
</div>  
    
@endif
@endforeach
</div>  


               </div>  
            </div>  
        </div>  
    </div>  
</div>  

      @endif
    @endforeach
 @endif


 @if($certi_cb->status == 8)
 {!! Form::open(['url' => 'certify/applicant-cb/update/status/cost/'.$certi_cb->token,
                'class' => 'form-horizontal',
                'id'=>'cost_form', 
                'files' => true])
 !!}
 <div class="row form-group">
     <div class="col-md-12">
         <div class="white-box" style="border: 2px solid #e5ebec;">
         <legend><h3>เหตุผล / หมายเหตุ ขอแก้ไข</h3></legend>
         <div class="container-fluid">
             <div class="col-md-12">
                 <div class="row">
                     <div class="col-md-3 text-right">
                         <p class="text-nowrap">เห็นชอบกับค่าใช้จ่ายที่เสนอมา</p>
                     </div>
                     <div class="col-md-9">
                         <label>{!! Form::radio('check_status', '1', true, ['class'=>'check check_status', 'data-radio'=>'iradio_square-green']) !!} &nbsp;ยืนยัน &nbsp;</label>
                         <label>{!! Form::radio('check_status', '2', false, ['class'=>'check check_status', 'data-radio'=>'iradio_square-red']) !!} &nbsp;แก้ไข &nbsp;</label>
                     </div>
                 </div>
                 <div  style="display: none" id="notAccept">
                     <div class="row">
                         <div class="col-md-3"></div>
                         <div class="col-md-7">
                             <label for="remark">หมายเหตุ :</label>
                             <textarea name="remark" id="remark" cols="30" rows="3" class="form-control"></textarea>
                         </div>
                         <div class="col-md-2"></div>
                     </div>
                     <div class="row m-t-20">
                         <div class="col-md-3"></div>
                         <div class="col-md-7">
                             {!! Form::label('another_modal_attach_files', 'ไฟล์แนบ (ถ้ามี):', ['class' => 'm-t-5']) !!}
                             <button type="button" class="btn btn-sm btn-success m-l-10 attach-add" id="attach-add">
                                 <i class="icon-plus"></i>&nbsp;เพิ่ม
                             </button>
                             <div id="modal_attach_box11">
                                 <div id="attach-box">
                                     <div class="form-group other_attach_item">
                                         <div class="col-md-5">
                                             {!! Form::text('file_desc[]', null, ['class' => 'form-control m-t-10', 'placeholder' => 'ชื่อไฟล์']) !!}
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
                                                     <input type="file" name="another_modal_attach_files[]" class="  check_max_size_file">
                                                 </span>
                                                 <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
                                             </div>
                                         </div>
                                         <div class="col-md-1 text-left m-t-15" style="margin-top: 3px">
                                             <button class="btn btn-danger btn-sm attach-remove" type="button" >
                                                 <i class="icon-close"></i>
                                             </button>
                                         </div>
                                      </div>
                                 </div>
                         </div>
                         <div class="col-md-2"></div>
                     </div>
                 </div>
             </div>


             <div class="row" hidden>
                 <div class="col-md-3 text-right">
                     <p class="text-nowrap">เห็นชอบกับ Scope  </p>
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
                             <label for="remark_scope">หมายเหตุ :</label>
                             <textarea name="remark_scope" id="remark_scope" cols="30" rows="3" class="form-control"></textarea>
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
                         <p class="text-nowrap"> <span class="text-danger">*</span>  หมายเหตุ</p>
                     </div>
                      <div class="col-md-9" >
                          ค่าใช้จ่ายนี้เฉพาะการตรวจประเมินเท่านั้น ยังไม่รวมค่าใบคำขอและค่าใบรับรองหรือค่าใช้จ่ายอื่น ๆ ที่เกี่ยวข้อง ทั้งนี้ ผู้ยื่นคำขอจะต้องรับผิดชอบค่าเดินทางและค่าที่พักต่อคณะผู้ตรวจประเมิน
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
           
             <input type="hidden" name="previousUrl" id="previousUrl" value="{{ $previousUrl ?? null}}">
                 <div class="form-group">
                     <div class="col-md-offset-4 col-md-4">
                         <button class="btn btn-primary" type="submit"  onclick="submit_form();return false;">
                                 บันทึก
                         </button>
                         <a class="btn btn-default" href="{{url("$previousUrl") }}">
                                 <i class="fa fa-rotate-left"></i> ยกเลิก
                         </a>
                     </div>
                 </div>

             </div>
           </div>
        </div>
    </div>
</div>
{!! Form::close() !!}
@else 
<a  href="{{ url("certify/applicant-cb") }}">
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
     <script>
        function submit_form() {
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
                       
                          $('#cost_form').submit();
                      }
                  })
          
          }
          
          jQuery(document).ready(function() {
             $('#cost_form').parsley().on('field:validated', function() {
                      var ok = $('.parsley-error').length === 0;
                      $('.bs-callout-info').toggleClass('hidden', !ok);
                      $('.bs-callout-warning').toggleClass('hidden', ok);
                  })  .on('form:submit', function() {
                          // Text
                          $.LoadingOverlay("show", {
                          image       : "",
                          text  : "กำลังบันทึก กรุณารอสักครู่..."
                          });
                      return true; // Don't submit form for this demo
                  });
          });
    </script>
     <script type="text/javascript">
        jQuery(document).ready(function() {
                    $('.check-readonly').prop('disabled', true);//checkbox ความคิดเห็น
                    $('.check-readonly').parent().removeClass('disabled');
                    $('.check-readonly').parent().css('margin-top', '8px');//checkbox ความคิดเห็น

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
            $('body').on('click', '.attach-remove', function(event) {
                var box = $(this).parent().parent().parent().parent();
                $(this).parent().parent().remove();
                ShowHideRemoveBtn94(box);
             
            });
            $('.attach-add').each(function(index,eve){
                var box = $(eve).next();
                ShowHideRemoveBtn94(box);
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
           
            $("input[name=check_status]").on("ifChanged",function(){
                 status_checkStatus();
            });
           status_checkStatus();

           $("input[name=status_scope]").on("ifChanged",function(){
                 status_status_scope();
            });
            status_status_scope();

         });
         function status_checkStatus(){
                 var row = $("input[name=check_status]:checked").val();
                 $('#notAccept').hide();
            if(row == "2"){
                $('#notAccept').fadeIn();
              }else{
                $('#notAccept').hide();
              }
          }

          function status_status_scope(){
                 var row = $("input[name=status_scope]:checked").val();
                 $('#DivStatusScope').hide();
            if(row == "2"){
                $('#DivStatusScope').fadeIn();
              }else{
                $('#DivStatusScope').hide();
              }
          }
          function ShowHideRemoveBtn94(box) { //ซ่อน-แสดงปุ่มลบ
            if (box.find('.other_attach_item').length > 1) {
                box.find('.attach-remove').show();
            } else {
                box.find('.attach-remove').hide();
            }
        }

        function ShowHideRemoveBtnScope(box) { //ซ่อน-แสดงปุ่มลบ
            if (box.find('.attach_item').length > 1) {
                box.find('.attach_remove_scope').show();
            } else {
                box.find('.attach_remove_scope').hide();
            }
        }
        </script>
  @endpush