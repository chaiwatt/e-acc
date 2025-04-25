


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <style>
       #style{
            /* width: 60%; */
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
        $attach_path =  'files/applicants/check_files_cb/';
    @endphp
   <div id="style">
   <p style="font-size:30px;"> 
         <p><b>เรียน ผู้อำนวยการสำนักงานคณะกรรมการการมาตรฐานแห่งชาติ</b></p>  
         <p><b>เรื่อง การแต่งตั้งคณะผู้ตรวจประเมิน</b></p>  
          
         @if($authorities != '-')
           @foreach($authorities as $key4 => $item)
       
                <p  class="indent50"> 
                     ตามที่สำนักงานมาตรฐานผลิตภัณฑ์อุตสาหกรรมได้แจ้งรายละเอียดการแต่งตั้งคณะผู้ตรวจประเมิน ของ  {{  !empty($certi_cb->name) ?   $certi_cb->name   :  ''  }} 
                     คำขอเลขที่  {{  !empty($certi_cb->app_no) ?   $certi_cb->app_no  :  ''  }}   
                     เมื่อวันที่ {{  !empty($item->updated_at) ?  HP::formatDateThaiFull($item->updated_at) :  HP::formatDateThaiFull($item->created_at)  }} 
                     โดย   {{  !empty($certi_cb->name) ?  $certi_cb->name :  ''  }}  
                     มีความเห็นดังนี้
                </p>

                @if($item->status != null)
                    @if ($item->status == 1)
                        <p  class="indent50">   
                            <b>เห็นชอบกับการแต่งตั้งคณะผู้ตรวจประเมินที่เสนอมา : </b> เห็นชอบดำเนินการแต่งตั้งคณะผู้ตรวจประเมินต่อไป
                        </p>
                    @elseif($item->status == 2)
                        <p  class="indent50">  
                            <b>เห็นชอบกับการแต่งตั้งคณะผู้ตรวจประเมินที่เสนอมา : </b> ไม่เห็นชอบ
                        </p>
                    @endif
                @else 
                    <p  class="indent50">  
                        <b>เห็นชอบกับการแต่งตั้งคณะผู้ตรวจประเมินที่เสนอมา : </b>
                    </p>
                @endif

                @if($item->remark != null)
                <p  class="indent50">   
                        <b>หมายเหตุ :</b> {{ $item->remark ?? '-' }} 
                </p>
                @endif
             
               @if($item->attachs != null)
               @php 
                $attachs = json_decode($item->attachs);
                @endphp
                <p  class="indent50">  
                    <b>หลักฐาน :</b>
                    @foreach($attachs as $files)
                        <p class="indent50">     
                            {{  @$files->file_desc  }}
                            {{-- @if($files->file!='' && HP::checkFileStorage($attach_path.$files->file)) --}}
                                <a href="{{url('certify/check/file_cb_client/'.$files->file.'/'.( !empty($files->file_client_name) ? $files->file_client_name : 'null' ))}}" target="_blank">
                                    {{  !empty($files->file_client_name) ? $files->file_client_name :  basename($files->file)   }}
                                </a>
                            {{-- @endif  --}}
                        </p>
                    @endforeach
                </p>
              @endif 

            @endforeach
         @endif 
 

        <p>
            จึงเรียนมาเพื่อโปรดพิจารณา 
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
