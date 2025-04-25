@if(!is_null($history->details)) 
<div class="row">
  <div class="col-md-4 text-right">
     <p class="text-nowrap">ชื่อคณะผู้ตรวจประเมิน :</p>
  </div>
  <div class="col-md-7">
    <span>{{$history->details ?? '-'}}</span> 
  </div>
 </div>
 @endif  

 @if(!is_null($history->DataBoardAuditorDateTitle)) 
 <div class="row">
   <div class="col-md-4 text-right">
      <p class="text-nowrap">วันที่ตรวจประเมิน :</p>
   </div>
   <div class="col-md-7">
     <span>   {!!  @$history->DataBoardAuditorDateTitle  ?? '-' !!}  </span> 
   </div>
  </div>
@endif  




@if(!is_null($history->attachs)) 
<div class="row">
 <div class="col-md-4 text-right">
    <p class="text-nowrap">กำหนดการตรวจประเมิน :</p>
 </div>
 <div class="col-md-7">
    <span>  
      <a href="{{url('certify/check/file_client/'.$history->attachs.'/'.( !empty($history->attach_client_name) ? $history->attach_client_name :  basename($history->attachs)  ))}}" target="_blank">
          {!! HP::FileExtension($history->attachs)  ?? '' !!}
      </a>
   </span> 
 </div>
</div>
@endif  

<div class="col-md-12">
  <label>โดยคณะผู้ตรวจประเมิน มีรายนามดังต่อไปนี้</label>
</div>

@if(!is_null($history->details_table))
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
           $groups = json_decode($history->details_table);
         @endphp
          @foreach($groups as $key2 => $item2)
            @php
                 $status = App\Models\Bcertify\StatusAuditor::where('id',$item2->status)->first();
            @endphp
          <tr>
              <td  class="text-center">{{ $key2 +1 }}</td>
              <td> {{ $status->title ?? '-'  }}</td>
              <td>
                @if(count($item2->temp_users) > 0) 
                    @foreach($item2->temp_users as $key3 => $item3)
                        {{ $item3 ?? '-' }}
                    @endforeach
                @endif
              </td>
              <td>
                @if(count($item2->temp_departments) > 0) 
                    @foreach($item2->temp_departments as $key4 => $item4)
                        {{ $item4 ?? '-' }}
                    @endforeach
                @endif
              </td>
          </tr>
          @endforeach
    </tbody>
</table>
</div>
@endif

@if(!is_null($history->details_cost_confirm))
@php
  $details_cost_confirm = json_decode($history->details_cost_confirm);
@endphp
<div class="col-md-12">
  <label>ประมาณค่าใช้จ่าย</label>
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
      @foreach($details_cost_confirm as $key => $item3)
          @php     
          $amount_date = !empty($item3->amount_date) ? $item3->amount_date : 0 ;
          $amount = !empty($item3->amount) ? $item3->amount : 0 ;
          $sum =   $amount*$amount_date;
          $SumAmount  +=  $sum;
          $details = App\Models\Bcertify\StatusAuditor::where('id',$item3->desc)->first();
          @endphp
          <tr>
              <td class="text-center">{{ $key+1 }}</td>
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
@if(!is_null($history->status)) 
<div class="row">
 <div class="col-md-4 text-right">
    <p class="text-nowrap">กำหนดการตรวจประเมิน :</p>
 </div>
 <div class="col-md-7">
    <label>   <input type="radio" class="check check-readonly" data-radio="iradio_square-green" {{ ($history->status == 1 ) ? 'checked' : ' '  }}>  &nbsp;เห็นชอบดำเนินการแต่งตั้งคณะผู้ตรวจประเมินต่อไป &nbsp;</label>
    <br>
    <label>   <input type="radio" class="check check-readonly" data-radio="iradio_square-red" {{ ($history->status == 2 ) ? 'checked' : ' '  }}>  &nbsp;ไม่เห็นชอบ เพราะ  &nbsp;</label>
 </div>
</div>
@endif  

@if(!is_null($history->remark)) 
<div class="row">
<div class="col-md-4 text-right">
   <p class="text-nowrap">หมายเหตุ :</p>
</div>
<div class="col-md-7">
    {{ @$history->remark  ?? '-'}}
</div>
</div>
@endif  

@if(!is_null($history->attachs_file)) 
@php 
$attachs_file = json_decode($history->attachs_file);
@endphp 
<div class="row">
<div class="col-md-4 text-right">
  <p class="text-nowrap">หลักฐาน :</p>
</div>
<div class="col-md-7">
  @foreach($attachs_file as $files)
    <p> 
        {{  @$files->file_desc  }}
        <a href="{{url('certify/check/file_client/'.$files->file.'/'.( !empty($files->file_client_name) ? $files->file_client_name :  basename($files->file)   ))}}" target="_blank">
          {!! HP::FileExtension($files->file)  ?? '' !!}
       </a>
    </p>
 @endforeach
</div>
</div>
@endif 

@if(!is_null($history->date)) 
  <div class="row">
     <div class="col-md-4 text-right">
           <p class="text-nowrap">วันที่บันทึก :</p>
     </div>
      <div class="col-md-7">
           {{ HP::DateThai($history->date)  ?? '-'}}
    </div>
  </div>
 @endif  