    <div class="lab-header">
        <div class="main">
            <div class="inline-block  w-100 text-center float-left" >
                <span class="title">รายละเอียดสาขาและขอบข่ายใบรับรองห้องปฏิบัติการ</span>
                 <br>
                 <span class="title_en" style="font-weight: 400"> (Scope of Accreditation for Calibration)</span>
                
                <br>
                <div style="display: inline-block; height:5px"></div>
                <span class="cer_no" style="line-height: 5px !important;"><strong>ใบรับรองเลขที่ {{$pdfData->certificate_no}}</strong> 

                </span>
                <br>
                    <span class="cer_no_en">(Certification no. {{$pdfData->certificate_no}})</span>
                
            </div>
        </div>
    
        <div class="info" style="margin-top: 7px">
            <div class="inline-block w-20 p-0 float-left">ชื่อห้องปฏิบัติการ <br> <span>(Laboratoy Name)</span> </div>
            <div class="inline-block w-78 float-left">{{$company->app_certi_lab->lab_name}} <br> <span>({{$company->app_certi_lab->lab_name_en}})</span></div>
        </div>
    
        <div class="info">
            <div class="inline-block w-20 float-left" style="margin-top:7px">หมายเลขการรับรองที่<br> <span>(Accreditation No.)</span> </div>
            <div class="inline-block w-78">ทดสอบ {{$pdfData->acc_no}}<br> <span>(Calibration {{$pdfData->acc_no}})</span></div>
        </div>
    
        <div class="info">
            <div class="inline-block w-20 float-left" style="margin-top:7px">ฉบับที่ {{$pdfData->book_no}}<br> <span>(Issue No. {{$pdfData->book_no}})</span></div>
            <div class="inline-block w-78">
                <div class="inline-block w-55 float-left">
                    ออกให้ตั้งแต่วันที่ {{$pdfData->from_date_th}}<br> <span style="padding-left:20px">(Valid from) &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;({{$pdfData->from_date_en}})</span>
                </div>
                <div class="inline-block w-40 float-right">
                    ถึงวันที่ {{$pdfData->to_date_th}}<br> <span>(Until) ({{$pdfData->to_date_en}})</span>
                </div>
            </div>
        </div>
    
        <div class="info">
            <div class="inline-block w-20 float-left" style="margin-top:7px">สถานภาพห้องปฏิบัติการ<br> <span>(Laboratory status)</span></div>
            <div class="inline-block w-78">
                <div class="inline-block w-17 float-left">
                    @if ($company->id == 1)
                        <!-- ตรวจสอบว่า uniqueKeys มี "pl_2_1_main" หรือไม่ -->
                        <input type="checkbox" {{ in_array("pl_2_1_main", $pdfData->uniqueKeys) ? 'checked="checked"' : '' }}>ถาวร<br> <span>(Permanent)</span>
                    @else
                        <!-- ตรวจสอบว่า uniqueKeys มี "pl_2_1_branch" หรือไม่ -->
                        <input type="checkbox" {{ in_array("pl_2_1_branch", $pdfData->uniqueKeys) ? 'checked="checked"' : '' }}>ถาวร<br> <span>(Permanent)</span>
                    @endif
                </div>
                <div class="inline-block w-20 float-left">
                    @if ($company->id == 1)
                        <!-- ตรวจสอบว่า uniqueKeys มี "pl_2_1_main" หรือไม่ -->
                        <input type="checkbox" {{ in_array("pl_2_2_main", $pdfData->uniqueKeys) ? 'checked="checked"' : '' }}>นอกสถานที่<br> <span>(Site)</span>
                    @else
                        <!-- ตรวจสอบว่า uniqueKeys มี "pl_2_1_branch" หรือไม่ -->
                        <input type="checkbox" {{ in_array("pl_2_2_branch", $pdfData->uniqueKeys) ? 'checked="checked"' : '' }}>นอกสถานที่<br> <span>(Site)</span>
                    @endif
                </div>
                <div class="inline-block w-20 float-left">
                    @if ($company->id == 1)
                        <!-- ตรวจสอบว่า uniqueKeys มี "pl_2_1_main" หรือไม่ -->
                        <input type="checkbox" {{ in_array("pl_2_3_main", $pdfData->uniqueKeys) ? 'checked="checked"' : '' }}>ชั่วคราว<br> <span>(Temporary)</span>
                    @else
                        <!-- ตรวจสอบว่า uniqueKeys มี "pl_2_1_branch" หรือไม่ -->
                        <input type="checkbox" {{ in_array("pl_2_3_branch", $pdfData->uniqueKeys) ? 'checked="checked"' : '' }}>ชั่วคราว<br> <span>(Temporary)</span>
                    @endif
                </div>
                <div class="inline-block w-20 float-left">
                    @if ($company->id == 1)
                        <!-- ตรวจสอบว่า uniqueKeys มี "pl_2_1_main" หรือไม่ -->
                        <input type="checkbox" {{ in_array("pl_2_4_main", $pdfData->uniqueKeys) ? 'checked="checked"' : '' }}>เคลื่อนที่<br> <span>(Mobile)</span>
                    @else
                        <!-- ตรวจสอบว่า uniqueKeys มี "pl_2_1_branch" หรือไม่ -->
                        <input type="checkbox" {{ in_array("pl_2_4_branch", $pdfData->uniqueKeys) ? 'checked="checked"' : '' }}>เคลื่อนที่<br> <span>(Mobile)</span>
                    @endif
                </div>
                <div class="inline-block w-17 float-left">
                    <input type="checkbox" {{ $pdfData->siteType == "multi" ? 'checked="checked"' : '' }} >หลายสถานที่<br> <span>(Multisite)</span>
                </div>
            </div>
        </div>
    </div>
    
    <div class="content">
        <table width="100%" style="border: 0.3px solid #000; border-collapse: collapse;margin-top:3px" cellspacing="0" cellpadding="5">
            <thead>
                <tr>
                    <td class="text-center" style="border: 0.3px solid #000;width:33.33%;font-size: 22px;padding-left:3px;padding-right:3px">
                        สาขาการทดสอบ<br><span style="font-size: 14px;">(Field of Testing)</span>
                    </td>
                    <td class="text-center" style="border: 0.3px solid #000;width:33.33%;font-size: 22px;">
                        รายการทดสอบ<br><span style="font-size: 14px;">(Parameter)</span>
                    </td>
                    <td class="text-center" style="border: 0.3px solid #000;width:33.33%;font-size: 22px;">
                        วิธีการสอบเทียบ<br><span style="font-size: 14px;">(Test Method)</span>
                    </td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="border: 0.3px solid #000;width:33.33%;font-size: 22px;">
                        <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                        <br><br><br><br><br><br><br><br><br><br><br>
                    </td>
                    <td style="border: 0.3px solid #000;width:33.33%;font-size: 22px;"></td>
                    <td style="border: 0.3px solid #000;width:33.33%;font-size: 22px;"></td>
                    
                </tr>
            </tbody>
        </table>
        
    </div>
    