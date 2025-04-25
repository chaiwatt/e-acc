
<div class="form-group">
    <div class="col-md-6">
        <label class="col-md-5 text-right"> รายงานการตรวจประเมิน : </label>
        <div class="col-md-7">
            @if(!is_null($history->file))
               <p>
                 <a href="{{url('certify/check/file_client/'.$history->file.'/'.( !empty($history->file_client_name) ? $history->file_client_name : basename($history->file) ))}}" 
                    title="{{  !empty($history->file_client_name) ? $history->file_client_name :  basename($history->file)}}"  target="_blank">
                     {!! HP::FileExtension($history->file)  ?? '' !!}
                     {{-- {{basename($history->file)}} --}}
                 </a>
             </p>
            @endif
        </div>
    </div>
    <div class="col-md-6">
        <label class="col-md-5 text-right"> รายงาน Scope : </label>
        <div class="col-md-7">
            @if(!is_null($history->details_table))
                @php
                $details_table = json_decode($history->details_table);
                @endphp
                @if(!is_null($details_table))
                    @foreach ($details_table as $item1)
                        <p>
                            <a href="{{url('certify/check/file_client/'.$item1->attachs.'/'.( !empty($item1->attachs_client_name) ? $item1->attachs_client_name : basename($item1->attachs) ))}}" 
                                title="{{  !empty($item1->attachs_client_name) ? $item1->attachs_client_name :  basename($item1->attachs)}}"  target="_blank">
                                {!! HP::FileExtension($item1->attachs)  ?? '' !!}
                               {{-- {{basename($item2->attachs)}} --}}
                            </a>
                        </p>
                    @endforeach
                @endif
            @endif
        </div>
    </div>
</div>
<div class="form-group">
    <div class="col-md-6">
        @if(!is_null($history->attachs))
        <label class="col-md-5 text-right"> ไฟล์แนบ : </label>
        <div class="col-md-7">
                 @php
                      $attachs = json_decode($history->attachs);
                @endphp
                @if(!is_null($attachs))
                @foreach ($attachs as $item3)
                    <p>
                        <a href="{{url('certify/check/file_client/'.$item3->attachs.'/'.( !empty($item3->attachs_client_name) ? $item3->attachs_client_name : basename($item3->attachs) ))}}" 
                            title="{{  !empty($item3->attachs_client_name) ? $item3->attachs_client_name :  basename($item3->attachs)}}"  target="_blank">
                         {!! HP::FileExtension($item3->attachs)  ?? '' !!}
                         {{-- {{basename($item3->attachs)}} --}}
                        </a>
                    </p>
                @endforeach
                @endif
        </div>
        @endif
    </div>

    <div class="col-md-6">
        @if(!is_null($history->details_date))
        <label class="col-md-4 text-right"> ไฟล์แนบ Car : </label>
        <div class="col-md-8">
              <p>
                 <a href="{{url('certify/check/file_client/'.$history->details_date.'/'.( !empty($history->attach_client_name) ? $history->attach_client_name : basename($history->details_date)  ))}}" 
                        title="{{  !empty($history->attach_client_name) ? $history->attach_client_name :  basename($history->details_date)}}"  target="_blank">
                    {!! HP::FileExtension($history->details_date)  ?? '' !!}
                    {{-- {{basename($history->details_date)}} --}}
                </a> 
             </p>
        </div>
        @endif
    </div>
  
</div>
<hr>
@if(!is_null($history->status_scope))
<div class="form-group">
    <div class="col-md-12">
        <label class="col-md-3 text-right">  เห็นชอบกับ Scope : </label>
        <div class="col-md-7">
            <label>   <input type="radio" class="check check-readonly" data-radio="iradio_square-green" {{ ($history->status_scope == 1 ) ? 'checked' : ' '  }}>  &nbsp;ยืนยัน Scope &nbsp;</label>
            <label>   <input type="radio" class="check check-readonly" data-radio="iradio_square-red" {{ ($history->status_scope == 2 ) ? 'checked' : ' '  }}>  &nbsp; แก้ไข Scope &nbsp;</label>
        </div>
    </div>
</div>
@endif

@if(!is_null($history->remark))
<div class="form-group">
    <div class="col-md-12">
        <label class="col-md-4 text-right"> หมายเหตุ : </label>
        <div class="col-md-7">
                {{ $history->remark ?? null }}
        </div>
    </div>
</div>
@endif

<div class="form-group">
    <div class="col-md-12">
        @if(!is_null($history->evidence))
        <label class="col-md-4 text-right"> ไฟล์แนบ : </label>
        <div class="col-md-7">
                @php
                      $evidence = json_decode($history->evidence);
                @endphp
                @if(!is_null($evidence))
                @foreach ($evidence as $history3)
                    <p>
                         {{ @$history3->file_desc_text }}
                       <a href="{{url('certify/check/file_client/'.$history3->attachs.'/'.( !empty($history3->attachs_client_name) ? $history3->attachs_client_name : basename($history3->attachs)  ))}}" target="_blank">
                         {!! HP::FileExtension($history3->attachs)  ?? '' !!}
                      </a>
                       
                    </p>
                @endforeach
                @endif
        </div>
         @endif
    </div>
</div>

@if(!is_null($history->date)) 
<div class="row">
<div class="col-md-4 text-right">
    <p class="text-nowrap">วันที่บันทึก</p>
</div>
<div class="col-md-7">
    {{ @HP::DateThai($history->date) ?? '-' }}
</div>
</div>
@endif