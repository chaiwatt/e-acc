

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

        #table_th th{
        text-align: right;
        }   

   </style>
</head>
<body>
   <div id="style"> 
        <p style="font-size:30px;"> 
            <img src="{!! asset('plugins/images/tisi.png') !!}"  height="50px" width="50px"/>
             <b>  {!! $title ?? '-' !!}  </b>
        </p> 

        <table  id="table_th">
            <tr>
              <th  width="10%"></th>
              <th  width="30%"></th>
              <th  width="60%"></th>
            </tr>
            <tr>
                <td><b></b></td>
                <th><b>เลขที่คำขอ :</b> </th>
                <td>
                    {{ $app_no ?? '-'}}
                </td>
            </tr>
            <tr>
                <td><b></b></td>
                <th><b>ข้าพเจ้า :</b> </th>
                <td>
                    {{ $name ?? '-'}}
                </td>
            </tr>
            <tr>
                <td><b></b></td>
                <th><b>เลขประจำตัวผู้เสียภาษีอากร :</b> </th>
                <td>
                    {{ $tax_indentification_number ?? '-'}}
                </td>
            </tr>
            <tr>
                <td><b></b></td>
                <th><b >วัตถุประสงค์ในการยื่นคำขอ :</b> </th>
                <td>
                    {{ $purpose_type ?? '-'}} 
                </td>
            </tr>
            <tr>
                <td><b></b></td>
                <th ><b >ความสามารถห้องปฏิบัติการ :</b> </th>
                <td>
                    {{ $lab_type ?? '-'}}
                </td>
            </tr>
            <tr>
                <td><b></b></td>
                <th ></th>
                <td>
                <a href="{{ $url ?? '/' }}"class="btn btn-link" target="_blank"> เข้าสู่ระบบ </a>
                </td>
            </tr>
          </table>
    </div> 
</body>
</html>

