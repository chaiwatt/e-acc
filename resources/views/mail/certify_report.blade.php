

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
        <p style="font-size:30px;"> <img src="{!! asset('plugins/images/tisi.png') !!}"  height="50px" width="50px"/> <b> ยื่นยันสรุปรายงานและเสนออนุกรรมการฯ </b></p>
        <p><dd><b>คำขอ :</b> {{ $app_no ?? '-' }} </p>   
        <p><a href="{{ $url ?? '/' }}"class="btn btn-link" target="_blank"> เข้าสู่ระบบ </a></p>  
    </div> 
</body>
</html>

