<style>
    /* สไตล์สำหรับ PDF */
    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 22px !important;
        margin-bottom: 20px;
        border: none !important;
    }
    th, td {
        border: none !important;
        padding: 5px;
        vertical-align: top;
        font-size: 22px !important;
        text-align: left !important;
    }
    th {
        background-color: #007bff;
        color: white;
        text-align: center;
    }
    h5 {
        font-size: 22px !important;
        margin: 10px 0;
    }
    tr.category-row td {
        line-height: 1.2;
    }
</style>

@php
    // กำหนด key ของ labType จาก index (เช่น $index = 0 -> pl_2_1_info)
    $key = 'pl_2_' . ($index + 1) . '_info';

    // ตรวจสอบว่า $labType เป็น array และมีข้อมูล
    if (is_array($labType) && count($labType) > 0) {
        // จัดกลุ่มตาม test_main_branch
        $groupedByMainBranch = [];
        foreach ($labType as $index => $item) {
            $mainBranchKey = $item['test_main_branch']['id'] ?? 'unknown';
            if (!isset($groupedByMainBranch[$mainBranchKey])) {
                $groupedByMainBranch[$mainBranchKey] = [
                    'mainBranch' => $item['test_main_branch']['text'] ?? '-',
                    'categories' => []
                ];
            }
            $categoryKey = $item['test_category']['id'] ?? 'unknown';
            if (!isset($groupedByMainBranch[$mainBranchKey]['categories'][$categoryKey])) {
                $groupedByMainBranch[$mainBranchKey]['categories'][$categoryKey] = [
                    'category' => $item['test_category']['text'] ?? '-',
                    'items' => []
                ];
            }
            $itemWithIndex = $item;
            $itemWithIndex['originalIndex'] = $index;
            $groupedByMainBranch[$mainBranchKey]['categories'][$categoryKey]['items'][] = $itemWithIndex;
        }
    }
@endphp

<!-- สร้างตาราง -->
<table class="table table-bordered align-middle" id="test_scope_table_{{ $key }}">
    <tbody>
        @if(!empty($groupedByMainBranch))
            @foreach($groupedByMainBranch as $mainBranchGroup)
                <tr>
                    <td style="vertical-align: top;"><strong>{{ $mainBranchGroup['mainBranch'] }}</strong></td>
                    <td style="vertical-align: top;"></td>
                    <td style="vertical-align: top;"></td>
                </tr>
                @foreach($mainBranchGroup['categories'] as $categoryGroup)
                    @php
                        $firstItem = true;
                    @endphp
                    @foreach($categoryGroup['items'] as $item)
                        @php
                            // คำนวณ rowspan ตามจำนวนแถวที่ต้องครอบคลุม
                            $rowspan = 1; // เริ่มจาก 1 (สำหรับ test_parameter.text)
                            if (!empty($item['test_condition_description'])) {
                                $rowspan++;
                            }
                            if (!empty($item['test_param_detail'])) {
                                $rowspan++;
                            }
                        @endphp
                        <tr class="category-row">
                            @if($firstItem)
                                <td rowspan="{{ $rowspan }}" style="vertical-align: top;">  {{ $categoryGroup['category'] }}</td>
                            @endif
                            <td style="vertical-align: top;">{{ $item['test_parameter']['text'] ?? '-' }}</td>
                            @if($firstItem)
                                <td rowspan="{{ $rowspan }}" style="vertical-align: top;">{{ $item['test_standard'] ?? '-' }}</td>
                            @endif
                        </tr>
                        @if(!empty($item['test_condition_description']))
                            <tr>
                                <td style="vertical-align: top;">{{ $item['test_condition_description'] }}</td>
                            </tr>
                        @endif
                        @if(!empty($item['test_param_detail']))
                            <tr>
                                <td style="vertical-align: top;">{!! nl2br($item['test_param_detail']) !!}</td>
                            </tr>
                        @endif
                        @php
                            $firstItem = false;
                        @endphp
                    @endforeach
                @endforeach
            @endforeach
        @endif
    </tbody>
</table>