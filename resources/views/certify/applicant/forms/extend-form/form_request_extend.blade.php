{{-- work on Certify\ApplicantController --}}
<input type="hidden" id="lab_addresses_input" name="lab_addresses" />
<input type="hidden" id="lab_main_address_input" name="lab_main_address" />
<div >
    <div class="clearfix"></div>
    <hr>
    <legend><h4>สำนักงานสาขา (กรณีต้องการขอรับบริการมากกว่า 1 สำนักงาน)</h4>     </legend>  
    <div class="form-group">
        {!! HTML::decode(Form::label('', '',['class' => 'col-md-5 control-label label-height'])) !!}
        <div class="col-md-12">
            <span class="pull-left text-warning" ><i>สำนักงานสาขาสามารถกำหนดประเภทสถานปฏิบัติการของห้องปฏิบัติการ / ขอบข่ายที่ยื่นขอรับการรับรองอิสระเหมือนหรือแตกต่างสำนักงานใหญ่ได้</i></span>
            <a class="btn btn-info pull-right" id="show_add_address" onclick="return false">
                <i class="icon-plus"></i> เพิ่มสาขา
            </a>

           
            <a class="btn btn-warning pull-right" id="show_add_address_demo" style="margin-right:5px" onclick="return false">
                <i class="icon-plus"></i> เพิ่มสาขา(Demo)
            </a>
        </div>
    </div>      
            <div class="clearfix"></div>
    @if ($urlType == 'create')
        <table class="table table-bordered" id="myTable_labAddress">
            <thead class="bg-primary">
                <tr>
                    <th class="text-center text-white "  width="10%">ลำดับ</th>
                    <th class="text-center text-white "  width="70%">ที่อยู่สาขา</th>
                    <th class="text-center text-white"  width="10%">ลบรายการ</th>
                </tr>
            </thead>
            <tbody id="lab_address_body">

            </tbody>
        </table>
        @elseif($urlType == 'show')

        <table class="table table-bordered">
            <thead class="bg-primary">
                <tr>
                    <th class="text-center text-white "  width="10%">ลำดับ</th>
                    <th class="text-center text-white "  width="70%">ที่อยู่สาขา</th>
                    <th class="text-center text-white"  width="10%">จัดการ</th>
                </tr>
            </thead>
            <tbody id="lab_address_body">
                @foreach ($branchLabAdresses as $key => $branchLabAdresse)
                    <tr>
                        <td class="text-center">{{$key+1}}</td>
                        <td>เลขที่ {{$branchLabAdresse->addr_no}} หมู่ที่ {{$branchLabAdresse->addr_moo}} 
                            แขวง/อำเภอ{{$branchLabAdresse->district->DISTRICT_NAME}} เขต/อำเภอ{{$branchLabAdresse->amphur->AMPHUR_NAME}} 
                            จังหวัด{{$branchLabAdresse->province->PROVINCE_NAME}} รหัสไปรษณีย์ {{$branchLabAdresse->postal}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @elseif($urlType == 'edit')


        <table class="table table-bordered">
            <thead class="bg-primary">
                <tr>
                    <th class="text-center text-white "  width="10%">ลำดับ</th>
                    <th class="text-center text-white "  width="70%">ที่อยู่สาขา</th>
                    <th class="text-center text-white"  width="10%">ลบรายการ</th>
                </tr>
            </thead>
            <tbody id="lab_address_body">
            </tbody>
        </table>

    @endif
            
     
        </div>

