<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document Editor | แต่งตั้งผู้ตรวจเอกสาร</title>
    <link rel="stylesheet" href="{{ asset('css/editor.css') }}">
        <style>

            
        #toolbar {
            display: none;
        }
        /* --- Select2 Custom Theme ให้เข้ากับ THSarabunNew --- */

        /* กล่องหลัก */
        .select2-container--default .select2-selection--single {
            height: auto !important;          /* ให้ขยายอัตโนมัติ */
            min-height: 40px;                 /* เท่ากับ select ปกติ */
            padding: 6px 12px !important;     /* padding แบบเดียวกับ select */
            display: flex !important;         
            align-items: center !important;   /* จัดข้อความตรงกลางแนวตั้ง */
            font-family: 'THSarabunNew', sans-serif;
            font-size: 14pt;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: #fff;
            box-sizing: border-box;
        }

        /* ตอน hover / focus */
        .select2-container--default .select2-selection--single:focus,
        .select2-container--default .select2-selection--single:hover {
            border-color: #007bff;
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.15);
            outline: none;
        }

        /* ลูกศรด้านขวา */
        .select2-container--default .select2-selection__arrow {
            height: 100% !important;
            right: 10px;
            display: flex;
            align-items: center;
        }

        /* ข้อความ placeholder */
        .select2-container--default .select2-selection__placeholder {
            color: #999;
            font-style: italic;
        }

        /* ตอนเลือกแล้ว */
        .select2-container--default .select2-selection__rendered {
            padding-left: 0 !important;
            line-height: normal !important;
        }

        /* Dropdown list */
        .select2-container--default .select2-dropdown {
            border: 1px solid #ccc;
            border-radius: 6px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            font-family: 'THSarabunNew', sans-serif;
            font-size: 14pt;
        }

        /* item ใน dropdown */
        .select2-container--default .select2-results__option {
            padding: 8px 12px;
            cursor: pointer;
        }

        /* item ตอน hover */
        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #007bff;
            color: white;
        }

        /* item ตอนเลือกแล้ว */
        .select2-container--default .select2-results__option[aria-selected="true"] {
            background-color: #e9ecef;
            color: #333;
        }
        .select2-selection__clear {
            display: none !important;
        }

    </style>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" xintegrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
          <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</head>
<body>

    <!-- Toolbar: เพิ่มปุ่ม Save Draft -->
    <div id="toolbar">
        <div class="toolbar-group">
            <button id="bold-btn" class="toolbar-button" title="Bold"><i class="fa-solid fa-bold"></i></button>
            <button id="italic-btn" class="toolbar-button" title="Italic"><i class="fa-solid fa-italic"></i></button>
            <button id="strikethrough-btn" class="toolbar-button" title="Strikethrough"><i class="fa-solid fa-strikethrough"></i></button>
            <button id="subscript-btn" class="toolbar-button" title="Subscript"><i class="fa-solid fa-subscript"></i></button>
            <button id="superscript-btn" class="toolbar-button" title="Superscript"><i class="fa-solid fa-superscript"></i></button>
        </div>
       <div class="toolbar-separator"></div>
        <div class="toolbar-group">
            <select id="font-size-select" class="toolbar-select" title="Font Size">
                <option value="" disabled selected>Font Size</option>
                <option value="12">12 pt</option>
                <option value="14">14 pt</option>
                <option value="16">16 pt</option>
                <option value="18">18 pt</option>
                <option value="20">20 pt</option>
                <option value="22">22 pt</option>
                <option value="24">24 pt</option>
                <option value="26">26 pt</option>
                <option value="28">28 pt</option>
            </select>
        </div>
        <div class="toolbar-separator"></div>
        <div class="toolbar-group">
            <button id="align-left-btn" class="toolbar-button" title="Align Left"><i class="fa-solid fa-align-left"></i></button>
            <button id="align-center-btn" class="toolbar-button" title="Align Center"><i class="fa-solid fa-align-center"></i></button>
            <button id="align-right-btn" class="toolbar-button" title="Align Right"><i class="fa-solid fa-align-right"></i></button>
        </div>
        <div class="toolbar-separator"></div>
        <div class="toolbar-group">
             <button id="insert-table-btn" class="toolbar-button" title="Insert Table"><i class="fa-solid fa-table-cells"></i></button>
             <button id="insert-image-btn" class="toolbar-button" title="Insert Image"><i class="fa-solid fa-image"></i></button>
             <input type="file" id="image-upload" accept="image/*" style="display: none;" />
        </div>
        <div class="toolbar-separator"></div>
        <div class="toolbar-group">
            <button class="toolbar-button" id="load-template-btn" title="Load Template">
                <i class="fa-solid fa-cloud-arrow-down"></i>
            </button>
            {{-- NEW: ปุ่ม Save Draft --}}
            <button class="toolbar-button" id="save-draft-button" title="Save Draft">
                <i class="fa-solid fa-file-pen"></i>
            </button>
            {{-- ปุ่ม Save เดิม (ตอนนี้คือ Save Final) --}}
            <button class="toolbar-button" id="save-html-button" title="Save Final">
                <i class="fa-solid fa-floppy-disk"></i>
            </button>

            <button class="toolbar-button" id="load-default-template-btn" title="Load Default Template">
                <i class="fa-solid fa-file-arrow-down"></i>
            </button>
            {{-- <button class="toolbar-button" id="export-pdf-button" title="Export to PDF">
                <i class="fa-regular fa-file-pdf"></i>
            </button> --}}
            <div id="loading-indicator" style="display: none;">
                <i class="fa-solid fa-spinner fa-spin"></i>
            </div>
        </div>
    </div>

    <div id="editor-container">
        <div id="document-editor">
            <div class="page" contenteditable="true"></div>
        </div>
    </div>

    <!-- Modals and Context Menu HTML (ไม่เปลี่ยนแปลง) -->
    <div id="table-modal" class="modal-backdrop" style="display: none;">
        <div class="modal">
            <div class="modal-header">
                <h3>Insert Table</h3>
                <button id="close-table-modal" class="modal-close-btn">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="table-rows">Rows:</label>
                    <input type="number" id="table-rows" value="3" min="1">
                </div>
                <div class="form-group">
                    <label for="table-cols">Columns:</label>
                    <input type="number" id="table-cols" value="3" min="1">
                </div>
                <div class="form-group">
                    <label>
                        <input type="checkbox" id="table-border-checkbox" checked>
                        Add borders
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button id="create-table-btn" class="modal-button primary">Create</button>
                <button id="cancel-table-btn" class="modal-button">Cancel</button>
            </div>
        </div>
    </div>
    <div id="table-context-menu" class="context-menu" style="display: none;">
        <div class="context-menu-item" id="insert-row-above">เพิ่มแถว (บน)</div>
        <div class="context-menu-item" id="insert-row-below">เพิ่มแถว (ล่าง)</div>
        <div class="context-menu-item" id="insert-row-above-bordered">เพิ่มแถวมีเส้นขอบ (บน)</div>
        <div class="context-menu-item" id="insert-row-below-bordered">เพิ่มแถวมีเส้นขอบ (ล่าง)</div>
        <div class="context-menu-separator"></div>
        <div class="context-menu-item" id="insert-col-left">เพิ่มคอลัมน์ (ซ้าย)</div>
        <div class="context-menu-item" id="insert-col-right">เพิ่มคอลัมน์ (ขวา)</div>
        <div class="context-menu-item" id="insert-col-left-bordered">เพิ่มคอลัมน์มีเส้นขอบ (ซ้าย)</div>
        <div class="context-menu-item" id="insert-col-right-bordered">เพิ่มคอลัมน์มีเส้นขอบ (ขวา)</div>
        <div class="context-menu-separator"></div>
        <div class="context-menu-item" id="delete-row">ลบแถว</div>
        <div class="context-menu-item" id="delete-col">ลบคอลัมน์</div>
        <div class="context-menu-separator"></div>
        <div class="context-menu-item" id="merge-cells">รวมเซลล์</div>
        <div class="context-menu-item" id="unmerge-cells">ยกเลิกการรวมเซลล์</div>
    </div>

    <!-- Modal for selecting signer with sequence dropdown -->
    <div id="signature-modal" style="display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.4); align-items: center; justify-content: center;">
        <div style="background-color: #fefefe; padding: 20px; border: 1px solid #888; width: 90%; max-width: 450px; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.3); font-family: sans-serif;">
            <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #e5e5e5; padding-bottom: 10px; margin-bottom: 20px;">
                <h3 style="margin: 0; font-size: 18px; font-weight: 600; color: #333;">เลือกผู้ลงนาม</h3>
                <button id="close-signature-modal" style="border: none; background: none; font-size: 28px; cursor: pointer; color: #aaa; line-height: 1;">&times;</button>
            </div>
            <div style="margin-bottom: 20px;">
                <div style="margin-bottom: 15px;">
                    <label for="signature-select" style="display: block; margin-bottom: 8px; font-size: 14px; color: #555;">รายชื่อ:</label>
                    <select id="signature-select" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px; background-color: white; font-size: 14px;"></select>
                </div>
                <div style="margin-bottom: 15px;">
                    <label for="signer-sequence-select" style="display: block; margin-bottom: 8px; font-size: 14px; color: #555;">ลำดับ:</label>
                    <select id="signer-sequence-select" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px; background-color: white; font-size: 14px;">
                        <option value="1">ลำดับที่ 1</option>
                        <option value="2">ลำดับที่ 2</option>
                        <option value="3">ลำดับที่ 3</option>
                        <option value="4">ลำดับที่ 4</option>
                        <option value="5">ลำดับที่ 5</option>
                        <option value="6">ลำดับที่ 6</option>
                        <option value="7">ลำดับที่ 7</option>
                        <option value="8">ลำดับที่ 8</option>
                        <option value="9">ลำดับที่ 9</option>
                        <option value="10">ลำดับที่ 10</option>
                    </select>
                </div>
                <div>
                    <label for="signer-position-input" style="display: block; margin-bottom: 8px; font-size: 14px; color: #555;">ตำแหน่ง:</label>
                    <input type="text" id="signer-position-input" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px; box-sizing: border-box; font-size: 14px;">
                </div>
            </div>
            <div style="display: flex; justify-content: flex-end; border-top: 1px solid #e5e5e5; padding-top: 15px;">
                <button id="cancel-signature-btn" style="background-color: #777; color: white; padding: 10px 20px; border: none; border-radius: 6px; cursor: pointer; margin-right: 10px; font-size: 14px;">ยกเลิก</button>
                <button id="confirm-signature-btn" style="background-color: #28a745; color: white; padding: 10px 20px; border: none; border-radius: 6px; cursor: pointer; font-size: 14px;">ยืนยัน</button>
            </div>
        </div>
    </div>


    <script>
        const templateType = @json($templateType ?? null);
        const ibId = @json($ibId ?? null);
        const assessmentId = @json($assessmentId ?? null);
        const initialStatus = @json($status ?? 'draft');

        document.addEventListener('DOMContentLoaded', function() {
            const select = document.getElementById('signature-select');
            if (select) {
                $('#signature-select').select2({
                    placeholder: "ค้นหารายชื่อ...",
                    allowClear: true,
                    width: '100%' // ให้เต็ม container
                });
            }
            document.execCommand('defaultParagraphSeparator', false, 'p');
            const editor = document.getElementById('document-editor');
            const exportButton = document.getElementById('export-pdf-button');
            const saveButton = document.getElementById('save-html-button');
            const saveDraftButton = document.getElementById('save-draft-button');
            const loadingIndicator = document.getElementById('loading-indicator');
            let activeSignatureBlock = null; 
            let signersData = []; 
            
            // ... (โค้ดส่วน formatButtons และอื่นๆ ไม่เปลี่ยนแปลง)
            const formatButtons = [
                { id: 'bold-btn', command: 'bold' },
                { id: 'italic-btn', command: 'italic' },
                { id: 'strikethrough-btn', command: 'strikeThrough' },
                { id: 'subscript-btn', command: 'subscript' },
                { id: 'superscript-btn', command: 'superscript' },
                { id: 'align-left-btn', command: 'justifyLeft' },
                { id: 'align-center-btn', command: 'justifyCenter' },
                { id: 'align-right-btn', command: 'justifyRight' },
            ];
            formatButtons.forEach(btnInfo => {
                const button = document.getElementById(btnInfo.id);
                if (button) {
                    button.addEventListener('click', () => {
                        const selection = window.getSelection();
                        if (selection.rangeCount > 0) {
                            const range = selection.getRangeAt(0).cloneRange();
                            document.execCommand(btnInfo.command, false, null);
                            range.collapse(false);
                            selection.removeAllRanges();
                            selection.addRange(range);
                        }
                        editor.focus();
                    });
                }
            });
            const fontSizeSelect = document.getElementById('font-size-select');
            fontSizeSelect.addEventListener('change', (e) => {
                const size = e.target.value;
                if (!size) return;
                const selection = window.getSelection();
                if (selection.rangeCount > 0) {
                    const range = selection.getRangeAt(0);
                    if (range.collapsed) { editor.focus(); return; }
                    document.execCommand('fontSize', false, '7');
                    const fontElements = editor.querySelectorAll("font[size='7']");
                    let lastSpan = null;
                    fontElements.forEach(fontElement => {
                        const span = document.createElement('span');
                        span.style.fontSize = `${size}pt`;
                        span.innerHTML = fontElement.innerHTML;
                        fontElement.parentNode.replaceChild(span, fontElement);
                        lastSpan = span;
                    });
                    if (lastSpan) {
                        const newRange = document.createRange();
                        newRange.setStartAfter(lastSpan);
                        newRange.collapse(true);
                        selection.removeAllRanges();
                        selection.addRange(newRange);
                    }
                }
                e.target.selectedIndex = 0;
                editor.focus();
            });
            const insertImageBtn = document.getElementById('insert-image-btn');
            const imageUpload = document.getElementById('image-upload');
            let savedRange = null;
            insertImageBtn.addEventListener('click', () => {
                const selection = window.getSelection();
                if (selection.rangeCount > 0) savedRange = selection.getRangeAt(0).cloneRange();
                imageUpload.click();
            });
            imageUpload.addEventListener('change', (event) => {
                const file = event.target.files[0];
                if (!file || !savedRange) return;
                const reader = new FileReader();
                reader.onload = (e) => {
                    const imgSrc = e.target.result;

                    const tempImg = new Image();
                    tempImg.onload = () => {
                        const page = savedRange.startContainer.closest('.page');
                        const pageContentWidth = page ? page.clientWidth : 600;

                        let initialWidth = tempImg.naturalWidth;
                        let initialHeight = tempImg.naturalHeight;

                        if (initialWidth > pageContentWidth) {
                            const ratio = pageContentWidth / initialWidth;
                            initialWidth = pageContentWidth;
                            initialHeight = initialHeight * ratio;
                        }

                        const wrapper = document.createElement('div');
                        wrapper.className = 'resizable-image-wrapper';
                        wrapper.contentEditable = false;
                        wrapper.style.width = `${initialWidth}px`;
                        wrapper.style.height = `${initialHeight}px`;

                        const img = document.createElement('img');
                        img.src = imgSrc;
                        
                        const resizer = document.createElement('div');
                        resizer.className = 'resizer';
                        
                        wrapper.appendChild(img);
                        wrapper.appendChild(resizer);
                        
                        savedRange.insertNode(wrapper);
                        selectImageWrapper(wrapper);
                        resizer.addEventListener('mousedown', initResize, false);
                    };
                    tempImg.src = imgSrc;
                };
                reader.readAsDataURL(file);
                imageUpload.value = '';
            });
            let selectedImageWrapper = null;
            function selectImageWrapper(wrapper) {
                if (selectedImageWrapper) selectedImageWrapper.classList.remove('selected');
                wrapper.classList.add('selected');
                selectedImageWrapper = wrapper;
            }
            document.addEventListener('click', (e) => {
                const wrapper = e.target.closest('.resizable-image-wrapper');
                if (wrapper) selectImageWrapper(wrapper);
                else if (selectedImageWrapper) {
                    selectedImageWrapper.classList.remove('selected');
                    selectedImageWrapper = null;
                }
            });
            
            let startX, startY, startWidth, startHeight;
            function initResize(e) {
                e.preventDefault();
                const wrapper = e.target.parentElement;
                startX = e.clientX; startY = e.clientY;
                startWidth = parseInt(document.defaultView.getComputedStyle(wrapper).width, 10);
                startHeight = parseInt(document.defaultView.getComputedStyle(wrapper).height, 10);
                document.documentElement.addEventListener('mousemove', doDrag, false);
                document.documentElement.addEventListener('mouseup', stopDrag, false);
            }
            function doDrag(e) {
                const wrapper = selectedImageWrapper;
                if (!wrapper) return;
                const newWidth = startWidth + (e.clientX - startX);
                const aspectRatio = startHeight / startWidth;
                wrapper.style.width = newWidth + 'px';
                wrapper.style.height = (newWidth * aspectRatio) + 'px';
            }
            function stopDrag(e) {
                document.documentElement.removeEventListener('mousemove', doDrag, false);
                document.documentElement.removeEventListener('mouseup', stopDrag, false);
            }
            const tableModal = document.getElementById('table-modal');
            const insertTableBtn = document.getElementById('insert-table-btn');
            const closeTableModalBtn = document.getElementById('close-table-modal');
            const cancelTableBtn = document.getElementById('cancel-table-btn');
            const createTableBtn = document.getElementById('create-table-btn');
            const showTableModal = () => {
                const selection = window.getSelection();
                if (selection.rangeCount > 0) {
                    savedRange = selection.getRangeAt(0).cloneRange();
                }
                tableModal.style.display = 'flex';
            };
            const hideTableModal = () => {
                tableModal.style.display = 'none';
            };
            insertTableBtn.addEventListener('click', showTableModal);
            closeTableModalBtn.addEventListener('click', hideTableModal);
            cancelTableBtn.addEventListener('click', hideTableModal);
            createTableBtn.addEventListener('click', () => {
                const rows = parseInt(document.getElementById('table-rows').value, 10);
                const cols = parseInt(document.getElementById('table-cols').value, 10);
                const hasBorders = document.getElementById('table-border-checkbox').checked;
                if (rows > 0 && cols > 0 && savedRange) {
                    const table = document.createElement('table');
                    if (hasBorders) {
                        table.className = 'table-bordered';
                    }
                    const tbody = document.createElement('tbody');
                    for (let i = 0; i < rows; i++) {
                        const tr = document.createElement('tr');
                        for (let j = 0; j < cols; j++) {
                            const td = createNewCell();
                            tr.appendChild(td);
                        }
                        tbody.appendChild(tr);
                    }
                    table.appendChild(tbody);
                    const p = document.createElement('p');
                    p.appendChild(document.createElement('br'));
                    savedRange.insertNode(p);
                    savedRange.insertNode(table);
                    
                    makeTableResizable(table);

                    hideTableModal();
                    editor.focus();
                }
            });
            const isOverflowing = (el) => el.scrollHeight > el.clientHeight + 1;
            const createNewPage = () => {
                const newPage = document.createElement('div');
                newPage.className = 'page';
                newPage.setAttribute('contenteditable', 'true');
                editor.appendChild(newPage);
                return newPage;
            };

            const managePages = () => {
                const selection = window.getSelection();
                if (!selection.rangeCount) return;

                const range = selection.getRangeAt(0);
                const markerId = `cursor-marker-${Date.now()}`;
                const marker = document.createElement('span');
                marker.id = markerId;
                try {
                    range.insertNode(marker);
                } catch (e) {
                    console.warn("Could not insert marker:", e);
                    return;
                }

                let pages = Array.from(editor.querySelectorAll('.page'));
                pages.forEach((page) => {
                    while (isOverflowing(page)) {
                        let nextPage = page.nextElementSibling;
                        if (!nextPage || !nextPage.classList.contains('page')) {
                            nextPage = createNewPage();
                            page.after(nextPage);
                        }
                        if (page.lastChild) {
                            nextPage.insertBefore(page.lastChild, nextPage.firstChild);
                        } else {
                            break;
                        }
                    }
                });

                pages = Array.from(editor.querySelectorAll('.page'));
                if (pages.length > 1) {
                    for (let i = pages.length - 1; i > 0; i--) {
                        const page = pages[i];
                        const isEmpty = page.textContent.trim() === '' && page.children.length === 0;
                        const hasOnlyEmptyP = page.innerHTML.trim() === '<p><br></p>';
                        if (isEmpty || hasOnlyEmptyP) {
                            page.remove();
                        }
                    }
                }
                
                const newMarker = document.getElementById(markerId);
                if (newMarker) {
                    const newRange = document.createRange();
                    newRange.setStartBefore(newMarker);
                    newRange.collapse(true);
                    selection.removeAllRanges();
                    selection.addRange(newRange);
                    newMarker.parentNode.removeChild(newMarker);
                }
            };

            editor.addEventListener('input', () => setTimeout(managePages, 10));
            
            editor.addEventListener('keydown', (e) => {
                if (selectedImageWrapper && (e.key === 'Delete' || e.key === 'Backspace')) {
                    e.preventDefault();
                    selectedImageWrapper.remove();
                    selectedImageWrapper = null;
                    setTimeout(managePages, 10);
                    return;
                }

                if (e.key === 'Backspace') {
                    const selection = window.getSelection();
                    if (selection.rangeCount > 0 && selection.isCollapsed) {
                        const range = selection.getRangeAt(0);
                        const startNode = range.startContainer;
                        const page = (startNode.nodeType === Node.ELEMENT_NODE ? startNode : startNode.parentElement).closest('.page');

                        if (!page) return;

                        const previousPage = page.previousElementSibling;

                        if (previousPage && previousPage.classList.contains('page')) {
                            const preCaretRange = document.createRange();
                            preCaretRange.selectNodeContents(page);
                            preCaretRange.setEnd(range.startContainer, range.startOffset);

                            const contentBefore = preCaretRange.cloneContents();
                            const isAtStart = contentBefore.textContent.replace(/[\u00A0\u200B]/g, '').trim() === '' &&
                                              contentBefore.querySelector('img, table, .resizable-image-wrapper') === null;

                            if (isAtStart) {
                                e.preventDefault();
                                const currentPageNodes = Array.from(page.childNodes);
                                
                                if (currentPageNodes.length === 0 || (currentPageNodes.length === 1 && currentPageNodes[0].textContent.trim() === '' && !currentPageNodes[0].querySelector('img, table'))) {
                                    page.remove();
                                    const newRange = document.createRange();
                                    newRange.selectNodeContents(previousPage);
                                    newRange.collapse(false);
                                    selection.removeAllRanges();
                                    selection.addRange(newRange);
                                    previousPage.focus();
                                    return;
                                }

                                let lastElInPrev = previousPage.lastElementChild;
                                if (lastElInPrev && lastElInPrev.nodeName === 'P' && (lastElInPrev.innerHTML.trim().toLowerCase() === '<br>' || lastElInPrev.innerHTML.trim() === '')) {
                                    previousPage.removeChild(lastElInPrev);
                                }

                                const newRange = document.createRange();
                                newRange.selectNodeContents(previousPage);
                                newRange.collapse(false);
                                selection.removeAllRanges();
                                selection.addRange(newRange);
                                
                                currentPageNodes.forEach(node => {
                                    previousPage.appendChild(node);
                                });

                                page.remove();
                                return;
                            }
                        }
                    }
                }

                if (e.key === 'Delete' || e.key === 'Backspace') {
                    setTimeout(managePages, 10);
                }
            });

            const tableContextMenu = document.getElementById('table-context-menu');
            let currentCell = null;
            let selectedCells = []; 
            let isMouseDown = false;
            let hasDragged = false;
            let startCell = null;

            function clearSelection() {
                if (selectedCells.length > 0) {
                    selectedCells.forEach(cell => cell.classList.remove('selected-table-cell'));
                    selectedCells = [];
                }
            }

            function highlightCells(start, end) {
                clearSelection();
                const table = start.closest('table');
                if (!table || !end || end.closest('table') !== table) return;

                const startCoords = getCellCoordinates(start);
                const endCoords = getCellCoordinates(end);

                const minRow = Math.min(startCoords.rowIndex, endCoords.rowIndex);
                const maxRow = Math.max(startCoords.rowIndex, endCoords.rowIndex);
                const minCol = Math.min(startCoords.colIndex, endCoords.colIndex);
                const maxCol = Math.max(startCoords.colIndex, endCoords.colIndex);

                Array.from(table.querySelectorAll('td, th')).forEach(cell => {
                    const cellCoords = getCellCoordinates(cell);
                    if (cellCoords.rowIndex >= minRow && cellCoords.rowIndex <= maxRow &&
                        cellCoords.colIndex >= minCol && cellCoords.colIndex <= maxCol) {
                        cell.classList.add('selected-table-cell');
                        selectedCells.push(cell);
                    }
                });
            }

            editor.addEventListener('mousedown', function(e) {
                if (e.button !== 0) return; 

                const cell = e.target.closest('td, th');
                if (cell) {
                    isMouseDown = true;
                    hasDragged = false;
                    startCell = cell;
                } else {
                    clearSelection();
                }
            });

            editor.addEventListener('mousemove', function(e) {
                if (!isMouseDown || !startCell) return;
                if (!hasDragged) {
                    hasDragged = true;
                    window.getSelection().removeAllRanges();
                }
                const endCell = e.target.closest('td, th');
                highlightCells(startCell, endCell);
            });

            document.addEventListener('mouseup', function(e) {
                if (!isMouseDown) return;
                if (isMouseDown && !hasDragged) {
                    clearSelection();
                }
                isMouseDown = false;
                hasDragged = false;
                startCell = null;
            });

            editor.addEventListener('contextmenu', function(e) {
                const cell = e.target.closest('td, th');
                if (cell) {
                    e.preventDefault();
                    currentCell = cell;
                    if (!cell.classList.contains('selected-table-cell')) {
                        clearSelection();
                        cell.classList.add('selected-table-cell');
                        selectedCells.push(cell);
                    }
                    showContextMenu(e.pageX, e.pageY);
                } else {
                    hideContextMenu();
                }
            });
            
            function showContextMenu(x, y) {
                tableContextMenu.style.left = `${x}px`;
                tableContextMenu.style.top = `${y}px`;
                tableContextMenu.style.display = 'block';
            }

            function hideContextMenu() {
                tableContextMenu.style.display = 'none';
            }

            document.addEventListener('click', function(e) {
                if (!e.target.closest('.context-menu')) {
                    hideContextMenu();
                }
            });
            
            function getCellCoordinates(cell) {
                const row = cell.closest('tr');
                const table = row.closest('table');
                let rowIndex = -1;
                let colIndex = -1;

                const tableMap = [];
                for (let i = 0; i < table.rows.length; i++) {
                    tableMap.push([]);
                }

                for (let r = 0; r < table.rows.length; r++) {
                    for (let c = 0; c < table.rows[r].cells.length; c++) {
                        const currentCellInLoop = table.rows[r].cells[c];
                        let mapCol = 0;
                        while (tableMap[r][mapCol]) {
                            mapCol++;
                        }
                        
                        const rowSpan = parseInt(currentCellInLoop.getAttribute('rowspan') || 1);
                        const colSpan = parseInt(currentCellInLoop.getAttribute('colspan') || 1);

                        for (let rs = 0; rs < rowSpan; rs++) {
                            for (let cs = 0; cs < colSpan; cs++) {
                                if (tableMap[r + rs]) {
                                    tableMap[r + rs][mapCol + cs] = currentCellInLoop;
                                }
                            }
                        }

                        if (currentCellInLoop === cell) {
                            rowIndex = r;
                            colIndex = mapCol;
                        }
                    }
                }
                return { rowIndex, colIndex };
            }

            function createNewCell() {
                const td = document.createElement('td');
                td.style.fontSize = '16pt';
                td.appendChild(document.createElement('br'));
                return td;
            }
            
            function insertRow({ position, bordered }) {
                if (!currentCell) return;
                const row = currentCell.closest('tr');
                const table = row.closest('table');
                if (!row || !table) return;

                if (bordered) {
                    table.classList.add('table-bordered');
                }

                const newRow = document.createElement('tr');
                
                let colCount = 0;
                if (table.rows.length > 0) {
                    for(let i = 0; i < table.rows.length; i++) {
                        let currentColCount = 0;
                        for (const cell of table.rows[i].cells) {
                            currentColCount += parseInt(cell.getAttribute('colspan') || 1);
                        }
                        if(currentColCount > colCount) {
                            colCount = currentColCount;
                        }
                    }
                } else {
                    colCount = 1;
                }

                for (let i = 0; i < colCount; i++) {
                    newRow.appendChild(createNewCell());
                }

                if (position === 'above') {
                    row.parentNode.insertBefore(newRow, row);
                } else {
                    row.parentNode.insertBefore(newRow, row.nextSibling);
                }
                hideContextMenu();
            }

            document.getElementById('insert-row-above').addEventListener('click', () => insertRow({ position: 'above', bordered: false }));
            document.getElementById('insert-row-below').addEventListener('click', () => insertRow({ position: 'below', bordered: false }));
            document.getElementById('insert-row-above-bordered').addEventListener('click', () => insertRow({ position: 'above', bordered: true }));
            document.getElementById('insert-row-below-bordered').addEventListener('click', () => insertRow({ position: 'below', bordered: true }));
            
            document.getElementById('delete-row').addEventListener('click', function() {
                if (!currentCell) return;
                const row = currentCell.closest('tr');
                if (row.parentElement.rows.length > 1) {
                    row.remove();
                } else {
                    row.closest('table').remove();
                }
                hideContextMenu();
            });
            
            document.getElementById('delete-col').addEventListener('click', function() {
                if (!currentCell) return;
                const table = currentCell.closest('table');
                const { colIndex } = getCellCoordinates(currentCell);

                if (currentCell.parentElement.cells.length > 1) {
                    Array.from(table.rows).forEach(row => {
                        const cellToRemove = Array.from(row.cells).find(cell => getCellCoordinates(cell).colIndex === colIndex);
                        if (cellToRemove) cellToRemove.remove();
                    });
                } else {
                    table.remove();
                }
                hideContextMenu();
            });

            function insertCol({ position, bordered }) {
                if (!currentCell) return;
                const table = currentCell.closest('table');
                if (!table) return;

                if (bordered) {
                    table.classList.add('table-bordered');
                }

                const { colIndex: targetLogicalColIndex } = getCellCoordinates(currentCell);

                for (const row of table.rows) {
                    let referenceCell = null;
                    
                    if (position === 'left') {
                        for (const cell of row.cells) {
                            const { colIndex: currentLogicalColIndex } = getCellCoordinates(cell);
                            if (currentLogicalColIndex >= targetLogicalColIndex) {
                                referenceCell = cell;
                                break;
                            }
                        }
                    } else { // 'right'
                        for (const cell of row.cells) {
                            const { colIndex: currentLogicalColIndex } = getCellCoordinates(cell);
                            const colspan = parseInt(cell.getAttribute('colspan') || 1);
                            if (currentLogicalColIndex + colspan > targetLogicalColIndex) {
                                referenceCell = cell.nextSibling;
                                break;
                            }
                        }
                    }

                    const newCell = createNewCell();
                    row.insertBefore(newCell, referenceCell);
                }

                makeTableResizable(table);
                hideContextMenu();
            }

            document.getElementById('insert-col-left').addEventListener('click', () => insertCol({ position: 'left', bordered: false }));
            document.getElementById('insert-col-right').addEventListener('click', () => insertCol({ position: 'right', bordered: false }));
            document.getElementById('insert-col-left-bordered').addEventListener('click', () => insertCol({ position: 'left', bordered: true }));
            document.getElementById('insert-col-right-bordered').addEventListener('click', () => insertCol({ position: 'right', bordered: true }));

            document.getElementById('merge-cells').addEventListener('click', function() {
                if (selectedCells.length <= 1) {
                    showCustomAlert('โปรดเลือกอย่างน้อย 2 เซลล์เพื่อรวม');
                    hideContextMenu();
                    return;
                }

                const table = selectedCells[0].closest('table');
                if (!table) return;

                let minRow = Infinity, maxRow = -1, minCol = Infinity, maxCol = -1;
                let mergedContent = '';
                
                selectedCells.forEach(cell => {
                    const coords = getCellCoordinates(cell);
                    minRow = Math.min(minRow, coords.rowIndex);
                    maxRow = Math.max(maxRow, coords.rowIndex);
                    minCol = Math.min(minCol, coords.colIndex);
                    maxCol = Math.max(maxCol, coords.colIndex);
                    
                    const cellContent = cell.innerHTML.replace(/<br\s*\/?>/gi, '').trim();
                    if(cellContent) {
                        mergedContent += (mergedContent ? ' ' : '') + cell.innerHTML;
                    }
                });

                const rowSpan = maxRow - minRow + 1;
                const colSpan = maxCol - minCol + 1;

                const topLeftCell = selectedCells.find(cell => {
                    const coords = getCellCoordinates(cell);
                    return coords.rowIndex === minRow && coords.colIndex === minCol;
                });

                if (!topLeftCell) {
                    showCustomAlert('ไม่สามารถรวมเซลล์ที่เลือกได้');
                    hideContextMenu();
                    return;
                }

                selectedCells.forEach(cell => {
                    if (cell !== topLeftCell) {
                        cell.remove();
                    }
                });

                topLeftCell.setAttribute('rowspan', rowSpan);
                topLeftCell.setAttribute('colspan', colSpan);
                topLeftCell.innerHTML = mergedContent || '<br>';

                clearSelection();
                hideContextMenu();
            });

            document.getElementById('unmerge-cells').addEventListener('click', function() {
                if (!currentCell) return;
                const cell = currentCell;
                const table = cell.closest('table');
                const originalRowSpan = parseInt(cell.getAttribute('rowspan') || 1);
                const originalColSpan = parseInt(cell.getAttribute('colspan') || 1);

                if (originalRowSpan <= 1 && originalColSpan <= 1) {
                    showCustomAlert('เซลล์นี้ไม่ได้ถูกรวม');
                    hideContextMenu();
                    return;
                }

                const { rowIndex, colIndex } = getCellCoordinates(cell);
                cell.removeAttribute('rowspan');
                cell.removeAttribute('colspan');

                for (let r = 0; r < originalRowSpan; r++) {
                    const targetRow = table.rows[rowIndex + r];
                    if (targetRow) {
                        for (let c = 0; c < originalColSpan; c++) {
                            if (r === 0 && c === 0) continue;
                            const newCell = createNewCell();
                            const insertBeforeCell = Array.from(targetRow.cells).find(c => getCellCoordinates(c).colIndex >= colIndex + c);
                            targetRow.insertBefore(newCell, insertBeforeCell || null);
                        }
                    }
                }
                hideContextMenu();
            });
            function makeTableResizable(table) {
                const colgroup = table.querySelector('colgroup') || document.createElement('colgroup');
                const firstRow = table.querySelector('tr');
                if (!firstRow) return;

                while (colgroup.firstChild) {
                    colgroup.removeChild(colgroup.firstChild);
                }

                const cols = Array.from(firstRow.children);
                cols.forEach(() => {
                    const col = document.createElement('col');
                    colgroup.appendChild(col);
                });
                
                if (!table.querySelector('colgroup')) {
                    table.prepend(colgroup);
                }

                cols.forEach((colCell, index) => {
                    if (index === cols.length - 1) return;
                    
                    const oldResizer = colCell.querySelector('.col-resizer');
                    if (oldResizer) oldResizer.remove();

                    const resizer = document.createElement('div');
                    resizer.className = 'col-resizer';
                    colCell.appendChild(resizer);
                    
                    resizer.addEventListener('mousedown', initColResize);
                });
            }

            let currentResizer;
            let resizeStartX;
            let startWidthCol;
            let nextColStartWidth;
            let tableBeingResized;
            let colBeingResized;
            let nextCol;

            function initColResize(e) {
                e.preventDefault();
                e.stopPropagation();

                currentResizer = e.target;
                tableBeingResized = currentResizer.closest('table');
                const th = currentResizer.parentElement;
                const colIndex = Array.from(th.parentElement.children).indexOf(th);
                
                const colgroup = tableBeingResized.querySelector('colgroup');
                colBeingResized = colgroup.children[colIndex];
                nextCol = colgroup.children[colIndex + 1];

                resizeStartX = e.clientX;
                startWidthCol = colBeingResized.offsetWidth;
                nextColStartWidth = nextCol.offsetWidth;

                document.addEventListener('mousemove', doColResize);
                document.addEventListener('mouseup', stopColResize);
            }

            function doColResize(e) {
                if (!colBeingResized || !nextCol) return;

                const diffX = e.clientX - resizeStartX;
                const minWidth = 20;

                let newWidth = startWidthCol + diffX;
                let newNextWidth = nextColStartWidth - diffX;

                if (newWidth < minWidth || newNextWidth < minWidth) {
                    return;
                }

                colBeingResized.style.width = `${newWidth}px`;
                nextCol.style.width = `${newNextWidth}px`;
            }

            function stopColResize() {
                document.removeEventListener('mousemove', doColResize);
                document.removeEventListener('mouseup', stopColResize);
            }

            document.querySelectorAll('.page table').forEach(makeTableResizable);

            /**
             * **NEW**: ฟังก์ชันสำหรับล็อก Editor
             */
            function lockEditor() {
                const editorContainer = document.getElementById('document-editor');
                editorContainer.setAttribute('contenteditable', 'false'); 

                editorContainer.querySelectorAll('.page').forEach(page => {
                    page.setAttribute('contenteditable', 'false');
                    // page.style.backgroundColor = '#f2f2f2';
                    page.style.cursor = 'not-allowed';
                });

                const toolbar = document.getElementById('toolbar');
                toolbar.querySelectorAll('button, select').forEach(el => {
                    if (el.id !== 'export-pdf-button' && el.id !== 'load-template-btn' && el.id !== 'load-default-template-btn') {
                        el.style.display = 'none';
                    }
                });
                toolbar.querySelectorAll('.toolbar-separator').forEach(el => {
                    el.style.display = 'none';
                });

                // **NEW**: ซ่อนปุ่มเลือกลายเซ็นทั้งหมด
                editor.querySelectorAll('.select-signer-btn').forEach(btn => btn.style.display = 'none');
            }

            /**
             * **NEW**: ฟังก์ชันสำหรับเพิ่มปุ่มเลือกลายเซ็น
             */
            function initializeSignatureBlocks() {
                // ค้นหา td ที่มี div ที่มี border-top (โครงสร้างของบล็อกลายเซ็น)
                const signatureBlocks = editor.querySelectorAll('td > div[style*="border-top"]');
                signatureBlocks.forEach(block => {
                    // **NEW**: ตรวจสอบว่ายังไม่มีปุ่มอยู่ก่อนที่จะเพิ่ม
                    if (!block.querySelector('.select-signer-btn')) {
                        const btn = document.createElement('button');
                        btn.innerHTML = '<i class="fa-solid fa-pen-to-square"></i> เลือก';
                        btn.className = 'select-signer-btn'; // เพิ่ม class เพื่อซ่อนตอน export
                        btn.style.cssText = 'font-size: 12px; padding: 2px 5px; margin-top: 5px; cursor: pointer;';
                        
                        btn.addEventListener('click', (e) => {
                            e.preventDefault();
                            activeSignatureBlock = block; 
                            openSignatureModal();
                        });

                        block.appendChild(btn);
                    }
                });
            }

            const loadTemplateBtn = document.getElementById('load-template-btn');
            loadTemplateBtn.addEventListener('click', () => {
                downloadTemplate();
            });

            function downloadTemplate()
            {
                loadingIndicator.style.display = 'inline-block';
                loadTemplateBtn.disabled = true;

                fetch("{{ route('download.editor.ib-doc.review.assessment') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ 
                        templateType: templateType ,
                        ibId: ibId
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('ไม่สามารถโหลดเทมเพลตได้');
                    }
                    return response.json();
                })
                .then(data => {
                    editor.innerHTML = ''; 

                    if (data.html) {
                        editor.innerHTML = data.html;
                    } else if (data.pages && Array.isArray(data.pages)) {
                        data.pages.forEach(pageHtml => {
                            const newPage = document.createElement('div');
                            newPage.className = 'page';
                            newPage.setAttribute('contenteditable', 'true');
                            newPage.innerHTML = pageHtml;
                            editor.appendChild(newPage);
                        });
                    }
                    
                    editor.querySelectorAll('table').forEach(makeTableResizable);
                    if(editor.firstChild) {
                       editor.firstChild.focus();
                    }

                    // if (data.all_signed) {
                        lockEditor();
                    // } else {
                    //     initializeSignatureBlocks();
                    // }
                    // initializeSignatureBlocks();
                    
                })
                .catch(error => {
                    console.error('Load Template Error:', error);
                    showCustomAlert(error.message);
                })
                .finally(() => {
                    loadingIndicator.style.display = 'none';
                    loadTemplateBtn.disabled = false;
                });
            }

            downloadTemplate();

            
            const loadDefaultTemplateBtn = document.getElementById('load-default-template-btn');
            loadDefaultTemplateBtn.addEventListener('click', () => {
                loadingIndicator.style.display = 'inline-block';
                loadTemplateBtn.disabled = true;

                
                
                fetch("aaa", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ 
                        templateType: templateType ,
                        ibId: ibId
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('ไม่สามารถโหลดเทมเพลตได้');
                    }
                    return response.json();
                })
                .then(data => {
                    editor.innerHTML = ''; 

                    if (data.html) {
                        editor.innerHTML = data.html;
                    } else if (data.pages && Array.isArray(data.pages)) {
                        data.pages.forEach(pageHtml => {
                            const newPage = document.createElement('div');
                            newPage.className = 'page';
                            newPage.setAttribute('contenteditable', 'true');
                            newPage.innerHTML = pageHtml;
                            editor.appendChild(newPage);
                        });
                    }
                    
                    editor.querySelectorAll('table').forEach(makeTableResizable);
                    if(editor.firstChild) {
                       editor.firstChild.focus();
                    }

                    // if (data.status === 'final') {
                        lockEditor();
                    // } else {
                    //     initializeSignatureBlocks();
                    // }
                    // initializeSignatureBlocks();
                })
                .catch(error => {
                    console.error('Load Template Error:', error);
                    showCustomAlert(error.message);
                })
                .finally(() => {
                    loadingIndicator.style.display = 'none';
                    loadTemplateBtn.disabled = false;
                });
            });
            
            // if (initialStatus === 'final') {
                lockEditor();
            // }

            /**
             * **NEW**: ฟังก์ชันเปิด Modal และดึงข้อมูลผู้ลงนาม
             */
            function openSignatureModal() {
                const modal = document.getElementById('signature-modal');
                const select = document.getElementById('signature-select');
                document.getElementById('signer-position-input').value = "";
                select.innerHTML = '<option value="">-- กรุณาเลือก --</option>'; // เคลียร์ค่าเก่า

                $.ajax({
                    url: "fff",
                    method: 'GET',
                    success: function(response) {
                        signersData = response.signers; // เก็บข้อมูลไว้ใช้ภายหลัง
                        response.signers.forEach(function(signer) {
                            const option = `<option value="${signer.id}">${signer.name}</option>`;
                            $('#signature-select').append(option);
                        });
                        modal.style.display = 'flex';
                    },
                    error: function() {
                        showCustomAlert('ไม่สามารถดึงข้อมูลผู้ลงนามได้');
                    }
                });
            }
            
            // Event listeners สำหรับ Modal
            document.getElementById('close-signature-modal').addEventListener('click', () => {
                document.getElementById('signature-modal').style.display = 'none';
            });
            document.getElementById('cancel-signature-btn').addEventListener('click', () => {
                document.getElementById('signature-modal').style.display = 'none';
            });

            // ======================= MODIFIED THIS BLOCK =======================
            // document.getElementById('confirm-signature-btn').addEventListener('click', () => {
            //     const selectedId = $('#signature-select').val();
            //     const newPosition = $('#signer-position-input').val();
            //     const selectedSequence = $('#signer-sequence-select').val(); // ดึงค่าลำดับ
                
            //     if (selectedId && activeSignatureBlock) {
            //         const selectedSigner = signersData.find(s => s.id == selectedId);
            //         if (selectedSigner) {
            //             // บันทึกลำดับเป็น data attribute
            //             activeSignatureBlock.setAttribute('data-signer-id', selectedSigner.id);
            //             activeSignatureBlock.setAttribute('data-signer-name', selectedSigner.name);
            //             activeSignatureBlock.setAttribute('data-signer-position', newPosition);
            //             activeSignatureBlock.setAttribute('data-signer-sequence', selectedSequence);

            //             const imgElement = activeSignatureBlock.parentElement.querySelector('img');
            //             const pElements = activeSignatureBlock.querySelectorAll('p');
                        
            //             if (imgElement) {
            //                 imgElement.src = selectedSigner.signature_img_path; 
            //                 imgElement.alt = `ลายเซ็นต์ ${selectedSigner.name}`;
            //             }
            //             if (pElements.length > 0) pElements[0].textContent = `(${selectedSigner.name})`;
            //             if (pElements.length > 1 && newPosition) pElements[1].textContent = newPosition;
            //         }
            //     }
            //     document.getElementById('signature-modal').style.display = 'none';
            // });
            document.getElementById('confirm-signature-btn').addEventListener('click', () => {
                const selectedId = $('#signature-select').val();
                const newPosition = $('#signer-position-input').val();
                const selectedSequence = $('#signer-sequence-select').val();

                if (!newPosition) {
                    alert('กรุณากรอกตำแหน่ง');
                    return;
                }

                // --- เริ่ม: โค้ดตรวจสอบลำดับซ้ำ ---
                const allSignatureBlocks = editor.querySelectorAll('td > div[style*="border-top"]');
                for (const block of allSignatureBlocks) {
                    // ไม่ต้องตรวจสอบกับบล็อกที่กำลังแก้ไขอยู่
                    if (block === activeSignatureBlock) {
                        continue;
                    }

                    const existingSequence = block.getAttribute('data-signer-sequence');
                    // ถ้าลำดับที่เลือก (selectedSequence) ตรงกับลำดับที่มีอยู่แล้ว (existingSequence)
                    if (existingSequence && existingSequence === selectedSequence) {
                        alert('ลำดับนี้ถูกใช้ไปแล้ว กรุณาเลือกลำดับอื่น');
                        return; // หยุดการทำงานทันที
                    }
                }
                // --- จบ: โค้ดตรวจสอบลำดับซ้ำ ---

                // ถ้าไม่ซ้ำ โค้ดด้านล่างนี้จะทำงานตามปกติ
                activeSignatureBlock.setAttribute('data-signer-sequence', selectedSequence);
                
                if (selectedId && activeSignatureBlock) {
                    const selectedSigner = signersData.find(s => s.id == selectedId);
                    if (selectedSigner) {
                        activeSignatureBlock.setAttribute('data-signer-id', selectedSigner.id);
                        activeSignatureBlock.setAttribute('data-signer-name', selectedSigner.name);
                        activeSignatureBlock.setAttribute('data-signer-position', newPosition);

                        const imgElement = activeSignatureBlock.parentElement.querySelector('img');
                        const pElements = activeSignatureBlock.querySelectorAll('p');
                        
                        if (imgElement) {
                            imgElement.src = selectedSigner.signature_img_path; 
                            imgElement.alt = `ลายเซ็นต์ ${selectedSigner.name}`;
                        }
                        if (pElements.length > 0) pElements[0].textContent = `(${selectedSigner.name})`;
                        if (pElements.length > 1 && newPosition) pElements[1].textContent = newPosition;
                    }
                }
                document.getElementById('signature-modal').style.display = 'none';
            });

            // ===================================================================


            function saveData(status) {
                loadingIndicator.style.display = 'inline-block';
                saveButton.disabled = true;
                saveDraftButton.disabled = true;
                
                const signersArray = [];
                const signatureBlocks = editor.querySelectorAll('td > div[style*="border-top"]');

                if (status === 'final') {
                    let allSigned = true;
                    signatureBlocks.forEach(block => {
                        if (!block.hasAttribute('data-signer-id')) {
                            allSigned = false;
                        }
                    });

                    if (!allSigned) {
                        showCustomAlert('กรุณาเลือกผู้ลงนามให้ครบทุกช่อง');
                        loadingIndicator.style.display = 'none';
                        saveButton.disabled = false;
                        saveDraftButton.disabled = false;
                        return; 
                    }
                }

                // ======================= MODIFIED THIS BLOCK =======================
                signatureBlocks.forEach(block => {
                    if (block.hasAttribute('data-signer-id')) {
                        // เพิ่ม sequence เข้าไปใน object ที่จะส่ง
                        signersArray.push({
                            id: block.getAttribute('data-signer-id'),
                            name: block.getAttribute('data-signer-name') || '',
                            position: block.getAttribute('data-signer-position') || '',
                            sequence: block.getAttribute('data-signer-sequence') || '1' 
                        });
                    }
                });
                // ===================================================================
                
                // **NEW**: Clone editor เพื่อลบปุ่มก่อนบันทึก
                const editorCloneForSave = editor.cloneNode(true);
                editorCloneForSave.querySelectorAll('.select-signer-btn').forEach(btn => btn.remove());

                editorCloneForSave.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
                    if (checkbox.checked) {
                        checkbox.setAttribute('checked', 'checked');
                    } else {
                        checkbox.removeAttribute('checked');
                    }
                });
                
                const htmlContentForSave = editorCloneForSave.innerHTML;

                fetch("bbb", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ 
                        html_content: htmlContentForSave,
                        ibId: ibId,
                        templateType: templateType,
                        status: status,
                        signers: signersArray
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(err => { throw new Error(err.message || 'เกิดข้อผิดพลาดในการบันทึก') });
                    }
                    return response.json();
                })
                .then(data => {
                    // showCustomAlert(data.message || 'บันทึกสำเร็จ!', 'สำเร็จ');
                    // if (status === 'final') {
                        lockEditor();
                    // }

                    //  // ตรวจสอบว่ามี redirect_url ส่งมาหรือไม่
                    if (data.success && data.redirect_url) {
                        // สั่งให้เบราว์เซอร์เปลี่ยนหน้าไปยัง URL ที่ได้รับมา
                        window.location.href = data.redirect_url;
                    }
                })
                .catch(error => {
                    console.error('Save Error:', error);
                    showCustomAlert(error.message || 'เกิดข้อผิดพลาดที่ไม่ทราบสาเหตุ');
                })
                .finally(() => {
                    loadingIndicator.style.display = 'none';
                    if (status !== 'final') {
                        saveButton.disabled = false;
                        saveDraftButton.disabled = false;
                    }
                });
            }

            saveDraftButton.addEventListener('click', () => saveData('draft'));
            saveButton.addEventListener('click', () => saveData('final'));


            exportButton.addEventListener('click', () => {
                loadingIndicator.style.display = 'inline-block';
                exportButton.disabled = true;
                
                const editorClone = editor.cloneNode(true);

                // **สำคัญ**: ลบปุ่มเลือกลายเซ็นออกจาก clone ก่อน export
                editorClone.querySelectorAll('.select-signer-btn').forEach(btn => btn.remove());

                editor.querySelectorAll('input[type="checkbox"]').forEach((originalCheckbox, index) => {
                    if (originalCheckbox.checked) {
                        editorClone.querySelectorAll('input[type="checkbox"]')[index].setAttribute('checked', 'checked');
                    } else {
                        editorClone.querySelectorAll('input[type="checkbox"]')[index].removeAttribute('checked');
                    }
                });

                editorClone.querySelectorAll('.resizable-image-wrapper, .selected-table-cell, .col-resizer').forEach(el => {
                    if(el) el.remove();
                });

                editorClone.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
                    const symbol = document.createTextNode(checkbox.hasAttribute('checked') ? '☑' : '☐');
                    if (checkbox.parentNode) {
                        checkbox.parentNode.replaceChild(symbol, checkbox);
                    }
                });
                
                const htmlContentForPdf = editorClone.innerHTML;

                fetch("ccc", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ html_content: htmlContentForPdf })
                })
                .then(response => {
                    if (!response.ok) {
                        return response.text().then(text => { throw new Error('เกิดข้อผิดพลาดจาก Server: ' + text) });
                    }
                    return response.blob();
                })
                .then(blob => {
                    const url = window.URL.createObjectURL(blob);
                    window.open(url, '_blank');
                })
                .catch(error => {
                    console.error('Export Error:', error);
                    showCustomAlert(error.message || 'เกิดข้อผิดพลาดที่ไม่ทราบสาเหตุ');
                })
                .finally(() => {
                    loadingIndicator.style.display = 'none';
                    exportButton.disabled = false;
                });
            });

            function showCustomAlert(message, title = 'ข้อผิดพลาด') {
                const alertModal = document.createElement('div');
                alertModal.className = 'modal-backdrop';
                alertModal.innerHTML = `
                    <div class="modal">
                        <div class="modal-header">
                            <h3>${title}</h3>
                            <button class="modal-close-btn">&times;</button>
                        </div>
                        <div class="modal-body">
                            <p>${message}</p>
                        </div>
                        <div class="modal-footer">
                            <button class="modal-button primary">ตกลง</button>
                        </div>
                    </div>
                `;
                document.body.appendChild(alertModal);

                const closeBtn = alertModal.querySelector('.modal-close-btn');
                const okBtn = alertModal.querySelector('.modal-button.primary');

                const closeModal = () => {
                    alertModal.remove();
                };

                closeBtn.addEventListener('click', closeModal);
                okBtn.addEventListener('click', closeModal);
            }
        });
    </script>
</body>
</html>
