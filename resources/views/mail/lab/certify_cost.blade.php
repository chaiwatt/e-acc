


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
        <b>เรื่อง  การประมาณการค่าใช้จ่าย </b>   
    </p> 
    <p class="indent50">   
        ตามที่สำนักงานมาตรฐานผลิตภัณฑ์อุตสาหกรรมได้แจ้งรายละเอียดการประมาณการค่าใช้จ่ายในการตรวจประเมิน 
        ของ     {{  !empty($certiLab->BelongsInformation->name) ?  $certiLab->BelongsInformation->name  :  ''  }} 
        คำขอเลขที่ {{  !empty($certiLab->app_no) ?   $certiLab->app_no  :  ''  }} 
        เมื่อวันที่ {{  !empty($certi_cost->created_at) ?  HP::formatDateThaiFull($certi_cost->created_at) :  ''  }} 
         {{  !empty($certiLab->BelongsInformation->name) ?   $certiLab->BelongsInformation->name   :  ''  }} 
        มีความเห็นดังนี้
    </p> 

    <p><b>เห็นชอบกับค่าใช่จ่ายที่เสนอมา :</b>  {{ $check_status ?? null }} </p>  
    @if(!empty($certi_cost->remark))
     <p><b>หมายเหตุ :</b>  {{ $certi_cost->remark  ?? null }} </p>  
    @endif

    
     @if($attachs != '-')
     <p><b>หลักฐาน :</b>   </p>  
            @foreach($attachs as $files)
            <p class="indent50"> 
                @if(isset($files->file))
                {{  @$files->file_desc  }}
                 <a href="{{ url('certify/check/files/'.$files->file) }}"  target="_blank"> 
                    <a href="{{url('certify/check/file_client/'.$files->file.'/'.( !empty($files->file_client_name) ? $files->file_client_name : 'null' ))}}" target="_blank">
                    {{  !empty($files->file_client_name) ? $files->file_client_name :   @basename($files->file)}}
                </a>
                @endif
            </p>
            @endforeach
      @endif


      <p><b>เห็นชอบกับ scope  :</b>  {{ $status_scope ?? null }} </p>  
      @if(!empty($certi_cost->remark_scope))
       <p><b>หมายเหตุ :</b>  {{ $certi_cost->remark_scope  ?? null }} </p>  
      @endif
      @if($attachs_scope != '-') 
      <p><b>หลักฐาน :</b>   </p>  
             @foreach($attachs_scope as $item)
             <p class="indent50"> 
                 @if(isset($item->attach_files))
                 {{  @$item->file_desc_text  }}
                 <a href="{{url('certify/check/file_client/'.$item->attach_files.'/'.( !empty($item->file_client_name) ? $item->file_client_name : 'null' ))}}" target="_blank">
                    {{  !empty($item->file_client_name) ? $item->file_client_name :   @basename($item->attach_files)}}
                 </a>
                 @endif
             </p>
             @endforeach
       @endif
       <p>
        จึงเรียนมาเพื่อโปรดดำเนินการต่อไป 
        {{-- <a href="{{ $url ?? '/' }}"class="btn btn-link" target="_blank">เข้าสู่ระบบ </a> --}}
        </p>
        <p>
            ------------------------------------------
            <br>
            {!!auth()->user()->SetDataTraderAddress ?? null!!}
        </p> 
    </div> 
</body>
</html>
 