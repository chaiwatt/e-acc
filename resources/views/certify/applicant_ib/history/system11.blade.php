@push('css')
    <link href="{{asset('plugins/components/bootstrap-datepicker/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
@endpush
@if(!is_null($history->file))
<div class="row">
    <div class="col-md-5 text-right">
       <p >คณะผู้ตรวจประเมิน</p>
    </div>
    <div class="col-md-7 text-left">
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
<div class="row">
    <div class="col-md-5 text-right">
       <p >ผลการตรวจคณะผู้ตรวจประเมิน</p>
    </div>
    <div class="col-md-7 text-left">
        <p>  
            <a href="{{url('certify/check/file_ib_client/'.$history->attachs.'/'.( !empty($history->attach_client_name) ? $history->attach_client_name :  basename($history->attachs) ))}}" 
                title="{{ !empty($history->attach_client_name) ? $history->attach_client_name :  basename($history->attachs) }}" target="_blank">
              {!! HP::FileExtension($history->attachs)  ?? '' !!}
            </a>
         </p>
    </div>
</div>
@endif

@if(!is_null($history->details_one))
<div class="row">
    <div class="col-md-5 text-right">  </div>
    <div class="col-md-7 text-left">
        <div class="checkbox checkbox-success">
            <input id="checkbox3" type="checkbox"  {{ ($history->details_one == 2) ? 'checked': '' }}  disabled>
            <label for="checkbox3">  &nbsp; ยืนยันแต่งตั้งคณะทบทวนฯ </label>
        </div>
    </div>
</div>
@endif


@push('js')
<script src="{{asset('plugins/components/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js')}}" type="text/javascript"></script>
 @endpush