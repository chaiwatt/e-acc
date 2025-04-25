
<style>
    tr {
        padding: 0;
    }
    td {
        padding: 0;
    }
    .table-one {
        margin-left: 3px;    
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
    $previousTextResult = null; // ตัวแปรสำหรับเก็บ $textResult ของรอบก่อนหน้า
    $previousTestFieldEng = null; // ตัวแปรสำหรับเก็บ $item->test_field_eng ของรอบก่อนหน้า
@endphp

<table width="100%" cellspacing="0" cellpadding="0" style="table-layout: fixed; border-collapse: collapse">
    <tbody>
        @foreach ($scopes as $key => $item)
            @php
                $textResult = TextHelper::callLonganTokenizePost($item->test_field);
                // แทนที่ '!' ด้วย span ที่ซ่อนด้วย visibility: hidden
                $textResult = str_replace('!', '<span style="visibility: hidden;color: white">!</span>', $textResult);
                    // ตรวจสอบว่า $textResult และ $item->test_field_eng ซ้ำกับรอบก่อนหน้าหรือไม่
                $isTextResultHidden = ($textResult === $previousTextResult);
                $isTestFieldEngHidden = ($item->test_field_eng === $previousTestFieldEng);

                // เก็บค่าปัจจุบันไว้ในตัวแปรสำหรับรอบถัดไป
                $previousTextResult = $textResult;
                $previousTestFieldEng = $item->test_field_eng;
            @endphp
            <tr>
                <td>
                    <table width="100%" cellspacing="0" cellpadding="0" style="table-layout: fixed; border-collapse: collapse">
                        <tr>
                            <td style="vertical-align: top;width: 250px;padding:5px;font-size:22px"><span @if ($key > 0) style="visibility: hidden;color: white;font-size:22px" @endif >สาขา{{ $item->category_th }}
                                
                                @if ($key == 0)
                                <br>
                                @endif
                                <span style="font-size: 16px">({{ $item->category }} field)</span>
                            </span>
                            <span style="visibility: hidden;color: white">*{{$key}}*</span></td>
                            <td style="vertical-align: top;width: 250px;padding:5px;"><span style="visibility: hidden;color: white;font-size:22px">{{ $item->category_th }}</span></td>
                            <td style="vertical-align: top;width: 250px;padding:5px;"><span style="visibility: hidden;color: white;font-size:22px">{{ $item->category_th }}</span></td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top;width: 250px;padding:5px;padding-left:10px">
                                <div style="display:block;word-spacing: -0.2em;font-size:22px"><span style="@if ($isTextResultHidden) visibility: hidden;color: white; @endif">{!! $textResult !!}</span></div>
                                <span style="display:block;float:left;font-size:16px"><span style="@if ($isTestFieldEngHidden) visibility: hidden;color: white; @endif">({!! $item->test_field_eng !!})</span></span>
                            </td>
                            <td style="vertical-align: top;width: 250px;padding:5px">
                                @php
                                    $measurementName = str_replace('!', '<span style="visibility: hidden;color: white">!</span>', TextHelper::callLonganTokenizePost($item->measurements[0]->name));
                                @endphp
                                {{-- <div style="display:block;word-spacing: -0.2em;font-size:22px">{!! $measurementName !!}</div>
                                <div style="display:block;float:left;font-size:16px">({!! $item->measurements[0]->name_eng !!})</div> --}}

                                <div style="display:block;word-spacing: -0.2em;font-size:22px">{!! $measurementName ?? '' !!}</div>
                                
                                @if($item->measurements[0]->name_eng)
                                    <div style="display:block;float:left;font-size:16px">({!! $item->measurements[0]->name_eng !!})</div>
                                @endif
                                

                                @if ($item->measurements[0]->detail !== "")
                                <table style="margin-top: 10px">
                                    <tr>
                                        <td style="padding-left: 10px;font-size:22px">{!!$item->measurements[0]->detail!!}</td>
                                    </tr>
                                </table>
                                @endif

                            </td>
                            <td style="vertical-align: top;width: 250px;padding:5px"><span style="font-size:22px">{!! $item->standard !!}</span></td>
                        </tr>
                    </table>
                </td>
                <td></td>
                <td></td>
            </tr>
            @endforeach
    </tbody>
</table> 

