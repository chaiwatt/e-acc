<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scope Editor</title>
      <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" xintegrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> --}}
   
    <style>

        @font-face {
            font-family: 'thsarabunnew';
            /* src: url('/fonts/THSarabunNew.ttf') format('truetype'); */
            src: url('{{ asset('fonts/THSarabunNew.ttf') }}') format('truetype');
            font-weight: normal;
            font-style: normal;
        }
        /* Style for the entire page */
        body {
            background-color: #f8f9fa;
            font-family: 'thsarabunnew', 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
        }

        /* Superscript and Subscript Styling */
        sup, sub {
            font-size: 16px;
        }

        /* --- Menubar --- */
        #menubar {
            background-color: #edf2fa;
            padding: 8px 16px;
            border-bottom: 1px solid #d4d4d4;
            position: sticky;
            top: 0;
            z-index: 1000;
            display: flex;
            flex-wrap: wrap;
            gap: 4px;
            align-items: center;
        }

        .vertical-align-top {
            vertical-align: top !important; /* Use !important to ensure it applies */
        }


        .menu-button {
            background: none;
            border: 1px solid transparent;
            border-radius: 4px;
            font-size: 18px;
            width: 36px;
            height: 36px;
            cursor: pointer;
            color: #444;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .menu-button:hover {
            background-color: #dce1e6;
            border-color: #c9ced2;
        }

        .menu-button.active {
            background-color: #cce1ff;
            color: #0b57d0;
        }
        
        .separator {
            width: 1px;
            height: 20px;
            background-color: #ccc;
            margin: 0 8px;
        }

        /* --- [ใหม่] Font Size Dropdown Styling --- */
        .font-size-container {
            display: flex;
            align-items: center;
            border: 1px solid transparent;
            border-radius: 4px;
            height: 36px;
            padding: 0 4px;
            cursor: pointer;
        }
        .font-size-container:hover {
            background-color: #dce1e6;
            border-color: #c9ced2;
        }
        #font-size-selector {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            border: none;
            background: transparent;
            height: 100%;
            font-size: 18px;
            font-family: inherit;
            cursor: pointer;
            outline: none;
            text-align: center;
            min-width: 50px;
        }

        /* --- Dropdown Styling --- */
        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
            border-radius: 4px;
            top: 100%; /* Position below the button */
            left: 0;
        }

        .dropdown-content a {
            color: black;
            padding: 3px 12px;
            text-decoration: none;
            display: block;
            cursor: pointer;
            font-size: 20px
        }

        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }
        /* Show dropdown content when the button is clicked */
        .dropdown.show .dropdown-content {
            display: block;
        }


        /* --- Editor Area --- */
        #editor-container {
            width: 100%;
            display: flex;
            justify-content: center;
        }
        
        #document-editor {
            width: 20cm;
            margin-top: 2rem;
            margin-bottom: 2rem;
        }

        .page {
            background-color: white;
            height: 29.5cm;
            padding: 1cm 1cm 0 1cm;
            margin-bottom: 0.5cm;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            box-sizing: border-box;
            line-height: 1.1;
            font-size: 20px;
            overflow: hidden;
            outline: none;
            position: relative;
        }

        .page:focus {
            outline: none;
        }

        .page:empty::before {
            /* content: "พิมพ์ที่นี่..."; */
            color: #aaa;
            pointer-events: none;
        }
        
        /* --- Table Styling --- */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 0.5em 0;
            table-layout: fixed; /* This is key to prevent tables from expanding. */
        }

        table.borderless {
            width: 100%;
            border-collapse: collapse;
            /* margin: 1em 0; */
        }
        
        th {
            border: 0.1px solid #050505;
            padding: 0px;
            vertical-align: top;
            word-wrap: break-word; /* Ensures text wraps within the cell. */
        }

        td {
            border: 0.1px solid #050505;
            padding: 5px;
            vertical-align: top;
            word-wrap: break-word; /* Ensures text wraps within the cell. */
        }

        table.borderless td,
        table.borderless th {
            
            border: none;
            padding: 2px 8px;
            margin: 0;
        }

        /* --- Image Styling (Revised) --- */
        .image-container {
            position: relative; /* Changed */
            display: inline-block; /* Added */
            vertical-align: bottom; /* Added for better text alignment */
            line-height: 0; /* Added to remove extra space under image */
            border: 2px dashed transparent;
            user-select: none;
        }
        .image-container.active {
            border-color: #4285f4;
            z-index: 10;
        }
        .image-container img {
            width: 100%;
            height: auto; /* Changed for aspect ratio */
            display: block;
            pointer-events: none;
        }
        .resize-handle {
            position: absolute;
            width: 10px;
            height: 10px;
            background: #4285f4;
            border: 1px solid white;
            border-radius: 50%;
            display: none;
        }
        .image-container.active .resize-handle {
            display: block;
        }
        .resize-handle.top-left { top: -5px; left: -5px; cursor: nwse-resize; }
        .resize-handle.top-right { top: -5px; right: -5px; cursor: nesw-resize; }
        .resize-handle.bottom-left { bottom: -5px; left: -5px; cursor: nesw-resize; }
        .resize-handle.bottom-right { bottom: -5px; right: -5px; cursor: nwse-resize; }

        /* --- Modal Styling --- */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 2000;
        }

        .modal-content {
            background-color: white;
            padding: 20px 30px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            width: 450px; /* Increased width for more complex modals */
            font-size: 22px;
            max-height: 90vh; /* Added for scrollability */
            overflow-y: auto;   /* Added for scrollability */
        }
        
        .modal-content h3 {
            margin-top: 0;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }

        .modal-input-group {
            margin: 15px 0;
        }
        
        .modal-input-group label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }
        
        .modal-input-group input[type="number"],
        .modal-input-group input[type="text"] {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 18px; /* Added for better readability */
            font-family: inherit; /* Ensure consistent font */
        }
        
        /* NEW: Styling for contenteditable div in modal */
        .modal-content .editable-div {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-family: inherit;
            min-height: 100px;
            background-color: #fff;
            line-height: 1.4;
            cursor: text;
        }

        .modal-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
        }
        
        .modal-buttons button {
            padding: 8px 16px;
            border-radius: 4px;
            border: none;
            cursor: pointer;
            font-weight: bold;
        }

        .modal-btn-confirm {
            background-color: #4285f4;
            color: white;
        }
        .modal-btn-confirm:hover {
            background-color: #357ae8;
        }

        .modal-btn-cancel {
            background-color: #e0e0e0;
            color: #333;
        }
        .modal-btn-cancel:hover {
            background-color: #d1d1d1;
        }

        /* --- Context Menu Styling --- */
        #context-menu {
            position: absolute;
            background-color: white;
            border: 1px solid #ccc;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            z-index: 3000;
            display: none;
            padding: 4px 0; /* Added padding */
        }

        .context-menu-item {
            padding: 1px 16px;
            cursor: pointer;
            font-size: 20px;
            white-space: nowrap; /* Prevent wrapping */
        }

        .context-menu-item:hover {
            background-color: #f0f0f0;
        }
        .context-menu-separator {
            height: 1px;
            background-color: #e0e0e0;
            margin: 4px 0;
        }

        /* Input field styling */
        .lab-test-modal input[type="text"],
        .lab-test-modal .editable-div {
            width: 250px;
            font-family: 'thsarabunnew', sans-serif;
            font-size: 22px;
        }
        /* Input field styling */
        .lab-cal-modal input[type="text"] {
            width: 200px;
            font-family: 'thsarabunnew', sans-serif;
            font-size: 22px;
        }

        /* Editable div styling */
        .lab-cal-modal .editable-div {
            width: 180px;
            font-family: 'thsarabunnew', sans-serif;
            font-size: 22px;
        }

        /* Specific styling for lab-cal-method-editor */
        .lab-cal-modal #lab-cal-method-editor {
            width: 200px;
        }

        /* Input field styling */
        .ib-modal input[type="text"],
        .ib-modal .editable-div,
        .cb-modal .editable-div {
            width: 250px ;
            font-family: 'thsarabunnew', sans-serif;
            font-size: 22px;
            box-sizing: border-box;
        }
        
        .cb-modal .code {
            width: 200px;
        }

        .cb-modal .detail {
            width: 540px;
        }

        /* Adjust select element styling to match other inputs */
        #lab-cal-item-modal select {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 22px;
            font-family: 'thsarabunnew', sans-serif;
            appearance: none; /* Remove default arrow */
            background-color: #fff;
            cursor: pointer;
            width: 200px;
        }

        /* Custom arrow for select */
        #lab-cal-item-modal select::-ms-expand {
            display: none; /* Hide default arrow in IE */
        }

        #lab-cal-item-modal .modal-input-group select:focus {
            outline: none;
            border-color: #4285f4;
            box-shadow: 0 0 5px rgba(66, 133, 244, 0.5);
        }

        /* Ensure consistent height and alignment */
        #lab-cal-item-modal .modal-input-group {
            align-items: center;
        }

        
        /* Adjust select element styling to match other inputs */
        #lab-test-item-modal select {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 22px;
            font-family: 'thsarabunnew', sans-serif;
            appearance: none; /* Remove default arrow */
            background-color: #fff;
            cursor: pointer;
            width: 250px;
        }

        /* Custom arrow for select */
        #lab-test-item-modal select::-ms-expand {
            display: none; /* Hide default arrow in IE */
        }

        #lab-test-item-modal .modal-input-group select:focus {
            outline: none;
            border-color: #4285f4;
            box-shadow: 0 0 5px rgba(66, 133, 244, 0.5);
        }

        /* Ensure consistent height and alignment */
        #lab-test-item-modal .modal-input-group {
            align-items: center;
        }
    </style>
</head>
<body>
    <div id="menubar">
        <button class="menu-button" data-command="bold" title="ตัวหนา"><i class="fas fa-bold"></i></button>
        <button class="menu-button" data-command="italic" title="ตัวเอียง"><i class="fas fa-italic"></i></button>
        <button class="menu-button" data-command="superscript" title="ตัวยก"><i class="fas fa-superscript"></i></button>
        <button class="menu-button" data-command="subscript" title="ตัวห้อย"><i class="fas fa-subscript"></i></button>
        <div class="separator"></div>
        <div class="font-size-container">
            <select id="font-size-selector" title="ขนาดฟอนต์">
                <option value="8">8</option>
                <option value="10">10</option>
                <option value="12">12</option>
                <option value="14">14</option>
                <option value="16">16</option>
                <option value="18">18</option>
                <option value="19">19</option>
                <option value="20">20</option>
                <option value="21">21</option>
                <option value="22">22</option>
                <option value="23">23</option>
                <option value="24">24</option>
                <option value="28">28</option>
                <option value="32">32</option>
                <option value="36">36</option>
                <option value="48">48</option>
                <option value="72">72</option>
            </select>
        </div>
        <div class="separator"></div>
        <button class="menu-button" data-command="justifyLeft" title="จัดชิดซ้าย"><i class="fas fa-align-left"></i></button>
        <button class="menu-button" data-command="justifyCenter" title="จัดกึ่งกลาง"><i class="fas fa-align-center"></i></button>
        <button class="menu-button" data-command="justifyRight" title="จัดชิดขวา"><i class="fas fa-align-right"></i></button>
        <div class="separator"></div>
        <button class="menu-button" data-command="increaseLineHeight" title="เพิ่มระยะห่างบรรทัด"><i class="fas fa-arrows-up-to-line"></i></button>
        <button class="menu-button" data-command="decreaseLineHeight" title="ลดระยะห่างบรรทัด"><i class="fas fa-arrows-down-to-line"></i></button>
        <div class="separator"></div>
        <button class="menu-button" data-command="insertTable" title="แทรกตาราง"><i class="fas fa-table"></i></button>
        <button class="menu-button" data-command="insertImage" title="แทรกรูปภาพ"><i class="fas fa-image"></i></button>
        
        <div class="dropdown">
            <button class="menu-button" id="template-dropdown-button" title="แทรกเทมเพลต"><i class="fas fa-file-alt"></i></button>
            <div class="dropdown-content">
                @if ($templateType == "cb")
                       <a href="#" data-template="cb-template" >CB template</a>
                @elseif($templateType == "ib")
                        <a href="#" data-template="ib-template" >IB template</a>
                @elseif($templateType == "lab_cal")
                        <a href="#" data-template="lab-cal-template" >Cal Lab template</a>
                @elseif($templateType == "lab_test")
                        <a href="#" data-template="lab-test-template" >Test Lab template</a>
                @endif
            </div>
        </div>
        
        {{-- <button class="menu-button" id="export-pdf-button" title="ส่งออกเป็น PDF"><i class="fas fa-file-pdf"></i></button> --}}
        <button class="menu-button" id="save-template-button"><i class="fas fa-save"></i></button>
        {{-- <button class="menu-button" id="load-template-button"><i class="fa fa-cloud-download" aria-hidden="true"></i></button> --}}

        
    </div>

    <input type="file" id="image-input" accept="image/*" style="display: none;">

    <div id="editor-container">
        <div id="document-editor">
            <div class="page" contenteditable="true"></div>
        </div>
    </div>

    <!-- Table Creation Modal -->
    <div id="table-modal-overlay" class="modal-overlay">
        <div class="modal-content">
            <h3>แทรกตาราง</h3>
            <div class="modal-input-group">
                <label for="table-rows">จำนวนแถว:</label>
                <input type="number" id="table-rows" value="3" min="1">
            </div>
            <div class="modal-input-group">
                <label for="table-cols">จำนวนคอลัมน์:</label>
                <input type="number" id="table-cols" value="3" min="1">
            </div>
            <div class="modal-input-group" style="display: flex; align-items: center; gap: 8px;">
                <input type="checkbox" id="table-border-toggle" checked style="width: auto; margin: 0;">
                <label for="table-border-toggle" style="margin: 0; font-weight: normal; user-select: none; cursor: pointer;">แสดงเส้นขอบ</label>
            </div>
            <div class="modal-buttons">
                <button id="insert-table-btn" class="modal-btn-confirm">แทรก</button>
                <button class="modal-btn-cancel">ยกเลิก</button>
            </div>
        </div>
    </div>

    <!-- NEW: Modals for Adding Template Items -->
    <!-- === START: REVISED CB Item Modal === -->
    <div id="cb-item-modal" class="modal-overlay cb-modal">
        <div class="modal-content" style="width: 750px">
            <h3>เพิ่มรายการ (CB)</h3>
            

            <div class="modal-input-group" style="display: flex; gap: 20px;">
                <div style="flex: 1;">
                    <label for="cb-code-editor">รหัส:</label>
                    <div id="cb-code-editor" class="editable-div code" contenteditable="true"></div>
                </div>
                <div style="flex: 1;">
                    <label for="cb-description-editor">รายละเอียด:</label>
                    <div id="cb-description-editor" class="editable-div detail" contenteditable="true"></div>
                </div>
            </div>

            <div class="modal-buttons">
                <button id="add-cb-item-btn" class="modal-btn-confirm">เพิ่ม</button>
                <button class="modal-btn-cancel">ยกเลิก</button>
            </div>
        </div>
    </div>
    <!-- === END: REVISED CB Item Modal === -->

    <!-- === START: REVISED IB Item Modal === -->
    <div id="ib-item-modal" class="modal-overlay ib-modal">
        <div class="modal-content" style="width: 540px">
            <h3>เพิ่มรายการ (IB)</h3>
            
            <div class="modal-input-group" style="display: flex; gap: 20px;">
                <div style="flex: 1;">
                    <label for="ib-main-branch">สาขาการตรวจหลัก:</label>
                    <input type="text" id="ib-main-branch">
                </div>
                <div style="flex: 1;">
                    <label for="ib-sub-branch">สาขาการตรวจย่อย:</label>
                    <div id="ib-sub-branch" class="editable-div" contenteditable="true"></div>
                </div>
            </div>

            <div class="modal-input-group" style="display: flex; gap: 20px;">
                <div style="flex: 1;">
                    <label for="ib-main-scope">ขอบข่ายหลัก:</label>
                    <div id="ib-main-scope" class="editable-div" contenteditable="true"></div>
                </div>
                <div style="flex: 1;">
                    <label for="ib-sub-scope">ขอบข่ายย่อย:</label>
                    <div id="ib-sub-scope" class="editable-div" contenteditable="true"></div>
                </div>
            </div>

            <div class="modal-input-group">
                <label for="ib-requirements-editor">ข้อกำหนดที่ใช้:</label>
                <div id="ib-requirements-editor" class="editable-div" contenteditable="true"></div>
            </div>

            <div class="modal-buttons">
                <button id="add-ib-item-btn" class="modal-btn-confirm">เพิ่ม</button>
                <button class="modal-btn-cancel">ยกเลิก</button>
            </div>
        </div>
    </div>
    <!-- === END: REVISED IB Item Modal === -->

    <!-- MODIFIED: Lab Cal Item Modal -->
    <div id="lab-cal-item-modal" class="modal-overlay lab-cal-modal">
        <div class="modal-content">
            <h3>เพิ่มรายการ (Lab Cal)</h3>
            <div class="modal-input-group" style="display: flex; gap: 20px;">
                <div style="flex: 1;">
                    <label for="lab-cal-field">สาขาการสอบเทียบ:</label>
                    <select id="lab-cal-field" >
                    </select>
                </div>
                <div style="flex: 1;">
                    <label for="lab-cal-instrument">เครื่องมือ:</label>
                    <select id="lab-cal-instrument" >
                    </select>
                </div>
            </div>
               <div class="modal-input-group" style="display: flex; gap: 20px;">

                <div style="flex: 1;">
                    <label for="lab-cal-instrument2">เครื่องมือ2:</label>
                    <select id="lab-cal-instrument2" >
                    </select>
                </div>
            </div>
            <div class="modal-input-group" style="display: flex; gap: 20px;">
                <div style="flex: 1;">
                    <label for="lab-cal-parameter-one">พารามิเตอร์1: <a href="{{ route('certify.applicant.special-sign') }}" style="text-decoration: none; font-size: 18px;" target="_blank">สัญลักษณ์พิเศษ</a></label>
                     <select id="lab-cal-parameter-one" >
                    </select>
                </div>
                <div style="flex: 1;">
                    <label for="lab-cal-parameter-two">พารามิเตอร์2: </label>
                     <select id="lab-cal-parameter-two" >
                    </select>
                </div>

            </div>

            <div class="modal-input-group"  >
                <label for="lab-cal-condition">เงื่อนไขการวัด:</label>
                <input type="text" id="lab-cal-condition" >
            </div>
              
            <div class="modal-input-group" style="display: flex; gap: 20px;">
 
                <div style="flex: 1;">
                    <label for="lab-cal-param-details-editor">ช่วงการวัด:</label>
                    <div id="lab-cal-param-details-editor" class="editable-div"  contenteditable="true"></div>
                </div>
                <div style="flex: 1;">
                    <label for="lab-cal-capability-editor">ขีดความสามารถฯ:</label>
                    <div id="lab-cal-capability-editor" class="editable-div" contenteditable="true"></div>
                </div>
            </div>
            <div class="modal-input-group">
                <label for="lab-cal-method-editor" style="display: block;">วิธีสอบเทียบ / มาตรฐานที่ใช้:</label>
                <div id="lab-cal-method-editor" class="editable-div" contenteditable="true"></div>
            </div>
            <div class="modal-buttons">
                <button id="add-lab-cal-item-btn" class="modal-btn-confirm">เพิ่ม</button>
                <button class="modal-btn-cancel">ยกเลิก</button>
            </div>
        </div>
    </div>

    <!-- === START: MODIFICATION FOR LAB TEST MODAL === -->
    <div id="lab-test-item-modal" class="modal-overlay lab-test-modal" >
        <div class="modal-content" style="width: 540px">
            <h3>เพิ่มรายการ (Lab Test)</h3>
            <div class="modal-input-group" style="display: flex; gap: 20px;">
                <div style="flex: 1;">
                    <label for="lab-test-field">สาขาการทดสอบ:</label>
                    <select id="lab-test-field" >
                    </select>
                </div>
                <div style="flex: 1;">
                    <label for="lab-test-category">ผลิตภัณฑ์ที่ทดสอบ:</label>
                    <select id="lab-test-category" >
                    </select>
                </div>
            </div>

             <div class="modal-input-group" style="display: flex; gap: 20px;">
                <div style="flex: 1;">
                     <label for="lab-test-parameter">รายการทดสอบ:</label>
                    <select id="lab-test-parameter" >
                    </select>
                </div>
                  <div style="flex: 1;">
                    <label for="lab-test-description-editor">คำอธิบาย:</label>
                
                    <input type="text" id="lab-test-description-editor" >
                </div>
             </div>

            <div class="modal-input-group" style="display: flex; gap: 20px;">
                <div style="flex: 1;">
                     <label for="lab-test-param-details-editor">ช่วงการทดสอบ:</label>
                    <div id="lab-test-param-details-editor" class="editable-div"  contenteditable="true"></div>
                </div>
                <div style="flex: 1;">
                    <label for="lab-test-method-editor">วิธีทดสอบ:</label>
                    <div id="lab-test-method-editor" class="editable-div"  contenteditable="true"></div>
                </div>
            </div>
            <div class="modal-buttons">
                <button id="add-lab-test-item-btn" class="modal-btn-confirm">เพิ่ม</button>
                <button class="modal-btn-cancel">ยกเลิก</button>
            </div>
        </div>
    </div>
    <!-- === END: MODIFICATION FOR LAB TEST MODAL === -->


    <!-- === START: MODIFICATION === -->
    <div id="context-menu">
        <div class="context-menu-item" data-action="add-item">เพิ่มรายการ</div>
        <div class="context-menu-separator" data-action="separator-add"></div>
        <div class="context-menu-item" data-action="insert-row-above">แทรกแถวด้านบน <span style="float: right; color: #888; margin-left: 20px;">Shift+F1</span></div>
        <div class="context-menu-item" data-action="insert-row-above-no-border">แทรกแถวด้านบน (ไม่มีขอบ) <span style="float: right; color: #888; margin-left: 20px;">Shift+F2</span></div>
        <div class="context-menu-item" data-action="insert-row-below">แทรกแถวด้านล่าง <span style="float: right; color: #888; margin-left: 20px;">Shift+F4</span></div>
        <div class="context-menu-item" data-action="insert-row-below-no-border">แทรกแถวด้านล่าง (ไม่มีขอบ) <span style="float: right; color: #888; margin-left: 20px;">Shift+F5</span></div>
        <div class="context-menu-item" data-action="insert-column-left">แทรกคอลัมน์ด้านซ้าย</div>
        <div class="context-menu-item" data-action="insert-column-right">แทรกคอลัมน์ด้านขวา</div>
        <div class="context-menu-separator"></div>
        <div class="context-menu-item" data-action="delete-row">ลบแถว</div>
        <div class="context-menu-item" data-action="delete-column">ลบคอลัมน์</div>
        <div class="context-menu-separator" data-action="separator-merge"></div>
        <div class="context-menu-item" data-action="merge-columns">รวมคอลัมน์</div>
    </div>
    <!-- === END: MODIFICATION === -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.execCommand('styleWithCSS', false, true);

        // --- DOM Elements ---
        const editor = document.getElementById('document-editor');
        const menubar = document.getElementById('menubar');
        const tableModalOverlay = document.getElementById('table-modal-overlay');
        const insertTableBtn = document.getElementById('insert-table-btn');
        const tableRowsInput = document.getElementById('table-rows');
        const tableColsInput = document.getElementById('table-cols');
        const tableBorderToggle = document.getElementById('table-border-toggle');
        const imageInput = document.getElementById('image-input');
        const contextMenu = document.getElementById('context-menu');
        const templateDropdownButton = document.getElementById('template-dropdown-button');
        const templateDropdownContent = document.querySelector('.dropdown-content');
        // const exportPdfButton = document.getElementById('export-pdf-button');
        const fontSizeSelector = document.getElementById('font-size-selector');
        const saveTemplateButton = document.getElementById('save-template-button'); 
        const loadTemplateButton = document.getElementById('load-template-button');

        // --- NEW: Template Item Modals ---
        const cbItemModal = document.getElementById('cb-item-modal');
        const ibItemModal = document.getElementById('ib-item-modal');
        const labCalItemModal = document.getElementById('lab-cal-item-modal');
        const labTestItemModal = document.getElementById('lab-test-item-modal');

        // 1. รับข้อมูลจาก Blade ที่ PHP ส่งมา
        const templateType = "{{ $templateType ?? '' }}"; 
        const labCalDetailsFromBlade = @json($labCalDetails ?? null); 
        const labTestDetailsFromBlade = @json($labTestDetails ?? null);
        const cbDetailsFromBlade = @json($cbDetails ?? null);
        const ibDetailsFromBlade = @json($ibDetails ?? null);

        const labCalDetails = @json($labCalDetails ?? null);
        const accordingFormula = @json($according_formula ?? null);
        const labAbility = @json($lab_ability ?? null);
        const purpose = @json($purpose ?? null);

        let labCalItems = [];
        let labTestItems = [];

        document.addEventListener('DOMContentLoaded', () => {
            downloadTemplate();
        });                                


        let savedRange = null; // Used for image insertion
        let contextMenuTarget = null;
        let contextMenuTargetRow = null; // To store the target TR element for immediate context menu actions
        let selectedTableCellsForMerge = []; // Holds cells selected for merging
        let activeModalTargetRow = null; // **NEW**: Persists the target row for modal operations

        // --- Global Paste Handler for Main Editor ---
        // This listener is attached to the main editor container (#document-editor).
        // It catches all paste events within any ".page" element.
        // Its purpose is to strip all formatting and paste as plain text.
        editor.addEventListener('paste', (event) => {
            // Prevent the default paste action which might include rich text formatting.
            event.preventDefault();

            // Get the pasted content as plain text from the clipboard.
            const text = (event.clipboardData || window.clipboardData).getData('text/plain');

            // Insert the plain text at the current cursor position.
            document.execCommand('insertText', false, text);
        });
        
        // --- LineExtractor Class ---
        // This class is specifically for the contenteditable div in the Lab Cal modal.
        class LineExtractor {
            constructor(elementId) {
                this.editableDiv = document.getElementById(elementId);
                this.init();
            }

            init() {
                if (!this.editableDiv) {
                    console.error('Element not found:', this.elementId);
                    return;
                }

                // --- Specific Paste Handler for Modal's Div ---
                // This listener ONLY applies to the div managed by this class instance
                // (e.g., #lab-cal-method-editor).
                // Its purpose is to paste as plain text BUT apply specific styles.
                this.editableDiv.addEventListener('paste', (event) => {
                    // Prevent the default paste action
                    event.preventDefault();
                    console.log("Paste event fired in modal's editableDiv!");
                    
                    // Get pasted text as plain text
                    const text = (event.clipboardData || window.clipboardData).getData('text/plain');

                    // Insert the plain text. The browser will handle wrapping it in the current context.
                    // For a contenteditable div, this is usually sufficient.
                    document.execCommand('insertText', false, text);
                });
            }

            getLines() {
                if (!this.editableDiv) return [];
                
                const tempDiv = document.createElement('div');
                const computedStyle = window.getComputedStyle(this.editableDiv);
                
                tempDiv.style.width = computedStyle.width;
                tempDiv.style.position = 'absolute';
                tempDiv.style.visibility = 'hidden';
                tempDiv.style.whiteSpace = 'pre-wrap';
                tempDiv.style.overflowWrap = 'break-word';
                tempDiv.style.fontFamily = computedStyle.fontFamily;
                tempDiv.style.fontSize = computedStyle.fontSize;
                tempDiv.style.lineHeight = computedStyle.lineHeight;
                tempDiv.style.padding = computedStyle.padding;
                tempDiv.style.border = computedStyle.border;
                tempDiv.style.boxSizing = computedStyle.boxSizing;

                // Use innerText to respect user-entered newlines
                let text = this.editableDiv.innerText;
                document.body.appendChild(tempDiv);
            
                const lines = [];
                const range = document.createRange();
                let lastTop = null;
            
                // Split text by newlines first to handle manual line breaks
                const textLines = text.split('\n');
            
                for (let line of textLines) {
                    if (line.trim() === '') {
                        // Add empty lines from newlines
                        lines.push('');
                        continue;
                    }
            
                    // Put the text of this line into tempDiv to check for wrapping
                    tempDiv.textContent = line;
            
                    let subCurrentLine = '';
                    let tempNode = tempDiv.firstChild;
                    if (!tempNode || tempNode.nodeType !== Node.TEXT_NODE) {
                         if (line) lines.push(line);
                         continue;
                    }

                    for (let i = 0; i < line.length; i++) {
                        range.setStart(tempNode, i);
                        range.setEnd(tempNode, i + 1);
                        const rects = range.getClientRects();
                        
                        if (rects.length > 0) {
                            const rect = rects[0];
                            // If the top position changes, it's a new line
                            if (lastTop !== null && rect.top > lastTop) {
                                lines.push(subCurrentLine.trim());
                                subCurrentLine = line[i];
                            } else {
                                subCurrentLine += line[i];
                            }
                            lastTop = rect.top;
                        }
            
                        // Push the last part of the line
                        if (i === line.length - 1) {
                            lines.push(subCurrentLine.trim());
                        }
                    }
                    lastTop = null; // Reset for the next line from text.split('\n')
                }
            
                document.body.removeChild(tempDiv);
            
                return lines;
            }
        }


        // --- Core Styling Functions ---
        const applyStyleToSelectedSpans = (styleCallback) => {
            const selection = window.getSelection();
            if (!selection.rangeCount || selection.isCollapsed) return;

            const originalRange = selection.getRangeAt(0).cloneRange();
            
            let startElement = originalRange.startContainer;
            if (startElement.nodeType === Node.TEXT_NODE) {
                startElement = startElement.parentElement;
            }
            const parentPage = startElement.closest('.page');
            
            if (!parentPage) return;

            const tempMarkerColor = 'rgb(1, 2, 3)';
            document.execCommand('foreColor', false, tempMarkerColor);
            
            const spans = parentPage.querySelectorAll(`span[style*="color: ${tempMarkerColor}"]`);

            if (spans.length === 0) {
                document.execCommand('undo');
                selection.removeAllRanges();
                selection.addRange(originalRange);
                return;
            }

            spans.forEach(span => {
                span.style.color = '';
                styleCallback(span);
                if (!span.style.cssText.trim()) {
                    span.removeAttribute('style');
                }
            });

            parentPage.querySelectorAll('span:not([style])').forEach(emptySpan => {
                const parent = emptySpan.parentNode;
                while(emptySpan.firstChild){
                    parent.insertBefore(emptySpan.firstChild, emptySpan);
                }
                parent.removeChild(emptySpan);
            });
            
            selection.removeAllRanges();
            selection.addRange(originalRange);
        };

        // --- Menubar Functionality ---
        menubar.addEventListener('click', (event) => {
            const button = event.target.closest('.menu-button');
            if (!button) return;
            const command = button.dataset.command;
            
            if (button.id !== 'template-dropdown-button') {
                templateDropdownContent.parentElement.classList.remove('show');
            }

            if (command === 'increaseLineHeight' || command === 'decreaseLineHeight') {
                changeLineHeight(command);
            } else if (command === 'insertTable') {
                insertTable();
            } else if (command === 'insertImage') {
                // Save range for image insertion
                const selection = window.getSelection();
                if (selection.rangeCount > 0) {
                    savedRange = selection.getRangeAt(0).cloneRange();
                }
                imageInput.click();
            } else {
                document.execCommand(command, false, null);
            }
            
            if(command !== 'insertTable' && command !== 'insertImage') {
               const lastActivePage = editor.querySelector('.page:focus') || editor.querySelector('.page');
               lastActivePage?.focus();
            }
        });

        fontSizeSelector.addEventListener('change', (event) => {
            const newSize = event.target.value;
            if (!newSize) return;

            applyStyleToSelectedSpans((element) => {
                element.style.fontSize = newSize + 'px';
            });
            
            const lastActivePage = editor.querySelector('.page:focus') || editor.querySelector('.page');
            lastActivePage?.focus();
        });
        
        templateDropdownButton.addEventListener('click', (event) => {
            event.stopPropagation();
            templateDropdownContent.parentElement.classList.toggle('show');
        });

        templateDropdownContent.addEventListener('click', (event) => {
            const templateItem = event.target.closest('a[data-template]');
            if (templateItem) {
                event.preventDefault();
                const templateId = templateItem.dataset.template;
                if (templateId === 'cb-template') {
                    insertCbTemplate();
                } else if (templateId === 'ib-template') {
                    insertIbTemplate();
                } else if (templateId === 'lab-cal-template') {
                    insertLabCalTemplate();
                } else if (templateId === 'lab-test-template') {
                    insertLabTestTemplate();
                }
                templateDropdownContent.parentElement.classList.remove('show');
            }
        });

        document.addEventListener('click', (event) => {
            if (!templateDropdownContent.parentElement.contains(event.target)) {
                templateDropdownContent.parentElement.classList.remove('show');
            }
        });
        
        const changeLineHeight = (direction) => {
            const selection = window.getSelection();
            if (!selection.rangeCount) return;

            let element = selection.getRangeAt(0).startContainer;
            if (element.nodeType === Node.TEXT_NODE) {
                element = element.parentElement;
            }
            
            while (element && window.getComputedStyle(element).display !== 'block' && !element.classList.contains('page')) {
                element = element.parentElement;
            }

            if (!element || element.classList.contains('page')) {
                document.execCommand('formatBlock', false, 'p');
                element = window.getSelection().getRangeAt(0).startContainer.closest('p');
            }
            
            if(!element) return;

            const computedStyle = window.getComputedStyle(element);
            let currentLineHeight = computedStyle.lineHeight;
            const fontSize = parseFloat(computedStyle.fontSize);
            let currentLineHeightValue;

            if (currentLineHeight === 'normal') {
                currentLineHeightValue = 1.6;
            } else if (currentLineHeight.endsWith('px')) {
                currentLineHeightValue = parseFloat(currentLineHeight) / fontSize;
            } else {
                currentLineHeightValue = parseFloat(currentLineHeight);
            }
            
            if (isNaN(currentLineHeightValue)) {
                currentLineHeightValue = 1.6;
            }

            const step = 0.2;
            let newLineHeight = (direction === 'increaseLineHeight')
                ? currentLineHeightValue + step
                : currentLineHeightValue - step;

            newLineHeight = Math.max(1.0, Math.min(4.0, newLineHeight));
            newLineHeight = Math.round(newLineHeight * 10) / 10;

            element.style.lineHeight = newLineHeight.toString();
        };

        const insertTable = () => {
            const selection = window.getSelection();
            if (selection.rangeCount > 0) savedRange = selection.getRangeAt(0).cloneRange();
            tableModalOverlay.style.display = 'flex';
            tableRowsInput.focus();
        };

        // Helper function to insert template content into the correct page
        const insertTemplateAtCurrentOrLastPage = (templateHTML) => {
            let targetPage = editor.querySelector('.page:focus');

            if (!targetPage || (targetPage.textContent.trim() === '' && editor.children.length > 1)) {
                const pages = Array.from(editor.querySelectorAll('.page'));
                for (let i = pages.length - 1; i >= 0; i--) {
                    if (pages[i].textContent.trim() !== '' || i === pages.length - 1) {
                        targetPage = pages[i];
                        break;
                    }
                }
            }

            if (!targetPage) {
                targetPage = editor.querySelector('.page');
            }

            if (targetPage) {
                targetPage.focus();
                const range = document.createRange();
                const selection = window.getSelection();
                range.selectNodeContents(targetPage);
                range.collapse(false);
                selection.removeAllRanges();
                selection.addRange(range);
                document.execCommand('insertHTML', false, templateHTML);
            }
            setTimeout(managePages, 10);
        };
        
const insertCbTemplate = () => {
            const templateData = cbDetailsFromBlade;

            if (!templateData) {
                console.error("No cbDetails data available to render.");
                return;
            }

            let accreditationCriteriaHTML = '';
            if (templateData.accreditationCriteria && Array.isArray(templateData.accreditationCriteria)) {
                accreditationCriteriaHTML = templateData.accreditationCriteria.map(item =>
                    `${item.th}<br><span style="font-size: 15px;">${item.en}</span>`
                ).join('<br>');
            }

            let isicTableRows = '';
            if (templateData.isicCodes && Array.isArray(templateData.isicCodes)) {
                templateData.isicCodes.forEach(item => {
                    isicTableRows += `
                        <tr>
                            <td style="width: 20%;">${item.code}</td>
                            <td >${item.description_th}<br><span style="font-size: 15px;">(${item.description_en})</span></td>
                        </tr>
                    `;
                });
            }

            const templateHTML = `
                <div style="text-align: center;line-height: 1.0">
                    <b style="font-size: 1.17em;">${templateData.scopeOfAccreditation.th}</b><br>
                    <span style="font-size: 15px;">(${templateData.scopeOfAccreditation.en})</span><br>
                    ${templateData.attachmentToCertificate.th}<br>
                    <span style="font-size: 15px;" class="certificate_no_th">(${templateData.attachmentToCertificate.en})</span><br>
                    <span class="certificate_no_th">ใบรับรองเลขที่ ${templateData.certificateNo}</span><br>
                    <span style="font-size: 15px;" class="certificate_no_en">(Certification No. ${templateData.certificateNo})</span>
                </div>
                <table class="borderless" style="width: 100%; margin-bottom: 1em;">
                    <tbody>
                        <tr>
                            <td class="vertical-align-top" style="width: 25%;"><b>หน่วยรับรอง</b><br><span style="font-size: 15px;">(Certification Body)</span></td>
                            <td class="vertical-align-top">${templateData.certificationBody.th}<br><span style="font-size: 15px;">(${templateData.certificationBody.en})</span></td>
                        </tr>
                        <tr>
                            <td class="vertical-align-top"><b>ที่ตั้งสถานประกอบการ</b><br><span style="font-size: 15px;">(Premise)</span></td>
                            <td class="vertical-align-top">${templateData.premise.th}<br><span style="font-size: 15px;">(${templateData.premise.en})</span></td>
                        </tr>
                        <tr>
                            <td class="vertical-align-top"><b>ข้อกำหนดที่ใช้ในการรับรอง</b><br><span style="font-size: 15px;">(Accreditation criteria)</span></td>
                            <td class="vertical-align-top">${accreditationCriteriaHTML}</td>
                        </tr>
                        <tr>
                            <td class="vertical-align-top"><b>กิจกรรมที่ได้รับการรับรอง</b><br><span style="font-size: 15px;">(Certification Mark)</span></td>
                            <td class="vertical-align-top">${templateData.certificationMark.th}<br><span style="font-size: 15px;">(${templateData.certificationMark.en})</span></td>
                        </tr>
                    </tbody>
                </table>
                <table class="detail-table" style="width: 100%; margin-bottom: 1em;">
                    <thead>
                        <tr>
                            <th style="width: 25%;">รหัส ISIC<br><span style="font-size: 15px">(ISIC Codes)</span></th>
                            <th>กิจกรรม<br><span style="font-size: 15px;">(Description)</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        ${isicTableRows}
                    </tbody>
                </table>
                <p><br></p>
            `;
            insertTemplateAtCurrentOrLastPage(templateHTML);
        };

   const insertIbTemplate = () => {
            const templateData = ibDetailsFromBlade;

            if (!templateData) {
                console.error("No ibDetails data available to render.");
                return;
            }

            let inspectionTableRows = '';
            templateData.inspectionItems.forEach(item => {
                inspectionTableRows += `
                    <tr>
                        <td>${item.category}</td>
                        <td>${item.procedure}</td>
                        <td>${item.requirements}</td>
                    </tr>
                `;
            });

            const templateHTML = `
                <div style="text-align: center; line-height: 1.1; margin-bottom: 1em;">
                    <span ><b style="font-size: 20px;">${templateData.title}</b></span><br>
                    <span class="certificate_no_th"><b>ใบรับรองเลขที่ ${templateData.certificateNo}</b><span>
                </div>
                <table class="borderless" style="width: 100%; margin-bottom: 1em;">
                    <tbody>
                        <tr>
                            <td class="vertical-align-top" style="width: 22%;"><b>ชื่อหน่วยตรวจ</b></td>
                            <td class="vertical-align-top">: ${templateData.inspectionBodyName}</td>
                        </tr>
                        <tr>
                            <td class="vertical-align-top" colspan="2">
                                <table class="borderless" style="width: 100%; margin: 0;">
                                    <tbody>
                                        <tr>
                                            <td class="vertical-align-top" style="width: 50%;">
                                                <b>ที่ตั้งสำนักงานใหญ่</b><br>
                                                ${templateData.headOfficeAddress}
                                            </td>
                                            <td class="vertical-align-top" style="width: 50%;">
                                                <b>ที่ตั้งสำนักงานสาขา (กรณีแตกต่างจากที่ตั้งสำนักงานใหญ่)</b><br>
                                                ${templateData.branchOfficeAddress}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td class="vertical-align-top"><b>หมายเลขการรับรอง</b></td>
                            <td class="vertical-align-top">: ${templateData.accreditationNo}</td>
                        </tr>
                        <tr>
                            <td class="vertical-align-top"><b>ประเภทของหน่วยตรวจ</b></td>
                            <td class="vertical-align-top">: ${templateData.inspectionBodyType}</td>
                        </tr>
                    </tbody>
                </table>
                <table class="detail-table" style="width: 100%; margin-bottom: 1em;">
                    <thead>
                        <tr>
                            <th style="text-align: center;">หมวดหมู่ / สาขาการตรวจ</th>
                            <th style="text-align: center;">ขั้นตอนและช่วงการตรวจ</th>
                            <th style="text-align: center;">ข้อกำหนดที่ใช้</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${inspectionTableRows}
                    </tbody>
                </table>
                <p><br></p>
            `;

            insertTemplateAtCurrentOrLastPage(templateHTML);
        };
        

        const insertLabCalTemplate = () => {
            const templateData = labCalDetailsFromBlade;
            if (!templateData) {
                console.error("No labCalDetails data available to render.");
                return;
            }

            let calibrationTableRows = '';
            templateData.calibrationData.forEach(item => {
                calibrationTableRows += `
                    <tr>
                        <td style="text-align: left;">${item.field.th}<br><span style="font-size: 15px;">${item.field.en}</span></td>
                        <td style="text-align: left;">${item.parameter}</td>
                        <td style="text-align: center;">${item.capability}</td>
                        <td style="text-align: left;">${item.method}</td>
                    </tr>
                `;
            });
            calibrationTableRows +=`
            <tr>
                <td style="text-align: center; line-height: 1; padding: 5px 0 0 0;" colspan="4">
                    <span>* ค่าความไม่แน่นอน (±) ที่ระดับความเชื่อมั่นประมาณ 95 %</span><br>
                    <span>และมีความหมายเป็นไปตามเอกสารวิชาการเรื่อง ขีดความสามารถของการสอบเทียบและการวัด (TLA-03)</span><br>
                    <span style="font-size:16px">(* Expressed as an uncertainty (±) providing a level of confidence of approximately 95%</span><br>
                    <span style="font-size:16px">and the term “CMCs” has been expressed in the technical document (TLA-03))</span><br>
                </td>
            </tr>
            `;

            const isPermanentChecked = templateData.laboratory_status.is_permanent ? 'checked="checked"' : '';
            const isSiteChecked = templateData.laboratory_status.is_site ? 'checked="checked"' : '';
            const isTemporaryChecked = templateData.laboratory_status.is_temporary ? 'checked="checked"' : '';
            const isMobileChecked = templateData.laboratory_status.is_mobile ? 'checked="checked"' : '';
            const isMultisiteChecked = templateData.laboratory_status.is_multisite ? 'checked="checked"' : '';


            const templateHTML = `
                <div style="text-align: center; line-height: 1.1; position: relative;  margin-bottom: 0em;">
                    <b style="font-size: 20px;">${templateData.title.th}</b><br>
                    <span style="font-size: 15px;" >(${templateData.title.en})</span><br>
                    <span class="certificate_no_th">ใบรับรองเลขที่ ${templateData.certificateNo}</span><br>
                    <span style="font-size: 15px;" class="certificate_no_en">(Certification no. ${templateData.certificateNo})</span>
                </div>
                <table class="borderless" style="width: 100%; ">
                    <tbody>
                        <tr>
                            <td class="vertical-align-top" style="width: 22%;"><b>ชื่อห้องปฏิบัติการ</b><br><span style="font-size: 15px;">(Laboratory Name)</span></td>
                            <td class="vertical-align-top" colspan="3">${templateData.labName.th}<br><span style="font-size: 15px;">(${templateData.labName.en})</span></td>
                        </tr>
                        <tr>
                            <td class="vertical-align-top"><b>หมายเลขการรับรองที่</b><br><span style="font-size: 15px;">(Accreditation No.)</span></td>
                            <td class="vertical-align-top" colspan="3"><span class="accreditation_no_th">${templateData.accreditationNo.th}</span><br><span style="font-size: 15px;" class="accreditation_no_en">(${templateData.accreditationNo.en})</span></td>
                        </tr>

                        <tr>
                            <td class="vertical-align-top"><b>ฉบับที่</b><span class="issue_no"> ${templateData.issueNo}</span><br><span style="font-size: 15px;">(Issue No.)</span></td>
                            <td class="vertical-align-top" colspan="2"><span class="issue_from_date_th">ออกให้ตั้งแต่วันที่ ${templateData.validFrom.th}</span><br><span style="font-size: 15px;" class="issue_from_date_en">(Valid from ${templateData.validFrom.en})</span></td>
                            <td class="vertical-align-top" colspan="2"><span class="issue_to_date_th">ถึงวันที่ ${templateData.until.th}</span><br><span style="font-size: 15px;" class="issue_to_date_en">(Until ${templateData.until.en})</span></td>
                        </tr>
                        <tr>
                            <td class="vertical-align-top"><b>สถานภาพห้องปฏิบัติการ</b><br><span style="font-size: 15px;">(Laboratory status)</span></td>
                            <td class="vertical-align-top" colspan="4">
                                <table class="borderless" style="width: 100%; margin: 0; font-size: 18px; table-layout: fixed;">
                                    <tbody>
                                        <tr>
                                            <td style="padding: 0; vertical-align: top; white-space: nowrap;">
                                                <input type="checkbox" ${isPermanentChecked} style="vertical-align: middle;">
                                                <span style="line-height: 1.2;font-size:20px">ถาวร<br><span style="font-size: 15px;">(Permanent)</span></span>
                                            </td>
                                            <td style="padding: 0; vertical-align: top; white-space: nowrap;">
                                                <input type="checkbox" ${isSiteChecked} style="vertical-align: middle; ">
                                                <span style="line-height: 1.2;font-size:20px">นอกสถานที่<br><span style="font-size: 15px;">(Site)</span></span>
                                            </td>
                                            <td style="padding: 0; vertical-align: top; white-space: nowrap;">
                                                <input type="checkbox" ${isTemporaryChecked} style="vertical-align: middle; ">
                                                <span style="line-height: 1.2;font-size:20px">ชั่วคราว<br><span style="font-size: 15px;">(Temporary)</span></span>
                                            </td>
                                            <td style="padding: 0; vertical-align: top; white-space: nowrap;">
                                                <input type="checkbox" ${isMobileChecked} style="vertical-align: middle; ">
                                                <span style="line-height: 1.2;font-size:20px">เคลื่อนที่<br><span style="font-size: 15px;">(Mobile)</span></span>
                                            </td>
                                            <td style="padding: 0; vertical-align: top; white-space: nowrap;">
                                                <input type="checkbox" ${isMultisiteChecked} style="vertical-align: middle; ">
                                                <span style="line-height: 1.2;font-size:20px">หลายสาขา<br><span style="font-size: 15px;">(Multisite)</span></span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table class="detail-table" style="width: 100%; margin-bottom: 1em; line-height: 1.1; ">
                    <thead>
                        <tr>
                            <th style="width: 17%; text-align: center;">สาขาการสอบเทียบ<br><span style="font-size: 15px;">(Field of Calibration)</span></th>
                            <th style="width: 28%; text-align: center;">รายการสอบเทียบ<br><span style="font-size: 15px;">(Parameter)</span></th>
                            <th style="width: 28%; text-align: center;">ขีดความสามารถของ<br>การสอบเทียบและการวัด*<br><span style="font-size: 15px;">(Calibration and Measurement<br>Capability*)</span></th>
                            <th style="width: 27%; text-align: center;">วิธีการสอบเทียบ<br><span style="font-size: 15px;">(Calibration Method)</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        ${calibrationTableRows}
                    </tbody>
                </table>
                <p><br></p>
            `;

            insertTemplateAtCurrentOrLastPage(templateHTML);
        };

        const insertLabTestTemplate = () => {
            const templateData = labTestDetailsFromBlade;

            if (!templateData) {
                console.error("No labTestDetails data available to render.");
                return;
            }

            let testTableRows = '';
            templateData.testLabData.forEach(item => {
                testTableRows += `
                    <tr>
                        <td style="text-align: left;">${item.field.th}<br><span style="font-size: 15px;">${item.field.en}</span></td>
                        <td style="text-align: left;">${item.parameter}</td>
                        <td style="text-align: left;">${item.method}</td>
                    </tr>
                `;
            });

            const isPermanentChecked = templateData.laboratory_status.is_permanent ? 'checked="checked"' : '';
            const isSiteChecked = templateData.laboratory_status.is_site ? 'checked="checked"' : '';
            const isTemporaryChecked = templateData.laboratory_status.is_temporary ? 'checked="checked"' : '';
            const isMobileChecked = templateData.laboratory_status.is_mobile ? 'checked="checked"' : '';
            const isMultisiteChecked = templateData.laboratory_status.is_multisite ? 'checked="checked"' : '';

            const templateHTML = `
                <div style="text-align: center; line-height: 1.1; position: relative; margin-bottom: 0em;">
                    <b style="font-size: 20px;">${templateData.title.th}</b><br>
                    <span style="font-size: 15px;">(${templateData.title.en})</span><br>
                    <span class="certificate_no_th">ใบรับรองเลขที่ ${templateData.certificateNo}</span><br>
                    <span style="font-size: 15px;" class="certificate_no_en">(Certification no. ${templateData.certificateNo})</span>
                </div>
                <table class="borderless" style="width: 100%; ">
                    <tbody>
                        <tr>
                            <td class="vertical-align-top" style="width: 25%;"><b>ชื่อห้องปฏิบัติการ</b><br><span style="font-size: 15px;">(Laboratory Name)</span></td>
                            <td class="vertical-align-top" colspan="3">${templateData.labName.th}<br><span style="font-size: 15px;">(${templateData.labName.en})</span></td>
                        </tr>
                        <tr>
                            <td class="vertical-align-top"><b>หมายเลขการรับรองที่</b><br><span style="font-size: 15px;">(Accreditation No.)</span></td>
                            <td class="vertical-align-top" colspan="3"><span class="accreditation_no_th">${templateData.accreditationNo.th}</span><br><span style="font-size: 15px;" class="accreditation_no_en">(${templateData.accreditationNo.en})</span></td>
                        </tr>

                        <tr>
                            <td class="vertical-align-top"><b>ฉบับที่</b><span class="issue_no"> ${templateData.issueNo}</span><br><span style="font-size: 15px;">(Issue No.)</span></td>
                            <td class="vertical-align-top" colspan="2"><span class="issue_from_date_th">ออกให้ตั้งแต่วันที่ ${templateData.validFrom.th}</span><br><span style="font-size: 15px;" class="issue_from_date_en">(Valid from ${templateData.validFrom.en})</span></td>
                            <td class="vertical-align-top" colspan="2"><span class="issue_to_date_th">ถึงวันที่ ${templateData.until.th}</span><br><span style="font-size: 15px;" class="issue_to_date_en">(Until ${templateData.until.en})</span></td>
                        </tr>
                        <tr>
                            <td class="vertical-align-top"><b>สถานภาพห้องปฏิบัติการ</b><br><span style="font-size: 15px;">(Laboratory status)</span></td>
                            <td class="vertical-align-top" colspan="4">
                                <table class="borderless" style="width: 100%; margin: 0; font-size: 18px; table-layout: fixed;">
                                    <tbody>
                                        <tr>
                                            <td style="padding: 0; vertical-align: top; white-space: nowrap;">
                                                <input type="checkbox" ${isPermanentChecked} style="vertical-align: middle; margin-right: 5px;">
                                                <span style="line-height: 1.2;font-size:20px">ถาวร<br><span style="font-size: 15px;">(Permanent)</span></span>
                                            </td>
                                            <td style="padding: 0; vertical-align: top; white-space: nowrap;">
                                                <input type="checkbox" ${isSiteChecked} style="vertical-align: middle; margin-right: 5px;">
                                                <span style="line-height: 1.2;font-size:20px">นอกสถานที่<br><span style="font-size: 15px;">(Site)</span></span>
                                            </td>
                                            <td style="padding: 0; vertical-align: top; white-space: nowrap;">
                                                <input type="checkbox" ${isTemporaryChecked} style="vertical-align: middle; margin-right: 5px;">
                                                <span style="line-height: 1.2;font-size:20px">ชั่วคราว<br><span style="font-size: 15px;">(Temporary)</span></span>
                                            </td>
                                            <td style="padding: 0; vertical-align: top; white-space: nowrap;">
                                                <input type="checkbox" ${isMobileChecked} style="vertical-align: middle; margin-right: 5px;">
                                                <span style="line-height: 1.2;font-size:20px">เคลื่อนที่<br><span style="font-size: 15px;">(Mobile)</span></span>
                                            </td>
                                            <td style="padding: 0; vertical-align: top; white-space: nowrap;">
                                                <input type="checkbox" ${isMultisiteChecked} style="vertical-align: middle; margin-right: 5px;">
                                                <span style="line-height: 1.2;font-size:20px">หลายสาขา<br><span style="font-size: 15px;">(Multisite)</span></span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table class="detail-table" style="width: 100%; margin-bottom: 1em; line-height: 1.1;">
                    <thead>
                        <tr>
                            <th style="width: 30%; text-align: center;">สาขาการทดสอบ<br><span style="font-size: 15px;">(Field of Testing)</span></th>
                            <th style="width: 35%; text-align: center;">รายการทดสอบ<br><span style="font-size: 15px;">(Parameter)</span></th>
                            <th style="width: 35%; text-align: center;">วิธีทดสอบ<br><span style="font-size: 15px;">(Test Method)</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        ${testTableRows}
                    </tbody>
                </table>
                <p><br></p>
            `;

            insertTemplateAtCurrentOrLastPage(templateHTML);
        };

        const updateMenubarState = () => {
             const commands = ['bold', 'italic', 'superscript', 'subscript', 'justifyLeft', 'justifyCenter', 'justifyRight'];
             commands.forEach(command => {
                 const button = menubar.querySelector(`[data-command="${command}"]`);
                 if (button) {
                     if (document.queryCommandState(command)) {
                        button.classList.add('active');
                     } else {
                        button.classList.remove('active');
                     }
                 }
             });

             const selection = window.getSelection();
             if (selection.rangeCount > 0 && selection.anchorNode) {
                let element = selection.anchorNode;
                if (element.nodeType !== Node.ELEMENT_NODE) {
                    element = element.parentNode;
                }
                if (element && element.closest('.page')) {
                    const size = window.getComputedStyle(element).getPropertyValue('font-size');
                    const sizeInPx = Math.round(parseFloat(size));
                    
                    const optionExists = [...fontSizeSelector.options].some(option => option.value == sizeInPx);
                    fontSizeSelector.value = optionExists ? sizeInPx : '';
                }
             }
        };
        
        const managePages = () => {
            const pages = Array.from(editor.querySelectorAll('.page'));
            const selection = window.getSelection();
            let originalStartContainer = selection.rangeCount > 0 ? selection.getRangeAt(0).startContainer : null;
            let originalStartOffset = selection.rangeCount > 0 ? selection.getRangeAt(0).startOffset : 0;
            let cursorRelocated = false;

            pages.forEach((page) => {
                while (isOverflowing(page)) {
                    let nextPage = page.nextElementSibling;
                    if (!nextPage || !nextPage.classList.contains('page')) {
                        nextPage = createNewPage();
                        editor.insertBefore(nextPage, page.nextElementSibling);
                    }
                    
                    while (isOverflowing(page) && page.lastChild) {
                        const nodeToMove = page.lastChild;
                        if (originalStartContainer && nodeToMove.contains(originalStartContainer)) {
                            cursorRelocated = true;
                        }
                        nextPage.insertBefore(nodeToMove, nextPage.firstChild);
                    }
                }
            });

            let currentPages = Array.from(editor.querySelectorAll('.page'));
            if (currentPages.length > 1) {
                for (let i = currentPages.length - 1; i >= 0; i--) {
                    const page = currentPages[i];
                    const isEmpty = !page.textContent.trim() && (!page.firstElementChild || page.firstElementChild.tagName === 'BR');
                    if (isEmpty && currentPages.length > 1) {
                        if (originalStartContainer && page.contains(originalStartContainer)) {
                            const prevPage = page.previousElementSibling;
                            if (prevPage && prevPage.classList.contains('page')) {
                                moveCursorToEnd(prevPage);
                                cursorRelocated = true;
                            }
                        }
                        page.remove();
                    }
                }
            }

            currentPages = Array.from(editor.querySelectorAll('.page'));
            currentPages.forEach((page, index) => {
                const nextPage = currentPages[index + 1];
                if (nextPage) {
                    while (nextPage.firstChild && !isOverflowing(page)) {
                        const nodeToMove = nextPage.firstChild;
                        page.appendChild(nodeToMove);
                        if (isOverflowing(page)) {
                            nextPage.insertBefore(nodeToMove, nextPage.firstChild);
                            break;
                        }
                    }
                }
            });

            if (cursorRelocated) {
                const lastPage = editor.querySelector('.page:last-of-type');
                if (lastPage) {
                    moveCursorToEnd(lastPage);
                }
            } else if (originalStartContainer && originalStartContainer.isConnected) {
                try {
                    const range = document.createRange();
                    range.setStart(originalStartContainer, originalStartOffset);
                    range.collapse(true);
                    selection.removeAllRanges();
                    selection.addRange(range);
                } catch (e) {
                    console.warn("Failed to restore original cursor position:", e);
                    const lastPage = editor.querySelector('.page:last-of-type');
                    if (lastPage) {
                        moveCursorToEnd(lastPage);
                    }
                }
            } else {
                const lastPage = editor.querySelector('.page:last-of-type');
                if (lastPage) {
                    moveCursorToEnd(lastPage);
                }
            }
        };

        const moveCursorToEnd = (element) => {
            element.focus();
            const range = document.createRange();
            const selection = window.getSelection();
            range.selectNodeContents(element);
            range.collapse(false);
            selection.removeAllRanges();
            selection.addRange(range);
        };
        
        const isOverflowing = (element) => element.scrollHeight > element.clientHeight + 1;

        const createNewPage = () => {
            const newPage = document.createElement('div');
            newPage.className = 'page';
            newPage.setAttribute('contenteditable', 'true');
            return newPage;
        };

        imageInput.addEventListener('change', (event) => {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    insertImageAtCursor(e.target.result);
                };
                reader.readAsDataURL(file);
            }
            imageInput.value = '';
        });

        function insertImageAtCursor(src) {
            if (savedRange) {
                const selection = window.getSelection();
                selection.removeAllRanges();
                selection.addRange(savedRange);
            } else {
                (editor.querySelector('.page:focus') || editor.querySelector('.page'))?.focus();
            }

            const uniqueId = 'img-temp-' + Date.now();
            const handlesHTML = ['top-left', 'top-right', 'bottom-left', 'bottom-right']
                .map(pos => `<div class="resize-handle ${pos}"></div>`).join('');

            const imageHTML = `
                <span class="image-container" id="${uniqueId}" style="width: 200px;">
                    <img src="${src}" style="width: 100%; height: auto; display: block;" />
                    ${handlesHTML}
                </span>`;
            
            document.execCommand('insertHTML', false, imageHTML);
            
            const newImageContainer = document.getElementById(uniqueId);
            if (newImageContainer) {
                newImageContainer.removeAttribute('id');
                makeResizable(newImageContainer);
            }
            savedRange = null;
        }
        
        function makeResizable(element) {
            let activeHandle = null;
            let startX, startY, startWidth;

            function onMouseDown(e) {
                e.preventDefault();
                e.stopPropagation();

                document.querySelectorAll('.image-container.active').forEach(el => el.classList.remove('active'));
                element.classList.add('active');

                if (e.target.classList.contains('resize-handle')) {
                    activeHandle = e.target;
                } else {
                    activeHandle = null;
                    return;
                }
                
                startX = e.clientX;
                startY = e.clientY;
                startWidth = element.offsetWidth;

                document.addEventListener('mousemove', onMouseMove);
                document.addEventListener('mouseup', onMouseUp);
            }

            function onMouseMove(e) {
                if (!activeHandle) return;

                const dx = e.clientX - startX;
                
                if (activeHandle.classList.contains('bottom-right') || activeHandle.classList.contains('top-right')) {
                    element.style.width = `${Math.max(20, startWidth + dx)}px`;
                } else if (activeHandle.classList.contains('bottom-left') || activeHandle.classList.contains('top-left')) {
                    element.style.width = `${Math.max(20, startWidth - dx)}px`;
                }
                element.style.height = 'auto';
            }

            function onMouseUp() {
                document.removeEventListener('mousemove', onMouseMove);
                document.removeEventListener('mouseup', onMouseUp);
                activeHandle = null;
            }

            element.addEventListener('mousedown', onMouseDown);
        }
        
        // --- Table & Context Menu Functions ---

        // === START: MODIFICATION ===
        function insertTableRow(table, rowIndex, above, removeConnectingBorder) {
            const insertAt = above ? rowIndex : rowIndex + 1;
            const newRow = table.insertRow(insertAt);

            // Determine the correct number of columns to create
            let colCount = 0;
            const thead = table.querySelector('thead');
            if (thead && thead.rows.length > 0 && thead.rows[0].cells.length > 0) {
                colCount = thead.rows[0].cells.length;
            } else if (table.rows.length > 1) {
                // Find a row with the most cells to account for colspans
                for(let i = 0; i < table.rows.length; i++) {
                    let currentCellCount = 0;
                    for(let j = 0; j < table.rows[i].cells.length; j++) {
                        currentCellCount += table.rows[i].cells[j].colSpan;
                    }
                    if(currentCellCount > colCount) {
                        colCount = currentCellCount;
                    }
                }
            } else {
                colCount = table.rows[rowIndex].cells.length;
            }


            // Create cells for the new row
            for (let i = 0; i < colCount; i++) {
                const cell = newRow.insertCell();
                cell.style.verticalAlign = 'top';
                cell.style.textAlign = 'left';
                cell.innerHTML = '<br>';
            }

            // --- Conditional Border Logic ---
            if (removeConnectingBorder) {
                if (!above) { // Inserting BELOW
                    const rowAbove = table.rows[rowIndex];
                    for (const cell of newRow.cells) {
                        cell.style.borderTop = 'none';
                    }
                    if (rowAbove) {
                        for (const cell of rowAbove.cells) {
                            cell.style.borderBottom = 'none';
                        }
                    }
                } else { // Inserting ABOVE
                    const rowBelow = table.rows[insertAt];
                    for (const cell of newRow.cells) {
                        cell.style.borderBottom = 'none';
                    }
                    if (rowBelow) {
                        for (const cell of rowBelow.cells) {
                            cell.style.borderTop = 'none';
                        }
                    }
                }
            }
            // If removeConnectingBorder is false, do nothing to the borders.

            managePages();
        }
        // === END: MODIFICATION ===

        function insertTableColumn(table, colIndex, right = true) {
            const rows = table.rows;
            for (let i = 0; i < rows.length; i++) {
                const cell = rows[i].insertCell(right ? colIndex + 1 : colIndex);
                cell.style.verticalAlign = 'top';
                cell.style.textAlign = 'left';
                cell.innerHTML = '<br>';
            }
            managePages();
        }

        function deleteTableRow(table, rowIndex) {
            if (table.rows.length > 1) {
                table.deleteRow(rowIndex);
                managePages();
            }
        }

        function deleteTableColumn(table, colIndex) {
            if (table.rows[0].cells.length > 1) {
                for (let i = 0; i < table.rows.length; i++) {
                    table.rows[i].deleteCell(colIndex);
                }
                managePages();
            }
        }
        
        function getSelectedTableCells() {
            const selection = window.getSelection();
            if (!selection.rangeCount || selection.isCollapsed) return [];

            const range = selection.getRangeAt(0);
            let startCell = range.startContainer.closest('td, th');
            let endCell = range.endContainer.closest('td, th');

            if (!startCell || !endCell || startCell.closest('table') !== endCell.closest('table')) {
                return [];
            }
            
            if (startCell.compareDocumentPosition(endCell) & Node.DOCUMENT_POSITION_FOLLOWING) {
                // Correct order
            } else {
                [startCell, endCell] = [endCell, startCell]; // Swap
            }

            const row = startCell.closest('tr');
            if (!row || endCell.closest('tr') !== row) {
                return [];
            }

            const cellsInRow = Array.from(row.cells);
            const startIndex = cellsInRow.indexOf(startCell);
            const endIndex = cellsInRow.indexOf(endCell);

            if (startIndex === -1 || endIndex === -1) return [];

            return cellsInRow.slice(startIndex, endIndex + 1);
        }

        function mergeTableColumns(cellsToMerge) {
            if (cellsToMerge.length <= 1) return;

            const firstCell = cellsToMerge[0];
            const parentRow = firstCell.closest('tr');
            if (!parentRow) return;

            let totalColspan = 0;
            let combinedContent = '';

            cellsToMerge.forEach(cell => {
                const cellContent = cell.innerHTML.trim();
                if (cellContent !== '<br>' && cellContent !== '') {
                    if (combinedContent !== '') combinedContent += ' ';
                    combinedContent += cellContent;
                }
                totalColspan += cell.colSpan || 1;
            });

            firstCell.colSpan = totalColspan;
            firstCell.innerHTML = combinedContent || '<br>';

            for (let i = 1; i < cellsToMerge.length; i++) {
                parentRow.removeChild(cellsToMerge[i]);
            }
            
            const activePage = firstCell.closest('.page');
            activePage?.focus();
            managePages();
        }


        function showContextMenu(event, cell) {
            event.preventDefault();
            contextMenuTarget = cell;
            contextMenuTargetRow = cell.closest('tr'); // Store the target row immediately
            
            const addItemMenu = contextMenu.querySelector('[data-action="add-item"]');
            const addItemSeparator = contextMenu.querySelector('[data-action="separator-add"]');
            const mergeMenuItem = contextMenu.querySelector('[data-action="merge-columns"]');
            const mergeSeparator = contextMenu.querySelector('[data-action="separator-merge"]');

            const table = cell.closest('table');
            const isInTbody = cell.closest('tbody');

            // Show "Add Item" only for tables with 'detail-table' class and inside tbody
            if (table && table.classList.contains('detail-table') && isInTbody) {
                addItemMenu.style.display = 'block';
                addItemSeparator.style.display = 'block';
            } else {
                addItemMenu.style.display = 'none';
                addItemSeparator.style.display = 'none';
            }

            const selectedCells = getSelectedTableCells();
            if (selectedCells.length > 1) {
                selectedTableCellsForMerge = selectedCells;
                mergeMenuItem.style.display = 'block';
                mergeSeparator.style.display = 'block';
            } else {
                mergeMenuItem.style.display = 'none';
                mergeSeparator.style.display = 'none';
            }

            contextMenu.style.display = 'block';
            contextMenu.style.left = `${event.pageX}px`;
            contextMenu.style.top = `${event.pageY}px`;
        }

        function hideContextMenu() {
            contextMenu.style.display = 'none';
            contextMenuTarget = null;
            contextMenuTargetRow = null; // Reset the target row
            selectedTableCellsForMerge = [];
        }

        editor.addEventListener('contextmenu', (event) => {
            const cell = event.target.closest('td, th');
            if (cell) {
                showContextMenu(event, cell);
            } else {
                hideContextMenu();
            }
        });

        // --- FIXED: Context Menu Click Logic ---
        // === START: MODIFICATION ===
        contextMenu.addEventListener('click', (event) => {
            const actionTarget = event.target.closest('.context-menu-item');
            if (!actionTarget) return;
            const action = actionTarget.dataset.action;
            if (!action) return;

            const table = contextMenuTarget?.closest('table');

            // Special handling for actions that open modals
            if (action === 'add-item') {
                activeModalTargetRow = contextMenuTargetRow; // Persist the row for the modal
                contextMenu.style.display = 'none'; // Hide menu visually, but keep state
                switch (templateType) {
                    case 'cb':      cbItemModal.style.display = 'flex'; break;
                    case 'ib':      ibItemModal.style.display = 'flex'; break;
                    case 'lab_cal': 
                        const labCalField = $('#lab-cal-field');
                        const instrumentSelect = $('#lab-cal-instrument');
                       
                        const parameterOneSelect = $('#lab-cal-parameter-one');
                        const parameterTwoSelect = $('#lab-cal-parameter-two');
                        labCalField.empty().append('<option value="" disabled selected>- สาขาสอบเทียบ -</option>');
                        instrumentSelect.empty();
                        
                        parameterOneSelect.empty(); // ล้างค่าเก่า
                        parameterTwoSelect.empty(); // ล้างค่าเก่า
                    
                        $.ajax({
                                url: "{!! url('/certify/applicant/api/calibrate') !!}", // As requested
                                method: "POST",
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                },
                                success: function(response) {
                          
                                    if (Array.isArray(response)) {
                                        $.each(response, function (index, value) {
                                            labCalField.append(`<option value="${value.id}" data-en="${value.title_en}">${value.title}</option>`);
                                        });
                                    }
                                    labCalItemModal.style.display = 'flex';
                                }
                            });
                            labCalItemModal.style.display = 'flex'; 
                    
                    break;
                    case 'lab_test':
                        const labTestField = $('#lab-test-field');
                        const categorySelect = $('#lab-test-category'); 
                        const parameterSelect = $('#lab-test-parameter'); 

                        labTestField.empty().append('<option value="" disabled selected>- สาขาการทดสอบ -</option>'); // เปลี่ยนข้อความให้ตรงกับ field
                        categorySelect.empty().append('<option value="" disabled selected>- หมวดหมู่การทดสอบ -</option>'); // เพิ่ม option สำหรับ category
                        parameterSelect.empty().append('<option value="" disabled selected>- พารามิเตอร์การทดสอบ -</option>'); // เพิ่ม option สำหรับ parameter

                       $.ajax({
                            url: "{!! url('/certify/applicant/api/test') !!}", // As requested
                            method: "POST",
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            success: function(response) {
                                console.log(response);
                                // ไม่ต้องมี return; ตรงนี้ เพราะจะทำให้โค้ดที่เหลือไม่ทำงาน
                               
                                if (Array.isArray(response)) {
                                    $.each(response, function (index, value) {
                                        labTestField.append(`<option value="${value.id}" data-en="${value.title_en}">${value.title}</option>`);
                                    });
                                }
                            }
                        });

                        labTestItemModal.style.display = 'flex'; 
                        break;


                    default:
                        alert('ไม่พบ Template ที่ใช้งานอยู่เพื่อเพิ่มรายการ');
                        hideContextMenu(); // Reset state fully if no template
                        activeModalTargetRow = null; // Clear persisted row if no modal shown
                }
                return; // Exit to prevent hideContextMenu() below
            }

            // Handle merge action
            if (action === 'merge-columns') {
                if (selectedTableCellsForMerge.length > 1) {
                    mergeTableColumns(selectedTableCellsForMerge);
                }
                hideContextMenu(); // Reset state fully
                return;
            }

            // For direct table manipulation actions
            if (!contextMenuTarget || !table) {
                hideContextMenu();
                return;
            }

            const row = contextMenuTargetRow;
            const rowIndex = row ? Array.from(table.rows).indexOf(row) : -1;
            const colIndex = row ? Array.from(row.cells).indexOf(contextMenuTarget) : -1;

            if (rowIndex === -1 || colIndex === -1) {
                hideContextMenu();
                return;
            }

            switch (action) {
                case 'insert-row-above':
                    insertTableRow(table, rowIndex, true, false); // above, with border
                    break;
                case 'insert-row-above-no-border':
                    insertTableRow(table, rowIndex, true, true); // above, no border
                    break;
                case 'insert-row-below':
                    insertTableRow(table, rowIndex, false, false); // below, with border
                    break;
                case 'insert-row-below-no-border':
                    insertTableRow(table, rowIndex, false, true); // below, no border
                    break;
                case 'insert-column-left':
                    insertTableColumn(table, colIndex, false);
                    break;
                case 'insert-column-right':
                    insertTableColumn(table, colIndex, true);
                    break;
                case 'delete-row':
                    deleteTableRow(table, rowIndex);
                    break;
                case 'delete-column':
                    deleteTableColumn(table, colIndex);
                    break;
            }

            hideContextMenu(); // Reset state fully after action
            const activePage = table?.closest('.page');
            activePage?.focus();
        });
        // === END: MODIFICATION ===


        $('#lab-cal-field').on('change', function() {
            const fieldId = $(this).val();
            if (fieldId) {

                const instrumentSelect = $('#lab-cal-instrument');
                instrumentSelect.empty();
                instrumentSelect.append(`<option value="">==เลือกรายการ==</option>`);

                $.ajax({
                    url:  "{!! url('/certify/applicant/api/instrumentgroup') !!}" ,
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    data: { bcertify_calibration_branche_id: fieldId},
                    success: function(response) {

                        console.log(response)
                        
                        if (Array.isArray(response)) {
                            $.each(response, function(index, value) {
                                instrumentSelect.append(`<option value="${value.id}">${value.name}</option>`);
                            });
                        }
                    }
                });
            }
        });

        $('#lab-cal-instrument').on('change', function() {
            const fieldId = $(this).val();
            if (fieldId) {
                const parameterOneSelect = $('#lab-cal-parameter-one');
                const parameterTwoSelect = $('#lab-cal-parameter-two');
                const instrumentSelect2 = $('#lab-cal-instrument2');
                parameterOneSelect.empty(); // ล้างค่าเก่า
                parameterTwoSelect.empty(); // ล้างค่าเก่า
                instrumentSelect2.empty();
                

                $.ajax({
                    url: "{!! url('/certify/applicant/api/instrument') !!}",
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    data: { calibration_branch_instrument_group_id: fieldId },
                    success: function(response) {
                        // console.log(response)

                        if (Array.isArray(response.instrument) && response.instrument.length > 0) {
                            instrumentSelect2.append(`<option value="">==เลือกรายการ==</option>`);
                            // วนลูปเพื่อสร้าง <option>
                            $.each(response.instrument, function(index, value) {
                                instrumentSelect2.append(`<option value="${value.id}">${value.name}</option>`);
                            });
                        }
                       
                        
                        if (Array.isArray(response.parameter_one) && response.parameter_one.length > 0) {
                            parameterOneSelect.append(`<option value="">==เลือกรายการ==</option>`);
                            // วนลูปเพื่อสร้าง <option>
                            $.each(response.parameter_one, function(index, value) {
                                parameterOneSelect.append(`<option value="${value.id}">${value.name}</option>`);
                            });
                        }

                        // ตรวจสอบว่า parameter_two เป็น array และมีข้อมูล
                        if (Array.isArray(response.parameter_two) && response.parameter_two.length > 0) {
                            parameterTwoSelect.append(`<option value="">==เลือกรายการ==</option>`);
                            // วนลูปเพื่อสร้าง <option>
                            $.each(response.parameter_two, function(index, value) {
                                parameterTwoSelect.append(`<option value="${value.id}">${value.name}</option>`);
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        // ควรมีการจัดการ error ด้วย
                        console.error("เกิดข้อผิดพลาดในการดึงข้อมูล:", error);
                        alert("ไม่สามารถโหลดข้อมูลพารามิเตอร์ได้");
                    }
                });
            } else {
                // กรณีที่ผู้ใช้เลือก "เลือกเครื่องมือ" ให้ล้างค่า parameter ด้วย
                $('#lab-cal-parameter-one').empty().append(`<option value="">==เลือกพารามิเตอร์==</option>`);
            }
        });

        $('#lab-test-field').on('change', function() {
            const fieldId = $(this).val();
            if (fieldId) {
                const categorySelect = $('#lab-test-category'); // เลือก select box ของหมวดหมู่
                categorySelect.empty(); // ล้างข้อมูลเดิม
                categorySelect.append(`<option value="">==เลือกรายการ==</option>`); // เพิ่ม option เริ่มต้น
                $.ajax({
                    // url: "/certify/applicant/api/test_category", 
                    url: "{!! url('/certify/applicant/api/test_category') !!}",
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    data: { 
                        bcertify_test_branche_id: fieldId 
                    },
                    success: function(response) {
                        console.log(response); // ตรวจสอบข้อมูลที่ได้จาก API
                       

                        if (Array.isArray(response)) {
                            $.each(response, function(index, value) {
                                // สมมติว่า response มี id และ name หรือ title สำหรับหมวดหมู่
                                categorySelect.append(`<option value="${value.id}">${value.name || value.title}</option>`); 
                            });
                        }
                    }
                });
            }
        });

        // เพิ่มโค้ดสำหรับการเปลี่ยนแปลงใน dropdown 'category'
        $('#lab-test-category').on('change', function() {
            const test_branch_category_id = $(this).val();
            const parameterSelect = $('#lab-test-parameter');

            // ล้างข้อมูลเดิมและเพิ่ม option เริ่มต้นสำหรับ Parameter
            parameterSelect.empty().append(`<option value="">==เลือกรายการ==</option>`);

            if (test_branch_category_id) {
                $.ajax({
                    // url: "/certify/applicant/api/test_parameter",
                    url: "{!! url('/certify/applicant/api/test_parameter') !!}",
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // ใช้ X-CSRF-TOKEN แทน _token ใน data
                    },
                    data: {
                        test_branch_category_id: test_branch_category_id
                    },
                    success: function(response) {
                        console.log("Parameters:", response); // ตรวจสอบข้อมูล Parameters
                        if (Array.isArray(response)) {
                            $.each(response, function(index, value) {
                                // สมมติว่า response มี id และ name หรือ title สำหรับ parameter
                                parameterSelect.append(`<option value="${value.id}">${value.name || value.title}</option>`);
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Error fetching parameters:", error);
                    }
                });
            }
        });

        document.addEventListener('click', (event) => {
            // Hide context menu if the click is outside of it AND not inside a modal overlay
            if (!contextMenu.contains(event.target) && !event.target.closest('.modal-overlay')) {
                hideContextMenu();
            }
        });

        editor.addEventListener('input', () => {
             setTimeout(() => { managePages(); updateMenubarState(); }, 10);
        });
        editor.addEventListener('keyup', updateMenubarState);
        editor.addEventListener('mouseup', updateMenubarState);
        document.addEventListener('selectionchange', updateMenubarState);
        editor.addEventListener('keydown', (event) => {
            const selection = window.getSelection();
            if (!selection.rangeCount) return;
            const range = selection.getRangeAt(0);
            if (selection.isCollapsed && range.startOffset === 0) {
                let currentPage = range.startContainer;
                while (currentPage && !currentPage.classList?.contains('page')) currentPage = currentPage.parentElement;
                if (currentPage?.classList.contains('page')) {
                    const prevPage = currentPage.previousElementSibling;
                    if (event.key === 'Backspace' && prevPage) {
                        event.preventDefault();
                        while (currentPage.firstChild) prevPage.appendChild(currentPage.firstChild);
                        moveCursorToEnd(prevPage);
                        setTimeout(managePages, 10);
                    }
                }
            }
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Delete') {
                const activeImage = document.querySelector('.image-container.active');
                if (activeImage) {
                    event.preventDefault();
                    activeImage.remove();
                    const lastActivePage = editor.querySelector('.page:focus') || editor.querySelector('.page');
                    lastActivePage?.focus();
                    setTimeout(managePages, 10);
                }
            }
        });
        
        // === START: NEW KEYBOARD SHORTCUTS FOR TABLE ROWS ===
        document.addEventListener('keydown', (event) => {
            // Check for Shift key and F1, F2, F4, F5 keys
            if (event.shiftKey && ['F1', 'F2', 'F4', 'F5'].includes(event.key)) {
                const selection = window.getSelection();
                if (!selection.rangeCount) return;

                const range = selection.getRangeAt(0);
                const currentElement = range.startContainer;
                // Find the closest cell (td or th) from the current cursor position
                const cell = currentElement.nodeType === Node.ELEMENT_NODE 
                             ? currentElement.closest('td, th') 
                             : currentElement.parentElement.closest('td, th');

                if (cell) {
                    event.preventDefault(); // Prevent default browser actions (like opening help)

                    const table = cell.closest('table');
                    const row = cell.closest('tr');
                    const rowIndex = Array.from(table.rows).indexOf(row);

                    if (rowIndex === -1) return;

                    switch (event.key) {
                        case 'F1': // Shift+F1: Insert row above
                            insertTableRow(table, rowIndex, true, false);
                            break;
                        case 'F2': // Shift+F2: Insert row above (no border)
                            insertTableRow(table, rowIndex, true, true);
                            break;
                        case 'F4': // Shift+F4: Insert row below
                            insertTableRow(table, rowIndex, false, false);
                            break;
                        case 'F5': // Shift+F5: Insert row below (no border)
                            insertTableRow(table, rowIndex, false, true);
                            break;
                    }
                     const activePage = table?.closest('.page');
                     activePage?.focus();
                }
            }
        });
        // === END: NEW KEYBOARD SHORTCUTS FOR TABLE ROWS ===


        document.addEventListener('mousedown', (event) => {
            if (!event.target.closest('.image-container')) {
                document.querySelectorAll('.image-container.active').forEach(el => {
                    el.classList.remove('active');
                });
            }
        });

        insertTableBtn.addEventListener('click', () => {
            const rows = parseInt(tableRowsInput.value, 10);
            const cols = parseInt(tableColsInput.value, 10);
            const hasBorders = tableBorderToggle.checked;
            
            tableModalOverlay.style.display = 'none';

            if (isNaN(rows) || isNaN(cols) || rows <= 0 || cols <= 0) return;

            if (savedRange) {
                const selection = window.getSelection();
                selection.removeAllRanges();
                selection.addRange(savedRange);
            } else {
                (editor.querySelector('.page:focus') || editor.querySelector('.page'))?.focus();
            }

            const tableClass = hasBorders ? '' : 'class="borderless"';
            let tableHTML = `<table ${tableClass} style="width: 100%; margin-bottom: 1em;"><tbody>`;
            for (let i = 0; i < rows; i++) {
                tableHTML += '<tr>';
                for (let j = 0; j < cols; j++) {
                    tableHTML += '<td style="vertical-align: top; "><br></td>';
                }
                tableHTML += '</tr>';
            }
            tableHTML += '</tbody></table><p><br></p>';
            document.execCommand('insertHTML', false, tableHTML);
            
            savedRange = null;
            tableBorderToggle.checked = true;
        });

        // --- FIXED: Modal Cancel/Close Logic ---
        function closeModal(modal) {
            modal.style.display = 'none';
            // Clear inputs
            modal.querySelectorAll('input[type="text"], input[type="number"]').forEach(input => input.value = '');
            // MODIFIED: Also clear contenteditable divs
            modal.querySelectorAll('.editable-div').forEach(div => div.innerHTML = '');
            // Also reset the context menu state since the modal action is complete.
            hideContextMenu();
            activeModalTargetRow = null; // **NEW**: Clear the persisted row
        }

        document.querySelectorAll('.modal-overlay').forEach(modal => {
            modal.addEventListener('click', (event) => {
                if (event.target === modal) {
                    closeModal(modal);
                }
            });
            modal.querySelector('.modal-btn-cancel')?.addEventListener('click', () => {
                closeModal(modal);
            });
        });
        
        // --- [แก้ไข] Helper function to append text to a cell ---
        function appendToCell(cell, text) {
            // Do nothing if text is null, undefined, or empty
            if (!text) {
                return;
            }

            // Check if the cell has any visible content using textContent.
            // This is more reliable than manipulating innerHTML with regex.
            const hasContent = cell.textContent.trim() !== '';

            if (hasContent) {
                // If there's existing content, add a line break before the new text.
                cell.innerHTML += '<br>' + text;
            } else {
                // If the cell is empty, just set the new text, replacing any placeholder <br>.
                cell.innerHTML = text;
            }
        }


        // --- Add Item Button Logic for each Modal (Using activeModalTargetRow) ---
        
        // === START: REVISED CB Item Button Logic ===
        document.getElementById('add-cb-item-btn').addEventListener('click', () => {
            const targetRow = activeModalTargetRow;
            if (!targetRow) {
                alert("ไม่สามารถหาแถวเป้าหมายได้");
                closeModal(cbItemModal);
                return;
            }

            const cells = targetRow.cells;
            if (cells.length < 2) {
                alert("โครงสร้างตารางไม่ถูกต้อง (ต้องการอย่างน้อย 2 คอลัมน์)");
                closeModal(cbItemModal);
                return;
            }

            // Get values from editable divs using LineExtractor
            const codeLines = cbCodeEditorExtractor.getLines();
            const code = codeLines.join('<br>');

            const descriptionLines = cbDescriptionEditorExtractor.getLines();
            const description = descriptionLines.join('<br>');

            // Append to the first cell
            appendToCell(cells[0], code);

            // Append to the second cell
            appendToCell(cells[1], description);

            managePages();
            closeModal(cbItemModal);
        });
        // === END: REVISED CB Item Button Logic ===


        // === START: REVISED IB Item Button Logic ===
        document.getElementById('add-ib-item-btn').addEventListener('click', () => {
            const targetRow = activeModalTargetRow;
            if (!targetRow) {
                alert("ไม่สามารถหาแถวเป้าหมายได้");
                closeModal(ibItemModal);
                return;
            }

            const cells = targetRow.cells;
            if (cells.length < 3) {
                alert("โครงสร้างตารางไม่ถูกต้อง (ต้องการ 3 คอลัมน์)");
                closeModal(ibItemModal);
                return;
            }

            // Get values from modal
            const mainBranch = document.getElementById('ib-main-branch').value.trim();

            const subBranchLines = ibSubBranchExtractor.getLines();
            const subBranch = subBranchLines.map(line => line ? '&nbsp;&nbsp;&nbsp;' + line : '').join('<br>');

            const mainScopeLines = ibMainScopeExtractor.getLines();
            const mainScope = mainScopeLines.map(line => line ? '&nbsp;&nbsp;&nbsp;' + line : '').join('<br>');

            const subScopeLines = ibSubScopeExtractor.getLines();
            const subScope = subScopeLines.map(line => line ? '&nbsp;&nbsp;&nbsp;' + line : '').join('<br>');

            const requirementsLines = ibRequirementsExtractor.getLines();
            const requirements = requirementsLines.join('<br>');

            // --- Cell 1: Main/Sub Branch ---
            const cell1Parts = [];
            if (mainBranch) cell1Parts.push(mainBranch);
            if (subBranch) cell1Parts.push(subBranch);
            const cell1Content = cell1Parts.join('<br>');
            appendToCell(cells[0], cell1Content);

            // --- Cell 2: Main/Sub Scope ---
            const cell2Parts = [];
            if (mainScope) cell2Parts.push(mainScope);
            if (subScope) cell2Parts.push(subScope);
            const cell2Content = cell2Parts.join('<br>');
            appendToCell(cells[1], cell2Content);

            // --- Cell 3: Requirements ---
            if (requirements) {
                appendToCell(cells[2], requirements);
            }

            managePages();
            closeModal(ibItemModal);
        });
        // === END: REVISED IB Item Button Logic ===

        // --- [MODIFIED] Logic for adding Lab Cal item ---
        document.getElementById('add-lab-cal-item-btn').addEventListener('click', () => {
            const targetRow = activeModalTargetRow;
            if (!targetRow) {
                alert("ไม่สามารถหาแถวเป้าหมายได้");
                closeModal(labCalItemModal);
                return;
            }

            const cells = targetRow.cells;
            if (cells.length < 4) {
                 alert("โครงสร้างตารางไม่ถูกต้อง");
                 closeModal(labCalItemModal);
                 return;
            }


            const fieldValue = $('#lab-cal-field').val();
            const fieldValueEn = $('#lab-cal-field option:selected').data('en');
            const instrumentValue = $('#lab-cal-instrument').val();
            const instrumentValueTwo = $('#lab-cal-instrument2').val();
            const parameterOneValue = $('#lab-cal-parameter-one').val();
            const parameterTwoValue = $('#lab-cal-parameter-two').val();
            // Get values from modal and trim them
            // const field = document.getElementById('lab-cal-field').value.trim();
            const field = $('#lab-cal-field option:selected').text();
            const instrument = $('#lab-cal-instrument option:selected').text();
            const instrumentTwo = $('#lab-cal-instrument2 option:selected').text();
            // const instrument = document.getElementById('lab-cal-instrument').value.trim();
            const parameterOne = $('#lab-cal-parameter-one option:selected').text();
            const parameterTwo = $('#lab-cal-parameter-two option:selected').text();
            // const parameter = document.getElementById('lab-cal-parameter-one').value.trim();
            const condition = document.getElementById('lab-cal-condition').value.trim();
            
            // Get values from editable divs using LineExtractor
            const paramDetailsLines = labCalParamDetailsEditorExtractor.getLines();
            const paramDetails = paramDetailsLines.map(line => line ? '&nbsp;&nbsp;&nbsp;' + line : '').join('<br>');

            const capabilityLines = labCalCapabilityEditorExtractor.getLines();
            // const capability = capabilityLines.map(line => line ? '&nbsp;&nbsp;&nbsp;' + line : '').join('<br>');

            const capability = capabilityLines.map(line => line ? '<div style="text-align: center;">' + line + '</div>' : '').join('');
            
            const methodLines = labCalMethodEditorExtractor.getLines();
            const method = methodLines.join('<br>');
            

            if (field && cells[0].textContent.trim()) {
                // ตรวจสอบโดย trim ทั้งสองค่าก่อนเปรียบเทียบ
                if (!cells[0].textContent.trim().startsWith(field.trim())) {
                    alert("ให้เพิ่มแถวใหม่สำหรับสาขาใหม่");
                    return;
                }
            }
      
            // --- Field (cells[0]) Logic ---
            if (field && !cells[0].textContent.trim()) {
                cells[0].innerHTML = field + "<br>(" + fieldValueEn + ")";
            }

            // console.log(field,cells[0].textContent.trim());

            // --- Parameter Column (cells[1]) Logic ---
            const parameterParts = [];

            if (instrument && instrument != "==เลือกรายการ==") {
                parameterParts.push(instrument);
            }
            if (instrumentTwo && instrumentTwo != "==เลือกรายการ==") {
                parameterParts.push(instrumentTwo);
            }

            if (parameterOne && parameterOne != "==เลือกรายการ==") {
                parameterParts.push('&nbsp;' + parameterOne);
            }
            if (parameterTwo && parameterTwo != "==เลือกรายการ==") {
                parameterParts.push('&nbsp;' + parameterTwo);
            }
            if (condition) {
                parameterParts.push('&nbsp;&nbsp;' + condition);
            }
            if (paramDetails) {
                parameterParts.push(paramDetails);
            }
            const parameterColumnContent = parameterParts.join('<br>');
            appendToCell(cells[1], parameterColumnContent);

            // --- Capability (cells[2]) Logic ---
            if (capability) {
                appendToCell(cells[2], capability);
            }

            // --- Method (cells[3]) Logic ---
            if (method) {
                appendToCell(cells[3], method);
            }

            const newItem = {
                field: fieldValue,
                instrument: instrumentValue,
                parameterOne: parameterOneValue,
                parameterTwo: parameterTwoValue,
            };

            // 2. เพิ่ม object ใหม่เข้าไปใน array `labCalItems`
            labCalItems.push(newItem);

            console.log(labCalItems)
            
            managePages();
            closeModal(labCalItemModal);
        });

        // === START: MODIFICATION FOR LAB TEST LOGIC ===
        document.getElementById('add-lab-test-item-btn').addEventListener('click', () => {
            const targetRow = activeModalTargetRow;
            if (!targetRow) {
                alert("ไม่สามารถหาแถวเป้าหมายได้");
                closeModal(labTestItemModal);
                return;
            }

            const cells = targetRow.cells;
            if (cells.length < 3) {
                alert("โครงสร้างตารางไม่ถูกต้อง (ต้องการ 3 คอลัมน์)");
                closeModal(labTestItemModal);
                return;
            }

            const fieldValue = $('#lab-test-field').val();
            const fieldValueEn = $('#lab-test-field option:selected').data('en');
            const categoryValue = $('#lab-test-category').val();
            const parameterValue = $('#lab-test-parameter').val();

            // Get text of selected options
            const field = $('#lab-test-field option:selected').text();
            const category = $('#lab-test-category option:selected').text();
            const parameter = $('#lab-test-parameter option:selected').text();


            const description = document.getElementById('lab-test-description-editor').value.trim();

            const paramDetailsLines = labTestParamDetailsEditorExtractor.getLines();
            const paramDetails = paramDetailsLines.map(line => line ? '&nbsp;&nbsp;&nbsp;' + line : '').join('<br>');
            
            const methodLines = labTestMethodEditorExtractor.getLines();
            const method = methodLines.join('<br>');

     

            // 
            
            if (field && cells[0].textContent.trim()) {
                let cleanedCell0 = cells[0].textContent.trim().replace(/\(.*$/, '')   // ลบตั้งแต่ ( จนจบ
                          .replace('สาขา', '')   // ลบคำว่า สาขา
                          .trim();               // ลบช่องว่างหน้า-หลัง
                    console.log(field , cleanedCell0);
                 if (field != cleanedCell0) {
                    alert("ให้เพิ่มแถวใหม่สำหนับสาขาใหม่");
                    return;
                }
            }
            
            // --- Cell 1 Logic: Field and Category ---
            const cell1Parts = [];

            
                // --- Field (cells[0]) Logic ---
            if (field && !cells[0].textContent.trim()) {
                if (field) cell1Parts.push("สาขา"+field + "<br>(" + fieldValueEn + ")");
            }

            if (category) cell1Parts.push(category);
            const cell1Content = cell1Parts.join('<br>');
            appendToCell(cells[0], cell1Content);

            // --- Cell 2 Logic: Parameter, Description, and Details ---
            const cell2Parts = [];
            if (parameter) cell2Parts.push(parameter);
            if (description) cell2Parts.push(description);
            if (paramDetails) cell2Parts.push(paramDetails);
            const cell2Content = cell2Parts.join('<br>');
            appendToCell(cells[1], cell2Content);

            // --- Cell 3 Logic: Method ---
            if (method) {
                appendToCell(cells[2], method);
            }
            

            const newItem = {
                field: fieldValue,
                categoryValue: categoryValue,
                parameterValue: parameterValue
            };

            // 2. เพิ่ม object ใหม่เข้าไปใน array `labCalItems`
            labTestItems.push(newItem);

            managePages();
            closeModal(labTestItemModal);
        });
        // === END: MODIFICATION FOR LAB TEST LOGIC ===

        function wrapSpecialCharactersInNode(node) {
            const specialChars = ['Ω', 'π', 'Σ', 'β', 'α', 'γ', 'µ', 'μ', '±', '∞', 'θ', 'δ', 'ξ', 'φ', 'χ', 'ψ', 'ω', 'ε', 'Δ', '√', '∮', '∫', '∂', '∇', '∑', '∏', '∆', 'λ', 'σ', 'ρ', '℃', '℉', 'Ξ','Ɛ'];
            const regex = new RegExp(`(${specialChars.join('|')})`, 'g');

            if (node.nodeType === Node.TEXT_NODE) {
                const parent = node.parentNode;
                if (parent.nodeName === 'SCRIPT' || parent.nodeName === 'STYLE') {
                    return;
                }

                const text = node.textContent;
                if (regex.test(text)) {
                    const fragment = document.createDocumentFragment();
                    const parts = text.split(regex);

                    parts.forEach(part => {
                        if (specialChars.includes(part)) {
                            const span = document.createElement('span');
                            span.style.fontFamily = 'dejavusans';
                            span.style.fontSize = '14px';
                            span.textContent = part;
                            fragment.appendChild(span);
                        } else if (part) {
                            fragment.appendChild(document.createTextNode(part));
                        }
                    });
                    parent.replaceChild(fragment, node);
                }
            } else if (node.nodeType === Node.ELEMENT_NODE) {
                Array.from(node.childNodes).forEach(child => wrapSpecialCharactersInNode(child));
            }
        }

        // exportPdfButton.addEventListener('click', () => {
        //     const editorClone = editor.cloneNode(true);
        //     const pagesContent = [];

        //     editorClone.querySelectorAll('.page').forEach(page => {
        //         page.removeAttribute('contenteditable');
                
        //         page.querySelectorAll('.image-container').forEach(container => {
        //             const containerWidth = container.style.width;
        //             const img = container.querySelector('img');
        //             if (img && containerWidth) {
        //                 img.style.width = containerWidth;
        //                 img.style.height = 'auto';
        //             }
        //             container.querySelectorAll('.resize-handle').forEach(handle => handle.remove());
        //             container.classList.remove('active');
        //             container.style.border = 'none';
        //         });

        //         wrapSpecialCharactersInNode(page);
                
        //         pagesContent.push(page.innerHTML); 
        //     });

        //     fetch("{!! url('/export-pdf') !!}", {
        //         method: 'POST',
        //         headers: {
        //             'Content-Type': 'application/json',
        //             'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        //         },
        //         body: JSON.stringify({ html_pages: pagesContent })
        //     })
        //     .then(response => {
        //         if (!response.ok) {
        //             return response.json().then(errorData => {
        //                 throw new Error(errorData.message || 'Network response was not ok');
        //             });
        //         }
        //         return response.blob();
        //     })
        //     .then(blob => {
        //         const url = window.URL.createObjectURL(blob);
        //         window.open(url);
        //     })
        //     .catch(error => {
        //         console.error('There was a problem with the fetch operation:', error);
        //         alert('เกิดข้อผิดพลาดในการสร้าง PDF: ' + error.message);
        //     });
        // });

        if (saveTemplateButton) {
            saveTemplateButton.addEventListener('click', () => {

                const editorClone = editor.cloneNode(true);
                const pagesContent = [];

                editorClone.querySelectorAll('.page').forEach(page => {
                    page.removeAttribute('contenteditable');

                    page.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
                        if (checkbox.checked) {
                            checkbox.setAttribute('checked', 'checked');
                        } else {
                            checkbox.removeAttribute('checked');
                        }
                    });

                    page.querySelectorAll('.image-container').forEach(container => {
                        const containerWidth = container.style.width;
                        const img = container.querySelector('img');
                        if (img && containerWidth) {
                            img.style.width = containerWidth;
                            img.style.height = 'auto';
                        }
                        container.querySelectorAll('.resize-handle').forEach(handle => handle.remove());
                        container.classList.remove('active');
                        container.style.border = 'none';
                    });

                    wrapSpecialCharactersInNode(page);

                    pagesContent.push(page.innerHTML);
                });


                // console.log(pagesContent);
                let labItems = [];
                if(templateType == "lab_test")
                {
                    labItems = labTestItems;
                }else if(templateType == "lab_cal")
                {
                    labItems = labCalItems;
                }

                // console.log(labItems)

                fetch("{!! route('certify.applicant.save-html-template') !!}" , {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        html_pages: pagesContent,
                        template_type: templateType,
                        labCalDetails: labCalDetails,
                        accordingFormula: accordingFormula,
                        labAbility: labAbility,
                        purpose: purpose,
                        labItems: labItems
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(errorData => {
                            throw new Error(errorData.message || 'Network response was not ok');
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    alert(data.message);
                    console.log('Save successful:', data);
                })
                .catch(error => {
                    console.error('There was a problem with the save operation:', error);
                    alert('เกิดข้อผิดพลาดในการบันทึก: ' + error.message);
                });
            });
        }
        
        if (loadTemplateButton) {
            loadTemplateButton.addEventListener('click', () => {
                downloadTemplate();
                //  alert('fk');
            });
        }

        function downloadTemplate()
        {
            console.log(accordingFormula,labAbility,purpose);
            fetch("{!! route('certify.applicant.download-html-template') !!}" , {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    accordingFormula: accordingFormula,
                    labAbility: labAbility,
                    purpose: purpose,
                })
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(errorData => {
                        throw new Error(errorData.message || 'Network response was not ok');
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data.html_pages && Array.isArray(data.html_pages)) {
                    while (editor.firstChild) {
                        editor.removeChild(editor.firstChild);
                    }

                    console.log(data.htmlTemplate)
                    data.html_pages.forEach(pageHtml => {
                        const newPage = createNewPage();
                        newPage.innerHTML = pageHtml;
                        editor.appendChild(newPage);
                    });
                    console.log('Load successful:', data);

                    // ตรวจสอบ template_type เพื่อสร้างตัวแปรที่เหมาะสม
                    if (data.htmlTemplate && data.htmlTemplate.template_type === "lab_test") {
                        const labTestItems = [];
                        try {
                            // Parse json_data ซึ่งเป็น string ให้เป็น JavaScript array/object
                            const jsonData = JSON.parse(data.htmlTemplate.json_data);
                            jsonData.forEach(item => {
                                const newItem = {
                                    field: item.field,
                                    categoryValue: item.categoryValue,
                                    parameterValue: item.parameterValue
                                };
                                labTestItems.push(newItem);
                            });
                            console.log('labTestItems:', labTestItems);
                        } catch (error) {
                            console.error("Error parsing json_data for lab_test:", error);
                        }
                    } else if (data.htmlTemplate && data.htmlTemplate.template_type === "lab_cal") {
                        const labCalItems = [];
                        try {

                            const jsonData = JSON.parse(data.htmlTemplate.json_data);
                            jsonData.forEach(item => {
                                const newItem = {
                                    field: item.field,
                                    instrument: item.instrument,
                                    parameterOne: item.parameterOne,
                                    parameterTwo: item.parameterTwo,
                                };
                                labCalItems.push(newItem);
                            });
                            console.log('labCalItems:', labCalItems);
                        } catch (error) {
                            console.error("Error parsing json_data for lab_cal:", error);
                        }
                    }
                
                } 
                
            });
        }

        // === START: MODIFICATION FOR LineExtractor INSTANCES ===
        // Instantiate LineExtractor for all editable divs in the modals
        const cbCodeEditorExtractor = new LineExtractor('cb-code-editor');
        const cbDescriptionEditorExtractor = new LineExtractor('cb-description-editor');
        const labCalMethodEditorExtractor = new LineExtractor('lab-cal-method-editor');
        const labCalParamDetailsEditorExtractor = new LineExtractor('lab-cal-param-details-editor');
        const labCalCapabilityEditorExtractor = new LineExtractor('lab-cal-capability-editor');
        const labTestParamDetailsEditorExtractor = new LineExtractor('lab-test-param-details-editor');
        const labTestMethodEditorExtractor = new LineExtractor('lab-test-method-editor');
        
        // New extractors for the modified IB modal
        const ibSubBranchExtractor = new LineExtractor('ib-sub-branch');
        const ibMainScopeExtractor = new LineExtractor('ib-main-scope');
        const ibSubScopeExtractor = new LineExtractor('ib-sub-scope');
        const ibRequirementsExtractor = new LineExtractor('ib-requirements-editor');
        // === END: MODIFICATION FOR LineExtractor INSTANCES ===

        if (editor.children.length === 0) {
            editor.appendChild(createNewPage());
        } else {
            Array.from(editor.children).forEach(page => page.setAttribute('contenteditable', 'true'));
        }

        fontSizeSelector.value = "20";

    </script>
</body>
</html>
