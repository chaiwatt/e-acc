

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
   <div id="style"> 
    <p> 
        <b>เรียน  ผู้อำนวยการสำนักงานคณะกรรมการการมาตรฐานแห่งชาติ</b> 
    </p>
    <p>   
        <b>เรื่อง แก้ใขขอบข่ายเรียบร้อยแล้ว</b>   
    </p> 
    <p class="indent50">   
     ข้าพเจ้า   {{  !empty($certi_ib->name) ? $certi_ib->name :  ''  }} 
     คำขอเลขที่   {{  !empty($certi_ib->app_no) ?   $certi_ib->app_no  :  ''  }} 
      ได้รับแจ้งให้แก้ไขขอบข่าย บัดนี้ {{  !empty($certi_ib->name) ?  $certi_ib->name   :  ''  }} ได้แก้ไขขอบข่ายเรียบร้อยตามเรื่องข้างต้นเรียบร้อยแล้ว แจ้งมาเพื่อทราบ 
    </p>
      
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

