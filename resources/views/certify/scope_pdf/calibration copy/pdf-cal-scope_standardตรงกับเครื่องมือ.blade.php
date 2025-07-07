
<style>
    tr {
        padding: 0;
    }
    td {
        padding: 0;
    }
    .table-one {
        margin-left: 5px;    
    }
    .table-two {
        margin-left: 5px
    }
    .table-three {
        margin-left: 5px
    }
    .table-four {
        margin-left: 5px
    }

</style>
    @php
        if (!function_exists('formatRangeWithSpecialChars')) {
            function formatRangeWithSpecialChars($range) {
                $result = '';
                $chars = mb_str_split($range, 1, 'UTF-8'); // แยก string เป็นตัวอักษร UTF-8

                foreach ($chars as $char) {
                    // รายการอักขระพิเศษทางวิทยาศาสตร์/คณิตศาสตร์ (เพิ่มได้ตามต้องการ)
                    // $scientificChars = ['Ω', 'π', 'Σ', 'β', 'α', 'γ', 'µ', '±', '∞', 'θ', 'δ','ξ', 'φ', 'χ', 'ψ', 'ω', 'ε','Δ','√', '∮', '∫', '∂', '∇', '∑', '∏', '∆','λ', 'ω', 'σ','ρ','℃','℉','Ξ'];
                             $scientificChars = [
    'α','β','γ','δ','ε','ζ','η','θ','ι','κ','λ','μ','ν','ξ','ο',
    'π','ρ','σ','τ','υ','φ','χ','ψ','ω',
    'Α','Β','Γ','Δ','Ε','Ζ','Η','Θ','Ι','Κ','Λ','Μ','Ν','Ξ','Ο',
    'Π','Ρ','Σ','Τ','Υ','Φ','Χ','Ψ','Ω',
    '∞','→','←','↑','↓','∑','∏','∫','∂','∇','≠','≈','=','≡','∝',
    '<','>','≤','≥','±','√','∛','∜','⊥','‖','∠','∟','°','′','″',
    '∴','∵','∅','∈','∉','⊂','⊃','⊆','⊇','∪','∩','∧','∨','¬','∃',
    '∀','⇒','⇔','↔','⊕','⊗','ℏ','ħ','∞','∆',
    'm','kg','s','A','K','mol','cd','Ω','V','W','J',
    'N','Pa','Hz','T','lx','C°','F°','K°','L','mL','cm','mm','km','m²','m³','g','mg',
    'µg','atm','bar','eV','dB','rad'
  ]   
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

{{-- @if ($index == 0)
    first
@endif --}}
<table  width="100%"  cellspacing="0" cellpadding="5" >
    <tbody>
        @php
            $previousCategoryTh = null;
        @endphp
        
        @foreach ($scopes as $key => $item)
            <tr>
                {{-- <td style="vertical-align: top;width:15%;padding-bottom: 90px;padding-left:5px;font-size:22px">
                    <span @if ($key != 0)
                            style="visibility: hidden"
                    @endif >สาขา{!! $item->category_th !!} <br><span style="font-size: 16px">({!!$item->category!!} field)</span> </span>
                </td> --}}
                <td style="vertical-align: top; width:15%; padding-bottom: 90px; padding-left:5px; font-size:22px">
                    <span @if ($key != 0 && $item->category_th === $previousCategoryTh)
                            style="visibility: hidden"
                          @endif>
                        สาขา{!! $item->category_th !!}<br>
                        <span style="font-size: 16px">({!! $item->category !!} field)</span>
                    </span>
                </td>
                <td style="vertical-align: top;width:28.33%;">
                    <table   class="table-one" cellspacing="0" width="100%" style="padding-right: 1px"  >
                        <tr>
                            <td style="padding-left: 0px" >
                                <span style="margin-top:5px">{!! $item->instrument !!}</span><span style="font-size:1px;visibility: hidden">*{{$key}}*</span>
                                @if ($item->instrument !== "")
                                    <span><br>{!! $item->instrument_two !!} </span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <table   class="table-two" cellspacing="0"  width="100%" >

                                    @if (!empty($item->description))
                                        <tr><td><span>{!! $item->description !!}</span></td></tr>
                                    @endif
                                    <tr>
                                        <td style="@if ($item->description !== '') margin-left:15px @endif">
                                            <table   class="table-three" cellspacing="0"  width="100%" >
                                                @foreach ($item->measurement_edit as $i => $measurement)
                                                    <tr>
                                                        <td style="@if ($i > 0) padding-top: 15px; @endif">
                                                            <span>{!! $measurement['name'] !!}</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <table   class="table-four" cellspacing="0" width="100%" style="margin-left:0px;padding-right:3px" >
                                                                @foreach ($measurement['ranges'] as $description_i => $range)
                                                                @if (!empty($description_i))
                                                                    <tr>
                                                                        <td style="@if ($loop->index > 0) padding-top: 15px; @endif">
                                                                            <span>{!! $description_i !!}</span> <!-- แสดงชื่อคีย์ เช่น "Nominal", "Ultraviolet at 257 nm" -->
                                                                        </td>
                                                                    </tr>
                                                                @endif

                                                                <tr>
                                                                    <td style="padding-left: 7px">
                                                                        @foreach ($range['ranges'] as $range)
                                                                            <span>{!! formatRangeWithSpecialChars($range) !!}</span><br>
                                                                        @endforeach
                                                                    </td>
                                                                </tr>

                                                                @endforeach
                                                            </table>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>

        
               <td style="vertical-align: top;width:28.33%">
                    <table   class="table-one" cellspacing="0" width="100%"  style="padding-right: 1px">
                        <tr>
                            <td style="padding-left: 0px">
                                <span style="visibility: hidden;margin-top:5px">{!! $item->instrument !!}</span><span style="font-size:1px;visibility: hidden">*{{$key}}*</span>
                                @if ($item->instrument !== "")
                                    <span style="visibility: hidden;"><br>{!! $item->instrument_two !!} </span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <table   class="table-two" cellspacing="0"  width="100%">
                                    @if (!empty($item->description))
                                        <tr><td><span style="visibility: hidden;">{!! $item->description !!}</span></td></tr>
                                    @endif
                                    <tr>
                                        <td style="@if ($item->description !== '') margin-left:15px @endif">
                                            <table   class="table-three" cellspacing="0"  width="100%">
                                                @foreach ($item->measurement_edit as $j => $measurement)
                                                    <tr>
                                                        <td style="@if ($j > 0) padding-top: 15px; @endif">
                                                            <span style="visibility: hidden;">{!! $measurement['name'] !!}</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <table   class="table-four" cellspacing="0" width="100%" style="margin-left:0px;text-align: center;padding-right:3px">
                                                                @foreach ($measurement['ranges'] as $description_j => $range)
                                                                @if (!empty($description_j))
                                                                    <tr>
                                                                        <td style="@if ($loop->index > 0) padding-top: 15px; @endif">
                                                                            <span style="visibility: hidden;">{!! $description_j !!}</span> <!-- แสดงชื่อคีย์ เช่น "Nominal", "Ultraviolet at 257 nm" -->
                                                                        </td>
                                                                    </tr>
                                                                @endif
                                                                <tr>
                                                                    <td style="padding-left: 7px">
                                                                        @foreach ($range['uncertainties'] as $uncertain)
                                                                             @if (preg_match('/\.(png|jpg|jpeg|gif)$/i', $uncertain))
                                                                                <span  style="padding-left: 0px">
                                                                                    <span> <img src="{{public_path('uploads/files/applicants/check_files/' . basename($uncertain))}}" style="width: 160px" alt=""> </span><br>
                                                                                </span>
                                                                            @else
                                                                                <span>{!! $uncertain !!}</span><br> 
                                                                            @endif
                                                                        @endforeach
                                                                    </td>
                                                                </tr>
                                                                @endforeach
                                                            </table>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td> 
                <td style="vertical-align: top;width:28.33%">
                    <table   class="table-one" cellspacing="0" width="100%"  style="padding-right: 1px">
                        <tr>
                            <td style="padding-left: 0px">
                                <span>{!! $item->standard !!}</span><span style="font-size:1px;visibility: hidden">*{{$key}}*</span>
                                @if ($item->instrument !== "")
                                    <span style="visibility: hidden;"><br>{!! $item->instrument_two !!} </span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <table   class="table-two" cellspacing="0"  width="100%">
                                    @if (!empty($item->description))
                                        <tr><td><span style="visibility: hidden;">{!! $item->description !!}</span></td></tr>
                                    @endif
                                    <tr>
                                        <td style="@if ($item->description !== '') margin-left:15px @endif">
                                            <table   class="table-three" cellspacing="0"  width="100%">
                                                <tr>
                                                       
                                           
                                                    <td>
                                                        <span style="visibility: hidden;">{!! $item->standard !!}</span>
                                                    </td>
                                             

                                                </tr>
                                                @foreach ($item->measurement_edit as $k => $measurement)
                                               
                                                    <tr>
                                                        <td>
                                                            <table   class="table-four" cellspacing="0" width="100%" style="margin-left:0px;text-align: center;padding-right:3px">
                                                                @foreach ($measurement['ranges'] as $description_k => $range)
                                                                @if (!empty($description_k))
                                                                    <tr>
                                                                        <td style="@if ($loop->index > 0) padding-top: 15px; @endif">
                                                                            <span style="visibility: hidden;">{!! $description_k !!}</span> <!-- แสดงชื่อคีย์ เช่น "Nominal", "Ultraviolet at 257 nm" -->
                                                                        </td>
                                                                    </tr>
                                                                @endif
                                                                <tr>
                                                                    <td style="padding-left: 7px">
                                                                        @foreach ($range['ranges'] as $range)
                                                                            <span  style="visibility: hidden;">{!! $range !!}</span><br>
                                                                        @endforeach
                                                                    </td>
                                                                </tr>
                                                                @endforeach
                                                            </table>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td> 
            </tr>
            @php
                $previousCategoryTh = $item->category_th; // อัพเดทค่า category_th สำหรับแถวถัดไป
            @endphp
        @endforeach
    
    </tbody>
</table>




