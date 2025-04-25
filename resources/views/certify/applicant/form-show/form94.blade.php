<?php $key94=0?>
<div class="m-l-10 m-t-20 form-group" style="margin-bottom: 0">
    {{--    <div class="col-md-3"></div>--}}
    <h4 class="m-l-5">8. วัสดุอ้างอิง/วัสดุอ้างอิงรับรอง</h4>
    <div class="white-box m-t-20" style="border: 2px solid #e5ebec;">
        <table class="table table-bordered" id="myTable_labTest">
            <thead class="bg-primary">
            <tr>
                <th class="text-center text-white ">ลำดับที่</th>
                <th class="text-center text-white ">ชื่อวัสดุอ้างอิงรับรอง/วัสดุอ้างอิง</th>
                <th class="text-center text-white ">ค่าอ้างอิงที่ระบุในใบรับรอง</th>
                <th class="text-center text-white ">บริษัทผู้ผลิต</th>
                <th class="text-center text-white ">Lot/Batch No.</th>
                <th class="text-center text-white ">ความสอบกลับได้</th>
                <th class="text-center text-white ">วันที่ครบอายุสอบเทียบ</th>
                <th class="text-center text-white ">ใบรับรองวัสดุ</th>
            </tr>
            </thead>
            <tbody id="labtest_tbody">
            @foreach($certi_lab_mat as $mat)
                <tr>
                    <td>{{ $mat->no ?? '-' }}</td>
                    <td>{{ $mat->name ?? '-' }}</td>
                    <td>{{ $mat->ref_value ?? '-' }}</td>
                    <td>{{ $mat->ref_manufacturer ?? '-' }}</td>
                    <td>{{ $mat->batch_no ?? '-' }}</td>
                    <td class="text-center">{{ $mat->testing ?? '-' }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($mat->cali_anni_date)->format('d M Y') ?? '-'}}</td>
                    <td class="text-center">
                        @if ($mat->certi_material_file)
                            <a  href="{{url('check/files/'.basename($mat->certi_material_file))}}" target="_blank">{{basename($mat->certi_material_file)}}</a>
                            @else
                            ยังไม่มีไฟล์
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
