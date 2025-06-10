<style>
    .ib-scope-table {
        width: 690px;
        border-collapse: collapse;
        font-family: "TH Sarabun New", sans-serif;
        font-size: 16px;
    }
    .ib-scope-table td {
        border: 1px solid black;
        padding: 8px;
        vertical-align: top;
    }
    .no-border {
        border: none !important;
    }
    .sub-table {
        width: 100%;
        border: none;
        /* margin-top: -15px; */
    }
    .sub-table td {
        border: none;
        padding: 0;
    }
    .detail-table {
        width: 100%;
        border: none;
    }
    .detail-table td {
        border: none;
        padding: 0;
    }
    ul {
        list-style-type: none;
        margin: 0;
        padding: 0;
    }
    li {
        margin: 0;
        padding: 0;
        line-height: 1.2;
    }
    .hidden-span {
        visibility: hidden;
    }
</style>

@php
    // Group transactions by main category
    $groupedTransactions = $ibScopeTransactions->groupBy(function ($item) {
        return $item->ibMainCategoryScope ? $item->ibMainCategoryScope->name : '';
    });

    // Transform into the groupedArray structure
    $groupedArray = $groupedTransactions->map(function ($transactions, $mainCategoryText) {
        // Group by sub-category
        $subGrouped = $transactions->groupBy(function ($item) {
            return $item->ibSubCategoryScope ? $item->ibSubCategoryScope->name : '';
        });

        $subCategories = $subGrouped->map(function ($transactions, $subCategoryText) {
            // Group by scope topic
            $topicGrouped = $transactions->groupBy(function ($item) {
                return $item->ibScopeTopic ? $item->ibScopeTopic->name : '';
            });

            $scopeTopics = $topicGrouped->map(function ($transactions, $scopeTopicText) {
                return [
                    'scopeTopicText' => $scopeTopicText,
                    'transactions' => $transactions->filter(function ($transaction) {
                        return $transaction->ib_scope_detail_id !== null;
                    })->values()
                ];
            })->values();

            return [
                'subCategoryText' => $subCategoryText,
                'scopeTopics' => $scopeTopics
            ];
        })->values();

        return [
            'mainCategoryText' => $mainCategoryText,
            'subCategories' => $subCategories
        ];
    })->values();
@endphp

<table class="ib-scope-table">
    @foreach ($groupedArray as $group)
        @php
            $mainCategoryTextResult = TextHelper::callLonganTokenizePost($group['mainCategoryText']);
            $mainCategoryTextResult = str_replace('!', '<span class="hidden-span">!</span>', $mainCategoryTextResult);
        @endphp
        <tr>
            <td>
                <span style="font-size: 22px; word-spacing: -0.2em;">{!! $mainCategoryTextResult !!}</span>
            </td>
            <td>
                <span class="hidden-span" style="font-size: 22px; word-spacing: -0.2em;">{!! $mainCategoryTextResult !!}</span>
            </td>
            <td>
                <span class="hidden-span" style="font-size: 22px; word-spacing: -0.2em;">{!! $mainCategoryTextResult !!}</span>
            </td>
        </tr>

        @foreach ($group['subCategories'] as $subCategory)
            @php
                $subCategoryArray = explode(',', $subCategory['subCategoryText']);
                $subCategoryArray = array_map('trim', $subCategoryArray);
            @endphp
            <tr>
                <td style="padding-left: 15px;">
                    <ul>
                        @foreach ($subCategoryArray as $subCat)
                            @php
                                $subCategoryTextResult = TextHelper::callLonganTokenizePost($subCat);
                                $subCategoryTextResult = str_replace('!', '<span class="hidden-span">!</span>', $subCategoryTextResult);
                            @endphp
                            <li><span style="font-size: 22px; word-spacing: -0.2em;">- {!! $subCategoryTextResult !!}</span></li>
                        @endforeach
                    </ul>
                </td>
                <td>
                    
                    <table class="sub-table">
                        @foreach ($subCategory['scopeTopics'] as $topic)
                            @php
                                $topicTextResult = TextHelper::callLonganTokenizePost($topic['scopeTopicText']);
                                $topicTextResult = str_replace('!', '<span class="hidden-span">!</span>', $topicTextResult);
                            @endphp
                            <tr>
                                <td>
                                    <span style="font-size: 22px; word-spacing: -0.2em;">{!! $topicTextResult !!}</span><br>
                                    <table class="detail-table">
                                        @foreach ($topic['transactions'] as $transaction)
                                            @php
                                                $detailArray = explode(',', $transaction->ibScopeDetail ? $transaction->ibScopeDetail->name : '');
                                                $detailArray = array_map('trim', $detailArray);
                                            @endphp
                                            <tr>
                                                <td>
                                                    <ul>
                                                        @foreach ($detailArray as $detail)
                                                            @php
                                                                $detailTextResult = TextHelper::callLonganTokenizePost($detail);
                                                                $detailTextResult = str_replace('!', '<span class="hidden-span">!</span>', $detailTextResult);
                                                            @endphp
                                                            <li><span style="font-size: 22px; word-spacing: -0.2em;">{!! $detailTextResult !!}</span></li>
                                                        @endforeach
                                                    </ul>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </td>
                <td>
                    @php
                        $std = $subCategory['scopeTopics'][0]['transactions'][0]->standard ?? '-';
                        $standardTextResult = TextHelper::callLonganTokenizePost($std);
                        $standardTextResult = str_replace('!', '<span class="hidden-span">!</span>', $standardTextResult);
                    @endphp
                    <span style="font-size: 22px; word-spacing: -0.2em;">{!! $standardTextResult !!}</span>
                </td>
            </tr>
        @endforeach
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
                <span style="font-size:22px">ตั้งแต่ วันที่ {{$startDate}}</span><br>
                <span style="font-size:22px">ถึง วันที่ {{$toDate}}</span><br>
                <span style="font-size:22px">ออกให้ ณ วันที่ {{$issuedDate}}</span><br>
            </div>
        </td>
    </tr>
</table> 