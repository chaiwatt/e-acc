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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>

        @font-face {
            font-family: 'thsarabunnew';
            src: url('/fonts/THSarabunNew.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;
        }
        /* สไตล์พื้นฐานของหน้าเว็บ */
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
            vertical-align: top !important; /* ใช้ !important ที่นี่เพื่อแน่ใจว่ามันมีผล */
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
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            cursor: pointer;
            font-size: 18px
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
            border: 1px solid #ccc;
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

        /* --- Image Styling --- */
        .image-container {
            position: absolute;
            cursor: move;
            border: 2px dashed transparent;
            user-select: none;
        }
        .image-container.active {
            border-color: #4285f4;
            z-index: 10;
        }
        .image-container img {
            width: 100%;
            height: 100%;
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
            font-size: 18px;
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
        const exportPdfButton = document.getElementById('export-pdf-button'); // New element

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
            
            // Close dropdown if another button is clicked
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
                imageInput.click();
            } else {
                document.execCommand(command, false, null);
            }
            
            if(command !== 'insertTable' && command !== 'insertImage') {
               const lastActivePage = editor.querySelector('.page:focus') || editor.querySelector('.page');
               lastActivePage?.focus();
            }
        });
        
        // Toggle template dropdown visibility
        templateDropdownButton.addEventListener('click', (event) => {
            event.stopPropagation(); // Prevent document click from closing it immediately
            templateDropdownContent.parentElement.classList.toggle('show');
        });

        // Handle clicks on template dropdown items
        templateDropdownContent.addEventListener('click', (event) => {
            const templateItem = event.target.closest('a[data-template]');
            if (templateItem) {
                event.preventDefault();
                const templateType = templateItem.dataset.template;
                if (templateType === 'cb-template') {
                    insertCbTemplate();
                }
                // Close the dropdown after selection
                templateDropdownContent.parentElement.classList.remove('show');
            }
        });

        // Close dropdown when clicking anywhere else on the document
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
        
        // Function for CB template using data from a JavaScript object
        const insertCbTemplate = () => {
            // Define the template data as a JavaScript object
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
                    // { th: "ISO 17021-3:2017 (มอก. 17021-3-2562)", en: "ISO 17021-3:2017 (มอก. 17021-3-2562)" }
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

            // Construct the HTML using the data from the templateData object
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
        
        const updateMenubarState = () => {
             const commands = ['bold', 'italic', 'justifyLeft', 'justifyCenter', 'justifyRight'];
             commands.forEach(command => {
                 const button = menubar.querySelector(`[data-command="${command}"]`);
                 if (button) { // Check if button exists to avoid errors with new dropdown structure
                     if (document.queryCommandState(command)) button.classList.add('active');
                     else button.classList.remove('active');
                 }
             });
        };
        
        // --- Pagination Logic ---
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
                    
                    // Move nodes one by one until the current page is no longer overflowing
                    while (isOverflowing(page) && page.lastChild) {
                        const nodeToMove = page.lastChild;
                        // Check if the cursor's original position is within the node being moved
                        if (originalStartContainer && nodeToMove.contains(originalStartContainer)) {
                            // If the node containing the cursor is moved, the cursor should follow to the new page.
                            cursorRelocated = true;
                        }
                        nextPage.insertBefore(nodeToMove, nextPage.firstChild);
                    }
                }
            });

            // Clean up empty pages
            let currentPages = Array.from(editor.querySelectorAll('.page'));
            if (currentPages.length > 1) {
                for (let i = currentPages.length - 1; i >= 0; i--) {
                    const page = currentPages[i];
                    const isEmpty = !page.textContent.trim() && (!page.firstElementChild || page.firstElementChild.tagName === 'BR');
                    if (isEmpty && currentPages.length > 1) {
                        if (originalStartContainer && page.contains(originalStartContainer)) {
                            // If the cursor was in a page that is now empty and being removed,
                            // we need to relocate the cursor to the previous page.
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

            // Re-distribute content back if pages become underfilled (from next to current)
            currentPages = Array.from(editor.querySelectorAll('.page')); // Re-get pages after potential removals
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

            // Final cursor positioning
            if (cursorRelocated) {
                // If the cursor's original node was moved or its page was removed,
                // place the cursor at the end of the last page. This covers new page creation
                // and page merging.
                const lastPage = editor.querySelector('.page:last-of-type');
                if (lastPage) {
                    moveCursorToEnd(lastPage);
                }
            } else if (originalStartContainer && originalStartContainer.isConnected) {
                // If the original cursor position is still valid in the DOM, try to restore it.
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
                // Fallback: if no valid cursor position, move to end of last page
                const lastPage = editor.querySelector('.page:last-of-type');
                if (lastPage) {
                    moveCursorToEnd(lastPage);
                }
            }
        };

        // Helper function to move cursor to the end of an element.
        const moveCursorToEnd = (element) => {
            element.focus();
            const range = document.createRange();
            const selection = window.getSelection();
            range.selectNodeContents(element);
            range.collapse(false); // Collapse to the end
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

        // --- Image Insertion and Manipulation ---
        imageInput.addEventListener('change', (event) => {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    createImageElement(e.target.result);
                };
                reader.readAsDataURL(file);
            }
            imageInput.value = '';
        });

        function createImageElement(src) {
            const activePage = editor.querySelector('.page:focus') || editor.querySelector('.page');
            if (!activePage) return;

            const container = document.createElement('div');
            container.className = 'image-container';
            container.style.width = '200px';
            container.style.height = 'auto';
            container.style.top = '50px';
            container.style.left = '50px';

            const img = document.createElement('img');
            img.src = src;

            const handles = ['top-left', 'top-right', 'bottom-left', 'bottom-right'];
            handles.forEach(pos => {
                const handle = document.createElement('div');
                handle.className = `resize-handle ${pos}`;
                container.appendChild(handle);
            });

            container.appendChild(img);
            activePage.appendChild(container);
            makeDraggableAndResizable(container);
        }
        
        function makeDraggableAndResizable(element) {
            let activeHandle = null;
            let isDragging = false;
            let startX, startY, startLeft, startTop, startWidth, startHeight;

            function onMouseDown(e) {
                e.preventDefault();
                e.stopPropagation();

                document.querySelectorAll('.image-container.active').forEach(el => el.classList.remove('active'));
                element.classList.add('active');

                if (e.target.classList.contains('resize-handle')) {
                    activeHandle = e.target;
                    isDragging = false;
                } else {
                    activeHandle = null;
                    isDragging = true;
                }
                
                startX = e.clientX;
                startY = e.clientY;
                startLeft = element.offsetLeft;
                startTop = element.offsetTop;
                startWidth = element.offsetWidth;
                startHeight = element.offsetHeight;

                document.addEventListener('mousemove', onMouseMove);
                document.addEventListener('mouseup', onMouseUp);
            }

            function onMouseMove(e) {
                if (isDragging) {
                    const newLeft = startLeft + e.clientX - startX;
                    const newTop = startTop + e.clientY - startY;
                    element.style.left = `${newLeft}px`;
                    element.style.top = `${newTop}px`;
                } else if (activeHandle) {
                    const dx = e.clientX - startX;
                    const dy = e.clientY - startY;

                    if (activeHandle.classList.contains('bottom-right')) {
                        element.style.width = `${startWidth + dx}px`;
                        element.style.height = `${startHeight + dy}px`;
                    } else if (activeHandle.classList.contains('bottom-left')) {
                        element.style.width = `${startWidth - dx}px`;
                        element.style.height = `${startHeight + dy}px`;
                        element.style.left = `${startLeft + dx}px`;
                    } else if (activeHandle.classList.contains('top-right')) {
                        element.style.width = `${startWidth + dx}px`;
                        element.style.height = `${startHeight - dy}px`;
                        element.style.top = `${startTop + dy}px`;
                    } else if (activeHandle.classList.contains('top-left')) {
                        element.style.width = `${startWidth - dx}px`;
                        element.style.height = `${startHeight - dy}px`;
                        element.style.left = `${startLeft + dx}px`;
                        element.style.top = `${startTop + dy}px`;
                    }
                }
            }

            function onMouseUp() {
                document.removeEventListener('mousemove', onMouseMove);
                document.removeEventListener('mouseup', onMouseUp);
                isDragging = false;
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
                cell.innerHTML = '<br>';
            }
            managePages();
        }

        function insertTableColumn(table, colIndex, right = true) {
            const rows = table.rows;
            for (let i = 0; i < rows.length; i++) {
                const cell = rows[i].insertCell(right ? colIndex + 1 : colIndex);
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

        // เพิ่มการจัดการการลบรูปภาพเมื่อกด Delete
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

        // Add a global mousedown listener to handle de-selecting images
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
                for (let j = 0; j < cols; j++) tableHTML += '<td style="vertical-align: top; !important"><br></td>';
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

        // --- Export PDF Logic ---
        // exportPdfButton.addEventListener('click', () => {
        //     let combinedContentHtml = '';
        //     const pages = editor.querySelectorAll('.page'); // เลือกทุก element ที่มี class 'page'

        //     pages.forEach(page => {
        //         // ดึง HTML ภายในแต่ละหน้า
        //         // การใช้ .innerHTML จะได้เนื้อหาทั้งหมดรวมถึงแท็ก HTML ด้านใน
        //         combinedContentHtml += page.innerHTML;
        //     });

        //     console.log(pages)

        //     // return;

        //     // สร้างฟอร์มชั่วคราวเพื่อส่งข้อมูลไปยัง Backend
        //     const form = document.createElement('form');
        //     form.method = 'POST';
        //     form.action = '/export-pdf'; // กำหนด action ไปยัง route ของ Laravel
        //     form.target = '_blank'; // เปิด PDF ในแท็บใหม่

        //     // เพิ่ม CSRF token สำหรับ Laravel (สำคัญสำหรับ POST request)
        //     const csrfTokenField = document.createElement('input');
        //     csrfTokenField.type = 'hidden';
        //     csrfTokenField.name = '_token';
        //     csrfTokenField.value = '{{ csrf_token() }}'; // Blade syntax เพื่อดึง CSRF token
        //     form.appendChild(csrfTokenField);

        //     // เพิ่มเนื้อหา HTML ที่รวมไว้เป็น hidden input
        //     const htmlContentField = document.createElement('input');
        //     htmlContentField.type = 'hidden';
        //     htmlContentField.name = 'html_content';
        //     htmlContentField.value = combinedContentHtml;
        //     form.appendChild(htmlContentField);

        //     // เพิ่มฟอร์มเข้าสู่ body และ submit
        //     document.body.appendChild(form);
        //     form.submit();
        //     document.body.removeChild(form); // ลบฟอร์มออกจาก DOM หลังจาก submit
        // });

        exportPdfButton.addEventListener('click', () => {
            // เปลี่ยนจากรวมเป็น string เดียว มาเก็บเป็น array ของ HTML แต่ละหน้า
            const pagesContent = []; 
            const pages = editor.querySelectorAll('.page'); // เลือกทุก element ที่มี class 'page'

            pages.forEach(page => {
                // ดึง HTML ภายในแต่ละหน้าเก็บเข้า array
                pagesContent.push(page.innerHTML); 
            });

            // ตรวจสอบข้อมูลก่อนส่ง (Optional: เพื่อ Debug)
            console.log("Pages content to send:", pagesContent); 

            // return;

            // ส่ง Array ของเนื้อหา HTML ไปยัง Backend
            fetch('/export-pdf', { // ตรวจสอบ URL ของคุณว่าตรงกับ route ที่ไป DocController@exportPdf หรือไม่
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json', // สำคัญ: ต้องระบุเป็น application/json
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // อย่าลืม CSRF Token
                },
                body: JSON.stringify({ html_pages: pagesContent }) // ส่งเป็น JSON ที่มีคีย์เป็น 'html_pages' และค่าเป็น array
            })
            .then(response => {
                // ตรวจสอบว่า request สำเร็จหรือไม่
                if (!response.ok) {
                    return response.json().then(errorData => {
                        throw new Error(errorData.message || 'Network response was not ok');
                    });
                }
                return response.blob(); // ถ้าสำเร็จ ให้รับเป็น blob (ไฟล์ PDF)
            })
            .then(blob => {
                // สร้าง URL สำหรับ Blob และเปิดในแท็บใหม่
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
            // Ensure existing pages are contenteditable
            Array.from(editor.children).forEach(page => page.setAttribute('contenteditable', 'true'));
        }

    </script>
</body>
</html>