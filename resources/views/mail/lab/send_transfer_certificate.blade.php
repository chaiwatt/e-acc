<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <style>
       #style{
            /* width: 60%; */
            padding: 5px;
            border: 5px solid gray;
            margin: 0;
            
       }    
       .customers td, .customers th {
            border: 1px solid #ddd;
            padding: 8px;
            }

        .customers th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: center;
        background-color: #66ccff;
        color: #000000;
        }   
        
        .center {
            text-align: center;
         }
         .right {
            text-align: right;
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
        <b>เรียน ผู้อำนวยการสำนักงานคณะกรรมการการมาตรฐานแห่งชาติ</b>
    </p>
    <p> 
        <b>เรื่อง นำส่งใบรับรองระบบงาน (โอนใบรับรอง)</b>    
    </p>

    <p class="indent50"> 
        ตามที่    {{  !empty($certilab->name) ?  $certilab->name   :  ''  }}
        คำขอเลขที่  {{  !empty($certilab->app_no) ?   $certilab->app_no  :  ''  }} 
        ได้ยืนยันความสามารถ (คำขอโอนใบรับรอง) ไปแล้วนั้น จึงแจ้งให้ท่านนำส่งใบรับรองระบบงาน โดยเข้าระบบ <a href="{{ $url ?? '/' }}"class="btn btn-link" target="_blank">E-Accreditation (ระบบนำส่งใบรับรองระบบงาน)</a>
        
    </p>
      
          --------------------------
      </p>
          <img src="{!! asset('plugins/images/anchor_sm200.jpg') !!}"  height="200px" width="200px"/>
     <p>
          {{-- {!!auth()->user()->UserContact!!} --}}
     </p>
    </div> 
</body> 
</html>

