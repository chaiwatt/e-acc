

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <style>
       #style{
            /* width: 50%; */
            padding: 5px;
            border: 5px solid gray;
            margin: 0;
            
       }     

       #customers td, #customers th {
            border: 1px solid #ddd;
            padding: 8px;
            }

        #customers th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #66ccff;
        color: #000000;
        }

        .indent50 {
        text-indent: 50px;
        } 
        .indent100 {
        text-indent: 100px;
        } 
   </style>
</head>
<body>
    @php
      $data = ['1'=>'เห็นชอบกับ Scope','2'=>'ไม่เห็นชอบกับ Scope']
    @endphp
   <div id="style"> 
    <p> 
      <b>เรียน ผู้อำนวยการสำนักงานคณะกรรมการการมาตรฐานแห่งชาติ</b> 
  </p>
  <p>   
      <b>เรื่อง ยืนยันขอบข่ายการรับรองหน่วยตรวจ</b>   
  </p> 
  <p class="indent50">   
    ตามที่    {{  !empty($certi_cb->name) ?  $certi_cb->name :  ''  }} 
    ได้ยื่นคำขอเลขที่   {{  !empty($certi_cb->app_no) ?   $certi_cb->app_no  :  ''  }} 
    {{ ($assessment->status == 1 ) ? ' ขอยืนยันขอบข่ายตามที่แนบ' : 'แก้ไขขอบข่ายตามที่แนบ' }}
  </p>

  <p class="indent50"> 
    <b>เห็นชอบกับ scope : </b>   {{ ($assessment->status == 1 ) ? ' ยืนยัน scope' : 'แก้ไข scope' }}
 </p>
 @if(!is_null($assessment->details)) 
  <p > 
   หมายเหตุ : {{ $assessment->details ?? null }}
 </p>
@endif
   @if( count($assessment->FileAttachAssessment6Many) > 0) 
    <p > 
       ไฟล์แนบ :
      @foreach ($assessment->FileAttachAssessment6Many as $item)
      <p class="indent100">
          {{ @$item->file_desc}}
          <a href="{{  str_replace("-trader","-center",url('/')).'/certify/check/files_ib/'.$item->file }}"   target="_blank">
            {!! basename($item->file)  !!}
        </a>
      </p>    
      @endforeach
    </p>
   @endif
      <p>
        จึงเรียนมาเพื่อโปรดพิจารณา 
          {{-- <a href="{{ $url ?? '/' }}"class="btn btn-link" target="_blank">เข้าสู่ระบบ </a> --}}
      </p>
      <p>
          ------------------------------------------
          <br>
          {!!auth()->user()->SetDataTraderAddress ?? null!!}
      </p> 
    </div> 
</body>
</html> 

