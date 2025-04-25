
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
        เรียน  ผู้อำนวยการสำนักงานคณะกรรมการการมาตรฐานแห่งชาติ
    </p>
    <p> 
        เรื่อง  ยืนยันขอบข่ายที่ขอการรับรองหน่วยตรวจ
    </p>
    <p class="indent50"> 
        ตามที่สำนักงานมาตรฐานผลิตภัณฑ์อุตสาหกรรมได้แจ้งมติคณะกรรมการ/คณะอนุกรรมการ และขอบข่ายที่ได้รับความเห็นชอบ คำขอเลขที่   {{  !empty($certi_ib->app_no) ?   $certi_ib->app_no  :  ''  }}  {{  !empty($certi_ib->name) ? $certi_ib->name   :  ''  }}  ขอยืนยันขอบข่ายที่ขอการรับรอง 
    </p> 
    <p>
        จึงเรียนมาเพื่อโปรดดำเนินการต่อไป 
         {{-- <a href="{{ $url ?? '/' }}"class="btn btn-link" target="_blank">Link </a> --}}
    </p>
    <p>
        ------------------------------------------
        <br>
        {!!auth()->user()->SetDataTraderAddress ?? null!!}
    </p>
 
    </div> 
</body>
</html>  

