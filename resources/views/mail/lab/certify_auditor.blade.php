

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
   </style>
</head>
<body>
   <div id="style">
   <p style="font-size:30px;"> 
         <p><b>เรียน เจ้าหน้าที่เกี่ยวข้องสำนักงานคณะกรรมการการมาตรฐานแห่งชาติ  ผู้อํานวยการเฉพาะด้าน (วิชาการมาตรฐาน)</b></p>  
         <p><b>เรื่อง ประมาณการค่าใช้จ่ายในการตรวจประเมิน</b></p>  
         <p> 
               &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  
               ตามที่ท่านได้แจ้งรายละเอียดการแต่งตั้งคณะผู้ตรวจประเมินในการตรวจประเมิน และสิ่งที่ส่งมาด้วย นั้นเมื่อ{{HP::formatDateThai(date('Y-m-d')) ?? '-'}} {{@$name}}  
               คำขอเลขที่ {{@$app_no}}  จึงขอแจ้งให้ดำเนินการแต่งตั้งคณะผู้ตรวจประเมินในการตรวจประเมิน อีกครั้ง
         </p>
         <p><a href="{{ $url ?? '/' }}" target="_blank"> เข้าสู่ระบบ </a></p> 
         <p>จึงเรียนมาเพื่อพราบ <br>----------------------</p>
    </div> 
</body>
</html>

