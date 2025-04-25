
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
        เมื่อวันที่   {{  !empty($pay_in->report_date) ?  HP::formatDateThaiFull($pay_in->report_date) :  ''  }}    
        ของคำขอเลขที่    {{  !empty($certi_ib->app_no) ?   $certi_ib->app_no  :  ''  }} 
        {{  !empty($certi_ib->name) ?   $certi_ib->name  :  ''  }}
         ได้ดำเนินการชำระเรียบร้อยแล้ว
     </p>
 
         {{-- @if(!is_null($PayIn->FileAttachPayInTwo3To))
            <p class="indent50"> 
                <a href="{{ url('certify/check/files_ib/'.$PayIn->FileAttachPayInTwo3To->file) }}"> 
                    {{@basename($PayIn->FileAttachPayInTwo3To->file)}}
                </a>
            </p>
         @endif 
         @if(!is_null($PayIn->FileAttachPayInTwo4To))
            <p class="indent50"> 
                <a href="{{ url('certify/check/files_ib/'.$PayIn->FileAttachPayInTwo4To->file) }}"> 
                    {{@basename($PayIn->FileAttachPayInTwo4To->file)}}
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

