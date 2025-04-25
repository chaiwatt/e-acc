

 
@if(!is_null($history->details_one))
@php 
     $details_one =json_decode($history->details_one);
@endphp 
 
@if(isset($details_one->report_date)) 
    <div class="row">
    <div class="col-md-4 text-right">
        <p class="text-nowrap">วันที่ประชุม :</p>
    </div>
    <div class="col-md-8 text-left">
        {{   !empty($details_one->report_date) ? @HP::DateThai(date("Y-m-d",strtotime($details_one->report_date))) : null }}
    </div>
    </div>
@endif

@if(isset($details_one->details)) 
    <div class="row">
    <div class="col-md-4 text-right">
        <p class="text-nowrap">รายละเอียด :</p>
    </div>
    <div class="col-md-8 text-left">
        {{ @$details_one->details ?? '-' }}
    </div>
    </div>
@endif

@if(isset($details_one->report_status)) 
    <div class="row">
    <div class="col-md-4 text-right">
        <p class="text-nowrap">มติคณะกรรมการ :</p>
    </div>
    <div class="col-md-8 text-left">
        <label  >   <input type="radio" class="check check-readonly" data-radio="iradio_square-green" {{ ($details_one->report_status == 1 ) ? 'checked' : ' '  }}>  &nbsp; เห็นชอบ  &nbsp;</label>
        <label >   <input type="radio" class="check check-readonly" data-radio="iradio_square-red" {{ ($details_one->report_status != 1 ) ? 'checked' : ' '  }}>  &nbsp;ไม่เห็นชอบ  &nbsp;</label>
    </div>
    </div>
@endif

@endif

@if(!is_null($history->file)) 
<div class="row">
    <div class="col-md-4 text-right">
       <p class="text-nowrap">ขอบข่ายที่ได้รับการเห็นชอบ :</p>
    </div>
    <div class="col-md-8 text-left">
          <p> 
            <a href="{{url('certify/check/file_ib_client/'.$history->file.'/'.( !empty($history->file_client_name) ? $history->file_client_name :  basename($history->file) ))}}" 
                title="{{ !empty($history->file_client_name) ? $history->file_client_name :  basename($history->file) }}" target="_blank">
                 {!! HP::FileExtension($history->file)  ?? '' !!}
              </a>
           </p>
    </div>
  </div>
  @endif

  @if(!is_null($history->attachs)) 
  @php 
       $attachs = json_decode($history->attachs);
 @endphp
  <div class="row">
      <div class="col-md-4 text-right">
         <p class="text-nowrap">หลักฐานอื่นๆ :</p>
      </div>
      <div class="col-md-8 text-left">
            @foreach($attachs as $key1 => $item)   
            <p> 
                {{ @$item->file_desc }}
                <a href="{{url('certify/check/file_ib_client/'.$item->file.'/'.( !empty($item->file_client_name) ? $item->file_client_name :  basename($item->file) ))}}" 
                    title="{{ !empty($item->file_client_name) ? $item->file_client_name :  basename($item->file) }}" target="_blank">
                    {!! HP::FileExtension($item->file)  ?? '' !!}
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
<div class="col-md-8 text-left">
    {{ @HP::DateThai($history->date) ?? '-' }}
</div>
</div>
@endif