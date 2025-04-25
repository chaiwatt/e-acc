

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <style>
       #style{
            width: 80%;
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
   <p style="font-size:30px;"> <img src="{!! asset('plugins/images/tisi.png') !!}"  height="50px" width="50px"/> <b> {{ $title ?? 'บันทึกผลการตรวจประเมิน' }}  </b></p>
         <p><b>คำขอ : </b>  {{ $app_no ?? '-' }}</p>  
         <p><b>ชื่อห้องปฏิบัติการ : </b>   {{ $lab_name ?? '-' }}</p>  
         <p><b>วันที่ทำรายงาน : </b>   {{ $assessment_date ?? '-' }}</p>   
         @if($file != '-')
            <p><b> รายงานการตรวจประเมิน :</b>    
                <a href="{{ url('certify/check/files/assessment/'. $file) }}"> 
                {!!  @basename($file) ?? '' !!}
                </a> 
            </p>  
         @endif
          <p><b>รายงานข้อบกพร่อง : </b>   {{ $report_status ?? '-' }}</p>  


     @if($data_table != '-')
          <table id="customers" width="90%">
            <thead>
                    <tr>
                        <th width="10%">ลำดับ</th>
                        <th width="30%">ผลการประเมินที่พบ</th>
                        <th width="20%">ประเภท</th>
                        <th width="30%">แนวทางการแก้ไข</th>
                     
                    </tr>
            </thead>
            <tbody>
                @foreach ($data_table  as $key => $data)
                @php 
                    $type = ['1'=>'ข้อบกพร่อง','2'=>'ข้อสังเกต']; 	
                @endphp
                    <tr>
                       <td> {{$key +1 }}</td>
                       <td>{{   $data->remark ?? '-'}}</td>
                       <td>
                           {{ array_key_exists($data->type,$type) ? $type[$data->type] : '-'   }}
                       </td>
                       <td>
                                <label for="app_name">ผลการประเมิน : <span> {{  $data->details ?? null   }} </span> </label>
                            @if($data->status == 1 && !is_null($data->attachs)) 
                                <label for="app_name">หลักฐาน : <span>  <a href="{{ url('certify/check/files/'.$data->attachs) }}">    {{basename($data->attachs)}}</a> </span>  </label> 
                            @else 
                            @endif
                      </td>
                      
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    	
          <p><a href="{{ $url ?? '/' }}"class="btn btn-link" target="_blank"> เข้าสู่ระบบ </a></p>  
    </div> 
</body>
</html>  

