
 @if(!is_null($history->details))
 @php 
      $details =json_decode($history->details);
 @endphp   

 <div class="row">
  <div class="col-md-4 text-right">
     <p class="text-nowrap">จำนวนเงิน :</p>
  </div>
  <div class="col-md-7">
    <span>{{ !empty($details[0]->amount)  ?  number_format($details[0]->amount,2) : '-'}} บาท</span> 
  </div>
</div>
 
<div class="row">
    <div class="col-md-4 text-right">
       <p class="text-nowrap">วันที่แจ้งชำระ :</p>
    </div>
    <div class="col-md-7">
      <span>{{ !empty($details[0]->report_date)  ? HP::DateThai($details[0]->report_date) : '-'}} </span> 
    </div>
  </div>

@endif

@if (!is_null($history->attachs))
<div class="row">
    <div class="col-md-4 text-right">
       <p class="text-nowrap">หลักฐานค่าบริการในการตรวจประเมิน :</p>
    </div>
    <div class="col-md-7">
        <a href="{{url('certify/check/file_client/'.$history->attachs.'/'.( !empty($history->attach_client_name) ? $history->attach_client_name : basename($history->attachs)  ))}}" target="_blank">
            {!! HP::FileExtension($history->attachs)  ?? '' !!}
        </a>
    </div>
</div>
@endif


@if (!is_null($history->attachs_file))
<div class="row">
    <div class="col-md-4 text-right">
       <p class="text-nowrap">หลักฐานการชำระเงินค่าตรวจประเมิน :</p>
    </div>
    <div class="col-md-7">
        <a href="{{url('certify/check/file_client/'.$history->attachs_file.'/'.( !empty($history->evidence) ? $history->evidence : basename($history->attachs_file)  ))}}" target="_blank">
            {!! HP::FileExtension($history->attachs_file)  ?? '' !!}
        </a>
    </div>
</div>
@endif

@if (!is_null($history->status))
 <div class="row">
    <div class="col-md-4 text-right">
        <p class="text-nowrap">ตรวจสอบการชำค่าตรวจประเมิน :</p> 
    </div>
    <div class="col-md-7">
        <label><input type="radio"  {{ ($history->status == 1) ? 'checked' : '' }}   class="check check-readonly" data-radio="iradio_square-green">
            &nbsp;ได้รับการชำระเงินค่าตรวจประเมินเรียบร้อยแล้ว &nbsp;
       </label>
       <br>
       <label><input type="radio"  {{ ($history->status != 1) ? 'checked' : '' }}    class="check check-readonly" data-radio="iradio_square-red"  > 
           &nbsp;ยังไม่ได้ชำระเงิน &nbsp;
       </label>
    </div>
</div> 
@endif
@if(!is_null($history->details))
@php 
     $details =json_decode($history->details);
@endphp   
@if(isset($details[0]->detail) && !is_null($details[0]->detail))
    <div class="row">   
    <div class="col-md-4 text-right">
        <p class="text-nowrap">หมายเหตุ :</p>
    </div>
    <div class="col-md-7">
        <span>{{ !empty($details[0]->detail)  ? $details[0]->detail : '-'}} </span> 
    </div>
    </div>
 @endif
@endif

@if(!is_null($history->date)) 
<div class="row">
<div class="col-md-4 text-right">
    <p class="text-nowrap">วันที่บันทึก :</p>
</div>
<div class="col-md-7">
    {{ @HP::DateThai($history->date) ?? '-' }}
</div>
</div>
@endif
