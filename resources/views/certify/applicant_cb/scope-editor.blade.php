<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scope template | CB</title>
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
            width: 240px;
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
            width: 240px ;
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
        #ib-item-modal select {
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
            width: 240px;
        }

        /* Custom arrow for select */
        #ib-item-modal select::-ms-expand {
            display: none; /* Hide default arrow in IE */
        }

        #ib-item-modal .modal-input-group select:focus {
            outline: none;
            border-color: #4285f4;
            box-shadow: 0 0 5px rgba(66, 133, 244, 0.5);
        }

        /* Ensure consistent height and alignment */
        #ib-item-modal .modal-input-group {
            align-items: center;
        }

             /* Adjust select element styling to match other inputs */
        #cb-isic-scope-modal select {
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
            width: 550px;
        }

        /* Custom arrow for select */
        #cb-isic-scope-modal select::-ms-expand {
            display: none; /* Hide default arrow in IE */
        }

        #cb-isic-scope-modal .modal-input-group select:focus {
            outline: none;
            border-color: #4285f4;
            box-shadow: 0 0 5px rgba(66, 133, 244, 0.5);
        }

        /* Ensure consistent height and alignment */
        #cb-isic-scope-modal .modal-input-group {
            align-items: center;
        }

        /* Adjust select element styling to match other inputs */
        #cb-enms-scope-modal select {
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
            width: 550px;
        }

        /* Custom arrow for select */
        #cb-enms-scope-modal select::-ms-expand {
            display: none; /* Hide default arrow in IE */
        }

        #cb-enms-scope-modal .modal-input-group select:focus {
            outline: none;
            border-color: #4285f4;
            box-shadow: 0 0 5px rgba(66, 133, 244, 0.5);
        }

        /* Ensure consistent height and alignment */
        #cb-enms-scope-modal .modal-input-group {
            align-items: center;
        }

        /* Adjust select element styling to match other inputs */
        #cb-enms-scope-modal select {
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
            width: 550px;
        }

        /* Custom arrow for select */
        #cb-enms-scope-modal select::-ms-expand {
            display: none; /* Hide default arrow in IE */
        }

        #cb-enms-scope-modal .modal-input-group select:focus {
            outline: none;
            border-color: #4285f4;
            box-shadow: 0 0 5px rgba(66, 133, 244, 0.5);
        }

        /* Ensure consistent height and alignment */
        #cb-enms-scope-modal .modal-input-group {
            align-items: center;
        }


        /* Adjust select element styling to match other inputs */
        #cb-bcms-scope-modal select {
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
            width: 550px;
        }

        /* Custom arrow for select */
        #cb-bcms-scope-modal select::-ms-expand {
            display: none; /* Hide default arrow in IE */
        }

        #cb-bcms-scope-modal .modal-input-group select:focus {
            outline: none;
            border-color: #4285f4;
            box-shadow: 0 0 5px rgba(66, 133, 244, 0.5);
        }

        /* Ensure consistent height and alignment */
        #cb-bcms-scope-modal .modal-input-group {
            align-items: center;
        }

        /* Adjust select element styling to match other inputs */
        #cb-sfms-scope-modal select {
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
            width: 550px;
        }

        /* Custom arrow for select */
        #cb-sfms-scope-modal select::-ms-expand {
            display: none; /* Hide default arrow in IE */
        }

        #cb-sfms-scope-modal .modal-input-group select:focus {
            outline: none;
            border-color: #4285f4;
            box-shadow: 0 0 5px rgba(66, 133, 244, 0.5);
        }

        /* Ensure consistent height and alignment */
        #cb-sfms-scope-modal .modal-input-group {
            align-items: center;
        }

         /* Adjust select element styling to match other inputs */
        #cb-mdms-scope-modal select {
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
            width: 550px;
        }

        /* Custom arrow for select */
        #cb-mdms-scope-modal select::-ms-expand {
            display: none; /* Hide default arrow in IE */
        }

        #cb-mdms-scope-modal .modal-input-group select:focus {
            outline: none;
            border-color: #4285f4;
            box-shadow: 0 0 5px rgba(66, 133, 244, 0.5);
        }

        /* Ensure consistent height and alignment */
        #cb-mdms-scope-modal .modal-input-group {
            align-items: center;
        }
   
         /* Adjust select element styling to match other inputs */
        #cb-corsia-scope-modal select {
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
            width: 550px;
        }

        /* Custom arrow for select */
        #cb-corsia-scope-modal select::-ms-expand {
            display: none; /* Hide default arrow in IE */
        }

        #cb-corsia-scope-modal .modal-input-group select:focus {
            outline: none;
            border-color: #4285f4;
            box-shadow: 0 0 5px rgba(66, 133, 244, 0.5);
        }

        /* Ensure consistent height and alignment */
        #cb-corsia-scope-modal .modal-input-group {
            align-items: center;
        }        

         /* Adjust select element styling to match other inputs */
        #cb-ohsms-scope-modal select {
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
            width: 550px;
        }

        /* Custom arrow for select */
        #cb-ohsms-scope-modal select::-ms-expand {
            display: none; /* Hide default arrow in IE */
        }

        #cb-ohsms-scope-modal .modal-input-group select:focus {
            outline: none;
            border-color: #4285f4;
            box-shadow: 0 0 5px rgba(66, 133, 244, 0.5);
        }

        /* Ensure consistent height and alignment */
        #cb-ohsms-scope-modal .modal-input-group {
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
                {{-- {{$certificateInitial}} --}}
                @if ($templateType == "cb")
                    
                    @if ($certificateInitial == "QMS" || $certificateInitial == "EMS" || $certificateInitial == "TLS")
                        <a href="#" data-template="cb-isic-template" >CB template ({{$certificateInitial}})</a>
                    @elseif($certificateInitial == "BCMS" || $certificateInitial == "ISMS")
                        <a href="#" data-template="cb-bcms-template" >CB template ({{$certificateInitial}})</a>
                    @elseif($certificateInitial == "OHSMS")
                        <a href="#" data-template="cb-ohsms-template" >CB template ({{$certificateInitial}})</a>
                    @elseif($certificateInitial == "EnMS")
                        <a href="#" data-template="cb-enms-template" >CB template ({{$certificateInitial}})</a>
                    @elseif($certificateInitial == "SFMS")
                        <a href="#" data-template="cb-sfms-template" >CB template ({{$certificateInitial}})</a>
                    @elseif($certificateInitial == "ICAO CORSIA")
                        <a href="#" data-template="cb-corsia-template" >CB template ({{$certificateInitial}})</a>
                    @elseif($certificateInitial == "MDMS")
                        <a href="#" data-template="cb-mdms-template" >CB template ({{$certificateInitial}})</a>
                    @elseif($certificateInitial == "PRODUCT")
                        <a href="#" data-template="cb-product-template" >CB template ({{$certificateInitial}})</a>
                    @elseif($certificateInitial == "PERSONEL")
                        <a href="#" data-template="cb-personel-template" >CB template ({{$certificateInitial}})</a>
                    @else 
                        <a href="#" data-template="cb-generic-template" >CB Generic template</a>
                    @endif
                
                       {{-- <a href="#" data-template="cb-template" >CB template</a> --}}
                @elseif($templateType == "ib")
                        <a href="#" data-template="ib-template" >IB template</a>
                @elseif($templateType == "else")
                        <a href="#" data-template="lab-cal-template" >Cal Lab template</a>
                @elseif($templateType == "lab_test")
                        <a href="#" data-template="lab-test-template" >Test Lab template</a>
                @endif
            </div>
        </div>
        
        {{-- <button class="menu-button" id="export-pdf-button" title="ส่งออกเป็น PDF"><i class="fas fa-file-pdf"></i></button> --}}
        <button class="menu-button" id="save-template-button"><i class="fas fa-save"></i></button>
        <button class="menu-button" id="load-template-button"><i class="fa fa-cloud-download" aria-hidden="true"></i></button>

        
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
    <div id="cb-isic-scope-modal" class="modal-overlay cb-modal">
        <div class="modal-content" style="width: 550px">
            <h3>เพิ่มรายการ CB {{ $certificateInitial }}</h3>
            <div class="modal-input-group" >
                <label for="cb-isic">สาขาการตรวจหลัก:</label>
                <select id="cb-isic">
                </select>

                <div  style="display: none;">
                    <input type="text" id="cb-isic-code" >

                    <div id="cb-isic-description-editor" class="editable-div detail" contenteditable="true"></div>
                    <div id="cb-isic-description-editor-en" class="editable-div detail" contenteditable="true"></div>
                </div>
            </div>

            <div class="modal-buttons">
                <button id="add-cb-isic-item-btn" class="modal-btn-confirm">เพิ่ม</button>
                <button class="modal-btn-cancel">ยกเลิก</button>
            </div>
        </div>
    </div>

    <div id="cb-enms-scope-modal" class="modal-overlay cb-modal">
        <div class="modal-content" style="width: 550px">
            <h3>เพิ่มรายการ CB {{ $certificateInitial }}</h3>
            <div class="modal-input-group" >
                <label for="cb-enms">กิจกรรม:</label>
                <select id="cb-enms">
                </select>

                <div  style="display: none;">
                {{-- <div > --}}
                    <div id="cb-enms-description_th" class="editable-div detail" contenteditable="true"></div>
                    <div id="cb-enms-description_en" class="editable-div detail" contenteditable="true"></div>
                </div>
            </div>

            <div class="modal-buttons">
                <button id="add-cb-enms-item-btn" class="modal-btn-confirm">เพิ่ม</button>
                <button class="modal-btn-cancel">ยกเลิก</button>
            </div>
        </div>
    </div>

    <div id="cb-bcms-scope-modal" class="modal-overlay cb-modal">
        <div class="modal-content" style="width: 550px">
            <h3>เพิ่มรายการ CB {{ $certificateInitial }}</h3>
            <div class="modal-input-group" >
                <label for="cb-bcms">กิจกรรม:</label>
                <select id="cb-bcms">
                </select>
                <div  style="display: none;">
                {{-- <div  > --}}
                    <div id="cb-bcms-sector" class="editable-div detail" contenteditable="true"></div>
                    <div id="cb-bcms-description_th" class="editable-div detail" contenteditable="true"></div>
                    <div id="cb-bcms-description_en" class="editable-div detail" contenteditable="true"></div>
                </div>
            </div>

            <div class="modal-buttons">
                <button id="add-cb-bcms-item-btn" class="modal-btn-confirm">เพิ่ม</button>
                <button class="modal-btn-cancel">ยกเลิก</button>
            </div>
        </div>
    </div>

    <div id="cb-sfms-scope-modal" class="modal-overlay cb-modal">
        <div class="modal-content" style="width: 550px">
            <h3>เพิ่มรายการ CB {{ $certificateInitial }}</h3>
            <div class="modal-input-group" >
                <label for="cb-sfms">สาขาและขอบข่าย:</label>
                <select id="cb-sfms">
                </select>
                </select>
                <div  style="display: none;">
                {{-- <div  > --}}
                    {{-- [ 'scope_th' => "",'scope_en' => "", 'activity_th' => "", 'activity_en' => "" ], --}}
                    <div id="cb-sfms-scope_th" class="editable-div detail" contenteditable="true"></div>
                    <div id="cb-sfms-scope_en" class="editable-div detail" contenteditable="true"></div>
                    <div id="cb-sfms-activity_th" class="editable-div detail" contenteditable="true"></div>
                    <div id="cb-sfms-activity_en" class="editable-div detail" contenteditable="true"></div>
                </div>
            </div>

            <div class="modal-buttons">
                <button id="add-cb-sfms-item-btn" class="modal-btn-confirm">เพิ่ม</button>
                <button class="modal-btn-cancel">ยกเลิก</button>
            </div>
        </div>
    </div>

    
    <div id="cb-mdms-scope-modal" class="modal-overlay cb-modal">
        <div class="modal-content" style="width: 550px">
            <h3>เพิ่มรายการ CB {{ $certificateInitial }}</h3>
            <div class="modal-input-group" >
                <label for="cb-mdms">กิจกรรม:</label>
                <select id="cb-mdms">
                </select>
                </select>
                <div  style="display: none;">
                {{-- <div  > --}}
                    {{--  [ 'sector_th' => "", 'sector_en' => "", 'description_th' => "", 'description_en' => "" ], --}}
                    <input type="text" id="cb-mdms-code" >
                    <div id="cb-mdms-description_th" class="editable-div detail" contenteditable="true"></div>
                    <div id="cb-mdms-description_en" class="editable-div detail" contenteditable="true"></div>
                </div>
            </div>

            <div class="modal-buttons">
                <button id="add-cb-mdms-item-btn" class="modal-btn-confirm">เพิ่ม</button>
                <button class="modal-btn-cancel">ยกเลิก</button>
            </div>
        </div>
    </div>

    <div id="cb-corsia-scope-modal" class="modal-overlay cb-modal">
        <div class="modal-content" style="width: 550px">
            <h3>เพิ่มรายการ CB {{ $certificateInitial }}</h3>
            <div class="modal-input-group" >
                <label for="cb-corsia">สาขาและขอบข่าย:</label>
                <select id="cb-corsia">
                </select>
                </select>
                <div  style="display: none;">
                {{-- <div  > --}}
                    {{--     [ 'sector_th' => "",'sector_en' => "", 'scope_th' => "", 'scope_en' => "" ],--}}
                    <div id="cb-corsia-sector_th" class="editable-div detail" contenteditable="true"></div>
                    <div id="cb-corsia-sector_en" class="editable-div detail" contenteditable="true"></div>
                    <div id="cb-corsia-scope_en" class="editable-div detail" contenteditable="true"></div>
                </div>
            </div>

            <div class="modal-buttons">
                <button id="add-cb-corsia-item-btn" class="modal-btn-confirm">เพิ่ม</button>
                <button class="modal-btn-cancel">ยกเลิก</button>
            </div>
        </div>
    </div>

    <div id="cb-ohsms-scope-modal" class="modal-overlay cb-modal">
        <div class="modal-content" style="width: 550px">
            <h3>เพิ่มรายการ CB {{ $certificateInitial }}</h3>
            <div class="modal-input-group" >
                <label for="cb-ohsms">สาขาและขอบข่าย:</label>
                <select id="cb-ohsms">
                </select>
                </select>
                <div  style="display: none;">
                {{-- <div  > --}}
                    {{--   [ 'iaf_code' => "<br>", 'description_th' => "", 'description_en' => "" ],--}}
                    <input type="text" id="cb-ohsms-code" >
                    <div id="cb-ohsms-description_th" class="editable-div detail" contenteditable="true"></div>
                    <div id="cb-ohsms-description_en" class="editable-div detail" contenteditable="true"></div>
                </div>
            </div>

            <div class="modal-buttons">
                <button id="add-cb-ohsms-item-btn" class="modal-btn-confirm">เพิ่ม</button>
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
                    <select id="ib-main-branch">
                    </select>
                </div>
                <div style="flex: 1;">
                    <label for="ib-sub-branch">สาขาการตรวจย่อย:</label>
                    <select id="ib-sub-branch">
                    </select>
                </div>
            </div>

            <div class="modal-input-group" style="display: flex; gap: 20px;">
                <div style="flex: 1;">
                    <label for="ib-main-scope">ขอบข่ายหลัก:</label>
                    <select id="ib-main-scope">
                    </select>
                </div>
                <div style="flex: 1;">
                    <label for="ib-sub-scope">ขอบข่ายย่อย:</label>
                    <select id="ib-sub-scope">
                    </select>
                </div>
            </div>


            <div style="display: none">
                <div class="modal-input-group" style="display: flex; gap: 20px;">
                    <div style="flex: 1;">
                        <div id="ib-main-branch-editable" class="editable-div" contenteditable="true"></div>
                    </div>
                    <div style="flex: 1;">
                        <div id="ib-sub-branch-editable" class="editable-div" contenteditable="true"></div>
                    </div>
                </div>

                <div class="modal-input-group" style="display: flex; gap: 20px;">
                    <div style="flex: 1;">
                        <div id="ib-main-scope-editable" class="editable-div" contenteditable="true"></div>
                    </div>
                    <div style="flex: 1;">
                        <div id="ib-sub-scope-editable" class="editable-div" contenteditable="true"></div>
                    </div>
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
            <!-- === START: MODIFICATION === -->
            <div class="modal-input-group" style="display: flex; gap: 20px;">
                <div style="flex: 1;">
                    <label for="lab-cal-field">สาขาการสอบเทียบ:</label>
                    <select id="lab-cal-field" >
                        {{-- <option value="1">1</option>
                         <option value="2">2</option> --}}
                    </select>
                </div>
                <div style="flex: 1;">
                    <label for="lab-cal-instrument">เครื่องมือ:</label>
                    <select id="lab-cal-instrument" >
                        {{-- <option value="1">1</option>
                         <option value="2">2</option> --}}
                    </select>
                </div>
            </div>
            <div class="modal-input-group" style="display: flex; gap: 20px;">
                <div style="flex: 1;">
                    <label for="lab-cal-parameter">พารามิเตอร์: <a href="{{ route('certify.applicant.special-sign') }}" style="text-decoration: none; font-size: 18px;" target="_blank">สัญลักษณ์พิเศษ</a></label>
                     <select id="lab-cal-parameter" >
                        {{-- <option value="1">1</option>
                         <option value="2">2</option> --}}
                    </select>
                </div>
                <div style="flex: 1;">
                    <label for="lab-cal-condition">เงื่อนไขการวัด:</label>
                    <input type="text" id="lab-cal-condition" >
                </div>
            </div>
            <div class="modal-input-group" style="display: flex; gap: 20px;">
                <div style="flex: 1;">
                    <label for="lab-cal-param-details-editor">รายละเอียดพารามิเตอร์:</label>
                    <div id="lab-cal-param-details-editor" class="editable-div"  contenteditable="true"></div>
                </div>
                <div style="flex: 1;">
                    <label for="lab-cal-capability-editor">ขีดความสามารถฯ:</label>
                    <div id="lab-cal-capability-editor" class="editable-div" contenteditable="true"></div>
                </div>
            </div>
            <!-- === END: MODIFICATION === -->
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
                    <input type="text" id="lab-test-field" >
                </div>
                <div style="flex: 1;">
                    <label for="lab-test-category">หมวดหมู่การทดสอบ:</label>
                    <input type="text" id="lab-test-category" >
                </div>
            </div>

             <div class="modal-input-group" style="display: flex; gap: 20px;">
                <div style="flex: 1;">
                    <label for="lab-test-parameter">พารามิเตอร์:</label>
                    <input type="text" id="lab-test-parameter" >
                </div>
                  <div style="flex: 1;">
                    <label for="lab-test-description-editor">คำอธิบาย:</label>
                
                    <input type="text" id="lab-test-description-editor" >
                </div>
             </div>

            <div class="modal-input-group" style="display: flex; gap: 20px;">
                <div style="flex: 1;">
                     <label for="lab-test-param-details-editor">รายละเอียดพารามิเตอร์:</label>
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
        const cbIsicScopeModal = document.getElementById('cb-isic-scope-modal');
        const cbEnmsScopeModal = document.getElementById('cb-enms-scope-modal');
        const cbBcmsScopeModal = document.getElementById('cb-bcms-scope-modal');
        const cbSfmsScopeModal = document.getElementById('cb-sfms-scope-modal');
        const cbMdmsScopeModal = document.getElementById('cb-mdms-scope-modal');
        const cbCorsiaScopeModal = document.getElementById('cb-corsia-scope-modal');
        const cbOhsmsScopeModal = document.getElementById('cb-ohsms-scope-modal');



        const ibItemModal = document.getElementById('ib-item-modal');
        const labCalItemModal = document.getElementById('lab-cal-item-modal');
        const labTestItemModal = document.getElementById('lab-test-item-modal');

        // 1. รับข้อมูลจาก Blade ที่ PHP ส่งมา
        const templateType = "{{ $templateType ?? '' }}"; 
  
        const cbDetailsFromBlade = @json($cbDetails ?? null);
        const ibDetailsFromBlade = @json($ibDetails ?? null);
        const standardChange = @json($standardChange ?? null);
        const typeStandard = @json($typeStandard ?? null);
        const typeUnit = @json($typeUnit ?? null);


        const typeStandardData = @json($typeStandard ?? null);
        const petitionerData = @json($petitioner ?? null);
        const trustMarkData = @json($trustMark ?? null);



        const certificateInitial = @json($certificateInitial ?? null);

        // console.log(certificateInitial)
                                                   
        let savedRange = null; // Used for image insertion
        let contextMenuTarget = null;
        let contextMenuTargetRow = null; // To store the target TR element for immediate context menu actions
        let selectedTableCellsForMerge = []; // Holds cells selected for merging
        let activeModalTargetRow = null; // **NEW**: Persists the target row for modal operations

        let ibItems = [];
        let cbItems = [];


        document.addEventListener('DOMContentLoaded', () => {
            downloadTemplate();
        });   

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
                if (templateId === 'cb-isic-template') {
                    insertCbIsicTemplate();
                } else if (templateId === 'cb-ohsms-template') {
                    insertCbOhsmsTemplate();
                } else if (templateId === 'cb-enms-template') {
                    insertCbEnmsTemplate();
                } else if (templateId === 'cb-bcms-template') {
                    insertCbBcmsTemplate();
                } else if (templateId === 'cb-sfms-template') {
                    insertCbSfmsTemplate();
                }else if (templateId === 'cb-corsia-template') {
                    insertCbCorsiaTemplate();
                }else if (templateId === 'cb-mdms-template') {
                    insertCbMdmsTemplate();
                }else if (templateId === 'cb-product-template') {
                    insertCbProductTemplate();
                }else if (templateId === 'cb-personel-template') {
                    insertCbPersonelTemplate();
                }else if (templateId === 'cb-generic-template') {
                    insertCbGenericTemplate();
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
        
        const insertCbIsicTemplate = () => {
            const templateData = cbDetailsFromBlade;
            console.log("==>",certificateInitial);
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
                            <td >${item.description_th}<br><span style="font-size: 15px;">${item.description_en}</span></td>
                        </tr>
                    `;
                });
            }

            const templateHTML = `
                <div style="text-align: center;line-height: 1.0">
                    <b style="font-size: 1.17em;">${templateData.scopeOfAccreditation.th}</b><br>
                    <span style="font-size: 15px;">(${templateData.scopeOfAccreditation.en})</span><br>
                    ${templateData.attachmentToCertificate.th}<br>
                    <span style="font-size: 15px;">(${templateData.attachmentToCertificate.en})</span><br>
                    <b>ใบรับรองเลขที่ <span class="certificate_no">${templateData.certificateNo}</span></b><br>
                    <span style="font-size: 15px;">(Certification No. <span class="certificate_no">${templateData.certificateNo}</span>)</span>
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


        const insertCbOhsmsTemplate = () => {
            const templateData = cbDetailsFromBlade;
            console.log("==>",certificateInitial);
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

            let ohsmsTableRows = '';
            if (templateData.oshms && Array.isArray(templateData.oshms)) {
                templateData.oshms.forEach(item => {
                    ohsmsTableRows += `
                        <tr>
                            <td style="width: 20%;">${item.iaf_code}</td>
                            <td >${item.description_th}<br><span style="font-size: 15px;">${item.description_en}</span></td>
                        </tr>
                    `;
                });
            }

            const templateHTML = `
                <div style="text-align: center;line-height: 1.0">
                    <b style="font-size: 1.17em;">${templateData.scopeOfAccreditation.th}</b><br>
                    <span style="font-size: 15px;">(${templateData.scopeOfAccreditation.en})</span><br>
                    ${templateData.attachmentToCertificate.th}<br>
                    <span style="font-size: 15px;">(${templateData.attachmentToCertificate.en})</span><br>
                    <b>ใบรับรองเลขที่ ${templateData.certificateNo}</b><br>
                    <span style="font-size: 15px;">(Certification No. ${templateData.certificateNo})</span>
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
                            <th style="width: 25%;">รหัส IAF<br><span style="font-size: 15px">(IAF Codes)</span></th>
                            <th>กิจกรรม<br><span style="font-size: 15px;">(Description)</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        ${ohsmsTableRows}
                    </tbody>
                </table>
                <p><br></p>
            `;
            insertTemplateAtCurrentOrLastPage(templateHTML);
        };

        const insertCbEnmsTemplate = () => {
            const templateData = cbDetailsFromBlade;
            // console.log("==>",certificateInitial);
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

            let enmsTableRows = '';
            if (templateData.enms && Array.isArray(templateData.enms)) {
                templateData.enms.forEach(item => {
                    enmsTableRows += `
                        <tr>
                            <td >${item.description_th}<br><span style="font-size: 15px;">${item.description_en}</span></td>
                        </tr>
                    `;
                });
            }

            const templateHTML = `
                <div style="text-align: center;line-height: 1.0">
                    <b style="font-size: 1.17em;">${templateData.scopeOfAccreditation.th}</b><br>
                    <span style="font-size: 15px;">(${templateData.scopeOfAccreditation.en})</span><br>
                    ${templateData.attachmentToCertificate.th}<br>
                    <span style="font-size: 15px;">(${templateData.attachmentToCertificate.en})</span><br>
                    <b>ใบรับรองเลขที่ ${templateData.certificateNo}</b><br>
                    <span style="font-size: 15px;">(Certification No. ${templateData.certificateNo})</span>
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
                            <th>กิจกรรม<br><span style="font-size: 15px;">(Description)</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        ${enmsTableRows}
                    </tbody>
                </table>
                <p><br></p>
            `;
            insertTemplateAtCurrentOrLastPage(templateHTML);
        };

        const insertCbBcmsTemplate = () => {
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

            let bcmsTableRows = '';
            if (templateData.bcms && Array.isArray(templateData.bcms)) {
                templateData.bcms.forEach(item => {
                    bcmsTableRows += `
                        <tr>
                            <td style="width: 20%;">${item.sector}</td>
                            <td >${item.description_th}<br><span style="font-size: 15px;">${item.description_en}</span></td>
                        </tr>
                    `;
                });
            }

            const templateHTML = `
                <div style="text-align: center;line-height: 1.0">
                    <b style="font-size: 1.17em;">${templateData.scopeOfAccreditation.th}</b><br>
                    <span style="font-size: 15px;">(${templateData.scopeOfAccreditation.en})</span><br>
                    ${templateData.attachmentToCertificate.th}<br>
                    <span style="font-size: 15px;">(${templateData.attachmentToCertificate.en})</span><br>
                    <b>ใบรับรองเลขที่ ${templateData.certificateNo}</b><br>
                    <span style="font-size: 15px;">(Certification No. ${templateData.certificateNo})</span>
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
                            <th style="width: 25%;">รหัสหมวด<br><span style="font-size: 15px">(Sector Codes)</span></th>
                            <th>กิจกรรม<br><span style="font-size: 15px;">(Description)</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        ${bcmsTableRows}
                    </tbody>
                </table>
                <p><br></p>
            `;
            insertTemplateAtCurrentOrLastPage(templateHTML);
        };

        const insertCbSfmsTemplate = () => {
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

            let sfmsTableRows = '';
            if (templateData.sfms && Array.isArray(templateData.sfms)) {
                templateData.sfms.forEach(item => {
                    sfmsTableRows += `
                        <tr>
                            <td style="width: 50%;">${item.scope_th}<br><span style="font-size: 15px;">${item.scope_en}</span></td>
                            <td >${item.activity_th}<br><span style="font-size: 15px;">${item.activity_en}</span></td>
                        </tr>
                    `;
                });
            }

            const templateHTML = `
                <div style="text-align: center;line-height: 1.0">
                    <b style="font-size: 1.17em;">${templateData.scopeOfAccreditation.th}</b><br>
                    <span style="font-size: 15px;">(${templateData.scopeOfAccreditation.en})</span><br>
                    ${templateData.attachmentToCertificate.th}<br>
                    <span style="font-size: 15px;">(${templateData.attachmentToCertificate.en})</span><br>
                    <b>ใบรับรองเลขที่ ${templateData.certificateNo}</b><br>
                    <span style="font-size: 15px;">(Certification No. ${templateData.certificateNo})</span>
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
                            <th style="width: 50%;">สาขาและขอบข่าย<br><span style="font-size: 15px">(Scope)</span></th>
                            <th>มาตรฐาน<br><span style="font-size: 15px;">(Standard)</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        ${sfmsTableRows}
                    </tbody>
                </table>
                <p><br></p>
            `;
            insertTemplateAtCurrentOrLastPage(templateHTML);
        };


        const insertCbCorsiaTemplate = () => {
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

            let corsiaTableRows = '';
            if (templateData.icao_corsia && Array.isArray(templateData.icao_corsia)) {
                templateData.icao_corsia.forEach(item => {
                    // [ 'sector_th' => "",'sector_en' => "",'scope_en' => "" ],
                    corsiaTableRows += `
                        <tr>
                            <td style="width: 20%;">${item.sector_th}<br><span style="font-size: 15px;">${item.sector_en}</span></td>
                            <td >${item.scope_en}</td>
                        </tr>
                    `;
                });
            }

            const templateHTML = `
                <div style="text-align: center;line-height: 1.0">
                    <b style="font-size: 1.17em;">${templateData.scopeOfAccreditation.th}</b><br>
                    <span style="font-size: 15px;">(${templateData.scopeOfAccreditation.en})</span><br>
                    ${templateData.attachmentToCertificate.th}<br>
                    <span style="font-size: 15px;">(${templateData.attachmentToCertificate.en})</span><br>
                    <b>ใบรับรองเลขที่ ${templateData.certificateNo}</b><br>
                    <span style="font-size: 15px;">(Certification No. ${templateData.certificateNo})</span>
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
                            <th style="width: 20%;">สาขาและขอบข่าย<br><span style="font-size: 15px">(Sector)</span></th>
                            <th>สาขาและขอบข่าย<br><span style="font-size: 15px;">(Verification Criteria)</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        ${corsiaTableRows}
                    </tbody>
                </table>
                <p><br></p>
            `;
            insertTemplateAtCurrentOrLastPage(templateHTML);
        };

        
        const insertCbMdmsTemplate = () => {
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

            let mdmsTableRows = '';
            if (templateData.mdms && Array.isArray(templateData.mdms)) {
                templateData.mdms.forEach(item => {
                    mdmsTableRows += `
                        <tr>
                            <td style="width: 20%;">${item.sector}</td>
                            <td >${item.description_th}<br><span style="font-size: 15px;">${item.description_en}</span></td>
                        </tr>
                    `;
                });
            }

            const templateHTML = `
                <div style="text-align: center;line-height: 1.0">
                    <b style="font-size: 1.17em;">${templateData.scopeOfAccreditation.th}</b><br>
                    <span style="font-size: 15px;">(${templateData.scopeOfAccreditation.en})</span><br>
                    ${templateData.attachmentToCertificate.th}<br>
                    <span style="font-size: 15px;">(${templateData.attachmentToCertificate.en})</span><br>
                    <b>ใบรับรองเลขที่ ${templateData.certificateNo}</b><br>
                    <span style="font-size: 15px;">(Certification No. ${templateData.certificateNo})</span>
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
                            <th style="width: 20%;">สาขาและขอบข่าย<br><span style="font-size: 15px">(Sector)</span></th>
                            <th>สาขาและขอบข่าย<br><span style="font-size: 15px;">(Verification Criteria)</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        ${mdmsTableRows}
                    </tbody>
                </table>
                <p><br></p>
            `;
            insertTemplateAtCurrentOrLastPage(templateHTML);
        };

        const insertCbProductTemplate = () => {
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

            let productTableRows = '';
            if (templateData.product && Array.isArray(templateData.product)) {
                templateData.product.forEach(item => {
                    productTableRows += `
                        <tr>
                            <td style="width: 20%;">${item.product_th}<br><span style="font-size: 15px;">${item.product_en}</span></td>
                            <td >${item.standard_th}<br><span style="font-size: 15px;">${item.standard_en}</span></td>
                        </tr>
                    `;
                });
            }

            const templateHTML = `
                <div style="text-align: center;line-height: 1.0">
                    <b style="font-size: 1.17em;">${templateData.scopeOfAccreditation.th}</b><br>
                    <span style="font-size: 15px;">(${templateData.scopeOfAccreditation.en})</span><br>
                    ${templateData.attachmentToCertificate.th}<br>
                    <span style="font-size: 15px;">(${templateData.attachmentToCertificate.en})</span><br>
                    <b>ใบรับรองเลขที่ ${templateData.certificateNo}</b><br>
                    <span style="font-size: 15px;">(Certification No. ${templateData.certificateNo})</span>
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
                            <td class="vertical-align-top"><b>เครื่องหมายการรับรอง</b><br><span style="font-size: 15px;">(Certification Mark)</span></td>
                            <td class="vertical-align-top"></td>
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
                            <th style="width: 20%;">สาขาและขอบข่าย<br><span style="font-size: 15px">(Sector)</span></th>
                            <th>สาขาและขอบข่าย<br><span style="font-size: 15px;">(Verification Criteria)</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        ${productTableRows}
                    </tbody>
                </table>
                <p><br></p>
            `;
            insertTemplateAtCurrentOrLastPage(templateHTML);
        };

        const insertCbPersonelTemplate = () => {
            const templateData = cbDetailsFromBlade;

            // console.log("ddd")

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

            let personelTableRows = '';
            if (templateData.personel && Array.isArray(templateData.personel)) {
                templateData.personel.forEach(item => {
                    personelTableRows += `
                        <tr>
                            <td style="width: 20%;">${item.text1}</td>
                            <td >${item.text2}</td>
                        </tr>
                    `;
                });
            }

            const templateHTML = `
                <div style="text-align: center;line-height: 1.0">
                    <b style="font-size: 1.17em;">${templateData.scopeOfAccreditation.th}</b><br>
                    <span style="font-size: 15px;">(${templateData.scopeOfAccreditation.en})</span><br>
                    ${templateData.attachmentToCertificate.th}<br>
                    <span style="font-size: 15px;">(${templateData.attachmentToCertificate.en})</span><br>
                    <b>ใบรับรองเลขที่ ${templateData.certificateNo}</b><br>
                    <span style="font-size: 15px;">(Certification No. ${templateData.certificateNo})</span>
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
                    </tbody>
                </table>
                <table class="detail-table" style="width: 100%; margin-bottom: 1em;">
                    <thead>
                        <tr>
                            <th style="width: 20%;">สาขาและขอบข่าย<br><span style="font-size: 15px">(Sector)</span></th>
                            <th>สาขาและขอบข่าย<br><span style="font-size: 15px;">(Verification Criteria)</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        ${personelTableRows}
                    </tbody>
                </table>
                <p><br></p>
            `;
            insertTemplateAtCurrentOrLastPage(templateHTML);
        };


        // 

        const insertCbGenericTemplate = () => {
            const templateData = cbDetailsFromBlade;

            // console.log(templateData)

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

            let personelTableRows = '';
            if (templateData.personel && Array.isArray(templateData.personel)) {
                templateData.personel.forEach(item => {
                    personelTableRows += `
                        <tr>
                            <td style="width: 20%;">${item.text1}</td>
                            <td >${item.text2}</td>
                        </tr>
                    `;
                });
            }

            const templateHTML = `
                <div style="text-align: center;line-height: 1.0">
                    <b style="font-size: 1.17em;">${templateData.scopeOfAccreditation.th}</b><br>
                    <span style="font-size: 15px;">(${templateData.scopeOfAccreditation.en})</span><br>
                    ${templateData.attachmentToCertificate.th}<br>
                    <span style="font-size: 15px;">(${templateData.attachmentToCertificate.en})</span><br>
                    <b>ใบรับรองเลขที่ ${templateData.certificateNo}</b><br>
                    <span style="font-size: 15px;">(Certification No. ${templateData.certificateNo})</span>
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
                    </tbody>
                </table>
                <table class="detail-table" style="width: 100%; margin-bottom: 1em;">
                    <thead>
                        <tr>
                            <th style="width: 20%;">สาขาและขอบข่าย<br><span style="font-size: 15px">(Sector)</span></th>
                            <th>สาขาและขอบข่าย<br><span style="font-size: 15px;">(Verification Criteria)</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        ${personelTableRows}
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
                    <b style="font-size: 20px;">${templateData.title}</b><br>
                    <b>ใบรับรองเลขที่ ${templateData.certificateNo}</b>
                </div>
                <table class="borderless" style="width: 100%; margin-bottom: 1em; table-layout: fixed;">
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
                <table class="detail-table" style="width: 100%; margin-bottom: 1em; table-layout: fixed;">
                    <thead>
                        <tr>
                            <th style="width:33%; text-align: center;">หมวดหมู่ / สาขาการตรวจ</th>
                            <th style="width:33%;text-align: center;">ขั้นตอนและช่วงการตรวจ</th>
                            <th style="width:34%;text-align: center;">ข้อกำหนดที่ใช้</th>
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
                    case 'cb':  
                        console.log(certificateInitial)
                        if(certificateInitial == "QMS" || certificateInitial == "EMS" || certificateInitial == "TLS")
                        {
                            const selectCbIsic = $('#cb-isic');
                            selectCbIsic.empty(); 
                            $.ajax({
                                url: "{{ route('certi_cb.get-cb-isic') }}",
                                method: "POST",
                                contentType: 'application/json',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                },
                                success: function(response) {
                                    console.log(response)
                                    selectCbIsic.append('<option value="">--- เลือกรายการ ---</option>'); 
                                    if (response.cbIsicScopes && Array.isArray(response.cbIsicScopes)) {
                                        response.cbIsicScopes.forEach(function(value) {
                                            selectCbIsic.append('<option value="' + value.id + '" data-desc_en="' + value.description_en + '" data-isic_code="' + value.isic_code + '" >' + value.description_th + '</option>');
                                        });
                                    } 
                                }
                            });
                            cbIsicScopeModal.style.display = 'flex'; break;
                        }else if(certificateInitial == "EnMS")
                        {
                            const selectCbEnms = $('#cb-enms');
                            selectCbEnms.empty(); 
                            $.ajax({
                                url: "{{ route('certi_cb.get-cb-enms') }}",
                                method: "POST",
                                contentType: 'application/json',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                },
                                success: function(response) {
                                    console.log(response)
                                    selectCbEnms.append('<option value="">--- เลือกรายการ ---</option>'); 
                                    if (response.cbEnmsScopes && Array.isArray(response.cbEnmsScopes)) {
                                        response.cbEnmsScopes.forEach(function(value) {
                                            selectCbEnms.append('<option value="' + value.id + '" data-activity_en="' + value.activity_en + '" >' + value.activity_th + '</option>');
                                        });
                                    } 
                                }
                            });
                            cbEnmsScopeModal.style.display = 'flex'; break;
                        }else if(certificateInitial == "BCMS" || certificateInitial == "ISMS")
                        {
                            const selectCbBcms = $('#cb-bcms');
                            selectCbBcms.empty(); 
                            $.ajax({
                                url: "{{ route('certi_cb.get-cb-bcms') }}",
                                method: "POST",
                                contentType: 'application/json',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                },
                                success: function(response) {
                                    console.log(response)
                                    selectCbBcms.append('<option value="">--- เลือกรายการ ---</option>'); 
                                    if (response.cbBcmsScopes && Array.isArray(response.cbBcmsScopes)) {
                                        response.cbBcmsScopes.forEach(function(value) {
                                            selectCbBcms.append('<option value="' + value.id + '" data-sector="' + value.category + '" data-description_en="' + value.activity_en + '" >' + value.activity_th + '</option>');
                                        });
                                    } 
                                }
                            });
                            cbBcmsScopeModal.style.display = 'flex'; break;
                        }else if(certificateInitial == "SFMS")
                        {
                            const selectCbSfms = $('#cb-sfms');
                            selectCbSfms.empty(); 
                            $.ajax({
                                url: "{{ route('certi_cb.get-cb-sfms') }}",
                                method: "POST",
                                contentType: 'application/json',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                },
                                success: function(response) {
                                    console.log(response)
                                    selectCbSfms.append('<option value="">--- เลือกรายการ ---</option>'); 
                                    if (response.cbScopeSfms && Array.isArray(response.cbScopeSfms)) {
                                        response.cbScopeSfms.forEach(function(value) {
                                            // [ 'scope_th' => "",'scope_en' => "", 'activity_th' => "", 'activity_en' => "" ],
                                            selectCbSfms.append('<option value="' + value.id + '" data-activity_th="' + value.activity_th + '" data-scope_en="' + value.scope_en + '" data-activity_en="' + value.activity_en + '" >' + value.scope_th + '</option>');
                                        });
                                    } 
                                }
                            });
                            cbSfmsScopeModal.style.display = 'flex'; break;
                        }else if(certificateInitial == "MDMS")
                        {
                            const selectCbMdms = $('#cb-mdms');
                            selectCbMdms.empty(); 
                            $.ajax({
                                url: "{{ route('certi_cb.get-cb-mdms') }}",
                                method: "POST",
                                contentType: 'application/json',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                },
                                success: function(response) {
                                    console.log(response)
                                    selectCbMdms.append('<option value="">--- เลือกรายการ ---</option>'); 
                                    if (response.cbScopeMdms && Array.isArray(response.cbScopeMdms)) {
                                        response.cbScopeMdms.forEach(function(value) {
                                            // [ 'sector' => "", 'description_th' => "", 'description_en' => "" ],
                                           selectCbMdms.append('<option value="' + value.id + '" data-sector="' + value.code_sector  + '" data-description_en="' + value.activity_en + '" >' + value.activity_th + '</option>');
                                        });
                                    } 
                                }
                            });
                            cbMdmsScopeModal.style.display = 'flex'; break;
                        }else if(certificateInitial == "ICAO CORSIA")
                        {
                            const selectCbCorsia = $('#cb-corsia');
                            selectCbCorsia.empty(); 
                            $.ajax({
                                url: "{{ route('certi_cb.get-cb-corsia') }}",
                                method: "POST",
                                contentType: 'application/json',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                },
                                success: function(response) {
                                    console.log(response)
                                    selectCbCorsia.append('<option value="">--- เลือกรายการ ---</option>'); 
                                    if (response.cbScopeCorsias && Array.isArray(response.cbScopeCorsias)) {
                                        response.cbScopeCorsias.forEach(function(value) {
                                            // [ 'sector_th' => "",'sector_en' => "",'scope_en' => "" ],
                                            selectCbCorsia.append('<option value="' + value.id + '" data-scope_en="' + value.criteria + '" data-sector_en="' + value.sector_en + '" >' + value.sector+ '</option>');
                                        });
                                    } 
                                }
                            });
                            cbCorsiaScopeModal.style.display = 'flex'; break;
                        }else if(certificateInitial == "OHSMS")
                        {
                            const selectCbOhsms = $('#cb-ohsms');
                            selectCbOhsms.empty(); 
                            $.ajax({
                                url: "{{ route('certi_cb.get-cb-ohsms') }}",
                                method: "POST",
                                contentType: 'application/json',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                },
                                success: function(response) {
                                    console.log(response)
                                    selectCbOhsms.append('<option value="">--- เลือกรายการ ---</option>'); 
                                    if (response.cbOhsmsScopes && Array.isArray(response.cbOhsmsScopes)) {
                                        response.cbOhsmsScopes.forEach(function(value) {
                                            // [ 'iaf_code' => "<br>", 'description_th' => "", 'description_en' => "" ],
                                            selectCbOhsms.append('<option value="' + value.id + '" data-iaf_code="' + value.iaf + '" data-description_en="' + value.activity_en + '" >' + value.activity_th + '</option>');
                                        });
                                    } 
                                }
                            });
                            cbOhsmsScopeModal.style.display = 'flex'; break;
                        }else if(certificateInitial == "PRODUCT" || certificateInitial == "PERSONEL")
                        {
                            alert("เทมเพลตนี้ พิมพ์รายการด้วยตนเอง")
                            return;
                        }else{
                            alert("เทมเพลตนี้ พิมพ์รายการด้วยตนเอง")
                            return;
                        }
                    
                    case 'ib':      

                        const selectMainBranch = $('#ib-main-branch');
                        const selectSubBranch = $('#ib-sub-branch');
                        const selectMainScope = $('#ib-main-scope');
                        const selectSubScope = $('#ib-sub-scope');

                        $("#ib-main-branch-editable").empty();
                        $("#ib-sub-branch-editable").empty();
                        $("#ib-main-scope-editable").empty();
                        $("#ib-sub-scope-editable").empty();
                        $("#ib-requirements-editor").empty();

                        // ล้างตัวเลือกเก่าทั้งหมดก่อนเพิ่มใหม่
                        selectMainBranch.empty(); 
                        selectSubBranch.empty(); 
                        selectMainScope.empty(); 
                        selectSubScope.empty(); 
                        $.ajax({
                            url: "{{ route('certi_ib.get-ib-main-category') }}",
                            method: "POST",
                            contentType: 'application/json',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            success: function(response) {
                                // ตรวจสอบจาก console.log() ของคุณที่แสดง response.ibMainCategoryScopes
                                // console.log("Response from get-ib-main-category:", response.ibMainCategoryScopes); 

                                // เพิ่มตัวเลือกเริ่มต้น (optional)
                                selectMainBranch.append('<option value="">--- เลือกสาขาการตรวจหลัก ---</option>'); 

                                // เปลี่ยนจาก response.data เป็น response.ibMainCategoryScopes
                                if (response.ibMainCategoryScopes && Array.isArray(response.ibMainCategoryScopes)) {
                                    response.ibMainCategoryScopes.forEach(function(value) {
                                        // เพิ่ม option เข้าไปใน select
                                        selectMainBranch.append('<option value="' + value.id + '">' + value.name + '</option>');
                                    });
                                } else {
                                    // แจ้งเตือนหากข้อมูลไม่เป็นไปตามที่คาดหวัง
                                    console.warn("Expected response.ibMainCategoryScopes to be an array, but got:", response.ibMainCategoryScopes);
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error("Error fetching main categories:", status, error, xhr.responseText);
                            }
                        });
                        
                        ibItemModal.style.display = 'flex'; 
                        break;

                    case 'lab_cal': labCalItemModal.style.display = 'flex'; break;
                    case 'lab_test': labTestItemModal.style.display = 'flex'; break;
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


        $('#cb-isic').on('change', function() {    
            let isicDesciption = $(this).find('option:selected').text();
            let isicDesciptionEn = $(this).find('option:selected').data('desc_en');
            let isicCode = $(this).find('option:selected').data('isic_code');
            $('#cb-isic-description-editor').text(isicDesciption);
            $('#cb-isic-description-editor-en').text(isicDesciptionEn);
            $('#cb-isic-code').val(isicCode);
            cbItems.push($(this).find('option:selected').val());
        });

        $('#cb-enms').on('change', function() {    
            $('#cb-enms-description_th').text($(this).find('option:selected').text());
            $('#cb-enms-description_en').text($(this).find('option:selected').data('activity_en'));
            cbItems.push($(this).find('option:selected').val());
        });

        $('#cb-bcms').on('change', function() {    
            $('#cb-bcms-sector').text($(this).find('option:selected').data('sector'));
            $('#cb-bcms-description_th').text($(this).find('option:selected').text());
            $('#cb-bcms-description_en').text($(this).find('option:selected').data('description_en'));
            cbItems.push($(this).find('option:selected').val());

        });

        $('#cb-sfms').on('change', function() {    
            $('#cb-sfms-scope_th').text($(this).find('option:selected').text());  
            $('#cb-sfms-scope_en').text($(this).find('option:selected').data('scope_en'));
            $('#cb-sfms-activity_en').text($(this).find('option:selected').data('activity_en'));
            $('#cb-sfms-activity_th').text($(this).find('option:selected').data('activity_th'));  
            cbItems.push($(this).find('option:selected').val());
        });

        $('#cb-mdms').on('change', function() {    
            $('#cb-mdms-code').val($(this).find('option:selected').data('sector')); 
            $('#cb-mdms-description_en').text($(this).find('option:selected').data('description_en'));
            $('#cb-mdms-description_th').text($(this).find('option:selected').text());
            cbItems.push($(this).find('option:selected').val());
        });

        $('#cb-corsia').on('change', function() {       
            $('#cb-corsia-sector_en').text($(this).find('option:selected').data('sector_en'));
            $('#cb-corsia-scope_en').text($(this).find('option:selected').data('scope_en'));  
            $('#cb-corsia-sector_th').text($(this).find('option:selected').text());
            cbItems.push($(this).find('option:selected').val());
        });

        $('#cb-ohsms').on('change', function() {       
            $('#cb-ohsms-code').val($(this).find('option:selected').data('iaf_code'));
            $('#cb-ohsms-description_en').text($(this).find('option:selected').data('description_en'));  
            $('#cb-ohsms-description_th').text($(this).find('option:selected').text());
            cbItems.push($(this).find('option:selected').val());
        });


        // --- เพิ่มโค้ดส่วนนี้เพื่อจัดการเมื่อ ib-main-branch มีการเปลี่ยนแปลง ---
        $('#ib-main-branch').on('change', function() {
            const selectedMainBranchId = $(this).val(); // ได้ค่า id ของสาขาหลักที่เลือก

            const mainBranchText = $(this).find('option:selected').text();
            $('#ib-main-branch-editable').text(mainBranchText);
            // ตรวจสอบว่ามีการเลือกค่า (ไม่ใช้ค่าเริ่มต้น "--- เลือกสาขาการตรวจหลัก ---")
           if (selectedMainBranchId) {
             $.ajax({
                url: "{{ route('certi_ib.get-ib-main-category') }}",
                method: "POST",
                contentType: 'application/json',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                success: function(response) {
                    console.log("Response from get-ib-main-category:", response.ibMainCategoryScopes);
                    const selectSubMainBranch = $('#ib-sub-branch');
                    selectSubMainBranch.empty();
                    selectSubMainBranch.append('<option value="">==เลือกรายการ==</option>');

                    if (response.ibMainCategoryScopes && Array.isArray(response.ibMainCategoryScopes)) {
                        response.ibMainCategoryScopes.forEach(function(value) {
                            console.log(value)
                            selectSubMainBranch.append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    } else {
                        console.warn("Expected response.ibMainCategoryScopes to be an array, but got:", response.ibMainCategoryScopes);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching main categories:", status, error, xhr.responseText);
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
                    tableHTML += '<td style="vertical-align: top; text-align: left;"><br></td>';
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
        
        // === START: REVISED CB Item Button Logic ===
        document.getElementById('add-cb-isic-item-btn').addEventListener('click', () => {
            const targetRow = activeModalTargetRow;
            if (!targetRow) {
                alert("ไม่สามารถหาแถวเป้าหมายได้");
                closeModal(cbIsicScopeModal);
                return;
            }
            const cells = targetRow.cells;
            if (cells.length < 2) {
                alert("โครงสร้างตารางไม่ถูกต้อง (ต้องการอย่างน้อย 2 คอลัมน์)");
                closeModal(cbIsicScopeModal);
                return;
            }
            const code = $('#cb-isic-code').val();
            const cbIsicDescriptionLines = cbIsicDescriptionEditorExtractor.getLines();
            const description = cbIsicDescriptionLines.join('<br>');

            const cbIsicDescriptionEnLines = cbIsicDescriptionEditorExtractorEn.getLines();
            const descriptionEn = cbIsicDescriptionEnLines.join('<br>');

            const descriptionParts = [];
            if (description) {
                descriptionParts.push(description);
            }
            if (descriptionEn) {
                descriptionParts.push("<span style='font-size:16px'>("+descriptionEn+")</span>");
            }

            const combinedDescription = descriptionParts.join('<br>');
            appendToCell(cells[0], code);
            appendToCell(cells[1], combinedDescription);
            managePages();
            closeModal(cbIsicScopeModal);
        });
        // === END: REVISED CB Item Button Logic ===

        document.getElementById('add-cb-enms-item-btn').addEventListener('click', () => {
            const targetRow = activeModalTargetRow;
            if (!targetRow) {
                alert("ไม่สามารถหาแถวเป้าหมายได้");
                closeModal(cbEnmsScopeModal);
                return;
            }
            const cells = targetRow.cells;
            // if (cells.length < 2) {
            //     alert("โครงสร้างตารางไม่ถูกต้อง (ต้องการอย่างน้อย 2 คอลัมน์)");
            //     closeModal(cbEnmsScopeModal);
            //     return;
            // }
            const code = $('#cb-isic-code').val();
            const cbEnmsDescriptionEditorExtractorLines = cbEnmsDescriptionEditorExtractor.getLines();
            const cbEnmsDescriptionEditorExtractorText = cbEnmsDescriptionEditorExtractorLines.join('<br>');

            const cbEnmsDescriptionEditorExtractorEnLines = cbEnmsDescriptionEditorExtractorEn.getLines();
            const cbEnmsDescriptionEditorExtractorEnText = cbEnmsDescriptionEditorExtractorEnLines.join('<br>');

            const combinationArray = [];
            if (cbEnmsDescriptionEditorExtractorText) {
                combinationArray.push(cbEnmsDescriptionEditorExtractorText);
            }
            if (cbEnmsDescriptionEditorExtractorEnText) {
                combinationArray.push("<span style='font-size:16px'>("+cbEnmsDescriptionEditorExtractorEnText+")</span>");
            }

            const cell_0_Data = combinationArray.join('<br>');
            appendToCell(cells[0], cell_0_Data);

            managePages();
            closeModal(cbEnmsScopeModal);
        });

        document.getElementById('add-cb-bcms-item-btn').addEventListener('click', () => {
            const targetRow = activeModalTargetRow;
            if (!targetRow) {
                alert("ไม่สามารถหาแถวเป้าหมายได้");
                closeModal(cbBcmsScopeModal);
                return;
            }
            const cells = targetRow.cells;
            if (cells.length < 2) {
                alert("โครงสร้างตารางไม่ถูกต้อง (ต้องการอย่างน้อย 2 คอลัมน์)");
                closeModal(cbBcmsScopeModal);
                return;
            }
            const code = $('#cb-bcms-code').val();
            const cbBcmsSectorEditorExtractorLines = cbBcmsSectorEditorExtractor.getLines();
            const cbBcmsSectorEditorExtractorText = cbBcmsSectorEditorExtractorLines.join('<br>');

            const cbBcmsDescriptionEditorExtractorLines = cbBcmsDescriptionEditorExtractor.getLines();
            const cbBcmsDescriptionEditorExtractorText = cbBcmsDescriptionEditorExtractorLines.join('<br>');

            const cbBcmsDescriptionEditorExtractorEnLines = cbBcmsDescriptionEditorExtractorEn.getLines();
            const cbBcmsDescriptionEditorExtractorEnText = cbBcmsDescriptionEditorExtractorEnLines.join('<br>');


            const combinationArray = [];
            if (cbBcmsDescriptionEditorExtractorText) {
                combinationArray.push(cbBcmsDescriptionEditorExtractorText);
            }
            if (cbBcmsDescriptionEditorExtractorEnText) {
                combinationArray.push("<span style='font-size:16px'>("+cbBcmsDescriptionEditorExtractorEnText+")</span>");
            }

            const cell_1_Data = combinationArray.join('<br>');

            appendToCell(cells[0], cbBcmsSectorEditorExtractorText);
            appendToCell(cells[1], cell_1_Data);

            managePages();
            closeModal(cbBcmsScopeModal);
        });

        document.getElementById('add-cb-sfms-item-btn').addEventListener('click', () => {
            const targetRow = activeModalTargetRow;
            if (!targetRow) {
                alert("ไม่สามารถหาแถวเป้าหมายได้");
                closeModal(cbSfmsScopeModal);
                return;
            }
            const cells = targetRow.cells;
            if (cells.length < 2) {
                alert("โครงสร้างตารางไม่ถูกต้อง (ต้องการอย่างน้อย 2 คอลัมน์)");
                closeModal(cbSfmsScopeModal);
                return;
            }
            const code = $('#cb-sfms-code').val();
            const cbSfmsScopeEditorExtractorLines = cbSfmsScopeEditorExtractor.getLines();
            const cbSfmsScopeEditorExtractorText = cbSfmsScopeEditorExtractorLines.join('<br>');

            const cbSfmsScopeEditorExtractorEnLines = cbSfmsScopeEditorExtractorEn.getLines();
            const cbSfmsScopeEditorExtractorEnText = cbSfmsScopeEditorExtractorEnLines.join('<br>');

            const cbSfmsActivityEditorExtractorLines = cbSfmsActivityEditorExtractor.getLines();
            const cbSfmsActivityEditorExtractorText = cbSfmsActivityEditorExtractorLines.join('<br>');

            const cbSfmsActivityEditorExtractorEnLines = cbSfmsActivityEditorExtractorEn.getLines();
            const cbSfmsActivityEditorExtractorEnText = cbSfmsActivityEditorExtractorEnLines.join('<br>');


            const combinationArrayCell0 = [];
            const combinationArrayCell1 = [];
            if (cbSfmsScopeEditorExtractorText) {
                combinationArrayCell0.push(cbSfmsScopeEditorExtractorText);
            }
            if (cbSfmsScopeEditorExtractorEnText) {
                combinationArrayCell0.push("<span style='font-size:16px'>("+cbSfmsScopeEditorExtractorEnText+")</span>");
            }

            if (cbSfmsActivityEditorExtractorText) {
                combinationArrayCell1.push(cbSfmsActivityEditorExtractorText);
            }
            if (cbSfmsActivityEditorExtractorEnText) {
                combinationArrayCell1.push("<span style='font-size:16px'>("+cbSfmsActivityEditorExtractorEnText+")</span>");
            }

            const cell_0_Data = combinationArrayCell0.join('<br>');
            const cell_1_Data = combinationArrayCell1.join('<br>');

            appendToCell(cells[0], cell_0_Data);
            appendToCell(cells[1], cell_1_Data);

            managePages();
            closeModal(cbSfmsScopeModal);
        });

        document.getElementById('add-cb-mdms-item-btn').addEventListener('click', () => {
            const targetRow = activeModalTargetRow;
            if (!targetRow) {
                alert("ไม่สามารถหาแถวเป้าหมายได้");
                closeModal(cbMdmsScopeModal);
                return;
            }
            const cells = targetRow.cells;
            if (cells.length < 2) {
                alert("โครงสร้างตารางไม่ถูกต้อง (ต้องการอย่างน้อย 2 คอลัมน์)");
                closeModal(cbMdmsScopeModal);
                return;
            }
       
            const sectorText = $('#cb-mdms-code').val();

            const cbMdmsDescriptionEditorExtractorLines = cbMdmsDescriptionEditorExtractor.getLines();
            const cbMdmsDescriptionEditorExtractorText = cbMdmsDescriptionEditorExtractorLines.join('<br>');

            const cbMdmsDescriptionEditorExtractorEnLines = cbMdmsDescriptionEditorExtractorEn.getLines();
            const cbMdmsDescriptionEditorExtractorEnText = cbMdmsDescriptionEditorExtractorEnLines.join('<br>');


            const combinationArray = [];
            if (cbMdmsDescriptionEditorExtractorText) {
                combinationArray.push(cbMdmsDescriptionEditorExtractorText);
            }
            if (cbMdmsDescriptionEditorExtractorEnText) {
                combinationArray.push("<span style='font-size:16px'>("+cbMdmsDescriptionEditorExtractorEnText+")</span>");
            }

            const cell_1_Data = combinationArray.join('<br>');

            appendToCell(cells[0], sectorText);
            appendToCell(cells[1], cell_1_Data);

            managePages();
            closeModal(cbMdmsScopeModal);
        });

        document.getElementById('add-cb-corsia-item-btn').addEventListener('click', () => {
            const targetRow = activeModalTargetRow;
            if (!targetRow) {
                alert("ไม่สามารถหาแถวเป้าหมายได้");
                closeModal(cbCorsiaScopeModal);
                return;
            }
            const cells = targetRow.cells;
            if (cells.length < 2) {
                alert("โครงสร้างตารางไม่ถูกต้อง (ต้องการอย่างน้อย 2 คอลัมน์)");
                closeModal(cbCorsiaScopeModal);
                return;
            }

            const cbCorsiaSectorEditorExtractorLines = cbCorsiaSectorEditorExtractor.getLines();
            const cbCorsiaSectorEditorExtractorText = cbCorsiaSectorEditorExtractorLines.join('<br>');

            const cbCorsiaSectorEditorExtractorEnLines = cbCorsiaSectorEditorExtractorEn.getLines();
            const cbCorsiaSectorEditorExtractorEnText = cbCorsiaSectorEditorExtractorEnLines.join('<br>');

            const cbCorsiaScopeEditorExtractorEnLines = cbCorsiaScopeEditorExtractorEn.getLines();
            const cbCorsiaScopeEditorExtractorEnText = cbCorsiaScopeEditorExtractorEnLines.join('<br>');


            const combinationArray = [];
            if (cbCorsiaSectorEditorExtractorText) {
                combinationArray.push(cbCorsiaSectorEditorExtractorText);
            }
            if (cbCorsiaSectorEditorExtractorEnText) {
                combinationArray.push("<span style='font-size:16px'>("+cbCorsiaSectorEditorExtractorEnText+")</span>");
            }

            const cell_0_Data = combinationArray.join('<br>');

            appendToCell(cells[0], cell_0_Data);
            appendToCell(cells[1], cbCorsiaScopeEditorExtractorEnText);

            managePages();
            closeModal(cbCorsiaScopeModal);
        });

        document.getElementById('add-cb-ohsms-item-btn').addEventListener('click', () => {
            const targetRow = activeModalTargetRow;
            if (!targetRow) {
                alert("ไม่สามารถหาแถวเป้าหมายได้");
                closeModal(cbOhsmsScopeModal);
                return;
            }
            const cells = targetRow.cells;
            if (cells.length < 2) {
                alert("โครงสร้างตารางไม่ถูกต้อง (ต้องการอย่างน้อย 2 คอลัมน์)");
                closeModal(cbOhsmsScopeModal);
                return;
            }

            const iafText = $('#cb-ohsms-code').val();

            const cbOhsmsDescriptionEditorExtractorLines = cbOhsmsDescriptionEditorExtractor.getLines();
            const cbOhsmsDescriptionEditorExtractorText = cbOhsmsDescriptionEditorExtractorLines.join('<br>');

            const cbOhsmsDescriptionEditorExtractorEnLines = cbOhsmsDescriptionEditorExtractorEn.getLines();
            const cbOhsmsDescriptionEditorExtractorEnText = cbOhsmsDescriptionEditorExtractorEnLines.join('<br>');


            const combinationArray = [];
            if (cbOhsmsDescriptionEditorExtractorText) {
                combinationArray.push(cbOhsmsDescriptionEditorExtractorText);
            }
            if (cbOhsmsDescriptionEditorExtractorEnText) {
                combinationArray.push("<span style='font-size:16px'>("+cbOhsmsDescriptionEditorExtractorEnText+")</span>");
            }

            const cell_1_Data = combinationArray.join('<br>');

            appendToCell(cells[0], iafText);
            appendToCell(cells[1], cell_1_Data);

            managePages();
            closeModal(cbOhsmsScopeModal);
        });


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
            // const mainBranch = document.getElementById('ib-main-branch  option:selected').text();
             const mainBranchValue = $('#ib-main-branch').val();
             const subBranchValue = $('#ib-sub-branch').val();
             const mainScopeValue = $('#ib-main-scope').val();
             const subScopeValue = $('#ib-sub-scope').val();

            const mainBranchRaw = $('#ib-main-branch option:selected').text().trim();;
            const subBranchRaw = $('#ib-sub-branch option:selected').text().trim();;

            const mainBranchLines = ibSubBranchExtractor.getLines();
            const mainBranch = mainBranchLines.map(line => line ? '&nbsp;' + line : '').join('<br>');

            const subBranchLines = ibSubBranchExtractor.getLines();
            const subBranch = subBranchLines.map(line => line ? '&nbsp;' + line : '').join('<br>');

            const mainScopeLines = ibMainScopeExtractor.getLines();
            const mainScope = mainScopeLines.map(line => line ? '&nbsp;' + line : '').join('<br>');

            const subScopeLines = ibSubScopeExtractor.getLines();
            const subScope = subScopeLines.map(line => line ? '&nbsp;' + line : '').join('<br>');

            const requirementsLines = ibRequirementsExtractor.getLines();
            const requirements = requirementsLines.join('<br>');

            // --- Cell 1: Main/Sub Branch ---
            const cell1Parts = [];
            if (mainBranch) cell1Parts.push(mainBranch);
            // if (subBranch && subBranch != "==เลือกรายการ==") cell1Parts.push(subBranch);
           
            if (subBranch && subBranch != "==เลือกรายการ==" && mainBranchRaw != subBranchRaw) {
                cell1Parts.push(subBranch);
            }

            let cell1Content = cell1Parts.join('<br>');

             console.log(cell1Content);
            cell1Content = processCellText(cell1Content);
            appendToCell(cells[0], cell1Content);

            // --- Cell 2: Main/Sub Scope ---
            const cell2Parts = [];
            if (mainScope && mainScope != "==เลือกรายการ==") cell2Parts.push(mainScope);
            if (subScope && subScope != "==เลือกรายการ==") cell2Parts.push(subScope);
            const cell2Content = cell2Parts.join('<br>');
            appendToCell(cells[1], cell2Content);

            // --- Cell 3: Requirements ---
            if (requirements) {
                appendToCell(cells[2], requirements);
            }

            const newItem = {
                mainBranchValue: mainBranchValue,
                subBranchValue: subBranchValue,
                mainScopeValue: mainScopeValue,
                subScopeValue: subScopeValue,
            };

            // 2. เพิ่ม object ใหม่เข้าไปใน array `labCalItems`
            ibItems.push(newItem);


            managePages();
            closeModal(ibItemModal);
        });

        function processCellText(cellContent) {
            // 1. แยกสตริงด้วย <br>
            const parts = cellContent.split('<br>');

            // 2. ถ้าไม่มี <br> (มีแค่ 1 ส่วน) ให้คืนค่าเดิมกลับไปเลย
            if (parts.length !== 2) {
                return cellContent;
            }

            // 3. ทำความสะอาดข้อความเพื่อใช้ในการเปรียบเทียบ
            const textBefore = parts[0].replace(/&nbsp;/g, ' ').trim();
            const textAfter = parts[1].replace(/&nbsp;/g, ' ').trim();

            // 4. เปรียบเทียบและคืนค่าตามเงื่อนไข
            if (textBefore === textAfter) {
                // ถ้าซ้ำกัน: คืนค่าเฉพาะข้อความก่อน <br> ที่ทำความสะอาดแล้ว
                return textBefore;
            } else {
                // ถ้าไม่ซ้ำ: คืนค่าสตริงดั้งเดิมทั้งหมด
                return cellContent;
            }
        }

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

            // Get values from modal and trim them
            // const field = document.getElementById('lab-cal-field').value.trim();
            const field = $('#lab-cal-field option:selected').text();
            const instrument = $('#lab-cal-instrument option:selected').text();
            // const instrument = document.getElementById('lab-cal-instrument').value.trim();
            const parameter = $('#lab-cal-parameter option:selected').text();
            // const parameter = document.getElementById('lab-cal-parameter').value.trim();
            const condition = document.getElementById('lab-cal-condition').value.trim();

            console.log(field)
            
            // Get values from editable divs using LineExtractor
            const paramDetailsLines = labCalParamDetailsEditorExtractor.getLines();
            const paramDetails = paramDetailsLines.map(line => line ? '&nbsp;&nbsp;&nbsp;' + line : '').join('<br>');

            const capabilityLines = labCalCapabilityEditorExtractor.getLines();
            const capability = capabilityLines.map(line => line ? '&nbsp;&nbsp;&nbsp;' + line : '').join('<br>');
            
            const methodLines = labCalMethodEditorExtractor.getLines();
            const method = methodLines.join('<br>');
            
            // --- Field (cells[0]) Logic ---
            if (field && !cells[0].textContent.trim()) {
                cells[0].innerHTML = field;
            }

            // --- Parameter Column (cells[1]) Logic ---
            const parameterParts = [];
            if (instrument) {
                parameterParts.push(instrument);
            }
            if (parameter) {
                parameterParts.push('&nbsp;' + parameter);
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

            // Get values from modal inputs
            const field = document.getElementById('lab-test-field').value.trim();
            const category = document.getElementById('lab-test-category').value.trim();
            const parameter = document.getElementById('lab-test-parameter').value.trim();
            const description = document.getElementById('lab-test-description-editor').value.trim();

            const paramDetailsLines = labTestParamDetailsEditorExtractor.getLines();
            const paramDetails = paramDetailsLines.map(line => line ? '&nbsp;&nbsp;&nbsp;' + line : '').join('<br>');
            
            const methodLines = labTestMethodEditorExtractor.getLines();
            const method = methodLines.join('<br>');
            
            // --- Cell 1 Logic: Field and Category ---
            const cell1Parts = [];
            if (field) cell1Parts.push(field);
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


                console.log(pagesContent);

                fetch("{!! route('certi_cb.save-html-template') !!}" , {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        html_pages: pagesContent,
                        template_type: templateType,
                        cbItems: cbItems,
                        typeStandard: typeStandardData,
                        petitioner: petitionerData,
                        trustMark: trustMarkData,
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
            downloadTemplate();
        }

        function downloadTemplate()
        {
            fetch("{!! route('certi_cb.download-html-template') !!}" , {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    typeStandard: typeStandardData,
                    petitioner: petitionerData,
                    trustMark: trustMarkData
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

                    if (data.htmlTemplate && data.htmlTemplate.template_type === "ib") {
                        try {
                            const jsonData = JSON.parse(data.htmlTemplate.json_data);
                            jsonData.forEach(item => {
           
                                // const newItem = {
                                //     mainBranchValue: item.mainBranchValue,
                                //     subBranchValue: item.subBranchValue,
                                //     mainScopeValue: item.mainScopeValue,
                                //     subScopeValue: item.subScopeValue
                                // };
                                
                                cbItems.push(item);
                            });
                            console.log('cbItems:', cbItems);
                        } catch (error) {
                            console.error("Error parsing json_data for ib:", error);
                        }
                    }
                
                } 
                
            });
        }

        // === START: MODIFICATION FOR LineExtractor INSTANCES ===
        // Instantiate LineExtractor for all editable divs in the modals
        const cbCodeEditorExtractor = new LineExtractor('cb-code-editor');
        const cbIsicDescriptionEditorExtractor = new LineExtractor('cb-isic-description-editor');
        const cbIsicDescriptionEditorExtractorEn = new LineExtractor('cb-isic-description-editor-en');

        const cbEnmsDescriptionEditorExtractor = new LineExtractor('cb-enms-description_th');
        const cbEnmsDescriptionEditorExtractorEn = new LineExtractor('cb-enms-description_en');

        const cbBcmsSectorEditorExtractor = new LineExtractor('cb-bcms-sector');
        const cbBcmsDescriptionEditorExtractor = new LineExtractor('cb-bcms-description_th');
        const cbBcmsDescriptionEditorExtractorEn = new LineExtractor('cb-bcms-description_en');

        const cbSfmsScopeEditorExtractor = new LineExtractor('cb-sfms-scope_th');
        const cbSfmsScopeEditorExtractorEn = new LineExtractor('cb-sfms-scope_en');
        const cbSfmsActivityEditorExtractor = new LineExtractor('cb-sfms-activity_th');
        const cbSfmsActivityEditorExtractorEn = new LineExtractor('cb-sfms-activity_en');

        const cbMdmsDescriptionEditorExtractor = new LineExtractor('cb-mdms-description_th');
        const cbMdmsDescriptionEditorExtractorEn = new LineExtractor('cb-mdms-description_en');

        const cbCorsiaSectorEditorExtractor = new LineExtractor('cb-corsia-sector_th');
        const cbCorsiaSectorEditorExtractorEn = new LineExtractor('cb-corsia-sector_en');
        const cbCorsiaScopeEditorExtractorEn = new LineExtractor('cb-corsia-scope_en');

        const cbOhsmsDescriptionEditorExtractor = new LineExtractor('cb-ohsms-description_th');
        const cbOhsmsDescriptionEditorExtractorEn = new LineExtractor('cb-ohsms-description_en');

        const labCalMethodEditorExtractor = new LineExtractor('lab-cal-method-editor');
        const labCalParamDetailsEditorExtractor = new LineExtractor('lab-cal-param-details-editor');
        const labCalCapabilityEditorExtractor = new LineExtractor('lab-cal-capability-editor');
        const labTestParamDetailsEditorExtractor = new LineExtractor('lab-test-param-details-editor');
        const labTestMethodEditorExtractor = new LineExtractor('lab-test-method-editor');
        
        // New extractors for the modified IB modal
        const ibSubBranchExtractor = new LineExtractor('ib-sub-branch-editable');
        const ibMainBranchExtractor = new LineExtractor('ib-main-branch-editable');
        const ibMainScopeExtractor = new LineExtractor('ib-main-scope-editable');
        const ibSubScopeExtractor = new LineExtractor('ib-sub-scope-editable');
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
