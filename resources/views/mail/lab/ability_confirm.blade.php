
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
        เรื่อง  ยืนยันความสามารถการขอใบรับรอง
    </p>
    <p class="indent50"> 
        ตามที่สำนักงานมาตรฐานผลิตภัณฑ์อุตสาหกรรมได้แจ้งมติเห็นชอบการตรวจประเมินความสามารถ  คำขอเลขที่   {{  !empty($certi_lab->app_no) ?   $certi_lab->app_no  :  ''  }}   บัดนี้   {{   !empty($certi_lab->BelongsInformation->name) ?   $certi_lab->BelongsInformation->name  :  ''  }}   ได้ยืนยันความสามารถเรียบร้อยแล้ว
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

