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
        {{-- <tr>
            <th class="isic-code">รหัส ISIC<br><span style="font-size: 16px; font-weight: normal;">(ISIC Codes)</span></th>
            <th class="description">กิจกรรม<br><span style="font-size: 16px; font-weight: normal;">(Description)</span></th>
        </tr> --}}
   
        @foreach ($cbScopeIsicTransactions as $key => $cbScopeIsicTransaction)
            <tr>
                <td class="isic-code" style="text-align: center;font-size:20px">{{$cbScopeIsicTransaction->isic->isic_code}} <span style="font-size: 0.01px">*{{$key}}*</span></td>
                <td class="description" style="font-size:22px">
                    {{$cbScopeIsicTransaction->isic->description_th}}<br>
                    <span class="sub-text">({{$cbScopeIsicTransaction->isic->description_en}})</span>
                </td>
            </tr>
        @endforeach
    </table>

    {{-- <table style="margin-top: 30px">
        <tr>
            <td style="width: 62%"></td>
            <td>
                <div >
                    <span style="font-size:22px">ตั้งแต่ วันที่ ๑๓ กันยายน พ.ศ. ๒๕๖๖</span><br>
                    <span style="font-size:18px">(Valid from) 13 September B.E. 2566 (2023)</span><br>
                    <span style="font-size:22px">ถึงวันที่ วันที่ ๑๑ มิถุนายน พ.ศ. ๒๕๗๑</span><br>
                    <span style="font-size:18px">(Valid from) ๑๑ June B.E. 2571 (2028)</span><br>
                    <span style="font-size:22px">ออกให้ ณ วันที่ ๑๓ กันยายน พ.ศ. ๒๕๖๖</span><br>
                    <span style="font-size:18px">(Valid from) 13 September B.E. 2566 (2023)</span>
                </div>
            </td>
        </tr>
    </table> --}}
    
</div>
