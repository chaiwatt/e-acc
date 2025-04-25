<style>
    .isic-table {
        width: 690px;
        border-collapse: collapse;
        font-family: "TH Sarabun New", sans-serif;
        font-size: 16px;
    }
    .isic-table th, .isic-table td {
        border: 1px solid black;
        padding: 8px;
        text-align: left;
    }
    .isic-table th {
        background-color: #f2f2f2;
        font-weight: bold;
        text-align: center;
        font-size: 20px;
    }

    .isic-code {
        width: 20%;
        text-align: center;
        font-weight: bold;
    }
    .description {
        width: 80%;
    }
    .sub-text {
        font-size: 14px;
        font-style: italic;
    }
</style>

    <table class="isic-table" style="margin-top: 20px">
        <tr>
            <th class="isic-code">รหัสหมวด<br><span style="font-size: 16px; font-weight: normal;">(Sector Codes)</span></th>
            <th class="description">กิจกรรม<br><span style="font-size: 16px; font-weight: normal;">(Description)</span></th>
        </tr>

        @foreach ($cbScopeBcmsTransactions as $key => $cbScopeBcmsTransaction)
        {{-- @php
            dd($cbScopeBcmsTransaction->cbScopeBcms);
        @endphp --}}
            <tr>
                <td class="isic-code" style="text-align: center;font-size:22px; font-weight: normal;">{{$cbScopeBcmsTransaction->cbScopeBcms->category}} 
                    <span style="font-size: 0.01px">*{{$key}}*</span>
                </td>
                <td class="description" style="font-size:22px">
                    {{$cbScopeBcmsTransaction->cbScopeBcms->activity_th}}<br>
                    <span class="sub-text">({{$cbScopeBcmsTransaction->cbScopeBcms->activity_en}})</span>
                </td>
            </tr>
        @endforeach
    </table> 

    <table style="margin-top: 30px">
        <tr>
            <td style="width: 430px"></td>
            <td>
                <div >
  
                    @php
                        // $issuedDate = "";
                        $startDate = "";
                        $toDate = "";
                        // $issuedDateEn = "";
                        $startDateEn = "";
                        $toDateEn = "";
                        $tmpIssueDate = \Carbon\Carbon::now()->format('Y/m/d');

                        $issuedDate = HP::formatDateThaiFull($tmpIssueDate);
                        $issuedDateEn  = HP::BEDate($tmpIssueDate);

                        if($app_certi_cb->app_certi_cb_export != null)
                        {
                            if($app_certi_cb->app_certi_cb_export->date_start != null)
                            {
                                $startDate = HP::formatDateThaiFull($strDate);
                                $startDateEn  = HP::BEDate($app_certi_cb->app_certi_cb_export->date_start);

                                $tmpToDate = \Carbon\Carbon::parse($strDate)->addYears(5)->format('Y/m/d');
                                $toDate = HP::formatDateThaiFull($tmpToDate);
                                $toDateEn  = HP::BEDate($tmpToDate);
                            }
                        }
                    @endphp
                    <span style="font-size:22px">ตั้งแต่ วันที่ {{$startDate}}</span><br>
                    <span style="font-size:18px">(Valid from) {{$startDateEn}}</span><br>
                    <span style="font-size:22px">ถึงวันที่ วันที่ {{$toDate}}</span><br>
                    <span style="font-size:18px">(Valid from) {{$toDateEn}}</span><br>
                    <span style="font-size:22px">ออกให้ ณ วันที่ {{$issuedDate}}</span><br>
                    <span style="font-size:18px">(Valid from) {{$issuedDateEn}}</span>
                </div>
            </td>
        </tr>
    </table> 
    
</div>
