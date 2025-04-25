
 
@if(!is_null($history->details))
@php 
     $details =json_decode($history->details);
@endphp 
 
@if(isset($details->meet_date)) 
    <div class="row">
    <div class="col-md-4 text-right">
        <p class="text-nowrap">วันที่ประชุม :</p>
    </div>
    <div class="col-md-4">
        {{   !empty($details->meet_date) ? @HP::DateThai(date("Y-m-d",strtotime($details->meet_date))) : null }}
    </div>
    </div>
@endif

@if(isset($details->desc)) 
    <div class="row">
    <div class="col-md-4 text-right">
        <p class="text-nowrap">รายละเอียด :</p>
    </div>
    <div class="col-md-4">
        {{ @$details->desc ?? '-' }}
    </div>
    </div>
@endif

@if(isset($details->status)) 
    <div class="row">
    <div class="col-md-4 text-right">
        <p class="text-nowrap">มติคณะอนุกรรมการ :</p>
    </div>
    <div class="col-md-8">
        <label  >   <input type="radio" class="check check-readonly" data-radio="iradio_square-green" {{ ($details->status == 1 ) ? 'checked' : ' '  }}>  &nbsp; เห็นชอบ  &nbsp;</label>
        <label >   <input type="radio" class="check check-readonly" data-radio="iradio_square-red" {{ ($details->status != 1 ) ? 'checked' : ' '  }}>  &nbsp;ไม่เห็นชอบ  &nbsp;</label>
    </div>
    </div>
@endif

@endif

@if(!is_null($history->file)) 
<div class="row">
    <div class="col-md-4 text-right">
       <p class="text-nowrap">ขอบข่ายที่ได้รับการเห็นชอบ :</p>
    </div>
    <div class="col-md-8">
          <p> 
            <a href="{{url('certify/check/file_client/'.$history->file.'/'.( !empty($history->file_client_name) ? $history->file_client_name :  basename($history->file)  ))}}" target="_blank">
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
      <div class="col-md-8">
            @foreach($attachs as $key1 => $item)   
            <p> 
                {{ @$item->file_desc }}
                <a href="{{url('certify/check/file_client/'.$item->file.'/'.( !empty($item->file_client_name) ? $item->file_client_name :  basename($item->file) ))}}" 
                    title=" {{ !empty($item->file_client_name) ? $item->file_client_name : basename($item->file)}}"  target="_blank"> 
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
<div class="col-md-8">
    {{ @HP::DateThai($history->date) ?? '-' }}
</div>
</div>
@endif