<?php $key=0?>
<div class="m-l-10 m-t-20 form-group" style="margin-bottom: 0">
    <h4 class="m-l-5">5. รายชื่อคุณวุฒิประสบการณ์และขอบข่ายความรับผิดชอบของเจ้าหน้าที่</h4>
    <div class="white-box m-t-20" style="border: 2px solid #e5ebec;">
        <table class="table table-bordered" id="myTable_labTest">
            <thead class="bg-primary">
            <tr>
                <th class="text-center text-white col-xs-2">ชื่อ</th>
                <th class="text-center text-white col-xs-1">นามสกุล</th>
                <th class="text-center text-white col-xs-1">ตำแหน่ง</th>
                <th class="text-center text-white col-xs-3">คุณวุฒิ</th>
                <th class="text-center text-white col-xs-3">ความรับผิดชอบ</th>
            </tr>
            </thead>
            <tbody id="labtest_tbody">
            @foreach($certi_lab_employees as $employee)
                <tr>
                    <td>{{ $employee->first_name }}</td>
                    <td>{{ $employee->last_name }}</td>
                    <td>{{ $employee->position }}</td>
                    <td>{{ $employee->quali }}</td>
                    <td>{{ $employee->responsible }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
