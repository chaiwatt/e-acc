@if(!is_null($history->details_one) ||  !is_null($history->details_two) )
 <div class="row">
 <div class="col-md-3 text-right">
 <p class="text-nowrap">ระบุรายละเอียด:</p>
 </div>
 <div class="col-md-9 text-left">
        {!!  $history->details_one  ?? '' !!}
        {!!  $history->details_two  ?? '' !!}
 </div>
 </div>
@endif

 @if(!is_null($history->attachs))
     @php 
     $attachs = json_decode($history->attachs);
     @endphp 
     <div class="row">
     <div class="col-md-3 text-right">
     <p class="text-nowrap">หลักฐาน:</p>
     </div>
     <div class="col-md-9 text-left">
     @foreach($attachs as $item)
         <p> 
            <a href="{{url('certify/check/file_cb_client/'.$item->file.'/'.( !empty($item->file_client_name) ? $item->file_client_name : @basename($item->file) ))}}" target="_blank">
                {!! HP::FileExtension($item->file)  ?? '' !!}
                {{ !empty($item->file_client_name) ? $item->file_client_name :@basename($item->file)}}
            </a> 
         </p>
     @endforeach
     </div>
     </div>
 @endif

 @if(!is_null($history->created_at)) 
 <div class="row">
 <div class="col-md-3 text-right">
     <p  >วันที่บันทึก :</p>
 </div>
 <div class="col-md-9 text-left">
     {{ @HP::DateThai($history->created_at) ?? '-' }}
 </div>
 </div>
 @endif
