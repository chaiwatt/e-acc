

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
    @php
      $data = ['1'=>'เห็นชอบกับ Scope','2'=>'ไม่เห็นชอบกับ Scope']
    @endphp
   <div id="style"> 
     <p> 
          <b>เรียน ผู้อำนวยการสำนักงานคณะกรรมการการมาตรฐานแห่งชาติ</b> 
      </p>
      <p>   
          <b>เรื่อง ยืนยันขอบข่ายการรับรอง</b>   
      </p> 
      <p class="indent50">   
        ตามที่   {{  !empty($certi->name) ?  $certi->name   :  ''  }} 
        ได้ยื่นคำขอเลขที่   {{  !empty($inspection->reference_refno) ?   $inspection->reference_refno  :  ''  }} 
        {{ ($inspection->status == 1 ) ? ' ขอยืนยันขอบข่ายตามที่แนบ' : 'แก้ไขขอบข่ายตามที่แนบ' }}
      </p>
    

      <p class="indent50"> 
         <b>เห็นชอบกับ scope : </b>   {{ ($inspection->status == 1 ) ? ' ยืนยัน scope' : 'แก้ไข scope' }}
      </p>
      @if(!is_null($inspection->details)) 
       <p > 
        หมายเหตุ : {{ $inspection->details ?? null }}
      </p>
       @endif
        @if( count($inspection->FileAttachFilesMany) > 0) 
         <p > 
            ไฟล์แนบ :
           @foreach ($inspection->FileAttachFilesMany as $item)
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
 

 
 


