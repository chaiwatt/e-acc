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
        width: 14%; /* คอลัมน์ 1 */
    }
    td:nth-child(2) {
        width: 24%; /* คอลัมน์ 2 */
    }
    td:nth-child(3) {
        width: 26.6%; /* คอลัมน์ 3 */
    }
    td:nth-child(4) {
        width: 26.6%; /* คอลัมน์ 4 */
    }
    th {
        background-color: #007bff;
        color: white;
        text-align: center;
        /* border: 1px solid black !important; */
    }
    h5 {
        font-size: 22px !important;
        margin: 10px 0;
    }
    .parameter-one td {
        padding-left: 20px;
    }
    td.text-center {
        text-align: center !important;
    }
</style>

@php
if (!function_exists('formatRangeWithSpecialChars')) {
    function formatRangeWithSpecialChars($range) {
        $result = '';
        $chars = mb_str_split($range, 1, 'UTF-8'); // แยก string เป็นตัวอักษร UTF-8

        foreach ($chars as $char) {
            // รายการอักขระพิเศษทางวิทยาศาสตร์/คณิตศาสตร์ (เพิ่มได้ตามต้องการ)
            $scientificChars = ['Ω', 'π', 'Σ', 'β', 'α', 'γ', 'µ', '±', '∞', 'θ', 'δ','ξ', 'φ', 'χ', 'ψ', 'ω', 'ε','Δ','√', '∮', '∫', '∂', '∇', '∑', '∏', '∆','λ', 'ω', 'σ','ρ','℃','℉','Ξ'];
            
            // ตรวจสอบว่าตัวอักษรนี้เป็นอักขระพิเศษทางวิทยาศาสตร์หรือไม่
            if (in_array($char, $scientificChars)) {
                // ห่ออักขระพิเศษด้วย <span>
                $result .= '<span style="font-family: DejaVuSans; font-size: 14px;">' . htmlspecialchars($char, ENT_QUOTES, 'UTF-8') . '</span>';
            } else {
                // ตัวอักษรปกติ ไม่ต้องห่อ
                $result .= htmlspecialchars($char, ENT_QUOTES, 'UTF-8');
            }
        }

        return $result;
    }
}
@endphp

@php
    // กำหนด key ของ labType จาก index (เช่น $index = 0 -> pl_2_1_info)
    $key = 'pl_2_' . ($index + 1) . '_info';

    // ตรวจสอบว่า $labType เป็น array และมีข้อมูล
    if (is_array($labType) && count($labType) > 0) {
        // จัดกลุ่มตาม cal_main_branch
        $groupedByMainBranch = [];
        foreach ($labType as $index => $item) {
            // dd($item);
            $mainBranchKey = $item['cal_main_branch']['id'] ?? 'unknown';
            if (!isset($groupedByMainBranch[$mainBranchKey])) {
                $groupedByMainBranch[$mainBranchKey] = [
                    'mainBranch' => isset($item['cal_main_branch']['text_en']) 
                        ? 'สาขา' . ($item['cal_main_branch']['text'] ?? '') . '<br>' . ($item['cal_main_branch']['text_en'] ?? '') 
                        : 'สาขา' . ($item['cal_main_branch']['text'] ?? '-'),
                    'instrumentGroups' => []
                ];
            }
            $groupKey = $item['cal_instrumentgroup']['id'] ?? 'unknown';
            if (!isset($groupedByMainBranch[$mainBranchKey]['instrumentGroups'][$groupKey])) {
                $groupedByMainBranch[$mainBranchKey]['instrumentGroups'][$groupKey] = [
                    'instrumentGroup' => $item['cal_instrumentgroup']['text'] ?? '-',
                    'items' => []
                ];
            }
            $itemWithIndex = $item;
            $itemWithIndex['originalIndex'] = $index;
            $groupedByMainBranch[$mainBranchKey]['instrumentGroups'][$groupKey]['items'][] = $itemWithIndex;
        }
    }
@endphp
<table class="table table-bordered align-middle" id="cal_scope_table_{{ $key }}">
    <tbody>
        @foreach($groupedByMainBranch as $mainBranchGroup)
            <!-- แถวแรกสำหรับ mainBranch -->
            <tr>
                <td style="vertical-align: top;">
                    {!! $mainBranchGroup['mainBranch'] !!}
                </td>
                <td style="vertical-align: top;"></td>
                <td style="vertical-align: top;"></td>
                <td style="vertical-align: top;"></td>
            </tr>

            @foreach($mainBranchGroup['instrumentGroups'] as $mainGroup)
                @php
                    // ตรวจสอบว่าไม่มี parameterOne และ parameterTwo
                    $hasNoParameters = true;
                    foreach ($mainGroup['items'] as $item) {
                        $hasParamOne = !empty($item['cal_parameter_one']['text'] ?? '');
                        $hasParamTwo = !empty($item['cal_parameter_two']['text'] ?? '') && $item['cal_parameter_two']['text'] !== '-' && $item['cal_parameter_two']['text'] !== '';
                        if ($hasParamOne || $hasParamTwo) {
                            $hasNoParameters = false;
                            break;
                        }
                    }
                    $calStandardForGroup = $hasNoParameters && !empty($mainGroup['items'][0]['cal_standard'] ?? '') && $mainGroup['items'][0]['cal_standard'] !== '<br>'
                        ? $mainGroup['items'][0]['cal_standard']
                        : '';
                @endphp
                <tr>
                    <td style="vertical-align: top;"></td>
                    <td style="vertical-align: top;">
                        {{ $mainGroup['instrumentGroup'] }}
                    </td>
                    <td style="vertical-align: top;"></td>
                    <td style="vertical-align: top;">
                        {!! $calStandardForGroup !!}
                    </td>
                </tr>
                @php
                    // จัดกลุ่มตาม cal_instrument และ cal_parameter_one
                    $groupedData = [];
                    foreach ($mainGroup['items'] as $index => $item) {
                        $parameterOneKey = !empty($item['cal_parameter_one']['text'] ?? '') ? ($item['cal_parameter_one']['id'] ?? '-') : '-';
                        $subGroupKey = ($item['cal_instrument']['id'] ?? '') . '_' . $parameterOneKey;
                        if (!isset($groupedData[$subGroupKey])) {
                            $groupedData[$subGroupKey] = [
                                'instrument' => $item['cal_instrument']['text'] ?? '',
                                'parameterOne' => $item['cal_parameter_one']['text'] ?? '',
                                'items' => []
                            ];
                        }
                        $groupedData[$subGroupKey]['items'][] = [
                            'parameterTwo' => $item['cal_parameter_two']['text'] ?? '',
                            'calStandard' => !empty($item['cal_standard']) && $item['cal_standard'] !== '<br>' ? $item['cal_standard'] : '',
                            'measurements' => $item['cal_cmc_info'] ?? [],
                            'originalIndex' => $index
                        ];
                    }
                @endphp

                @foreach($groupedData as $group)
                    @if(!empty($group['instrument']))
                        <tr class="parameter-one">
                            <td style="vertical-align: top;"></td>
                            <td style="vertical-align: top; padding-left: 20px;">
                                {{ $group['instrument'] }}
                            </td>
                            <td style="vertical-align: top;"></td>
                            <td style="vertical-align: top;"></td>
                        </tr>
                        @foreach($group['items'] as $item)
                            @if(is_array($item['measurements']) && count($item['measurements']) > 0)
                                @php
                                    // จัดกลุ่ม measurements ตาม description
                                    $groupedByDescription = [];
                                    foreach ($item['measurements'] as $measIndex => $meas) {
                                        $descKey = !empty($meas['description']) && trim($meas['description']) !== '' ? $meas['description'] : '';
                                        if (!isset($groupedByDescription[$descKey])) {
                                            $groupedByDescription[$descKey] = [];
                                        }
                                        $groupedByDescription[$descKey][] = $meas;
                                    }
                                @endphp
                                @foreach($groupedByDescription as $desc => $measurements)
                                    @if(!empty($desc))
                                        <tr class="parameter-one">
                                            <td style="vertical-align: top;"></td>
                                            <td style="vertical-align: top; padding-left: 20px;">
                                                {{ $desc }}
                                            </td>
                                            <td style="vertical-align: top;"></td>
                                            <td style="vertical-align: top;"></td>
                                        </tr>
                                    @endif
                                    @foreach($measurements as $meas)
                                        @php
                                            $rangeDisplay = '';
                                            if (is_array($meas['range']) && isset($meas['range']['name'])) {
                                                $rangeDisplay = $meas['range']['name'];
                                            } elseif (is_array($meas['range'])) {
                                                $rangeDisplay = implode(', ', $meas['range']);
                                            } else {
                                                $rangeDisplay = $meas['range'] ?? '';
                                            }

                                            $uncertaintyDisplay = '';
                                            if (is_array($meas['uncertainty']) && isset($meas['uncertainty']['name'])) {
                                                $uncertaintyDisplay = $meas['uncertainty']['name'];
                                            } elseif (is_array($meas['uncertainty'])) {
                                                $uncertaintyDisplay = implode(', ', $meas['uncertainty']);
                                            } else {
                                                $uncertaintyDisplay = $meas['uncertainty'] ?? '';
                                            }
                                            if (is_string($uncertaintyDisplay) && strpos($uncertaintyDisplay, '.png') !== false) {
                                                $uncertaintyDisplay = '<img src="' . $uncertaintyDisplay . '" alt="uncertainty image" style="max-width: 160px;">';
                                            }
                                        @endphp
                                        <tr class="parameter-one">
                                            <td style="vertical-align: top;"></td>
                                            <td style="vertical-align: top; padding-left: 20px; text-align: center;">
                                                {!! formatRangeWithSpecialChars($rangeDisplay) !!}
                                            </td>
                                            <td style="vertical-align: top; text-align: center;">
                                                {!! formatRangeWithSpecialChars($uncertaintyDisplay) !!}
                                            </td>
                                            <td style="vertical-align: top;"></td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            @endif
                        @endforeach
                    @endif

                    @if(!empty($group['parameterOne']) && empty($group['instrument']))
                        <tr class="parameter-one">
                            <td style="vertical-align: top;"></td>
                            <td style="vertical-align: top; padding-left: 20px;">
                                {{ $group['parameterOne'] }}
                            </td>
                            <td style="vertical-align: top;"></td>
                            <td style="vertical-align: top;">
                                {!! $group['items'][0]['calStandard'] !!}
                            </td>
                        </tr>
                        @foreach($group['items'] as $item)
                            @if(is_array($item['measurements']) && count($item['measurements']) > 0)
                                @php
                                    // จัดกลุ่ม measurements ตาม description
                                    $groupedByDescription = [];
                                    foreach ($item['measurements'] as $measIndex => $meas) {
                                        $descKey = !empty($meas['description']) && trim($meas['description']) !== '' ? $meas['description'] : '';
                                        if (!isset($groupedByDescription[$descKey])) {
                                            $groupedByDescription[$descKey] = [];
                                        }
                                        $groupedByDescription[$descKey][] = $meas;
                                    }
                                @endphp
                                @foreach($groupedByDescription as $desc => $measurements)
                                    @if(!empty($desc))
                                        <tr class="parameter-one">
                                            <td style="vertical-align: top;"></td>
                                            <td style="vertical-align: top; padding-left: 20px;">
                                                {{ $desc }}
                                            </td>
                                            <td style="vertical-align: top;"></td>
                                            <td style="vertical-align: top;"></td>
                                        </tr>
                                    @endif
                                    @foreach($measurements as $meas)
                                        @php
                                            $rangeDisplay = '';
                                            if (is_array($meas['range']) && isset($meas['range']['name'])) {
                                                $rangeDisplay = $meas['range']['name'];
                                            } elseif (is_array($meas['range'])) {
                                                $rangeDisplay = implode(', ', $meas['range']);
                                            } else {
                                                $rangeDisplay = $meas['range'] ?? '';
                                            }

                                            $uncertaintyDisplay = '';
                                            if (is_array($meas['uncertainty']) && isset($meas['uncertainty']['name'])) {
                                                $uncertaintyDisplay = $meas['uncertainty']['name'];
                                            } elseif (is_array($meas['uncertainty'])) {
                                                $uncertaintyDisplay = implode(', ', $meas['uncertainty']);
                                            } else {
                                                $uncertaintyDisplay = $meas['uncertainty'] ?? '';
                                            }
                                            if (is_string($uncertaintyDisplay) && strpos($uncertaintyDisplay, '.png') !== false) {
                                                $uncertaintyDisplay = '<img src="' . $uncertaintyDisplay . '" alt="uncertainty image" style="max-width: 160px;">';
                                            }
                                        @endphp
                                        <tr class="parameter-one">
                                            <td style="vertical-align: top;"></td>
                                            <td style="vertical-align: top; padding-left: 20px; text-align: center;">
                                                {!! formatRangeWithSpecialChars($rangeDisplay) !!}
                                            </td>
                                            <td style="vertical-align: top; text-align: center;">
                                                {!! formatRangeWithSpecialChars($uncertaintyDisplay) !!}
                                            </td>
                                            <td style="vertical-align: top;"></td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            @endif
                        @endforeach
                    @endif

                    @foreach($group['items'] as $itemIndex => $item)
                        @if(!empty($item['parameterTwo']) && $item['parameterTwo'] !== '-')
                            <tr class="parameter-one">
                                <td style="vertical-align: top;"></td>
                                <td style="vertical-align: top; padding-left: 20px;">
                                    {{ $item['parameterTwo'] }}
                                </td>
                                <td style="vertical-align: top;"></td>
                                <td style="vertical-align: top;">
                                    @if(empty($group['parameterOne']))
                                        {!! $item['calStandard'] !!}
                                    @endif
                                </td>
                            </tr>
                            @if(is_array($item['measurements']) && count($item['measurements']) > 0)
                                @php
                                    // จัดกลุ่ม measurements ตาม description
                                    $groupedByDescription = [];
                                    foreach ($item['measurements'] as $measIndex => $meas) {
                                        $descKey = !empty($meas['description']) && trim($meas['description']) !== '' ? $meas['description'] : '';
                                        if (!isset($groupedByDescription[$descKey])) {
                                            $groupedByDescription[$descKey] = [];
                                        }
                                        $groupedByDescription[$descKey][] = $meas;
                                    }
                                @endphp
                                @foreach($groupedByDescription as $desc => $measurements)
                                    @if(!empty($desc))
                                        <tr class="parameter-one">
                                            <td style="vertical-align: top;"></td>
                                            <td style="vertical-align: top; padding-left: 20px;">
                                                {{ $desc }}
                                            </td>
                                            <td style="vertical-align: top;"></td>
                                            <td style="vertical-align: top;"></td>
                                        </tr>
                                    @endif
                                    @foreach($measurements as $meas)
                                        @php
                                            $rangeDisplay = '';
                                            if (is_array($meas['range']) && isset($meas['range']['name'])) {
                                                $rangeDisplay = $meas['range']['name'];
                                            } elseif (is_array($meas['range'])) {
                                                $rangeDisplay = implode(', ', $meas['range']);
                                            } else {
                                                $rangeDisplay = $meas['range'] ?? '';
                                            }

                                            $uncertaintyDisplay = '';
                                            if (is_array($meas['uncertainty']) && isset($meas['uncertainty']['name'])) {
                                                $uncertaintyDisplay = $meas['uncertainty']['name'];
                                            } elseif (is_array($meas['uncertainty'])) {
                                                $uncertaintyDisplay = implode(', ', $meas['uncertainty']);
                                            } else {
                                                $uncertaintyDisplay = $meas['uncertainty'] ?? '';
                                            }
                                            if (is_string($uncertaintyDisplay) && strpos($uncertaintyDisplay, '.png') !== false) {
                                                $uncertaintyDisplay = '<img src="' . $uncertaintyDisplay . '" alt="uncertainty image" style="max-width: 160px;">';
                                            }
                                        @endphp
                                        <tr class="parameter-one">
                                            <td style="vertical-align: top;"></td>
                                            <td style="vertical-align: top; padding-left: 20px; text-align: center;">
                                                {!! formatRangeWithSpecialChars($rangeDisplay) !!}
                                            </td>
                                            <td style="vertical-align: top; text-align: center;">
                                                {!! formatRangeWithSpecialChars($uncertaintyDisplay) !!}
                                            </td>
                                            <td style="vertical-align: top;"></td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            @endif
                        @endif
                    @endforeach
                @endforeach
            @endforeach
        @endforeach
    </tbody>
</table>