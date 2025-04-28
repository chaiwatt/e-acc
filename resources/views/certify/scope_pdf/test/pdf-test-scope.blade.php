<style>
    /* สไตล์สำหรับ PDF */
    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 22px !important;
        margin-bottom: 20px;
        /* border: 1px solid black !important;  */
        table-layout: fixed; /* บังคับให้คอลัมน์มีความกว้างตามที่กำหนด */
    }
    th, td {
        /* border: 1px solid black !important;  */
        padding: 5px;
        vertical-align: top;
        font-size: 22px !important;
        text-align: left !important;
        word-wrap: break-word; /* ให้ข้อความตัดคำและขึ้นบรรทัดใหม่เมื่อยาวเกิน */
    }
    /* กำหนดความกว้างสำหรับแต่ละคอลัมน์ */
    td:nth-child(1) {
        width: 33.33%; /* คอลัมน์ 1 */
    }
    td:nth-child(2) {
        width: 33.33%; /* คอลัมน์ 2 */
    }
    td:nth-child(3) {
        width: 33.33%; /* คอลัมน์ 3 */
    }
    th {
        background-color: #007bff;
        color: white;
        text-align: center;
        /* border: 1px solid black !important;  */
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
            // dd($item);
            $mainBranchKey = $item['test_main_branch']['id'] ?? 'unknown';
            if (!isset($groupedByMainBranch[$mainBranchKey])) {
                $groupedByMainBranch[$mainBranchKey] = [
                    'mainBranch' => isset($item['test_main_branch']['text_en']) 
                        ? 'สาขา' . ($item['test_main_branch']['text'] ?? '') . '<br>' . ($item['test_main_branch']['text_en'] ?? '') 
                        : 'สาขา' . ($item['test_main_branch']['text'] ?? '-'),
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

<table class="table table-bordered align-middle" id="test_scope_table_{{ $key }}">
    <tbody>
        @if(!empty($groupedByMainBranch))
            @foreach($groupedByMainBranch as $mainBranchGroup)
                <tr>
                    <td style="vertical-align: top;">{!! $mainBranchGroup['mainBranch'] !!}</td>
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
                            @else
                                <td style="vertical-align: top;"></td> <!-- เพิ่ม td ว่างเพื่อรักษาตำแหน่งคอลัมน์ -->
                            @endif
                            <td style="vertical-align: top;padding-left:10px">{{ $item['test_parameter']['text'] ?? '-' }}</td>
                            @if($firstItem)
                                <td rowspan="{{ $rowspan }}" style="vertical-align: top;padding-left:20px">{{ $item['test_standard'] ?? '-' }}</td>
                            @endif
                        </tr>
                        @if(!empty($item['test_condition_description']))
                            <tr>
                                <td style="vertical-align: to;padding-left:20px;">{{ $item['test_condition_description'] }}</td>
                            </tr>
                        @endif
                        @if(!empty($item['test_param_detail']))
                            <tr>
                                @if(!$firstItem)
                                    <td style="vertical-align: top;"></td> <!-- เพิ่ม td ว่างเพื่อรักษาตำแหน่งคอลัมน์ -->
                                @endif
                                <td style="vertical-align: top;padding-left:25px;">{!! nl2br($item['test_param_detail']) !!}</td>
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