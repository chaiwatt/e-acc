
 
@if(isset($history->details_one)) 
<div class="row">
<div class="col-md-4 text-right">
    <p class="text-nowrap">วันที่ประชุม :</p>
</div>
<div class="col-md-4 text-left">
    {{   !empty($history->details_one) ? @HP::DateThai($history->details_one) : null }}
</div>
</div>
@endif

@if(isset($history->details_two)) 
<div class="row">
<div class="col-md-4 text-right">
    <p class="text-nowrap">รายละเอียด :</p>
</div>
<div class="col-md-4 text-left">
    {{ @$history->details_two ?? '-' }}
</div>
</div>
@endif

@if(isset($history->status)) 
<div class="row">
<div class="col-md-4 text-right">
    <p class="text-nowrap">มติคณะกรรมการ :</p>
</div>
<div class="col-md-8 text-left">
    <label  >   <input type="radio" class="check check-readonly" data-radio="iradio_square-green" {{ ($history->status == 1 ) ? 'checked' : ' '  }}>  &nbsp; เห็นชอบ  &nbsp;</label>
    <label >   <input type="radio" class="check check-readonly" data-radio="iradio_square-red" {{ ($history->status != 1 ) ? 'checked' : ' '  }}>  &nbsp;ไม่เห็นชอบ  &nbsp;</label>
</div>
</div>
@endif


@if(!is_null($history->file)) 
<div class="row">
<div class="col-md-4 text-right">
   <p class="text-nowrap">ขอบข่ายที่ได้รับการเห็นชอบ :</p>
</div>
<div class="col-md-8 text-left">
      <p> 
        {{-- @if($history->file !='' && HP::checkFileStorage($attach_path.$history->file)) --}}
        <a href="{{url('certify/check/file_cb_client/'.$history->file.'/'.( !empty($history->file_client_name) ? $history->file_client_name :  basename($history->file) ))}}" 
            title="{{ !empty($history->file_client_name) ? $history->file_client_name :  basename($history->file) }}" target="_blank">
             {!! HP::FileExtension($history->file)  ?? '' !!}
          </a>
        {{-- @endif --}}
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
            {{-- @if($item->file !='' && HP::checkFileStorage($attach_path.$item->file)) --}}
             <a href="{{url('certify/check/file_cb_client/'.$item->file.'/'.( !empty($item->file_client_name) ? $item->file_client_name :  basename($item->file) ))}}" 
                 title="{{ !empty($item->file_client_name) ? $item->file_client_name :  basename($item->file) }}" target="_blank">
                 {!! HP::FileExtension($item->file)  ?? '' !!}
             </a>
            {{-- @endif --}}
   
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