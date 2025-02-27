
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
        เรื่อง แจ้งหลักฐานการชำระค่าบริการในการตรวจประเมิน 
    </p>
    <p class="indent50"> 
        ตามที่ สำนักงานมาตรฐานผลิตภัณฑ์อุตสาหกรรม ได้แนบหลักฐานการชำระเงินค่าบริการในการตรวจประเมิน คำขอรับบริการหน่วยรับรอง
        เมื่อวันที่  {{  !empty($pay_in->start_date) ?  HP::formatDateThaiFull($pay_in->start_date) :  ''  }}    
        หมายเลขคำขอ    {{  !empty($pay_in->reference_refno) ?   $pay_in->reference_refno  :  ''  }} 
         {{  !empty($certi->name) ?  $certi->name   :  ''  }}
         สำนักงานมาตรฐานผลิตภัณฑ์อุตสาหกรรม ได้รับการชำระเงินเรียบร้อยแล้ว   
    </p> 
 
    <p>
            จึงเรียนมาเพื่อโปรดดำเนินการ 
           
     </p>
    <p>
            ------------------------------------------
    <br>
    {!! HP::SetDataTraderAddress() !!}
     </p>
    </div> 
</body>
</html>  

