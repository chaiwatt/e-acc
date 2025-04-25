

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
       .address{
            /* width: 50%; */
            padding: 5px;
            border: 1px solid gray;
            margin: 0;
            
       }    
        #table_th th{
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
           <b>เรียน  เลขาธิการสำนักงานมาตรฐานผลิตภัณฑ์อุตสาหกรรม</b> 
        </p>
        <p>   
            <b>เรื่อง ขอยื่นคำขอรับบริการหน่วยรับรอง</b>   
        </p> 
        <p class="indent50"> 
            ข้าพเจ้า{{@$name}} {{@$request}}ได้ยื่นคำขอรับบริการยืนยันความสามารถหน่วยรับรอง
            ผ่านระบบการรับรองระบบงาน  คำขอเลขที่ {{@$app_no}}
            เมื่อวันที่   {{ HP::formatDateThaiFull(date('Y-m-d')) }}    
            และได้แนบเอกสารประกอบคำขอดังกล่าวมาพร้อมนี้แล้ว
        </p> 
        <p>
            จึงเรียนมาเพื่อโปรดดำเนินการต่อไป 
             {{-- <a href="{{ $url ?? '/' }}"class="btn btn-link" target="_blank">Link </a> --}}
        </p>
        <p>
            ------------------------------------------
            <br>
            {!! HP::SetDataTraderAddress() !!}
        </p>
    </div> 
</body>
</html> 

 