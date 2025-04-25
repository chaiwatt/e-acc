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
</div>
