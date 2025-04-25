

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
          <b>เรียน ผู้อำนวยการสำนักงานคณะกรรมการการมาตรฐานแห่งชาติ</b> 
      </p>
      <p>   
          <b>เรื่อง ยืนยันขอบข่ายการรับรองหน่วยรับรอง</b>   
      </p> 
      <p class="indent50">   
        ตามที่   {{  !empty($certi->name) ?  $certi->name   :  ''  }} 
        ได้ยื่นคำขอเลขที่   {{  !empty($evaluation->reference_refno) ?   $evaluation->reference_refno  :  ''  }} 
        {{ ($evaluation->status == 1 ) ? ' ขอยืนยันผลการตรวจประเมิน' : 'แก้ไขผลการตรวจประเมิน' }}
      </p>
    
      <p class="indent50"> 
         <b>ผลการตรวจประเมิน : </b>   {{ ($evaluation->status == 1 ) ? ' ยืนยันผลการตรวจประเมิน' : 'แก้ไขผลการตรวจประเมิน' }}
      </p>
      @if(!is_null($evaluation->details)) 
       <p > 
        หมายเหตุ : {{ $evaluation->details ?? null }}
      </p>
     @endif
        @if( count($evaluation->FileAttachAssessment6Many) > 0) 
         <p > 
            ไฟล์แนบ :
           @foreach ($evaluation->FileAttachAssessment6Many as $item)
           <p class="indent100">
               {{ @$item->caption}}
                    @if(!empty($item->url))
                              <a href="{{url('funtions/get-view/'.$item->url.'/'.( !empty($item->filename) ? $item->filename :  basename($item->url)  ))}}" target="_blank">
                              {!! basename($item->url)  ?? '' !!}
                              </a>
                    @endif
           </p>    
           @endforeach
         </p>
        @endif
 
      <p>
        จึงเรียนมาเพื่อโปรดพิจารณา 
      </p>
      <p>
          ------------------------------------------
          <br>
          {!! HP::SetDataTraderAddress() !!}
      </p> 
    </div> 
</body>
</html> 
 

 
 


