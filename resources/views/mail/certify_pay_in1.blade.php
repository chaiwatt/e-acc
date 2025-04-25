

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <style>
       #style{
            width: 60%;
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
        <p style="font-size:30px;"> <img src="{!! asset('plugins/images/tisi.png') !!}"  height="50px" width="50px"/> <b> สำนักงานมาตรฐานผลิตภัณฑ์อุตสาหกรรม (สมอ.)  </b></p>
        <p><dd><b>เรื่อง :</b> ใบ Pay-in ครั้งที่ 1  </p>   
        <p>ดำเนินการชำระค่าใช้จ่ายในการตรวจประเมินเรียบร้อยแล้ว ตามหลักฐานที่แนบมา โปรดออกใบเสร็จรับเงินในนาม บริษัทซูซูกิ มอเตอร์ (ประเทศไทย) จำกัด เป็นค่าใช้จ่ายในการตรวจประเมิน จำนวนเงิน {{ $amount ?? '-' }}  บาท อ้างอิงเลขคำขอที่ {{ $app_no ?? '-' }}</p>  
        @if($invoice != '-')
        <p><b> หลักฐานการชำระเงิน :</b>    
              <a href="{{ url('certify/check/files/'. $invoice) }}"> 
              {!!  @basename($invoice) ?? '' !!}
           </a> 
        </p>  
      @endif
    </div> 
</body>
</html>

