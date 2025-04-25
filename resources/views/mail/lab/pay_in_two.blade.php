<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <style>
       #style{

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
   <div id="style">
     <p> 
        <b> เรียน  ผู้อำนวยการสำนักงานคณะกรรมการการมาตรฐานแห่งชาติ  </b> 
     </p>
     <p> 
         <b> เรื่อง แจ้งหลักฐานการชำระค่าธรรมเนียมคำขอ และค่าธรรมเนียมใบรับรอง  </b> 
      </p>
      <p class="indent50"> 
         ตามที่สำนักงานมาตรฐานผลิตภัณฑ์อุตสาหกรรมได้แจ้งรายละเอียดค่าธรรมเนียมคำขอ และค่าธรรมเนียมใบรับรอง
         เมื่อวันที่     {{  !empty($PayIn->notification_date) ?  HP::formatDateThaiFull($PayIn->notification_date) :  ''  }}    
         ของคำขอเลขที่    {{  !empty($find_certi->app_no) ?   $find_certi->app_no  :  ''  }} 
          {{  !empty($find_certi->BelongsInformation->name) ?   $find_certi->BelongsInformation->name   :  ''  }}
         ได้ดำเนินการชำระเรียบร้อยแล้ว
     </p>
 
         {{-- @if(!is_null($PayIn->invoice))
            <p class="indent50"> 
                <a href="{{ url('certify/check/files/'.$PayIn->invoice) }}"> 
                    {{@basename($PayIn->invoice)}}
                </a>
            </p>
         @endif 
         @if(!is_null($PayIn->attach_certification))
            <p class="indent50"> 
                <a href="{{ url('certify/check/files/'.$PayIn->attach_certification) }}"> 
                    {{@basename($PayIn->attach_certification)}}
                </a>
            </p>
         @endif  --}}
         <p>
            จึงเรียนมาเพื่อโปรดดำเนินการ 
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

