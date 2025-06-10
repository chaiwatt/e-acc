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

<table class="ib-scope-table" style="margin-top: 20px">
    <tr>
        <th >Category / Field of Inspection</th>
        <th >Stage and Range of Inspection</th>
        <th >Inspection Requirements or Criteria</th>
    </tr>

    @php
        // จัดกลุ่มตาม ib_main_category_scope_text
        $groupedTransactions = $ibScopeTransactions->groupBy(function ($item) {
            return $item->ibMainCategoryScope ? $item->ibMainCategoryScope->name_en : '';
        });

        // แปลงเป็นโครงสร้างเหมือน groupedArray
        $groupedArray = $groupedTransactions->map(function ($transactions, $mainCategoryText) {
            // จัดกลุ่มย่อยตาม ib_sub_category_scope_text
            $subGrouped = $transactions->groupBy(function ($item) {
                return $item->ibSubCategoryScope ? $item->ibSubCategoryScope->name_en : '';
            });

            $subCategories = $subGrouped->map(function ($transactions, $subCategoryText) {
                // จัดกลุ่มตาม ib_scope_topic_text
                $topicGrouped = $transactions->groupBy(function ($item) {
                    return $item->ibScopeTopic ? $item->ibScopeTopic->name_en : '';
                });

                $scopeTopics = $topicGrouped->map(function ($transactions, $scopeTopicText) {
                    return [
                        'scopeTopicText' => $scopeTopicText,
                        'transactions' => $transactions->filter(function ($transaction) {
                            return $transaction->ib_scope_detail_id !== null; // กรอง ib_scope_detail_id ไม่เป็น null
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

    @foreach ($groupedArray as $key => $group)
        @php
            $mainCategoryTextResult = TextHelper::callLonganTokenizePost($group['mainCategoryText']);
            $mainCategoryTextResult = str_replace('!', '<span style="visibility: hidden;">!</span>', $mainCategoryTextResult);
        @endphp
        {{-- ;word-spacing: -0.2em;font-size:22px" --}}
        <tr style="border-bottom: none !important;">
            <td style="vertical-align: top; border-bottom: none !important;">
                <span style="word-spacing: -0.2em; font-size: 22px">{!! $mainCategoryTextResult !!}</span>
            </td>
            <td style="vertical-align: top; border-bottom: none !important;">
                <span style="visibility: hidden; word-spacing: -0.2em; font-size: 22px">{!! $mainCategoryTextResult !!}</span>
            </td>
            <td style="vertical-align: top; border-bottom: none !important;">
                <span style="visibility: hidden; word-spacing: -0.2em; font-size: 22px">{!! $mainCategoryTextResult !!}</span>
            </td>
        </tr>

        @foreach ($group['subCategories'] as $subCategory)
            @php
                $subCategoryArray = explode(',', $subCategory['subCategoryText']);
                $subCategoryArray = array_map('trim', $subCategoryArray);
            @endphp

            <tr>
                <td style="width:200px;padding-left:25px; vertical-align: top; border-top: none !important;">
                    <ul style="list-style-type: none;">
                        @foreach ($subCategoryArray as $subCat)
                            @php
                                $subCategoryTextResult = TextHelper::callLonganTokenizePost($subCat);
                                $subCategoryTextResult = str_replace('!', '<span style="visibility: hidden;">!</span>', $subCategoryTextResult);
                            @endphp
                            <li><span style="word-spacing: -0.2em;font-size:22px">{!! $subCategoryTextResult !!}</span></li>
                        @endforeach
                    </ul>
                </td>
                <td style="vertical-align: top;width:35%; border-top: none !important;">
                    <span>
                        {{-- <table style="border: none; !important;"> --}}
                        <table style="border: none !important; width: 100% !important;padding-top:-10px">
                            @foreach ($subCategory['scopeTopics'] as $topic)
                                <tr style="border: none !important;">
                                    <td style="vertical-align: top; border: none !important;padding-left:0px">
                                        @php
                                            $topicText = TextHelper::callLonganTokenizePost($topic['scopeTopicText']);
                                            $topicTextResult = str_replace('!', '<span style="visibility: hidden;">!</span>', $topicText);
                                        @endphp

                                        <span style="word-spacing: -0.2em;font-size:22px">{!! $topicTextResult !!}</span>

                                       <br>
                                        <table style="border: none !important; width: 100% !important;">
                                            @foreach ($topic['transactions'] as $transaction)
                                                @php
                                                    $detailArray = explode(',', $transaction->ibScopeDetail ? $transaction->ibScopeDetail->name_en : '');
                                                    $detailArray = array_map('trim', $detailArray);
                                                @endphp
                                                <tr  style="border: none !important;">
                                                    <td style="vertical-align: top; border: none !important;padding-left:0px">
                                                        <ul>
                                                            @foreach ($detailArray as $detail)
                                                                @php
                                                                    $detailTextResult = TextHelper::callLonganTokenizePost($detail);
                                                                    $detailTextResult = str_replace('!', '<span style="visibility: hidden;">!</span>', $detailTextResult);
                                                                @endphp
                                                                <li style="margin: 0; padding: 0; line-height: 1.0;"><span style="word-spacing: -0.2em; font-size: 22px">{!! $detailTextResult !!}</span></li>
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
                    </span>
                    
                </td>
                <td style="vertical-align: top;width:35%; border-top: none !important;">
                    @php
                        $std = $subCategory['scopeTopics'][0]['transactions'][0]->standard_en ?? '-';
                        $standardTextResult = TextHelper::callLonganTokenizePost($std);
                        $standardTextResult = str_replace('!', '<span style="visibility: hidden;">!</span>', $standardTextResult);
                    @endphp
                    <span style="word-spacing: -0.2em;font-size:22px">{!! $standardTextResult !!}</span>
                    <!-- ถ้าต้องการปุ่มลบ ต้องใช้ JavaScript หรือ form -->
                    <span style="font-size: 0.01px">*{{$key}}*</span>
                </td>
            </tr>
        @endforeach
    @endforeach
</table>


    
</div>
