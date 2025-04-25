

 @if(!is_null($history->details))
@php 
       $details = json_decode($history->details);
       $notice =  App\Models\Certify\Applicant\Notice::find($history->ref_id);
       $app =     App\Models\Certify\Applicant\CertiLab::where('app_no',@$history->app_no)->first();
 @endphp   
 <div class="row">
  <div class="col-md-2 text-right">
     <p class="text-nowrap">เลขคำขอ :</p>
  </div>
  <div class="col-md-4">
       {{  $app->app_no ??  null }}
  </div>
  <div class="col-md-2 text-right">
     <p class="text-nowrap">หน่วยงาน :</p>
  </div>
  <div class="col-md-4">
    {{   !empty($app->BelongsInformation->name) ? $app->BelongsInformation->name: null }}
  </div>
</div>

 <div class="row">
  <div class="col-md-2 text-right">
     <p class="text-nowrap">ชื่อห้องปฏิบัติการ :</p>
  </div>
  <div class="col-md-4">
    {{   !empty($app->lab_name) ? $app->lab_name : null }}
  </div>
  <div class="col-md-2 text-right">
     <p class="text-nowrap">วันที่ทำรายงาน :</p>
  </div>
  <div class="col-md-4">
       {{   !empty($details->assessment_date) ? @HP::DateThai(date("Y-m-d",strtotime($details->assessment_date))) : null }}
  </div>
</div>

 <div class="row">
  <div class="col-md-3 text-right">
     <p class="text-nowrap">รายงานการตรวจประเมิน :</p>
  </div>
  <div class="col-md-2">
    @if(!is_null($history->file) ) 
        <p> 
            <a href="{{url('certify/check/file_client/'.$history->file.'/'.( !empty($history->file_client_name) ? $history->file_client_name : basename($history->file) ))}}" target="_blank">
                {!! HP::FileExtension($history->file)  ?? '' !!}
           </a>
         </p>
      @endif
  </div>

  @if(!is_null($history->attachs))
  @php 
       $attachs = json_decode($history->attachs);
  @endphp  
    <div class="col-md-2 text-right">
        <p class="text-nowrap">ไฟล์แนบ :</p>
    </div>
    <div class="col-md-4">
        @foreach($attachs as $key1 => $item)   
            <p> 
                <a href="{{url('certify/check/file_client/'.$item->attachs.'/'.( !empty($item->attachs_client_name) ? $item->attachs_client_name : basename($history->attachs) ))}}" target="_blank">
                    {!! HP::FileExtension($item->attachs)  ?? '' !!}
                </a>
            </p>
        @endforeach
    </div>
  @endif

</div>

<div class="row">
    <div class="col-md-2 text-right">
       <p class="text-nowrap">รายงานข้อบกพร่อง :</p>
    </div>
    <div class="col-md-10">
      @if($details->report_status == 1)
          <label>   <input type="radio" class="check check-readonly" data-radio="iradio_square-green" checked>  &nbsp; มี &nbsp;</label>
          <label>   <input type="radio" class="check check-readonly" data-radio="iradio_square-red">  &nbsp;ไม่มี &nbsp;</label>
      @else 
          <label>   <input type="radio" class="check check-readonly" data-radio="iradio_square-green">  &nbsp; มี &nbsp;</label>
          <label>   <input type="radio" class="check check-readonly" data-radio="iradio_square-red" checked>  &nbsp;ไม่มี &nbsp;</label>
      @endif

    </div>
</div>
@endif



@if(!is_null($history->details_table)) 
@php 
$details_table = json_decode($history->details_table);
@endphp
@if(!is_null($details_table))
<div class="row">
<div class="col-sm-12 m-t-15" >
   <table class="table color-bordered-table primary-bordered-table">
       <thead>
       <tr>
          <th class="text-center" width="2%">ลำดับ</th>
          <th class="text-center" width="15%">รายงานที่</th>
          <th class="text-center" width="15%">ผลการประเมินที่พบ</th>
          <th class="text-center" width="15%">มอก. 17025 : ข้อ</th>
          <th class="text-center" width="10%">ประเภท</th>
          <th class="text-center" width="33%">แนวทางการแก้ไข</th>
          <th class="text-center" width="20%" >หลักฐาน</th>
       </tr>
       </thead>
       <tbody >
         @foreach($details_table as $key1 => $item1)   
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
                                     @elseif(isset($item1->comment_file))
                                            @if(!is_null($item1->comment_file))
                                              <span> <i class="fa  fa-close" style="font-size:20px;color:rgb(255, 0, 0)"></i> ไม่ผ่าน </span> 
                                              {!!   " : ".$item1->comment_file ?? null  !!}
                                            @endif
                                    @endif
                                <label for="app_name">
                                    <span>
                                        @if(!is_null($item1->attachs) && isset($item1->attachs) )
                                              <a href="{{url('certify/check/file_client/'.$item1->attachs.'/'.( !empty($item1->attachs_client_name) ? $item1->attachs_client_name :  basename($item1->attachs)  ))}}" target="_blank">
                                                {!! HP::FileExtension($item1->attachs)  ?? '' !!}
                                            </a>
                                         @endif
                                    </span> 
                                </label> 
                        @endif
              </td>
               </tr> 
         @endforeach
       </tbody>
   </table>
</div>
</div>
@endif   
@endif 


 


@if(!is_null($history->date)) 
<div class="row">
<div class="col-md-2 text-right">
    <p class="text-nowrap">วันที่บันทึก :</p>
</div>
<div class="col-md-4">
    {{ @HP::DateThai($history->date) ?? '-' }}
</div>
</div>
@endif