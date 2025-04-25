

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
        text-align: center;
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
          <b>เรียน  ผู้อำนวยการสำนักงานคณะกรรมการการมาตรฐานแห่งชาติ</b> 
      </p>
      <p>   
          <b>เรื่อง  {{( isset($assessment->check_file) &&  $assessment->check_file == 'true') ? 'แจ้งแนวทางแก้ไข' : 'ส่งหลักฐานการแก้ไขข้อบกพร่อง'}}</b>   
      </p> 
      <p class="indent50">   
       ข้าพเจ้า {{  !empty($certi_cb->name) ?   $certi_cb->name   :  ''  }} 
       คำขอเลขที่   {{  !empty($certi_cb->app_no) ?   $certi_cb->app_no  :  ''  }} 
       ได้ดำเนินการส่งแนวทางการแก้ไข/หลักฐานการแก้ไขข้อบกพร่องเรียบร้อยแล้ว ดังแนบ
      </p>
      @if(count($assessment->CertiCBBugMany) > 0) 
      <table  id="customers" width="100%">
          <thead>
                  <tr>
                      <th width="5%" >#</th>
                      <th width="45%">ผลการประเมินที่พบ</th>
                      <th width="50%">หลักฐานการแก้ไข</th>
                  </tr>
          </thead>
          <tbody>
              @foreach ($assessment->CertiCBBugMany as $key => $item)
                  <tr>
                      <td class="center">{{ $key + 1 }}</td>
                      <td>{{!empty($item->remark)?$item->remark:null}}</td>
                      <td> 
                         @if($item->status == 1) 
                              @if(!is_null($item->attachs) && isset($item->attachs))
                                   <a href="{{ url('certify/check/files_cb/'.$item->attachs) }}" title=" {{basename($item->attachs)}}" target="_blank">
                                        {!! basename($item->attachs)  ?? '' !!}
                                    </a>
                              @endif
                         @else 
                               {{!empty($item->details)?$item->details:null}}
                         @endif
                      </td>
                  </tr>
              @endforeach
          </tbody>
      </table>
      @endif
      
      <p>
          จึงเรียนมาเพื่อโปรดดำเนินการตรวจสอบรับคำขอ 
          {{-- <a href="{{ $url ?? '/' }}"class="btn btn-link" target="_blank">เข้าสู่ระบบ </a> --}}
      </p>
      <p>
          ------------------------------------------
          <br>
          {!! HP::SetDataTraderAddress() !!}
      </p> 
    </div> 
</body>
</html> 

