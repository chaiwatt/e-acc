<div class="row ">
    <div class="col-md-6">
        <label class="col-md-6 text-right"> รายงานการตรวจประเมิน : </label>
        <div class="col-md-6 text-left">
            @if(!is_null($history->details_three))
               <p>
                {{-- @if($history->details_three !='' && HP::checkFileStorage($attach_path.$history->details_three)) --}}
                <a href="{{url('certify/check/file_cb_client/'.$history->details_three.'/'.( !empty($history->file_client_name) ? $history->file_client_name : basename($history->details_three) ))}}" 
                    title="{{ !empty($history->file_client_name) ? $history->file_client_name :  basename($history->details_three) }}" target="_blank">
                    {!! HP::FileExtension($history->details_three)  ?? '' !!}
                </a>
                {{-- @endif --}}
            
             </p>
            @endif
        </div>
    </div>
    <div class="col-md-6">
        @if(!is_null($history->attachs_car))
        <label class="col-md-6 text-right"> รายงานปิด Car : </label>
        <div class="col-md-6 text-left">
                    <p>
                        {{-- @if($history->attachs_car !='' && HP::checkFileStorage($attach_path.$history->attachs_car)) --}}
                        <a href="{{url('certify/check/file_cb_client/'.$history->attachs_car.'/'.( !empty($history->attach_client_name) ? $history->attach_client_name : basename($history->attachs_car) ))}}" 
                            title="{{ !empty($history->attach_client_name) ? $history->attach_client_name :  basename($history->attachs_car) }}" target="_blank">
                            {!! HP::FileExtension($history->attachs_car)  ?? '' !!}
                        </a>
                        {{-- @endif --}}
                    </p>
        </div>
        @endif
    </div>
</div>

<div class="row">
@if(!is_null($history->details_four))
<div class="col-md-6">
    <label class="col-md-6 text-right"> รายงาน Scope : </label>
    <div class="col-md-6 text-left">
             @php
                  $details_four = json_decode($history->details_four);
            @endphp
            @if(!is_null($details_four))
            @foreach ($details_four as $item2)
                {{-- <p> --}}
                    {{-- @if($item2->file !='' && HP::checkFileStorage($attach_path.$item2->file)) --}}
                    <a href="{{url('certify/check/file_cb_client/'.$item2->file.'/'.( !empty($item2->file_client_name) ? $item2->file_client_name :   basename($item2->file) ))}}" 
                        title="{{ !empty($item2->file_client_name) ? $item2->file_client_name :  basename($item2->file) }}" target="_blank">
                         {!! HP::FileExtension($item2->file)  ?? '' !!}
                    </a>
                   {{-- @endif --}}
                {{-- </p> --}}
            @endforeach
            @endif
    </div>
</div>
@endif
@if(!is_null($history->attachs))
<div class="col-md-6">
    <label class="col-md-8 text-right"> สรุปรายงานการตรวจทุกครั้ง : </label>
    <div class="col-md-4 text-left">
             @php
                  $attachs = json_decode($history->attachs);
            @endphp
            @if(!is_null($attachs))
            @foreach ($attachs as $item3)
                {{-- <p> --}}
                    @if($item3->file !='' && HP::checkFileStorage($attach_path.$item3->file))
                    <a href="{{url('certify/check/file_cb_client/'.$item3->file.'/'.( !empty($item3->file_client_name) ? $item3->file_client_name :  basename($item3->file) ))}}" 
                        title="{{ !empty($item3->file_client_name) ? $item3->file_client_name :  basename($item3->file) }}" target="_blank">
                        {!! HP::FileExtension($item3->file)  ?? '' !!}
                    </a>
                   @endif
            
                {{-- </p> --}}
            @endforeach
            @endif
    </div>
</div>
@endif
</div>
<div class="row">
@if(!is_null($history->file))
<div class="col-md-6">
    <label class="col-md-6 text-right"> ไฟล์แนบ : </label>
    <div class="col-md-6 text-left">
             @php
                  $files = json_decode($history->file);
            @endphp
            @if(!is_null($files))
            @foreach ($files as $item4)
                {{-- <p> --}}
                    @if($item4->file !='' && HP::checkFileStorage($attach_path.$item4->file))
                      <a href="{{url('certify/check/file_cb_client/'.$item4->file.'/'.( !empty($item4->file_client_name) ? $item4->file_client_name :  basename($item4->file) ))}}" 
                        title="{{ !empty($item4->file_client_name) ? $item4->file_client_name :  basename($item4->file) }}" target="_blank">
                       {!! HP::FileExtension($item4->file)  ?? '' !!}
                     </a>
                   @endif
              
                {{-- </p> --}}
            @endforeach
            @endif
    </div>
</div>
@endif
</div>


<hr>@if(!is_null($history->status))
<div class="form-group">
    <div class="col-md-12">
        <label class="col-md-3 text-right">  เห็นชอบกับ Scope : </label>
        <div class="col-md-7">
            <label>   <input type="radio" class="check check-readonly" data-radio="iradio_square-green" {{ ($history->status == 1 ) ? 'checked' : ' '  }}>  &nbsp;ยืนยัน Scope &nbsp;</label>
            <label>   <input type="radio" class="check check-readonly" data-radio="iradio_square-red" {{ ($history->status == 2 ) ? 'checked' : ' '  }}>  &nbsp; แก้ไข Scope &nbsp;</label>
        </div>
    </div>
</div>
@endif

@if(!is_null($history->remark))
<div class="form-group">
    <div class="col-md-12">
        <label class="col-md-3 text-right"> หมายเหตุ : </label>
        <div class="col-md-7">
                {{ $history->remark ?? null }}
        </div>
    </div>
</div>
@endif

<div class="form-group">
    <div class="col-md-12">
        @if(!is_null($history->attachs_file))
        <label class="col-md-3 text-right"> ไฟล์แนบ : </label>
        <div class="col-md-7">
                @php
                      $attachs_file = json_decode($history->attachs_file);
                @endphp
                @foreach ($attachs_file as $item13)
                    <p>
                        {{ @$item13->file_desc}}
                        {{-- @if($item13->file !='' && HP::checkFileStorage($attach_path.$item13->file)) --}}
                           <a href="{{url('certify/check/file_cb_client/'.$item13->file.'/'.( !empty($item13->file_client_name) ? $item13->file_client_name :  basename($item13->file) ))}}" 
                               title="{{ !empty($item13->file_client_name) ? $item13->file_client_name :  basename($item13->file) }}" target="_blank">
                               {!! HP::FileExtension($item13->file)  ?? '' !!}
                           </a>
                        {{-- @endif --}}
                     
                    </p>
                @endforeach
         
        </div>
         @endif
    </div>
</div>

@if(!is_null($history->date)) 
<div class="row">
<label class="col-md-3 text-right">
  วันที่บันทึก :
</label>
<div class="col-md-8 text-left">
{{ @HP::DateThai($history->date) ?? '-' }}
</div>
</div>
@endif