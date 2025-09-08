


<div class="row">
     <div class="col-md-3 text-right">
        <p class="text-nowrap">หลักฐาน:</p>
     </div>
     <div class="col-md-9 text-left">

        <p> 
        <a href="{{url('certify/check/file_cb_client/'.$history->file.'/'.( !empty($history->file_client_name) ? $history->file_client_name : @basename($history->file) ))}}" target="_blank">
            {!! HP::FileExtension($history->file)  ?? '' !!}
            {{ !empty($history->file_client_name) ? $history->file_client_name :@basename($history->file)}}
        </a> 
        </p>

     </div>
</div>

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
