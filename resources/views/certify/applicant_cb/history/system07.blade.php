@if(!is_null($history->details_two)) 
@php 
$details_two = json_decode($history->details_two);
@endphp
 
<div class="row">
<div class="col-sm-12 m-t-15" >
   <table class="table color-bordered-table primary-bordered-table">
       <thead>
       <tr>
          <th class="text-center bg-info  text-white" width="2%">ลำดับ</th>
          <th class="text-center bg-info  text-white" width="15%">รายงานที่</th>
          <th class="text-center bg-info  text-white" width="15%">ผลการประเมินที่พบ</th>
          <th class="text-center bg-info  text-white" width="15%">มอก. 17025 : ข้อ</th>
          <th class="text-center bg-info  text-white" width="10%">ประเภท</th>
          <th class="text-center bg-info  text-white" width="33%">แนวทางการแก้ไข</th>
          <th class="text-center bg-info  text-white" width="20%" >หลักฐาน</th>
       </tr>
       </thead>
       <tbody >
      @if (!is_null($details_two))
         @foreach($details_two as $key1 => $item1)   
             @php 
               $type =   ['1'=>'ข้อบกพร่อง','2'=>'ข้อสังเกต'];
           @endphp
             <tr>
                <td class="text-center">{{ $key1+1 }}</td>
                <td>
                    {{ $item1->report ?? null }}
                </td>
                <td>
                    {{ $item1->remark ?? null }}
                </td>
                <td>
                    {{ $item1->no ?? null }}
                </td>
                <td>
                    {{  array_key_exists($item1->type,$type) ? $type[$item1->type] : '-' }}  
                </td>
              
                <td>
                    {{ @$item1->details ?? null }}
                    <br>
                    @if($item1->status == 1) 
                      <label for="app_name"> <span> <i class="fa fa-check-square" style="font-size:20px;color:rgb(0, 255, 42)"></i></span> ผ่าน </label> 
                    @elseif(!is_null($item1->comment)) 
                    <label for="app_name"><span>  <i class="fa  fa-close" style="font-size:20px;color:rgb(255, 0, 0)"></i> {{  'ไม่ผ่าน:'.$item1->comment ?? null   }}</span> </label> 
                   @endif
                </td>
                <td>

                         @if($item1->status == 1) 
                                     @if($item1->file_status == 1)
                                              <span> <i class="fa fa-check-square" style="font-size:20px;color:rgb(0, 255, 42)"></i> ผ่าน</span>  
                                     @elseif(isset($item1->file_comment))
                                            @if(!is_null($item1->file_comment))
                                              <span> <i class="fa  fa-close" style="font-size:20px;color:rgb(255, 0, 0)"></i> ไม่ผ่าน </span> 
                                              {!!   " : ".$item1->file_comment ?? null  !!}
                                            @endif
                                    @endif
                                <label for="app_name">
                                    <span>
                                        @if(!is_null($item1->attachs) && isset($item1->attachs) )
                                          {{-- @if($item1->attachs !='' && HP::checkFileStorage($attach_path.$item1->attachs)) --}}
                                          <a href="{{url('certify/check/file_cb_client/'.$item1->attachs.'/'.( !empty($item1->attach_client_name) ? $item1->attach_client_name :   basename($item1->attachs) ))}}" 
                                               title="{{ !empty($item1->attach_client_name) ? $item1->attach_client_name :  basename($item1->attachs) }}" target="_blank">
                                               {!! HP::FileExtension($item1->attachs)  ?? '' !!}
                                         </a>
                                         {{-- @endif --}}
                                            {{-- <a href="{{ url('/certify/check/files_cb/'.$item1->attachs) }}" title=" {{basename($item1->attachs)}}">
                                                {!! HP::FileExtension($item1->attachs)  ?? '' !!}
                                            </a> --}}
                                         @endif
                                    </span> 
                                </label> 
                        @endif
              </td>
               </tr> 
           @endforeach
         @endif
       </tbody>
   </table>
</div>
</div>
@endif 

@if(!is_null($history->details_three)) 
<div class="row">
<div class="col-md-4 text-right">
    <p >รายงานการตรวจประเมิน :</p>
</div>
<div class="col-md-8 text-left">
    <p>
        {{-- @if($history->details_three !='' && HP::checkFileStorage($attach_path.$history->details_three)) --}}
        <a href="{{url('certify/check/file_cb_client/'.$history->details_three.'/'.( !empty($history->file_client_name) ? $history->file_client_name :  basename($history->details_three) ))}}" 
            title="{{ !empty($history->file_client_name) ? $history->file_client_name :  basename($history->details_three) }}" target="_blank">
                {!! HP::FileExtension($history->details_three)  ?? '' !!}
            </a> 
       {{-- @endif --}}
    </p>
</div>
</div>
@endif

@if(!is_null($history->file)) 
<div class="row">
<div class="col-md-4 text-right">
    <p >ไฟล์แนบ :</p>
</div>
<div class="col-md-8 text-left">
        @php 
                $files = json_decode($history->file);
        @endphp  
        @foreach($files as  $key => $item2)
            <p>
                {{-- @if($item2->file !='' && HP::checkFileStorage($attach_path.$item2->file)) --}}
                <a href="{{url('certify/check/file_cb_client/'.$item2->file.'/'.( !empty($item2->file_client_name) ? $item2->file_client_name :  basename($item2->file) ))}}" 
                    title="{{ !empty($item2->file_client_name) ? $item2->file_client_name :  basename($item2->file) }}" target="_blank">
                    {!! HP::FileExtension($item2->file)  ?? '' !!}
                </a> 
                {{-- @endif --}}
           </p>
        @endforeach
</div>
</div>
@endif


@if(!is_null($history->created_at)) 
<div class="row">
<div class="col-md-4 text-right">
    <p >วันที่เจ้าหน้าที่บันทึก :</p>
</div>
<div class="col-md-8 text-left">
    {{ @HP::DateThai($history->created_at) ?? '-' }}
</div>
</div>
@endif

@if(!is_null($history->date)) 
<div class="row">
<div class="col-md-4 text-right">
    <p >วันที่ผู้ประกอบการบันทึก :</p>
</div>
<div class="col-md-8 text-left">
    {{ @HP::DateThai($history->date) ?? '-' }}
</div>
</div>
@endif
