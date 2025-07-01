<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export PDF</title>
    
    <style>
        body {
            font-family: 'thsarabunnew', sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
        }

        #document-content {
            /* *** แก้ไขความกว้างเป็น 21cm สำหรับ A4 *** */
            width: 21cm; 
            margin: 0 auto; /* ไม่ต้องมี margin บน-ล่าง เพราะ mPDF จะจัดการ margin ของหน้าเอง */
        }

        .page {
            /* ลบ margin-bottom ออก เพราะ mPDF จะจัดการการแบ่งหน้า */
            /* margin-bottom: 1cm; */ 
            padding: 1cm; /* หากต้องการ padding ภายในแต่ละหน้า */
            line-height: 1.6;
            font-size: 22px;
            box-sizing: border-box;
            background-color: white; /* หากต้องการพื้นหลังสีขาวสำหรับแต่ละหน้า */
        }
        
        /* ... สไตล์อื่นๆ เช่น table, image-container ... */

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 1em 0;
        }
        table.borderless {
            width: 100%;
            border-collapse: collapse;
            margin: 1em 0;
        }
        
        td, th {
            border: 1px solid #ccc;
            padding: 8px;
            vertical-align: top;
        }

        table.borderless td,
        table.borderless th {
            border: none;
            padding: 2px 8px;
            margin: 0;
        }

        .image-container {
            position: relative;
            display: inline-block;
            margin-bottom: 10px;
        }
        .image-container img {
            max-width: 100%;
            height: auto;
            display: block;
        }

        .image-container.active, .resize-handle {
            display: none !important;
        }
    </style>
</head>
<body>
    {{-- *** สำคัญ: ตัวแปร $htmlContent จะถูก Render โดยตรงทีละครั้งใน Controller แล้ว *** --}}
    {{-- ดังนั้นส่วนนี้จะถูกใช้เป็นโครงสร้างหลักของ PDF ซึ่งจะถูกใช้เป็นแม่แบบ --}}
    <div id="document-content">
        {{-- โครงสร้างนี้จะถูกใช้เป็น wrapper สำหรับเนื้อหาแต่ละหน้าใน PDF --}}
        {{-- เนื่องจาก Controller จะใช้ AddPage() และ WriteHTML แยกกันสำหรับแต่ละหน้า --}}
        {{-- ตรงนี้ไม่ต้องมี {!! $htmlContent !!} แล้วครับ เพราะจะถูก Render ใน Controller --}}
        {{-- ถ้าต้องการให้ CSS .page มีผลกับเนื้อหาที่ส่งมา ให้เนื้อหาที่ส่งมามี class="page" --}}
    </div>
</body>
</html>