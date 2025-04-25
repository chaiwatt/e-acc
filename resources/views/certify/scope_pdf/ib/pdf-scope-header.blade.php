
<div class="lab-header">
    <div class="main">
        <div class="inline-block  w-100 text-center float-left" >
            <span class="title" style="font-size: 24px">รายละเอียดแนบท้ายใบรับรองระบบงานหน่วยตรวจ</span>

            <br>
            <div style="display: inline-block; height: 8px"></div>
            @php
                $certificate = "xx-IBxxxx";
                if($app_certi_ib->app_certi_ib_export != null)
                {
                    if($app_certi_ib->app_certi_ib_export->certificate != null)
                    {
                        $certificate = $app_certi_ib->app_certi_ib_export->certificate;
                    }
                }
            @endphp
            <span class="cer_no" style="line-height: 5px !important"><strong>ใบรับรองเลขที่ {{$certificate}}</strong></span>

        </div>
    </div>



    <table>
        <tr>
            <td style="width:23%;vertical-align:top"><strong><span style="font-size:21px">ชื่อหน่วยตรวจ</span></strong></td>
            <td style="vertical-align:top"><span style="font-size:21px">: {{$app_certi_ib->name_unit}}</span></td>
        </tr>
    </table>

    <table>
        <tr>
            <td style="width:98%;vertical-align:top"><strong><span style="font-size:21px">ที่ตั้งสถานประกอบการของหน่วยตรวจและข้อมูลติดต่อ :</span></strong></td>
            <td style="vertical-align:top"></td>
        </tr>
    </table>
    <table>
        <tr>
            <td style="width:50%;vertical-align:top;padding-left:15px">
                <span style="font-weight: bold">ที่ตั้งสำนักงานใหญ่</span><br>
                @if ($app_certi_ib->hq_address != null)
                        {{$app_certi_ib->hq_address}}
                    @endif
                    @if ($app_certi_ib->hq_moo != null)
                        หมู่ที่{{$app_certi_ib->hq_moo}}
                    @endif
                    @if ($app_certi_ib->hq_soi != null)
                        ซอย{{$app_certi_ib->hq_soi}}
                    @endif
                    @if ($app_certi_ib->hq_road != null)
                        ถนน{{$app_certi_ib->hq_road}}
                    @endif
                    @if (strpos($app_certi_ib->hq_province->PROVINCE_NAME, 'กรุงเทพ') !== false)
                    แขวง {{$app_certi_ib->hq_subdistrict->DISTRICT_NAME}} เขต{{$app_certi_ib->hq_district->AMPHUR_NAME}} {{$app_certi_ib->hq_province->PROVINCE_NAME}}
                @else
                    ตำบล{{$app_certi_ib->hq_subdistrict->DISTRICT_NAME}}  อำเภอ{{$app_certi_ib->hq_district->AMPHUR_NAME}}  จังหวัด{{$app_certi_ib->hq_province->PROVINCE_NAME}}
                @endif
            </td>
            <td style="width:50%;vertical-align:top">
                <span style="font-weight: bold">ที่ตั้งสำนักงานสาขา (กรณีแตกต่างจากที่ตั้งสำนักงานใหญ่)</span><br>
                @if ($app_certi_ib->address != null)
                        {{$app_certi_ib->address}}
                @endif
                    @if ($app_certi_ib->allay != null)
                        หมู่ที่{{$app_certi_ib->allay}}
                    @endif
                    @if ($app_certi_ib->village_no != null)
                        ซอย{{$app_certi_ib->village_no}}
                    @endif
                    @if ($app_certi_ib->road != null)
                        ถนน{{$app_certi_ib->road}}
                    @endif
                    @if (strpos($app_certi_ib->BasicProvince->PROVINCE_NAME, 'กรุงเทพ') !== false)
                    แขวง {{$app_certi_ib->district_id}} เขต{{$app_certi_ib->amphur_id}} {{$app_certi_ib->BasicProvince->PROVINCE_NAME}}
                @else
                    ตำบล{{$app_certi_ib->district_id}}  อำเภอ{{$app_certi_ib->amphur_id}}  จังหวัด{{$app_certi_ib->BasicProvince->PROVINCE_NAME}}
                @endif
            </td>
        </tr>
    </table>

    <table>
        @php
                        $accereditation = "หน่วยตรวจ xxxx";
                    if($app_certi_ib->app_certi_ib_export != null)
                    {
                        if($app_certi_ib->app_certi_ib_export->accereditatio_no != null)
                        {
                            $accereditation = $app_certi_ib->app_certi_ib_export->accereditatio_no;
                             
                        }
                    }
            @endphp
        @endphp
        <tr>
            <td style="width:23%;vertical-align:top"><strong><span style="font-size:21px">หมายเลขการรับรอง</span></strong></td>
            <td style="vertical-align:top"><span style="font-size:21px">: {{$accereditation}}</span>
            </td>
        </tr>
    </table>
    <table>
        <tr>
            <td style="width:23%;vertical-align:top"><strong><span style="font-size:21px">ประเภทของหน่วยตรวจ</span></strong></td>
            <td style="vertical-align:top"><span style="font-size:21px">: {{$app_certi_ib->typeUnitTitle}}</span>
            </td>
        </tr>
    </table>
    {{-- <table> --}}




{{-- 
        <tr>
            <td style="width:23%;vertical-align:top"><strong><span style="font-size:21px">หมายเลขการรับรอง</span></strong></td>
            <td style="vertical-align:top">:xxx</td>
        </tr>
        <tr>
            <td style="width:23%;vertical-align:top"><strong><span style="font-size:20px">ประเภทของหน่วยตรวจ</span></strong></td>
            <td style="vertical-align:top"><span style="font-size:21px">: xxx โดยมีสาขาและขอบข่ายตามมาตรฐาน xxx</span></td>
        </tr>
    </table> --}}


    
</div>
