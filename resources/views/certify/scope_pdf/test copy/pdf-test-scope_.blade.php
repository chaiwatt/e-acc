
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

{{-- @if ()
<div style="height: 80px"></div> 
@endif --}}
<table width="100%" cellspacing="0" cellpadding="0" style="table-layout: fixed; border-collapse: collapse">
    <tbody>
        @foreach ($scopes as $key => $item)
            <tr>
                <td>
                    <table cellspacing="0" width="100%" style="table-layout: fixed; border-collapse: collapse;margin-top:-10px">
                            <tr>
                                <td style="width: 22%;padding:5px"><span @if ($key != 0) style="visibility: hidden" @endif >{{ $item->category_th }}
                                        <br><span style="font-size: 16px">({!! $item->category !!})</span>
                                        <span style="visibility: hidden">*{{$key}}*</span></td>
                                <td style="width: 33%;padding:5px"><span style="visibility: hidden">{{ $item->category_th }}
                                    <br><span style="font-size: 16px;visibility: hidden">({!! $item->category !!})</span>
                                </td>
                                <td style="width: 33%;padding:5px"><span style="visibility: hidden">{{ $item->category_th }}
                                    <br><span style="font-size: 16px;visibility: hidden">({!! $item->category !!})</span>
                                </td>
                            </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table cellspacing="0" width="100%" border="1" style="table-layout: fixed; border-collapse: collapse;">
                            <tr>
                                <td style="width: 22%;padding:5px"><span >{{ $item->test_field }}
                                        <br><span style="font-size: 16px">({!! $item->test_field_eng !!})</span></td>
                                <td style="width: 33%;padding:5px"><span>{{ $item->measurements[0]->name }}
                                    <br><span style="font-size: 16px;visibility: hidden">({!! $item->measurements[0]->name_eng !!})</span>
                                </td>
                                <td style="width: 33%;padding:5px"><span>{{ $item->category_th }}
                                    <br><span style="font-size: 16px;visibility: hidden">({!! $item->category !!})</span>
                                </td>
                            </tr>
                    </table>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>






