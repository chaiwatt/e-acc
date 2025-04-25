
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
            เมื่อวันที่    {{  !empty($pay_in->report_date) ?  HP::formatDateThaiFull($pay_in->report_date) :  ''  }}    
            ของคำขอเลขที่    {{  !empty($pay_in->reference_refno) ?   $pay_in->reference_refno  :  ''  }} 
             {{  !empty($certi->name) ? $certi->name   :  ''  }}
            ได้ดำเนินการชำระเรียบร้อยแล้ว 
        </p>
 
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
 

