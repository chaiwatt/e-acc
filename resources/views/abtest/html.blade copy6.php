<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Google Docs</title>
      <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    {{-- <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@400;700&display=swap" rel="stylesheet"> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" xintegrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>

        @font-face {
            font-family: 'thsarabunnew';
            src: url('/fonts/THSarabunNew.ttf') format('truetype');
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
            height: 30.5cm;
            padding: 1cm;
            margin-bottom: 1cm;
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
            content: "พิมพ์ที่นี่...";
            color: #aaa;
            pointer-events: none;
        }
        
        /* --- Table Styling --- */
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
            border: 0.1px solid #050505;
            padding: 8px;
            min-width: 50px;
            vertical-align: top;
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
            width: 300px;
            font-size: 22px;
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
        
        .modal-input-group input[type="number"] {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
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
        }

        .context-menu-item {
            padding: 4px 16px;
            cursor: pointer;
            font-size: 22px;
        }

        .context-menu-item:hover {
            background-color: #f0f0f0;
        }
    </style>
</head>
<body>
    <div id="menubar">
        <button class="menu-button" data-command="bold" title="ตัวหนา"><i class="fas fa-bold"></i></button>
        <button class="menu-button" data-command="italic" title="ตัวเอียง"><i class="fas fa-italic"></i></button>
        <div class="separator"></div>
        <button class="menu-button" data-command="increaseFontSize" title="เพิ่มขนาดฟอนต์"><i class="fas fa-plus"></i></button>
        <button class="menu-button" data-command="decreaseFontSize" title="ลดขนาดฟอนต์"><i class="fas fa-minus"></i></button>
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
                <a href="#" data-template="cb-template" >CB template</a>
                <a href="#" data-template="lab-cal-template" >Cal Lab template</a>
                <a href="#" data-template="lab-test-template" >Test Lab template</a>
                </div>
        </div>
        
        <button class="menu-button" id="export-pdf-button" title="ส่งออกเป็น PDF"><i class="fas fa-file-pdf"></i></button>
    </div>

    <input type="file" id="image-input" accept="image/*" style="display: none;">

    <div id="editor-container">
        <div id="document-editor">
            <div class="page" contenteditable="true"></div>
        </div>
    </div>

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
                <button id="cancel-table-btn" class="modal-btn-cancel">ยกเลิก</button>
            </div>
        </div>
    </div>

    <div id="context-menu">
        <div class="context-menu-item" data-action="insert-row-above">แทรกแถวด้านบน</div>
        <div class="context-menu-item" data-action="insert-row-below">แทรกแถวด้านล่าง</div>
        <div class="context-menu-item" data-action="insert-column-left">แทรกคอลัมน์ด้านซ้าย</div>
        <div class="context-menu-item" data-action="insert-column-right">แทรกคอลัมน์ด้านขวา</div>
        <div class="context-menu-item" data-action="delete-row">ลบแถว</div>
        <div class="context-menu-item" data-action="delete-column">ลบคอลัมน์</div>
    </div>

    <script>
        document.execCommand('styleWithCSS', false, true);

        // --- DOM Elements ---
        const editor = document.getElementById('document-editor');
        const menubar = document.getElementById('menubar');
        const tableModalOverlay = document.getElementById('table-modal-overlay');
        const insertTableBtn = document.getElementById('insert-table-btn');
        const cancelTableBtn = document.getElementById('cancel-table-btn');
        const tableRowsInput = document.getElementById('table-rows');
        const tableColsInput = document.getElementById('table-cols');
        const tableBorderToggle = document.getElementById('table-border-toggle');
        const imageInput = document.getElementById('image-input');
        const contextMenu = document.getElementById('context-menu');
        const templateDropdownButton = document.getElementById('template-dropdown-button');
        const templateDropdownContent = document.querySelector('.dropdown-content');
        const exportPdfButton = document.getElementById('export-pdf-button');

        let savedRange = null;
        let contextMenuTarget = null;

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

            const newRangeToRestore = window.getSelection().getRangeAt(0).cloneRange();

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
            selection.addRange(newRangeToRestore);
        };

        // --- Menubar Functionality ---
        menubar.addEventListener('click', (event) => {
            const button = event.target.closest('.menu-button');
            if (!button) return;
            const command = button.dataset.command;
            
            if (button.id !== 'template-dropdown-button') {
                templateDropdownContent.parentElement.classList.remove('show');
            }

            if (command === 'increaseFontSize' || command === 'decreaseFontSize') {
                changeFontSize(command);
            } else if (command === 'increaseLineHeight' || command === 'decreaseLineHeight') {
                changeLineHeight(command);
            } else if (command === 'insertTable') {
                insertTable();
            } else if (command === 'insertImage') {
                // Save selection before opening file dialog
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
        
        templateDropdownButton.addEventListener('click', (event) => {
            event.stopPropagation();
            templateDropdownContent.parentElement.classList.toggle('show');
        });

        templateDropdownContent.addEventListener('click', (event) => {
            const templateItem = event.target.closest('a[data-template]');
            if (templateItem) {
                event.preventDefault();
                const templateType = templateItem.dataset.template;
                if (templateType === 'cb-template') {
                    insertCbTemplate();
                } else if (templateType === 'lab-cal-template') {
                    insertLabCalTemplate();
                } else if (templateType === 'lab-test-template') {
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


        const changeFontSize = (direction) => {
            applyStyleToSelectedSpans((element) => {
                const currentSizeStyle = element.style.fontSize;
                const computedSize = parseFloat(window.getComputedStyle(element).fontSize);
                let currentSize = currentSizeStyle ? parseFloat(currentSizeStyle) : computedSize;

                const newSize = (direction === 'increaseFontSize') 
                    ? currentSize + 2 
                    : currentSize - 2;
                
                if (newSize >= 8 && newSize <= 72) {
                    element.style.fontSize = newSize + 'px';
                }
            });
        };

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
        
        const insertCbTemplate = () => {
            const templateData = {
                scopeOfAccreditation: {
                    th: "สาขาและขอบข่ายการรับรองระบบงาน",
                    en: "Scope of Accreditation"
                },
                attachmentToCertificate: {
                    th: "แนบท้ายใบรับรองระบบงาน : หน่วยรับรองระบบงานการจัดการคุณภาพ",
                    en: "Attachment to Certificate of Quality Management System Certification Body Accreditation"
                },
                certificateNo: "24-CB0003",
                certificationBody: {
                    th: "สถาบันวิจัยวิทยาศาสตร์และเทคโนโลยีแห่งประเทศไทย สำนักรับรองระบบคุณภาพ",
                    en: "Thailand Institute of Scientific and Technological Research, Office of Certification Body"
                },
                premise: {
                    th: "35 หมู่ 3 เทคโนธานี ตำบลคลองห้า อำเภอคลองหลวง จังหวัดปทุมธานี",
                    en: "35 Moo 3 Technopolis, Tambon Klong 5, Amphoe Khlong Luang, Pathum Thani"
                },
                accreditationCriteria: [
                    { th: "ISO/IEC 17021-1:2015 (มอก. 17021-1-2559)", en: "ISO 17021-3:2017 (มอก. 17021-3-2562)" },
                ],
                certificationMark: {
                    th: "การรับรองระบบบริหารงานคุณภาพตามมาตรฐาน ISO 9001/มอก.9001 โดยมีสาขาและ<br>ขอบข่ายตามมาตรฐานการจัดประเภทอุตสาหกรรมตามกิจกรรมทางเศรษฐกิจทุกประเภท<br>ตามมาตรฐานสากล (ISIC) มอก.2000-2540 ดังต่อไปนี้",
                    en: "Quality Management system Certification according to ISO 9001/TIS 9001, covered by International Standard industrial classification of all economic activities (ISIC) according to TIS 2000-2540 as following"
                },
                isicCodes: [
                    { code: "15", description_th: "การผลิตผลิตภัณฑ์อาหารและเครื่องดื่ม", description_en: "Manufacture of food products and beverages" },
                    { code: "24(ยกเว้น 2423)", description_th: "การผลิตสารเคมีและผลิตภัณฑ์เคมี", description_en: "Manufacture of chemicals and chemical products" }
                ]
            };

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
                    <span style="font-size: 15px;">(${templateData.attachmentToCertificate.en})</span><br>
                    ใบรับรองเลขที่ ${templateData.certificateNo}<br>
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
                <table style="width: 100%; margin-bottom: 1em;">
                    <thead>
                        <tr>
                            <th>รหัส ISIC<br><span style="font-size: 15px;">(ISIC Codes)</span></th>
                            <th>กิจกรรม<br><span style="font-size: 15px;">(Description)</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        ${isicTableRows}
                    </tbody>
                </table>
                <p><br></p>
            `;
            (editor.querySelector('.page:focus') || editor.querySelector('.page'))?.focus();
            document.execCommand('insertHTML', false, templateHTML);
        };
        
        const insertLabCalTemplate = () => {
            const templateData = {
                title: {
                    th: "รายละเอียดสาขาและขอบข่ายใบรับรองห้องปฏิบัติการ",
                    en: "Scope of Accreditation for Calibration"
                },
                certificateNo: "21-LB0036",
                labName: {
                    th: "บริษัท ไออาร์ซี เทคโนโลยีส์ จำกัด",
                    en: "IRC Technologies Co.,Ltd."
                },
                accreditationNo: {
                    th: "สอบเทียบ 0203",
                    en: "Calibration 0203"
                },
                issueNo: "01",
                validFrom: {
                    th: "ออกให้ตั้งแต่วันที่ 2 กันยายน 2564",
                    en: "2nd September 2021"
                },
                until: {
                    th: "ถึงวันที่ 1 กันยายน 2569",
                    en: "1st September 2026"
                },
                calibrationData: [
                    {
                        field: { th: "ไฟฟ้า", en: "Electrical" },
                        parameter: "Measuring instrument<br>DC voltage<br>0 mV to < 220 mV<br>0.22 V to < 2.2 V<br>2.2 V to < 11 V",
                        capability: "8.0 &mu;V/V + 1.8 &mu;V<br>7.0 &mu;V/V + 7.3 &mu;V<br>7.0 &mu;V/V + 8.1 &mu;V",
                        method: "In-house method :<br>CP-01DCV by direct<br>measurement with<br>multifunction calibrator"
                    }
                ]
            };

            let calibrationTableRows = '';
            templateData.calibrationData.forEach(item => {
                calibrationTableRows += `
                    <tr>
                        <td style="text-align: left;">${item.field.th}<br><span style="font-size: 15px;">(${item.field.en})</span></td>
                        <td style="text-align: left;">${item.parameter}</td>
                        <td style="text-align: left;">${item.capability}</td>
                        <td style="text-align: left;">${item.method}</td>
                    </tr>
                `;
            });

            const templateHTML = `
                <div style="text-align: center; line-height: 1.1; position: relative; padding-top: 50px; margin-bottom: 0em;">
                    <b style="font-size: 20px;">${templateData.title.th}</b><br>
                    <span style="font-size: 15px;">(${templateData.title.en})</span><br>
                    ใบรับรองเลขที่ ${templateData.certificateNo}<br>
                    <span style="font-size: 15px;">(Certification no. ${templateData.certificateNo})</span>
                </div>
                <table class="borderless" style="width: 100%; margin-bottom: 1em;">
                    <tbody>
                        <tr>
                            <td class="vertical-align-top" style="width: 25%;"><b>ชื่อห้องปฏิบัติการ</b><br><span style="font-size: 15px;">(Laboratory Name)</span></td>
                            <td class="vertical-align-top" colspan="3">${templateData.labName.th}<br><span style="font-size: 15px;">(${templateData.labName.en})</span></td>
                        </tr>
                        <tr>
                            <td class="vertical-align-top"><b>หมายเลขการรับรองที่</b><br><span style="font-size: 15px;">(Accreditation No.)</span></td>
                            <td class="vertical-align-top" colspan="3">${templateData.accreditationNo.th}<br><span style="font-size: 15px;">(${templateData.accreditationNo.en})</span></td>
                        </tr>
                         <tr>
                            <td class="vertical-align-top"><b>ฉบับที่</b><br><span style="font-size: 15px;">(Issue No.)</span></td>
                            <td class="vertical-align-top" colspan="3">${templateData.issueNo}</td>
                        </tr>
                        <tr>
                            <td class="vertical-align-top" style="width: 25%;"><b>ออกให้ตั้งแต่วันที่</b><br><span style="font-size: 15px;">(Valid from)</span></td>
                            <td class="vertical-align-top" style="width: 35%;">${templateData.validFrom.th}<br><span style="font-size: 15px;">(${templateData.validFrom.en})</span></td>
                            <td class="vertical-align-top" style="width: 15%;"><b>ถึงวันที่</b><br><span style="font-size: 15px;">(Until)</span></td>
                            <td class="vertical-align-top" style="width: 25%;">${templateData.until.th}<br><span style="font-size: 15px;">(${templateData.until.en})</span></td>
                        </tr>
                        <tr>
                            <td class="vertical-align-top"><b>สถานภาพห้องปฏิบัติการ</b><br><span style="font-size: 15px;">(Laboratory status)</span></td>
                            <td class="vertical-align-top" colspan="3">
                                <table class="borderless" style="width: 100%; margin: 0; font-size: 18px; table-layout: fixed;">
                                    <tbody>
                                        <tr>
                                            <td style="padding: 0; vertical-align: top; white-space: nowrap;">
                                                <input type="checkbox" checked="checked" style="vertical-align: middle; margin-right: 5px;">
                                                <span style="line-height: 1.2;">ถาวร<br><span style="font-size: 15px;">(Permanent)</span></span>
                                            </td>
                                            <td style="padding: 0; vertical-align: top; white-space: nowrap;">
                                                <input type="checkbox" style="vertical-align: middle; margin-right: 5px;">
                                                <span style="line-height: 1.2;">นอกสถานที่<br><span style="font-size: 15px;">(Site)</span></span>
                                            </td>
                                            <td style="padding: 0; vertical-align: top; white-space: nowrap;">
                                                <input type="checkbox" style="vertical-align: middle; margin-right: 5px;">
                                                <span style="line-height: 1.2;">ชั่วคราว<br><span style="font-size: 15px;">(Temporary)</span></span>
                                            </td>
                                            <td style="padding: 0; vertical-align: top; white-space: nowrap;">
                                                <input type="checkbox" style="vertical-align: middle; margin-right: 5px;">
                                                <span style="line-height: 1.2;">เคลื่อนที่<br><span style="font-size: 15px;">(Mobile)</span></span>
                                            </td>
                                            <td style="padding: 0; vertical-align: top; white-space: nowrap;">
                                                <input type="checkbox" style="vertical-align: middle; margin-right: 5px;">
                                                <span style="line-height: 1.2;">หลายสาขา<br><span style="font-size: 15px;">(Multisite)</span></span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table style="width: 100%; margin-bottom: 1em;">
                     <thead>
                        <tr>
                            <th style="width: 20%; text-align: center;">สาขาการสอบเทียบ<br><span style="font-size: 15px;">(Field of Calibration)</span></th>
                            <th style="width: 30%; text-align: center;">รายการสอบเทียบ<br><span style="font-size: 15px;">(Parameter)</span></th>
                            <th style="text-align: center;">ขีดความสามารถของ<br>การสอบเทียบและการวัด*<br><span style="font-size: 15px;">(Calibration and Measurement<br>Capability*)</span></th>
                            <th style="text-align: center;">วิธีการสอบเทียบ<br><span style="font-size: 15px;">(Calibration Method)</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        ${calibrationTableRows}
                    </tbody>
                </table>
                <p><br></p>
            `;

            (editor.querySelector('.page:focus') || editor.querySelector('.page'))?.focus();
            document.execCommand('insertHTML', false, templateHTML);
        };

        const insertLabTestTemplate = () => {
            const templateData = {
                title: {
                    th: "รายละเอียดสาขาและขอบข่ายใบรับรองห้องปฏิบัติการ",
                    en: "Scope of Accreditation for Calibration"
                },
                certificateNo: "21-LB0036",
                labName: {
                    th: "บริษัท ไออาร์ซี เทคโนโลยีส์ จำกัด",
                    en: "IRC Technologies Co.,Ltd."
                },
                accreditationNo: {
                    th: "สอบเทียบ 0203",
                    en: "Calibration 0203"
                },
                issueNo: "01",
                validFrom: {
                    th: "ออกให้ตั้งแต่วันที่ 2 กันยายน 2564",
                    en: "2nd September 2021"
                },
                until: {
                    th: "ถึงวันที่ 1 กันยายน 2569",
                    en: "1st September 2026"
                },
                testLabData: [
                    {
                        field: { th: "สาขาโยธา", en: "(Civil field)" },
                        parameter: "ความละเอียดโดยเครื่องแอร์เพอร์มีอะบิลิตี<br>(Fineness by air-permeability)",
                        method: "มอก. 2752 เล่ม 6-2562 (วิธี A)<br>(TIS 2752 Part 6-2562 (2019) (Method A))<br>-ASTM C204-18Ɛ1 (Method A)"
                    }
                ]
            };

            let testTableRows = '';
            templateData.testLabData.forEach(item => {
                testTableRows += `
                    <tr>
                        <td style="text-align: left;">${item.field.th}<br><span style="font-size: 15px;">(${item.field.en})</span></td>
                        <td style="text-align: left;">${item.parameter}</td>
                        <td style="text-align: left;">${item.method}</td>
                    </tr>
                `;
            });

            const templateHTML = `
                <div style="text-align: center; line-height: 1.1; position: relative; padding-top: 50px; margin-bottom: 0em;">
                    <b style="font-size: 20px;">${templateData.title.th}</b><br>
                    <span style="font-size: 15px;">(${templateData.title.en})</span><br>
                    ใบรับรองเลขที่ ${templateData.certificateNo}<br>
                    <span style="font-size: 15px;">(Certification no. ${templateData.certificateNo})</span>
                </div>
                <table class="borderless" style="width: 100%; margin-bottom: 1em;">
                    <tbody>
                        <tr>
                            <td class="vertical-align-top" style="width: 25%;"><b>ชื่อห้องปฏิบัติการ</b><br><span style="font-size: 15px;">(Laboratory Name)</span></td>
                            <td class="vertical-align-top" colspan="3">${templateData.labName.th}<br><span style="font-size: 15px;">(${templateData.labName.en})</span></td>
                        </tr>
                        <tr>
                            <td class="vertical-align-top"><b>หมายเลขการรับรองที่</b><br><span style="font-size: 15px;">(Accreditation No.)</span></td>
                            <td class="vertical-align-top" colspan="3">${templateData.accreditationNo.th}<br><span style="font-size: 15px;">(${templateData.accreditationNo.en})</span></td>
                        </tr>
                         <tr>
                            <td class="vertical-align-top"><b>ฉบับที่</b><br><span style="font-size: 15px;">(Issue No.)</span></td>
                            <td class="vertical-align-top" colspan="3">${templateData.issueNo}</td>
                        </tr>
                        <tr>
                            <td class="vertical-align-top" style="width: 25%;"><b>ออกให้ตั้งแต่วันที่</b><br><span style="font-size: 15px;">(Valid from)</span></td>
                            <td class="vertical-align-top" style="width: 35%;">${templateData.validFrom.th}<br><span style="font-size: 15px;">(${templateData.validFrom.en})</span></td>
                            <td class="vertical-align-top" style="width: 15%;"><b>ถึงวันที่</b><br><span style="font-size: 15px;">(Until)</span></td>
                            <td class="vertical-align-top" style="width: 25%;">${templateData.until.th}<br><span style="font-size: 15px;">(${templateData.until.en})</span></td>
                        </tr>
                        <tr>
                            <td class="vertical-align-top"><b>สถานภาพห้องปฏิบัติการ</b><br><span style="font-size: 15px;">(Laboratory status)</span></td>
                            <td class="vertical-align-top" colspan="3">
                                <table class="borderless" style="width: 100%; margin: 0; font-size: 18px; table-layout: fixed;">
                                    <tbody>
                                        <tr>
                                            <td style="padding: 0; vertical-align: top; white-space: nowrap;">
                                                <input type="checkbox" checked="checked" style="vertical-align: middle; margin-right: 5px;">
                                                <span style="line-height: 1.2;">ถาวร<br><span style="font-size: 15px;">(Permanent)</span></span>
                                            </td>
                                            <td style="padding: 0; vertical-align: top; white-space: nowrap;">
                                                <input type="checkbox" style="vertical-align: middle; margin-right: 5px;">
                                                <span style="line-height: 1.2;">นอกสถานที่<br><span style="font-size: 15px;">(Site)</span></span>
                                            </td>
                                            <td style="padding: 0; vertical-align: top; white-space: nowrap;">
                                                <input type="checkbox" style="vertical-align: middle; margin-right: 5px;">
                                                <span style="line-height: 1.2;">ชั่วคราว<br><span style="font-size: 15px;">(Temporary)</span></span>
                                            </td>
                                            <td style="padding: 0; vertical-align: top; white-space: nowrap;">
                                                <input type="checkbox" style="vertical-align: middle; margin-right: 5px;">
                                                <span style="line-height: 1.2;">เคลื่อนที่<br><span style="font-size: 15px;">(Mobile)</span></span>
                                            </td>
                                            <td style="padding: 0; vertical-align: top; white-space: nowrap;">
                                                <input type="checkbox" style="vertical-align: middle; margin-right: 5px;">
                                                <span style="line-height: 1.2;">หลายสาขา<br><span style="font-size: 15px;">(Multisite)</span></span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table style="width: 100%; margin-bottom: 1em;">
                     <thead>
                        <tr>
                            <th style="width: 25%; text-align: center;">สาขาการทดสอบ<br><span style="font-size: 15px;">(Field of Testing)</span></th>
                            <th style="width: 35%; text-align: center;">รายการทดสอบ<br><span style="font-size: 15px;">(Parameter)</span></th>
                            <th style="text-align: center;">วิธีทดสอบ<br><span style="font-size: 15px;">(Test Method)</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        ${testTableRows}
                    </tbody>
                </table>
                <p><br></p>
            `;

            (editor.querySelector('.page:focus') || editor.querySelector('.page'))?.focus();
            document.execCommand('insertHTML', false, templateHTML);
        };


        const updateMenubarState = () => {
             const commands = ['bold', 'italic', 'justifyLeft', 'justifyCenter', 'justifyRight'];
             commands.forEach(command => {
                 const button = menubar.querySelector(`[data-command="${command}"]`);
                 if (button) {
                     if (document.queryCommandState(command)) button.classList.add('active');
                     else button.classList.remove('active');
                 }
             });
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

        // --- Image Insertion and Manipulation (Revised) ---
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

        // --- Table Row/Column Manipulation ---
        function insertTableRow(table, rowIndex, above = true) {
            const row = table.insertRow(above ? rowIndex : rowIndex + 1);
            const colCount = table.rows[0].cells.length;
            for (let i = 0; i < colCount; i++) {
                const cell = row.insertCell();
                cell.style.verticalAlign = 'top';
                cell.style.textAlign = 'left';
                cell.innerHTML = '<br>';
            }
            managePages();
        }

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

        // --- Context Menu for Table ---
        function showContextMenu(event, cell) {
            event.preventDefault();
            contextMenuTarget = cell;
            contextMenu.style.display = 'block';
            contextMenu.style.left = `${event.pageX}px`;
            contextMenu.style.top = `${event.pageY}px`;
        }

        function hideContextMenu() {
            contextMenu.style.display = 'none';
            contextMenuTarget = null;
        }

        editor.addEventListener('contextmenu', (event) => {
            const cell = event.target.closest('td, th');
            if (cell) {
                showContextMenu(event, cell);
            } else {
                hideContextMenu();
            }
        });

        contextMenu.addEventListener('click', (event) => {
            const action = event.target.dataset.action;
            if (!action || !contextMenuTarget) return;

            const table = contextMenuTarget.closest('table');
            const row = contextMenuTarget.closest('tr');
            const rowIndex = Array.from(table.rows).indexOf(row);
            const colIndex = Array.from(row.cells).indexOf(contextMenuTarget);

            switch (action) {
                case 'insert-row-above':
                    insertTableRow(table, rowIndex, true);
                    break;
                case 'insert-row-below':
                    insertTableRow(table, rowIndex, false);
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

            hideContextMenu();
            const activePage = table.closest('.page');
            activePage.focus();
        });

        document.addEventListener('click', (event) => {
            if (!contextMenu.contains(event.target)) {
                hideContextMenu();
            }
        });

        // --- Event Listeners ---
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

        document.addEventListener('mousedown', (event) => {
            if (!event.target.closest('.image-container')) {
                document.querySelectorAll('.image-container.active').forEach(el => {
                    el.classList.remove('active');
                });
            }
        });

        // --- Modal Event Listeners ---
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

        const closeTableModal = () => {
            tableModalOverlay.style.display = 'none';
            savedRange = null;
            tableBorderToggle.checked = true;
        }

        cancelTableBtn.addEventListener('click', closeTableModal);
        tableModalOverlay.addEventListener('click', (event) => {
            if (event.target === tableModalOverlay) closeTableModal();
        });

        // ================= Special Character Wrapper =================
        /**
         * Wraps special characters in a span to enforce a specific font in mPDF.
         * @param {Node} node - The DOM node to process.
         */
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


        // --- Export PDF Logic (Revised for special characters) ---
        exportPdfButton.addEventListener('click', () => {
            const editorClone = editor.cloneNode(true);
            const pagesContent = [];

            editorClone.querySelectorAll('.page').forEach(page => {
                page.removeAttribute('contenteditable');
                
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

            fetch('/export-pdf', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ html_pages: pagesContent })
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(errorData => {
                        throw new Error(errorData.message || 'Network response was not ok');
                    });
                }
                return response.blob();
            })
            .then(blob => {
                const url = window.URL.createObjectURL(blob);
                window.open(url);
            })
            .catch(error => {
                console.error('There was a problem with the fetch operation:', error);
                alert('เกิดข้อผิดพลาดในการสร้าง PDF: ' + error.message);
            });
        });

        // Initial setup for the first page
        if (editor.children.length === 0) {
            editor.appendChild(createNewPage());
        } else {
            Array.from(editor.children).forEach(page => page.setAttribute('contenteditable', 'true'));
        }

    </script>
</body>
</html>
