<?php $key93=0?>
<div id="viewForm93" class="{{$certi_lab->lab_type == 3 ? 'show':'hide'}}">
    <div class="m-l-10 m-t-20 form-group" style="margin-bottom: 0">
        <h4 class="m-l-5">7. เครื่องมือ (ทดสอบ)</h4>
    </div>
    @if ($certi_lab)
        @if($certi_lab->certi_tools_test->count() > 0)
            <button class="btn btn-success btn-sm pull-right m-b-10 m-l-5" id="test_tools_add" type="button">
                <i class="icon-plus"></i> เพิ่ม
            </button>
            <div id="tools-test-container">
                @foreach ($certi_lab->certi_tools_test as $tools_test)
                    <?php $key93++ ?>
                    <div class="test_tools_box">
                        <div class="row test_tools_item">
                            <div class="col-md-12 m-b-10">
                                <div class="row">
                                    <div class="col-md-8"></div>
                                    {!! $errors->first('all_test_tools[]', '<p class="help-block">:message</p>') !!}
                                    <div class="col-md-4">
                                        @if($key93==0)
                                            <button class="btn btn-success pull-right btn-sm" id="test_tools_add" type="button">
                                                <i class="icon-plus"></i> เพิ่ม
                                            </button>
                                        @else
                                            <button class="btn btn-danger pull-right btn-sm test_tools_remove" type="button">
                                                <i class="icon-close"></i> &nbsp;ลบ
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="white-box" style="border: 2px solid #e5ebec;">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group {{ $errors->has('test_tools_no[]') ? 'has-error' : ''}}">
                                                {!! Form::label('test_tools_no', 'ลำดับที่: ', ['class' => ' control-label']) !!}
                                                <input type="number" name="test_tools_no[]" class="form-control text-center" readonly value="{{$tools_test->no ?? ''}}">
                                                {!! $errors->first('test_tools_no[]', '<p class="help-block">:message</p>') !!}
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group {{ $errors->has('test_license_number[]') ? 'has-error' : ''}}">
                                                {!! Form::label('test_license_number[]', 'หมายเลขทะเบียน: ', ['class' => ' control-label']) !!}
                                                {!! Form::text('test_license_number[]',$tools_test->regis_no ?? '', ['class' => 'form-control']) !!}
                                                {!! $errors->first('test_license_number[]', '<p class="help-block">:message</p>') !!}
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group {{ $errors->has('test_name_trader[]') ? 'has-error' : ''}}">
                                                {!! Form::label('test_name_trader[]', 'รายการ (ชื่อและเครื่องหมายการค้า): ', ['class' => ' control-label']) !!}
                                                {!! Form::text('test_name_trader[]',$tools_test->name ?? '', ['class' => 'form-control']) !!}
                                                {!! $errors->first('test_name_trader[]', '<p class="help-block">:message</p>') !!}
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group {{ $errors->has('test_type_model_layout[]') ? 'has-error' : ''}}">
                                                {!! Form::label('test_type_model_layout[]', 'ประเภท/รุ่น/แบบ: ', ['class' => ' control-label']) !!}
                                                {!! Form::text('test_type_model_layout[]',$tools_test->type ?? '', ['class' => 'form-control']) !!}
                                                {!! $errors->first('test_type_model_layout[]', '<p class="help-block">:message</p>') !!}
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group {{ $errors->has('test_number_code[]') ? 'has-error' : ''}}">
                                                {!! Form::label('test_number_code[]', 'เลขที่/รหัส: ', ['class' => ' control-label']) !!}
                                                {!! Form::text('test_number_code[]',$tools_test->code_no ?? '', ['class' => 'form-control']) !!}
                                                {!! $errors->first('test_number_code[]', '<p class="help-block">:message</p>') !!}
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group {{ $errors->has('test_limit_line[]') ? 'has-error' : ''}}">
                                                {!! Form::label('test_limit_line[]', 'ขีดความสามารถ: ', ['class' => ' control-label']) !!}
                                                {!! Form::text('test_limit_line[]',$tools_test->capability ?? '', ['class' => 'form-control']) !!}
                                                {!! $errors->first('test_limit_line[]', '<p class="help-block">:message</p>') !!}
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group {{ $errors->has('test_use_range[]') ? 'has-error' : ''}}">
                                                {!! Form::label('test_use_range[]', 'ช่วงการใช้งาน: ', ['class' => ' control-label']) !!}
                                                {!! Form::text('test_use_range[]',$tools_test->usage_time ?? '', ['class' => 'form-control']) !!}
                                                {!! $errors->first('test_use_range[]', '<p class="help-block">:message</p>') !!}
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group {{ $errors->has('test_standard_accept[]') ? 'has-error' : ''}}">
                                                {!! Form::label('test_standard_accept[]', 'เกณฑ์การยอมรับ: ', ['class' => ' control-label']) !!}
                                                {!! Form::text('test_standard_accept[]',$tools_test->standard ?? '', ['class' => 'form-control']) !!}
                                                {!! $errors->first('test_standard_accept[]', '<p class="help-block">:message</p>') !!}
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group {{ $errors->has('test_calibrate_freq[]') ? 'has-error' : ''}}">
                                                {!! Form::label('test_calibrate_freq[]', 'ความถี่ของการสอบเทียบ: ', ['class' => ' control-label']) !!}
                                                {!! Form::text('test_calibrate_freq[]',$tools_test->cali_times ?? '', ['class' => 'form-control']) !!}
                                                {!! $errors->first('test_calibrate_freq[]', '<p class="help-block">:message</p>') !!}
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group {{ $errors->has('test_last_calibrate[]') ? 'has-error' : ''}}">
                                                {!! Form::label('test_last_calibrate[]', 'สอบเทียบล่าสุด: ', ['class' => ' control-label']) !!}
                                                {!! Form::text('test_last_calibrate[]',$tools_test->cali_latest_date ? \Carbon\Carbon::parse($tools_test->cali_latest_date)->format('d/m/Y'):'', ['class' => 'form-control mydatepicker']) !!}
                                                {!! $errors->first('test_last_calibrate[]', '<p class="help-block">:message</p>') !!}
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group {{ $errors->has('test_matured_calibrate[]') ? 'has-error' : ''}}">
                                                {!! Form::label('test_matured_calibrate[]', 'วันที่ครบอายุสอบเทียบ: ', ['class' => ' control-label']) !!}
                                                {!! Form::text('test_matured_calibrate[]',$tools_test->cali_anni_date ? \Carbon\Carbon::parse($tools_test->cali_anni_date)->format('d/m/Y'):'', ['class' => 'form-control mydatepicker']) !!}
                                                {!! $errors->first('test_matured_calibrate[]', '<p class="help-block">:message</p>') !!}
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group {{ $errors->has('test_calibrate_department[]') ? 'has-error' : ''}}">
                                                {!! Form::label('test_calibrate_department[]', 'หน่วยงานที่สอบเทียบ: ', ['class' => ' control-label']) !!}
                                                {!! Form::text('test_calibrate_department[]',$tools_test->cali_depart ?? '', ['class' => 'form-control']) !!}
                                                {!! $errors->first('test_calibrate_department[]', '<p class="help-block">:message</p>') !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div id="tools-test-container">
                <div class="test_tools_box">
                    <div class="row test_tools_item">
                        <div class="col-md-12 m-b-10">
                            <div class="row">
                                <div class="col-md-8"></div>
                                {!! $errors->first('all_test_tools[]', '<p class="help-block">:message</p>') !!}
                                <div class="col-md-4">
                                    @if($key93==0)
                                        <button class="btn btn-success pull-right btn-sm" id="test_tools_add" type="button">
                                            <i class="icon-plus"></i> เพิ่ม
                                        </button>
                                    @else
                                        <button class="btn btn-danger pull-right btn-sm test_tools_remove" type="button">
                                            <i class="icon-close"></i> &nbsp;ลบ
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="white-box" style="border: 2px solid #e5ebec;">
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group {{ $errors->has('test_tools_no[]') ? 'has-error' : ''}}">
                                            {!! Form::label('test_tools_no', 'ลำดับที่: ', ['class' => ' control-label']) !!}
                                            <input type="number" name="test_tools_no[]" class="form-control text-center" readonly value="1">
                                            {!! $errors->first('test_tools_no[]', '<p class="help-block">:message</p>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group {{ $errors->has('test_license_number[]') ? 'has-error' : ''}}">
                                            {!! Form::label('test_license_number[]', 'หมายเลขทะเบียน: ', ['class' => ' control-label']) !!}
                                            {!! Form::text('test_license_number[]',null, ['class' => 'form-control']) !!}
                                            {!! $errors->first('test_license_number[]', '<p class="help-block">:message</p>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group {{ $errors->has('test_name_trader[]') ? 'has-error' : ''}}">
                                            {!! Form::label('test_name_trader[]', 'รายการ (ชื่อและเครื่องหมายการค้า): ', ['class' => ' control-label']) !!}
                                            {!! Form::text('test_name_trader[]',null, ['class' => 'form-control']) !!}
                                            {!! $errors->first('test_name_trader[]', '<p class="help-block">:message</p>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group {{ $errors->has('test_type_model_layout[]') ? 'has-error' : ''}}">
                                            {!! Form::label('test_type_model_layout[]', 'ประเภท/รุ่น/แบบ: ', ['class' => ' control-label']) !!}
                                            {!! Form::text('test_type_model_layout[]',null, ['class' => 'form-control']) !!}
                                            {!! $errors->first('test_type_model_layout[]', '<p class="help-block">:message</p>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group {{ $errors->has('test_number_code[]') ? 'has-error' : ''}}">
                                            {!! Form::label('test_number_code[]', 'เลขที่/รหัส: ', ['class' => ' control-label']) !!}
                                            {!! Form::text('test_number_code[]',null, ['class' => 'form-control']) !!}
                                            {!! $errors->first('test_number_code[]', '<p class="help-block">:message</p>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group {{ $errors->has('test_limit_line[]') ? 'has-error' : ''}}">
                                            {!! Form::label('test_limit_line[]', 'ขีดความสามารถ: ', ['class' => ' control-label']) !!}
                                            {!! Form::text('test_limit_line[]',null, ['class' => 'form-control']) !!}
                                            {!! $errors->first('test_limit_line[]', '<p class="help-block">:message</p>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group {{ $errors->has('test_use_range[]') ? 'has-error' : ''}}">
                                            {!! Form::label('test_use_range[]', 'ช่วงการใช้งาน: ', ['class' => ' control-label']) !!}
                                            {!! Form::text('test_use_range[]',null, ['class' => 'form-control']) !!}
                                            {!! $errors->first('test_use_range[]', '<p class="help-block">:message</p>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group {{ $errors->has('test_standard_accept[]') ? 'has-error' : ''}}">
                                            {!! Form::label('test_standard_accept[]', 'เกณฑ์การยอมรับ: ', ['class' => ' control-label']) !!}
                                            {!! Form::text('test_standard_accept[]',null, ['class' => 'form-control']) !!}
                                            {!! $errors->first('test_standard_accept[]', '<p class="help-block">:message</p>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group {{ $errors->has('test_calibrate_freq[]') ? 'has-error' : ''}}">
                                            {!! Form::label('test_calibrate_freq[]', 'ความถี่ของการสอบเทียบ: ', ['class' => ' control-label']) !!}
                                            {!! Form::text('test_calibrate_freq[]',null, ['class' => 'form-control']) !!}
                                            {!! $errors->first('test_calibrate_freq[]', '<p class="help-block">:message</p>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group {{ $errors->has('test_last_calibrate[]') ? 'has-error' : ''}}">
                                            {!! Form::label('test_last_calibrate[]', 'สอบเทียบล่าสุด: ', ['class' => ' control-label']) !!}
                                            {!! Form::text('test_last_calibrate[]',null, ['class' => 'form-control mydatepicker']) !!}
                                            {!! $errors->first('test_last_calibrate[]', '<p class="help-block">:message</p>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group {{ $errors->has('test_matured_calibrate[]') ? 'has-error' : ''}}">
                                            {!! Form::label('test_matured_calibrate[]', 'วันที่ครบอายุสอบเทียบ: ', ['class' => ' control-label']) !!}
                                            {!! Form::text('test_matured_calibrate[]',null, ['class' => 'form-control mydatepicker']) !!}
                                            {!! $errors->first('test_matured_calibrate[]', '<p class="help-block">:message</p>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group {{ $errors->has('test_calibrate_department[]') ? 'has-error' : ''}}">
                                            {!! Form::label('test_calibrate_department[]', 'หน่วยงานที่สอบเทียบ: ', ['class' => ' control-label']) !!}
                                            {!! Form::text('test_calibrate_department[]',null, ['class' => 'form-control']) !!}
                                            {!! $errors->first('test_calibrate_department[]', '<p class="help-block">:message</p>') !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php $key93++ ?>
            </div>
        @endif
    @endif

    <div class="form-group" style="margin-bottom: 10px;margin-left: 10px">
        <div class="col-md-6"> </div>
        <button type="button" class="btn btn-sm btn-success" id="attach-add71">
            <i class="icon-plus"></i>&nbsp;เพิ่ม
        </button>
    </div>

    <div id="other_attach-box71">
        <div class="form-group other_attach_item71">
            <div class="col-md-2">
                {!! Form::text('attachs_desc71[]', null, ['class' => 'form-control m-t-10', 'placeholder' => 'ชื่อไฟล์']) !!}
            </div>
            <div class="col-md-4">
                <div class="fileinput fileinput-new input-group m-t-10" data-provides="fileinput">
                    <div class="form-control" data-trigger="fileinput">
                        <i class="glyphicon glyphicon-file fileinput-exists"></i>
                        <span class="fileinput-filename"></span>
                    </div>
                    <span class="input-group-addon btn btn-default btn-file">
                        <span class="fileinput-new">เลือกไฟล์</span>
                        <span class="fileinput-exists">เปลี่ยน</span>
                        {!! Form::file('attachs_sec71[]', null) !!}
                    </span>
                    <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
                </div>
            </div>

            <div class="col-md-2 text-left m-t-15" style="margin-top: 3px">
                <button class="btn btn-danger btn-sm attach-remove71" type="button">
                    <i class="icon-close"></i>
                </button>
            </div>

        </div>
    </div>

    @if ($certi_lab_attach_all71->count() > 0)
        <div class="col-md-12" style="padding-left: 4rem;padding-right: 4rem">
            <div class="container-fluid">
                <table class="table table-bordered" id="myTable_labTest">
                    <thead class="bg-primary">
                      <tr>
                          <th class="text-center text-white col-xs-4">ชื่อไฟล์</th>
                          <th class="text-center text-white col-xs-3">ดาวน์โหลด</th>
                          <th class="text-center text-white col-xs-3">ลบ</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($certi_lab_attach_all71 as $data)
                          <tr>
                              @if ($data->file)
                                  <td class="text-center">
                                      {{$data->file_desc}}
                                  </td>
                                  <td class="text-center">
                                      <a href="{{url('check/files/'.basename($data->file))}}" target="_blank">
                                          <i class="fa fa-file-pdf-o" style="font-size:25px; color:red" aria-hidden="true"></i>
                                      </a>
                                  </td>
                                  <td class="text-center">
                                      <a href="{{url('certify/applicant/delete/file').'/'.basename($data->file).'/'.$data->token}}" class="btn btn-danger btn-xs" onclick="return confirm('ต้องการลบไฟล์นี้ใช่หรือไม่ ?')">
                                          <i class="fa fa-remove"></i>
                                      </a>
                                  </td>
                              @endif
                          </tr>
                      @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

</div>

@push('js')
    <script src="{{ asset('plugins/components/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>

    <script>

        $(document).ready(function () {

            //เพิ่มไฟล์แนบ
            $('#attach-add71').click(function(event) {
                $('.other_attach_item71:first').clone().appendTo('#other_attach-box71');

                $('.other_attach_item71:last').find('input').val('');
                $('.other_attach_item71:last').find('a.fileinput-exists').click();
                $('.other_attach_item71:last').find('a.view-attach').remove();

                ShowHideRemoveBtn93();

            });

            //ลบไฟล์แนบ
            $('body').on('click', '.attach-remove71', function(event) {
                $(this).parent().parent().remove();
                ShowHideRemoveBtn93();
            });

            ShowHideRemoveBtn93();
        });

        function ShowHideRemoveBtn93() { //ซ่อน-แสดงปุ่มลบ

            if ($('.other_attach_item71').length > 1) {
                $('.attach-remove71').show();
            } else {
                $('.attach-remove71').hide();
            }

        }
    </script>

    <script>
        $(document).ready(function () {
            let box_test = $('.test_tools_box:first').clone();
            //ปฎิทิน
            $('.mydatepicker').datepicker({
                autoclose: true,
                todayHighlight: true,
                format: 'dd/mm/yyyy',
                orientation: 'bottom'
            });

            //เพิ่มตำแหน่งงาน
            $('#test_tools_add').click(function() {

                let newBox = box_test.clone(); //Clone Element
                newBox.find('input.mydatepicker').datepicker({
                    autoclose: true,
                    todayHighlight: true,
                    format: 'dd/mm/yyyy',
                    orientation: 'bottom'
                });
                newBox.find('input').val('');
                newBox.appendTo('#tools-test-container');

                var last_new = $('.test_tools_box').children(':last');
                {!! $key93+=1 !!}
                //Change Button
                $(last_new).find('button').removeClass('btn-success');
                $(last_new).find('button').addClass('btn-danger test_tools_remove');
                $(last_new).find('button').html('<i class="icon-close"></i> &nbsp;ลบ');
                if (reOrderLabTest() === 1){
                    last_new.find('button').remove();
                }

            });

            //ลบตำแหน่ง
            $('body').on('click', '.test_tools_remove', function() {

                $(this).parent().parent().parent().parent().parent().remove();

                if (reOrderLabTest() === 0){
                    $('#test_tools_add').trigger('click');
                }

            });


        });

        function reOrderLabTest(){//รีเซตลำดับของตำแหน่ง
            let new_val = 0;
            $('.test_tools_box').children().each(function(index, el) {
                $(el).find('input[name="test_tools_no[]"]').val(index+1);
                new_val++;
            });
            return new_val;
        }
    </script>
@endpush
