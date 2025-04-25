



@php 
    $payin2 = json_decode($history->details_one);
    $amount  =  !empty($payin2->amount) ? $payin2->amount :  '0';
    $amount_fee  =  !empty($payin2->amount_fee) ?$payin2->amount_fee :  '0';
    $amount_fixed  =  !empty($payin2->amount_fixed) ?$payin2->amount_fixed :  '0';
    $sum =   ((string)$amount  +   (string)$amount_fee  +   (string)$amount_fixed);
@endphp

<div class="row">
<div class="col-sm-5 text-right"> <b>เงื่อนไขการชำระเงิน :</b></div>
<div class="col-sm-7">
    <p>  
     @if (!empty($payin2->conditional_type))
         @if ($payin2->conditional_type == 1) <!--  หลักฐานค่าธรรมเนียม -->
            หลักฐานค่าธรรมเนียม
        @elseif($payin2->conditional_type == 2) <!--  ยกเว้นค่าธรรมเนียม -->  
            ยกเว้นค่าธรรมเนียม
        @elseif($payin2->conditional_type == 3) <!--  ยกเว้นค่าชำระเงินนอกระบบ, ไม่เรียกชำระเงิน หรือ กรณีอื่นๆธรรมเนียม --> 
            ยกเว้นค่าชำระเงินนอกระบบ, ไม่เรียกชำระเงิน หรือ กรณีอื่นๆธรรมเนียม
        @endif
    @else 
         หลักฐานค่าธรรมเนียม   
    @endif

    </p>
</div>
</div>

<div class="row">
<div class="col-sm-5 text-right"> <b>จำนวนเงิน :</b></div>
<div class="col-sm-6">
    <p>  
        {{ !empty($sum) ? number_format($sum,2) : '0.00' }}
    </p>
</div>
</div>
@if (!empty($payin2->conditional_type))
    @if ($payin2->conditional_type == 1) <!--  หลักฐานค่าธรรมเนียม -->
    <div class="row">
    <div class="col-sm-5 text-right"> <b>วันที่แจ้งชำระ :</b></div>
    <div class="col-sm-6">
        <p>  
            {{  !empty($payin2->report_date) ? HP::DateThai($payin2->report_date) :  null }}
        </p>
    </div>
    </div>   
    @if(!is_null($history->attachs)) 
    <div class="row">
    <div class="col-sm-5 text-right"> <b>ใบแจ้งหนี้ค่าธรรมเนียม :</b></div>
    <div class="col-sm-6 text-left">
        <p>  
            <a href="{{url('certify/check/file_ib_client/'.$history->attachs.'/'.( !empty($history->attach_client_name) ? $history->attach_client_name :  basename($history->attachs) ))}}" 
                title="{{ !empty($history->attach_client_name) ? $history->attach_client_name :  basename($history->attachs) }}" target="_blank">
                {!! HP::FileExtension($history->attachs)  ?? '' !!}
            </a>
        </p>
    </div>
    </div>
    @endif

@elseif($payin2->conditional_type == 2) <!--  ยกเว้นค่าธรรมเนียม -->
    <div class="row">
    <div class="col-sm-5 text-right"> <b>วันที่แจ้งชำระ :</b></div>
    <div class="col-sm-6">
        <p>  
            {{  !empty($payin2->start_date_feewaiver) && !empty($payin2->end_date_feewaiver) ? HP::DateFormatGroupTh($payin2->start_date_feewaiver,$payin2->end_date_feewaiver) :  '-' }}
        </p>
    </div>
    </div>   
    @if(!is_null($history->attachs)) 
    <div class="row">
    <div class="col-sm-5 text-right"> <b>ใบแจ้งหนี้ค่าธรรมเนียม :</b></div>
    <div class="col-sm-6 text-left">
        <p>  
            <a href="{{url('funtions/get-view-file/'.base64_encode($history->attachs).'/'.( !empty($history->attach_client_name) ? $history->attach_client_name : basename($history->attachs) ))}}" target="_blank">
                {!! HP::FileExtension($history->attachs)  ?? '' !!}
            </a>
        </p>
    </div>
    </div>
    @endif

@elseif($payin2->conditional_type == 3) <!--  ยกเว้นค่าชำระเงินนอกระบบ, ไม่เรียกชำระเงิน หรือ กรณีอื่นๆธรรมเนียม -->
    <div class="row">
    <div class="col-sm-5 text-right"> <b>หมายเหตุ :</b></div>
    <div class="col-sm-6">
        <p>  
            {{  !empty($payin2->remark)  ? $payin2->remark :  '-' }}
        </p>
    </div>
    </div>   
    @if(!is_null($history->attachs)) 
    <div class="row">
    <div class="col-sm-5 text-right"> <b>ไฟล์แนบ :</b></div>
    <div class="col-sm-6 text-left">
        <p>  
            <a href="{{url('certify/check/file_ib_client/'.$history->attachs.'/'.( !empty($history->attach_client_name) ? $history->attach_client_name :  basename($history->attachs) ))}}" 
                title="{{ !empty($history->attach_client_name) ? $history->attach_client_name :  basename($history->attachs) }}" target="_blank">
                {!! HP::FileExtension($history->attachs)  ?? '' !!}
            </a>
        </p>
    </div>
    </div>
    @endif
@endif

@else 

@if(!is_null($history->attachs)) 
 <div class="row">
    <div class="col-sm-5 text-right"> <b>ใบแจ้งหนี้ค่าธรรมเนียม :</b></div>
    <div class="col-sm-6 text-left">
        <p>  
            <a href="{{url('certify/check/file_ib_client/'.$history->attachs.'/'.( !empty($history->attach_client_name) ? $history->attach_client_name :  basename($history->attachs) ))}}" 
                title="{{ !empty($history->attach_client_name) ? $history->attach_client_name :  basename($history->attachs) }}" target="_blank">
                {!! HP::FileExtension($history->attachs)  ?? '' !!}
            </a>
         </p>
    </div>
  </div>
  @endif

@endif



@if(!is_null($history->attachs_file)) 
<div class="row">
<div class="col-sm-5 text-right"> <b>หลักฐานค่าธรรมเนียม :</b></div>
<div class="col-sm-6 text-left">
    <p>  
        <a href="{{url('certify/check/file_ib_client/'.$history->attachs_file.'/'.( !empty($history->evidence) ? $history->evidence :  basename($history->attachs_file) ))}}" 
            title="{{ !empty($history->evidence) ? $history->evidence :  basename($history->attachs_file) }}" target="_blank">
            {!! HP::FileExtension($history->attachs_file)  ?? '' !!}
       </a>
     </p>
</div>
</div>
@endif
@if(!is_null($history->status)) 
<div class="row">
<div class="col-sm-5 text-right"> <b>ตรวจสอบการชำระ :</b></div>
<div class="col-sm-6 text-left">
    <label  >   <input type="radio" class="check check-readonly" data-radio="iradio_square-green" {{ ($history->status == 1 ) ? 'checked' : ' '  }}>  &nbsp; รับชำระเงินเรียบร้อยแล้ว  &nbsp;</label>
    <label >   <input type="radio" class="check check-readonly" data-radio="iradio_square-red" {{ ($history->status != 1 ) ? 'checked' : ' '  }}>  &nbsp;ยังไม่ชำระเงิน  &nbsp;</label>
</div>
</div>
@endif

@if(isset($payin2->detail) ) 
<div class="row ">
<div class="col-sm-5 text-right"><b>หมายเหตุ :</b>  </div>
  <div class="col-sm-7 text-left">
    {{ $payin2->detail ?? null }}
</div>
</div>
@endif

 