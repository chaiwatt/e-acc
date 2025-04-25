
<div class="lab-header">
    <div class="main">
        <div class="inline-block  w-100 text-center float-left" >
            <span class="title" style="font-size: 24px">สาขาและขอบข่ายการรับรองระบบงาน</span>
             <br>
             <span class="title_en" style="font-weight: 400;font-size: 16px"> (Scope of Accreditation)</span>
            <br>
            <div style="display: inline-block; height: 8px"></div>
            <span class="cer_no" style="line-height: 5px !important"><strong>แนบท้ายใบรับรองระบบงาน:</strong> {{$app_certi_cb->certificationBranch->title}}

            </span>
            <br>
                <span class="cer_no_en" style="font-size: 16px">(Attachment to Certificate of Quality Management System Certification Body Accreditation)</span>
            <br> 
            <div style="display: inline-block; height:8px"></div>
            @php
                $certificate = "xx-CBxxxx";
                if($app_certi_cb->app_certi_cb_export != null)
                {
                    if($app_certi_cb->app_certi_cb_export->certificate != null)
                    {
                        $certificate = $app_certi_cb->app_certi_cb_export->certificate;
                    }
                }
            @endphp
            <span class="cer_no" style="line-height: 5px !important"><strong>ใบรับรองเลขที่ {{$certificate}}</strong> 

            </span>
            <br>
                <span class="cer_no_en" style="font-size: 16px">(Certification No. {{$certificate}})</span> 
        </div>
    </div>
    <table>
        <tr>
            <td style="width:23%;vertical-align:top"><strong><span style="font-size:21px">หน่วยรับรอง</span></strong>  <br> <span style="font-size:16px">(Certification Body)</td>
            <td style="vertical-align:top"><span style="font-size:21px">: {{$app_certi_cb->name_standard}} </span><br> <span style="font-size:16px">({{$app_certi_cb->name_en_standard}})</span></td>
        </tr>

        <tr>
            <td style="width:23%;vertical-align:top"><strong><span style="font-size:21px">ที่ตั้งสถานประกอบการ</span></strong> <br> <span style="font-size:16px">(Premise)</span> </td>
            <td style="vertical-align:top"><span style="font-size:21px">: 
                @if ($app_certi_cb->address != null)
                    {{$app_certi_cb->address}}
                @endif
                @if ($app_certi_cb->allay != null)
                    หมู่ที่{{$app_certi_cb->allay}}
                @endif
                @if ($app_certi_cb->village_no != null)
                    ซอย{{$app_certi_cb->village_no}}
                @endif
                @if ($app_certi_cb->road != null)
                    ถนน{{$app_certi_cb->road}}
                @endif
                @if (strpos($app_certi_cb->BasicProvince->PROVINCE_NAME, 'กรุงเทพ') !== false)
                แขวง {{$app_certi_cb->district_id}} เขต{{$app_certi_cb->amphur_id}} {{$app_certi_cb->BasicProvince->PROVINCE_NAME}}
            @else
                ตำบล{{$app_certi_cb->district_id}}  อำเภอ{{$app_certi_cb->amphur_id}}  จังหวัด{{$app_certi_cb->BasicProvince->PROVINCE_NAME}}
            @endif
        </span><br> <span style="font-size:16px">(@if ($app_certi_cb->cb_address_no_eng != null){{$app_certi_cb->cb_address_no_eng}}
            @endif
            @if ($app_certi_cb->cb_moo_eng != null)
                Moo {{$app_certi_cb->cb_moo_eng}}
            @endif
            @if ($app_certi_cb->cb_soi_eng != null)
                Soi{{$app_certi_cb->cb_soi_eng}}
            @endif
            @if ($app_certi_cb->cb_street_eng != null)
                Road{{$app_certi_cb->cb_street_eng}}
            @endif

            {{$app_certi_cb->cb_district_eng}}  {{$app_certi_cb->cb_amphur_eng}}  {{$app_certi_cb->BasicProvince->PROVINCE_NAME_EN}})</span></td>
        </tr>

        <tr>
            <td style="width:23%;vertical-align:top"><strong><span style="font-size:21px">ข้อกำหนดที่ใช้ในการรับรอง</span></strong> <br> <span style="font-size:16px">(Accreditation criteria)</span></td>
            <td style="vertical-align:top">:{{$app_certi_cb->FormulaTo->title}}<br> <span style="font-size:16px">(Accreditation criteria)</span></td>
        </tr>
        <tr>
            <td style="width:23%;vertical-align:top"><strong><span style="font-size:20px">กิจกรรมที่ได้รับการรับรอง</span></strong> <br> <span style="font-size:14px">(Certification Mark)</span> </td>
            <td style="vertical-align:top"><span style="font-size:21px">: การรับรองระบบการบริหารงานคุณภาพตามมาตรฐาน {{$app_certi_cb->FormulaTo->tis_no}} โดยมีสาขาและขอบข่ายตามมาตรฐาน {{$app_certi_cb->FormulaTo->condition_th}} ดังต่อไปนี้</span><br> <span style="font-size:16px">({{$app_certi_cb->FormulaTo->condition_en}})</span></td>
        </tr>
    </table>


    
</div>
