@if(!is_null($history->details_one) ||  !is_null($history->details_two) )
 <div class="row">
 <div class="col-md-4 text-right">
 <p class="text-nowrap">ระบุรายละเอียด:</p>
 </div>
 <div class="col-md-8  text-left">
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
     <div class="col-md-4 text-right">
     <p class="text-nowrap">หลักฐาน:</p>
     </div>
     <div class="col-md-8  text-left">
     @foreach($attachs as $item)
         <p> 
             @if(isset($item->file))
                <a href="{{url('certify/check/file_ib_client/'.$item->file.'/'.( !empty($item->file_client_name) ? $item->file_client_name : @basename($item->file) ))}}" target="_blank">
                    {!! HP::FileExtension($item->file)  ?? '' !!}
                    {{@basename($item->file)}}
                </a> 
             @endif
         </p>
     @endforeach
     </div>
     </div>
 @endif

 @if(!is_null($history->created_at)) 
 <div class="row">
 <div class="col-md-4 text-right">
     <p class="text-nowrap">วันที่บันทึก :</p>
 </div>
 <div class="col-md-8  text-left">
     {{ @HP::DateThai($history->created_at) ?? '-' }}
 </div>
 </div>
 @endif
