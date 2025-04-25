@if(!is_null($history->details))
 <div class="row">
 <div class="col-md-3 text-right">
 <p class="text-nowrap">ระบุรายละเอียด:</p>
 </div>
 <div class="col-md-9">
        {!!  $history->details  ?? '' !!}
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
     <div class="col-md-9">
     @foreach($attachs as $files)
         <p> 
             @if(isset($files->file))
             <a href="{{ url('certify/check/files/'.$files->file) }}"> 
              {!! HP::FileExtension($files->file)  ?? '' !!}
                 {{@basename($files->file)}}
             </a>
             @endif
         </p>
     @endforeach
     </div>
     </div>
 @endif