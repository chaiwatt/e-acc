

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
        ตามที่ สำนักงานมาตรฐานผลิตภัณฑ์อุตสาหกรรม ได้แนบหลักฐานการชำระเงินค่าบริการในการตรวจประเมิน คำขอรับบริการห้องปฏิบัติการ
        เมื่อวันที่  {{  !empty($assessment->report_date) ?  HP::formatDateThaiFull($assessment->report_date) :  ''  }}    
        หมายเลขคำขอ    {{  !empty($certi_lab->app_no) ?   $certi_lab->app_no  :  ''  }} 
          {{  !empty($certi_lab->BelongsInformation->name) ?   $certi_lab->BelongsInformation->name   :  ''  }} 
        สำนักงานมาตรฐานผลิตภัณฑ์อุตสาหกรรม ได้รับการชำระเงินเรียบร้อยแล้ว   
    </p> 

         @if(!empty($assessment->invoice))
          <p>   
              <b>หลักฐานการชำระเงินค่าบริการในการตรวจประเมิน :</b>
              <a href="{{url('certify/check/file_client/'.$assessment->invoice.'/'.( !empty($assessment->invoice_client_name) ? $assessment->invoice_client_name : 'null' ))}}" target="_blank">
                    {{ !empty($assessment->invoice_client_name) ? $assessment->invoice_client_name : @basename($assessment->invoice)}}
              </a>
          </p> 
        @endif  
        <p>
            จึงเรียนมาเพื่อโปรดดำเนินการ 
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
 