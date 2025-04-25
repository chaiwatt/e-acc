<?php $key95=0?>
<div class="m-l-10 m-t-20 form-group" style="margin-bottom: 0">
    {{--    <div class="col-md-3"></div>--}}
    <h4 class="m-l-5">9. การเข้าร่วมโปรแกรมการทดสอบความสามารถ/การเปรียบเทียบผลระหว่างห้องปฏิบัติการ</h4>
    <div class="white-box m-t-20" style="border: 2px solid #e5ebec;">
        <table class="table table-bordered" id="myTable_labTest">
            <thead class="bg-primary">
            <tr>
                <th class="text-center text-white ">ลำดับที่</th>
                <th class="text-center text-white ">วันที่ดำเนินการ</th>
                <th class="text-center text-white ">ผลิตภัณฑ์/สาขาการวัด</th>
                <th class="text-center text-white ">รายการทดสอบ/รายการวัด</th>
                <th class="text-center text-white ">หน่วยงานที่จัด</th>
                <th class="text-center text-white ">ผลการเข้าร่วม</th>
            </tr>
            </thead>
            <tbody id="labtest_tbody">
            @foreach($certi_lab_program as $program)
                <tr>
                    <td class="text-center">{{ $program->no ?? '-' }}</td>
                    @if ($program->process_date != null)
                        <td class="text-center">{{ \Carbon\Carbon::parse($program->process_date)->format('d M Y') ?? '-' }}</td>
                    @else
                        <td></td>
                    @endif
                    <td>{{ $program->product ?? '-' }}</td>
                    <td>{{ $program->item ?? '-' }}</td>
                    <td class="text-center">{{ $program->depart ?? '-' }}</td>
                    <td class="text-center">{{ $program->result ?? '-' }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
