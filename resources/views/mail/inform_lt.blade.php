

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
           <b>เรียน	{{@$name}}</b>
        </p>
        <p>
            <b>เรื่อง ผู้ประกอบการลงทะเบียนเข้ามาในระบบ</b>
        </p>
        <p class="indent50">
          ตามที่ {{@$name}} ได้ลงทะเบียนในระบบ เมื่อ
          {{ HP::formatDateThaiFull(date('Y-m-d')) }}
        </p>
        <p>ขณะนี้มี {{ @$name }} ลงทะเบียนในระบบแล้ว การลงทะเบียนสำเร็จ</p>
        <p>กรุณาเข้าสู่ระบบเพื่อเปิดสิทธิ์ให้ผู้ประกอบการ เพื่อผู้ประกอบการจะได้เข้าสู่ระบบตามสิทธิ์ที่ได้รับต่อไป</p>
        <p>
            จึงเรียนมาเพื่อโปรดรับทราบ
        </p>
        <p>
            ------------------------------------------
            <br>
        </p>
    </div>
</body>
</html>

