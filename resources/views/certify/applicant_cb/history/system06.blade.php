

@if(!is_null($history->details_five)) 
@php 
    $payin1 = json_decode($history->details_five);
@endphp
<div class="row">
    <div class="col-sm-4 text-right"> <b>เงื่อนไขการชำระเงิน :</b></div>
    <div class="col-sm-7">
        <p>  
         @if (!empty($payin1->conditional_type))
             @if ($payin1->conditional_type == 1) <!--  หลักฐานค่าธรรมเนียม -->
                หลักฐานค่าธรรมเนียม
            @elseif($payin1->conditional_type == 2) <!--  ยกเว้นค่าธรรมเนียม -->  
                ยกเว้นค่าธรรมเนียม
            @elseif($payin1->conditional_type == 3) <!--  ยกเว้นค่าชำระเงินนอกระบบ, ไม่เรียกชำระเงิน หรือ กรณีอื่นๆธรรมเนียม --> 
                ยกเว้นค่าชำระเงินนอกระบบ, ไม่เรียกชำระเงิน หรือ กรณีอื่นๆธรรมเนียม
            @endif
        @else 
             หลักฐานค่าธรรมเนียม   
        @endif
        </p>
    </div>
    </div>
@endif

@if(!is_null($history->details_three))
<div class="row">
  <div class="col-md-4 text-right">
      <p class="text-nowrap">ชื่อคณะผู้ตรวจประเมิน :</p>
  </div>
  <div class="col-md-8 text-left">
    {{ $history->details_three ?? null }}
  </div>
</div>
@endif
 @if(!is_null($history->details_one)) 
 <div class="row">
 <div class="col-md-4 text-right">
     <p class="text-nowrap">จำนวนเงิน :</p>
 </div>
 <div class="col-md-8 text-left">
     {{  number_format($history->details_one,2).' บาท' ?? '-' }}
 </div>
 </div>
 @endif

 @if(!is_null($history->details_five)) 
 
     @if ($payin1->conditional_type == 1) <!--  หลักฐานค่าธรรมเนียม -->
        @if(!is_null($history->details_two)) 
            <div class="row">
                <div class="col-md-4 text-right">
                    <p class="text-nowrap"> วันที่แจ้งชำระ :</p>
                </div>
                <div class="col-md-8 text-left">
                    {{ @HP::DateThai($history->details_two) ?? '-' }}
                </div>
            </div>
        @endif
        @if(!is_null($history->attachs))
            <div class="row">
            <div class="col-md-4 text-right">
            <p class="text-nowrap">ค่าบริการในการตรวจประเมิน:</p>
            </div>
            <div class="col-md-8 text-left">
                <p> 
                    @if(isset($history->attachs))
                    <a href="{{url('certify/check/file_cb_client/'.$history->attachs.'/'.( !empty($history->attach_client_name) ? $history->attach_client_name : basename($history->attachs) ))}}" target="_blank">
                    {!! HP::FileExtension($history->attachs)  ?? '' !!}
                    {{@basename($history->attachs)}} 
                    </a>
                    @endif
                </p>
            </div>
            </div>
        @endif
    @elseif($payin1->conditional_type == 2) <!--  ยกเว้นค่าธรรมเนียม -->
        <div class="row">
            <div class="col-sm-4 text-right"> <b>วันที่แจ้งชำระ :</b></div>
            <div class="col-sm-6">
                <p>  
                    {{  !empty($payin1->start_date_feewaiver) && !empty($payin1->end_date_feewaiver) ? HP::DateFormatGroupTh($payin1->start_date_feewaiver,$payin1->end_date_feewaiver) :  '-' }}
                </p>
            </div>
            </div>   
            @if(!is_null($history->attachs)) 
            <div class="row">
            <div class="col-sm-4 text-right"> <b>ใบแจ้งหนี้ค่าธรรมเนียม :</b></div>
            <div class="col-sm-6 text-left">
                <p>  
                    <a href="{{url('funtions/get-view-file/'.base64_encode($history->attachs).'/'.( !empty($history->attach_client_name) ? $history->attach_client_name : basename($history->attachs) ))}}" target="_blank">
                        {!! HP::FileExtension($history->attachs)  ?? '' !!}
                    </a>
                </p>
            </div>
            </div>
            @endif
    @elseif($payin1->conditional_type == 3) <!--  ยกเว้นค่าชำระเงินนอกระบบ, ไม่เรียกชำระเงิน หรือ กรณีอื่นๆธรรมเนียม -->
         <div class="row">
            <div class="col-md-4 text-right">
                <p class="text-nowrap"> หมายเหตุ :</p>
            </div>
            <div class="col-md-8 text-left">
                 {{  !empty($payin1->detail)  ? $payin1->detail :  '-' }}
            </div>
        </div>
        @if(!is_null($history->attachs))
            <div class="row">
            <div class="col-md-4 text-right">
            <p class="text-nowrap">ไฟล์แนบ:</p>
            </div>
            <div class="col-md-8 text-left">
                <p> 
                    @if(isset($history->attachs))
                    <a href="{{url('certify/check/file_cb_client/'.$history->attachs.'/'.( !empty($history->attach_client_name) ? $history->attach_client_name : basename($history->attachs) ))}}" target="_blank">
                    {!! HP::FileExtension($history->attachs)  ?? '' !!}
                    {{@basename($history->attachs)}} 
                    </a>
                    @endif
                </p>
            </div>
            </div>
        @endif
    @endif

@else


    @if(!is_null($history->details_two)) 
        <div class="row">
        <div class="col-md-4 text-right">
            <p class="text-nowrap"> วันที่แจ้งชำระ :</p>
        </div>
        <div class="col-md-8 text-left">
            {{ @HP::DateThai($history->details_two) ?? '-' }}
        </div>
        </div>
    @endif

    @if(!is_null($history->attachs))
        <div class="row">
        <div class="col-md-4 text-right">
        <p class="text-nowrap">ค่าบริการในการตรวจประเมิน:</p>
        </div>
        <div class="col-md-8 text-left">
            <p> 
                {{-- @if($history->attachs !='' && HP::checkFileStorage($attach_path.$history->attachs)) --}}
                <a href="{{url('certify/check/file_cb_client/'.$history->attachs.'/'.( !empty($history->attach_client_name) ? $history->attach_client_name : basename($history->attachs) ))}}" target="_blank">
                    {!! HP::FileExtension($history->attachs)  ?? '' !!}
                    {{@basename($history->attachs)}} 
                </a>
                {{-- @endif --}}
        
            </p>
        </div>
        </div>
    @endif
@endif

@if(!is_null($history->attachs_file))
<div class="row">
<div class="col-md-4 text-right">
<p class="text-nowrap">หลักฐานการชำระเงินค่าตรวจประเมิน:</p>
</div>
<div class="col-md-8 text-left">
    <p> 
      {{-- @if($history->attachs_file !='' && HP::checkFileStorage($attach_path.$history->attachs_file)) --}}
         <a href="{{url('certify/check/file_cb_client/'.$history->attachs_file.'/'.( !empty($history->evidence) ? $history->evidence : basename($history->attachs_file) ))}}" target="_blank">
            {!! HP::FileExtension($history->attachs_file)  ?? '' !!}
            {{@basename($history->attachs_file)}}
        </a> 
     {{-- @endif --}}
    </p>
</div>
</div>
@endif
 
@if(!is_null($history->status))
<div class="row">
    <div class="col-md-4 text-right">
        <p class="text-nowrap">ตรวจสอบการชำค่าตรวจประเมิน :</p> 
    </div>
    <div class="col-md-8 text-left">
        <label  >   <input type="radio" class="check check-readonly" data-radio="iradio_square-green" {{ ($history->status == 1 ) ? 'checked' : ' '  }}>  &nbsp; ได้รับการชำระเงินค่าตรวจประเมินเรียบร้อยแล้ว  &nbsp;</label>
        <label >   <input type="radio" class="check check-readonly" data-radio="iradio_square-red" {{ ($history->status != 1 ) ? 'checked' : ' '  }}>  &nbsp;ยังไม่ได้ชำระเงิน  &nbsp;</label>
    </div>
</div> 
@endif

@if(!is_null($history->details_four)) 
<div class="row">
<div class="col-md-4 text-right">
    <p class="text-nowrap">หมายเหตุ :</p>
</div>
<div class="col-md-8 text-left">
    {{ $history->details_four ?? '-' }}
</div>
</div>
@endif


 @if(!is_null($history->created_at)) 
 <div class="row">
 <div class="col-md-4 text-right">
     <p class="text-nowrap">วันที่บันทึก :</p>
 </div>
 <div class="col-md-8 text-left">
     {{ @HP::DateThai($history->created_at) ?? '-' }}
 </div>
 </div>
 @endif


 @if(!is_null($history->details_auditors_cancel))
    <span class="text-danger">ยกเลิกแต่งตั้งคณะผู้ตรวจประเมิน</span>
    <hr>
    @php
    $auditors_cancel = json_decode($history->details_auditors_cancel);
    @endphp
    @if(!is_null(HP::UserTitle($auditors_cancel->created_cancel)) )
        <div class="row">
        <div class="col-md-4 text-right">
            <p class="text-nowrap">ผู้ยกเลิก</p>
        </div>
        <div class="col-md-7 text-left">
                {{HP::UserTitle($auditors_cancel->created_cancel)->FullName}}
        </div>
        </div>
    @endif
    @if(isset($auditors_cancel->date_cancel))
        <div class="row">
        <div class="col-md-4 text-right">
            <p class="text-nowrap">วันที่ยกเลิก</p>
        </div>
        <div class="col-md-7 text-left">
            {{ HP::DateThai($auditors_cancel->date_cancel)  ?? '-'}}
        </div>
        </div>
    @endif
    @if(isset($auditors_cancel->reason_cancel))
        <div class="row">
        <div class="col-md-4 text-right">
            <p class="text-nowrap">เหตุผลที่ยกเลิก</p>
        </div>
        <div class="col-md-7 text-left">
            {{ $auditors_cancel->reason_cancel   ?? '-'}}
        </div>
        </div>
    @endif
@endif