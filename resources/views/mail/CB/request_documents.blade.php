

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
           <b>เรียน	 ผู้อำนวยการสำนักงานคณะกรรมการการมาตรฐานแห่งชาติ</b> 
        </p>
        <p>   
            <b>เรื่อง ขอส่งเอกสารเพิ่มเติม</b>   
        </p> 
        <p class="indent50">  
            ตามที่สำนักงานมาตรฐานผลิตภัณฑ์อุตสาหกรรมได้ขอให้   {{  !empty($certi_cb->name) ?  $certi_cb->name  :  ''  }} 
            ดำเนินการแนบเอกสารเพิ่มเติม เมื่อวันที่ {{  !empty($certi_cb->start_date) ?  HP::formatDateThaiFull($certi_cb->start_date) :  ''  }} 
            นั้น   {{  !empty($certi_cb->name) ?   $certi_cb->name  :  ''  }} 
            ได้แนบไฟล์เอกสารเพิ่มเติมแล้ว รายละเอียดดังแนบ
        </p> 
        <p>
            จึงเรียนมาเพื่อโปรดพิจารณาและดำเนินการต่อไป 
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

 