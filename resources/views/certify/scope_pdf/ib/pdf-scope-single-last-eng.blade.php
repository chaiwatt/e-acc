<style>
    .ib-scope-table {
        width: 690px;
        border-collapse: collapse;
        font-family: "TH Sarabun New", sans-serif;
        font-size: 16px;
    }
    .ib-scope-table th, .ib-scope-table td {
        border: 1px solid black;
        padding: 8px;
        text-align: left;
    }
    .ib-scope-table th {
        background-color: #f2f2f2;
        font-weight: bold;
        text-align: center;
        font-size: 20px;
    }

    .ib-category {
        width: 30%;
        text-align: center;
        font-weight: bold;
    }
    .description {
        width: 35%;
    }
    .sub-text {
        font-size: 14px;
        font-style: italic;
    }
</style>



<table style="margin-top: 30px">
    <tr>
        <td style="width: 430px"></td>
        <td>
            <div >

                {{-- @php
                    $tmpIssueDate = \Carbon\Carbon::now()->format('Y/m/d');
                    $issuedDate = HP::formatDateThaiFull($tmpIssueDate);
                    $issuedDateEn  = HP::BEDate($tmpIssueDate);
                @endphp --}}

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

                    if($app_certi_ib->app_certi_ib_export != null)
                    {
                        if($app_certi_ib->app_certi_ib_export->date_start != null)
                        {
                            $startDate = HP::formatDateThaiFull($strDate);
                            $startDateEn  = HP::BEDate($app_certi_ib->app_certi_ib_export->date_start);

                            $tmpToDate = \Carbon\Carbon::parse($strDate)->addYears(5)->format('Y/m/d');
                            $toDate = HP::formatDateThaiFull($tmpToDate);
                            $toDateEn  = HP::BEDate($tmpToDate);   
                        }
                    }
                @endphp
                <span style="font-size:21px">Valid from : {{$startDateEn}}</span><br>
                <span style="font-size:21px">Until : {{$toDateEn}}</span><br>
                <span style="font-size:21px">Issue Date : {{$issuedDateEn}}</span>
            </div>
        </td>
    </tr>
</table> 


    
</div>
