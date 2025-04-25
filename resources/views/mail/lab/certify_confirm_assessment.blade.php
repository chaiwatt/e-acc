

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
        <b>เรื่อง ยืนยันขอบข่ายการรับรองห้องปฏิบัติการ</b>   
    </p> 
    <p class="indent50">   
    ตามที่  {{  !empty($certi_lab->BelongsInformation->name) ?   $certi_lab->BelongsInformation->name  :  ''  }} 
    ได้ยื่นคำขอเลขที่   {{  !empty($certi_lab->app_no) ?   $certi_lab->app_no  :  ''  }} 
    {{ ($status_scope == 1 ) ? ' ขอยืนยันขอบข่ายตามที่แนบ' : 'แก้ไขขอบข่ายตามที่แนบ' }}
    </p>

    <p class="indent50"> 
    <b>เห็นชอบกับ scope : </b>   {{ ($status_scope == 1 ) ? ' ยืนยัน scope' : 'แก้ไข scope' }}
    </p>

 
        @if(!is_null($remark)) 
            <p class="indent50"> 
                โดยมีรายละเอียดดังนี้
            </p>
            <p > 
                หมายเหตุ : {{ $remark ?? null }}
            </p>
        @endif
        @if(!is_null($evidence))
         <p > 
            ไฟล์แนบ : 
           @foreach ($evidence as $item)
           <p class="indent100">
               {{ @$item->file_desc_text }}
                 <a href="{{url('certify/check/file_client/'.$item->attachs.'/'.( !empty($item->attachs_client_name) ? $item->attachs_client_name : 'null' ))}}" target="_blank">
                     {!! !empty($item->attachs_client_name) ? $item->attachs_client_name : basename($item->attachs)  !!}
                </a>
           </p>    
           @endforeach 
         </p>
        @endif
      <p>
          จึงเรียนมาเพื่อโปรดดำเนินการตรวจสอบรับคำขอ 
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

