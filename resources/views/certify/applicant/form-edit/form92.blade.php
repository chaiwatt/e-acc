<?php $key92=0?>
<div id="viewForm92" class="{{$certi_lab->lab_type == 4 ? 'show':'hide'}}">
    <div class="m-l-10 m-t-20 form-group" style="margin-bottom: 0">
        <h4 class="m-l-5">7. เครื่องมือ (สอบเทียบ)</h4>
    </div>
    <input type="hidden" name="calibrateAddSize" id="calibrateAddSize" value="1">
    @if ($certi_lab)
        @if($certi_lab->certi_tools_calibrate->count() > 0)
            <button class="btn btn-success btn-sm pull-right m-b-10 m-l-5" id="tools-add" type="button">
                <i class="icon-plus"></i> เพิ่ม
            </button>
            <div id="tools-calibrate-container">
                @foreach ($certi_lab->certi_tools_calibrate as $tools_calibrate)
                    <?php $key92++ ?>
                    <div class="tools-box">
                        <div class="row tools-item">
                            <div class="col-md-12 m-b-10">
                                <div class="row">
                                    <div class="col-md-8"></div>
                                    {!! $errors->first('all_tools[]', '<p class="help-block">:message</p>') !!}
                                    <div class="col-md-4">
                                        @if($key92==0)
                                            <button class="btn btn-success pull-right btn-sm" id="tools-add" type="button">
                                                <i class="icon-plus"></i> เพิ่ม
                                            </button>
                                        @else
                                            <button class="btn btn-danger pull-right btn-sm tools-remove" type="button">
                                                <i class="icon-close"></i> &nbsp;ลบ
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="white-box" style="border: 2px solid #e5ebec;">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group {{ $errors->has('name_trader[]') ? 'has-error' : ''}}">
                                                {!! Form::label('name_trader[]', 'รายการ (ชื่อและเครื่องหมายการค้า): ', ['class' => ' control-label']) !!}
                                                {!! Form::text('name_trader[]',$tools_calibrate->name ?? '', ['class' => 'form-control' ]) !!}
                                                {!! $errors->first('name_trader[]', '<p class="help-block">:message</p>') !!}
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group {{ $errors->has('type_model_layout[]') ? 'has-error' : ''}}">
                                                {!! Form::label('type_model_layout[]', 'ประเภท/รุ่น/แบบ: ', ['class' => ' control-label']) !!}
                                                {!! Form::text('type_model_layout[]',$tools_calibrate->type ?? '', ['class' => 'form-control' ]) !!}
                                                {!! $errors->first('type_model_layout[]', '<p class="help-block">:message</p>') !!}
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group {{ $errors->has('number_code[]') ? 'has-error' : ''}}">
                                                {!! Form::label('number_code[]', 'เลขที่/รหัส: ', ['class' => ' control-label']) !!}
                                                {!! Form::text('number_code[]',$tools_calibrate->code_no ?? '', ['class' => 'form-control' ]) !!}
                                                {!! $errors->first('number_code[]', '<p class="help-block">:message</p>') !!}
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group {{ $errors->has('limit_line[]') ? 'has-error' : ''}}">
                                                {!! Form::label('limit_line[]', 'ขีดความสามารถ: ', ['class' => ' control-label']) !!}
                                                {!! Form::text('limit_line[]',$tools_calibrate->capability ?? '', ['class' => 'form-control' ]) !!}
                                                {!! $errors->first('limit_line[]', '<p class="help-block">:message</p>') !!}
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group {{ $errors->has('use_range[]') ? 'has-error' : ''}}">
                                                {!! Form::label('use_range[]', 'ช่วงการใช้งาน: ', ['class' => ' control-label']) !!}
                                                {!! Form::text('use_range[]',$tools_calibrate->usage_time ?? '', ['class' => 'form-control' ]) !!}
                                                {!! $errors->first('use_range[]', '<p class="help-block">:message</p>') !!}
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group {{ $errors->has('standard_accept[]') ? 'has-error' : ''}}">
                                                {!! Form::label('standard_accept[]', 'เกณฑ์การยอมรับ: ', ['class' => ' control-label']) !!}
                                                {!! Form::text('standard_accept[]',$tools_calibrate->standard ?? '', ['class' => 'form-control' ]) !!}
                                                {!! $errors->first('standard_accept[]', '<p class="help-block">:message</p>') !!}
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group {{ $errors->has('calibrate_freq[]') ? 'has-error' : ''}}">
                                                {!! Form::label('calibrate_freq[]', 'ความถี่ของการสอบเทียบ: ', ['class' => ' control-label']) !!}
                                                {!! Form::text('calibrate_freq[]',$tools_calibrate->cali_times ?? '', ['class' => 'form-control' ]) !!}
                                                {!! $errors->first('calibrate_freq[]', '<p class="help-block">:message</p>') !!}
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group {{ $errors->has('last_calibrate[]') ? 'has-error' : ''}}">
                                                {!! Form::label('last_calibrate[]', 'สอบเทียบล่าสุด: ', ['class' => ' control-label']) !!}
                                                {!! Form::text('last_calibrate[]',$tools_calibrate->cali_latest_date ? \Carbon\Carbon::parse($tools_calibrate->cali_latest_date)->format('d/m/Y'):'', ['class' => 'form-control mydatepicker' ]) !!}
                                                {!! $errors->first('last_calibrate[]', '<p class="help-block">:message</p>') !!}
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group {{ $errors->has('calibrate_department[]') ? 'has-error' : ''}}">
                                                {!! Form::label('calibrate_department[]', 'หน่วยงานที่สอบเทียบ: ', ['class' => ' control-label']) !!}
                                                {!! Form::text('calibrate_department[]',$tools_calibrate->cali_depart ?? '', ['class' => 'form-control' ]) !!}
                                                {!! $errors->first('calibrate_department[]', '<p class="help-block">:message</p>') !!}
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
            <div id="tools-calibrate-container">
                <div class="tools-box">
                    <div class="row tools-item">
                        <div class="col-md-12 m-b-10">
                            <div class="row">
                                <div class="col-md-8"></div>
                                {!! $errors->first('all_tools[]', '<p class="help-block">:message</p>') !!}
                                <div class="col-md-4">
                                    @if($key92==0)
                                        <button class="btn btn-success pull-right btn-sm" id="tools-add" type="button">
                                            <i class="icon-plus"></i> เพิ่ม
                                        </button>
                                    @else
                                        <button class="btn btn-danger pull-right btn-sm tools-remove" type="button">
                                            <i class="icon-close"></i> &nbsp;ลบ
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="white-box" style="border: 2px solid #e5ebec;">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group {{ $errors->has('name_trader[]') ? 'has-error' : ''}}">
                                            {!! Form::label('name_trader[]', 'รายการ (ชื่อและเครื่องหมายการค้า): ', ['class' => ' control-label']) !!}
                                            {!! Form::text('name_trader[]',null, ['class' => 'form-control' ]) !!}
                                            {!! $errors->first('name_trader[]', '<p class="help-block">:message</p>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group {{ $errors->has('type_model_layout[]') ? 'has-error' : ''}}">
                                            {!! Form::label('type_model_layout[]', 'ประเภท/รุ่น/แบบ: ', ['class' => ' control-label']) !!}
                                            {!! Form::text('type_model_layout[]',null, ['class' => 'form-control' ]) !!}
                                            {!! $errors->first('type_model_layout[]', '<p class="help-block">:message</p>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group {{ $errors->has('number_code[]') ? 'has-error' : ''}}">
                                            {!! Form::label('number_code[]', 'เลขที่/รหัส: ', ['class' => ' control-label']) !!}
                                            {!! Form::text('number_code[]',null, ['class' => 'form-control' ]) !!}
                                            {!! $errors->first('number_code[]', '<p class="help-block">:message</p>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group {{ $errors->has('limit_line[]') ? 'has-error' : ''}}">
                                            {!! Form::label('limit_line[]', 'ขีดความสามารถ: ', ['class' => ' control-label']) !!}
                                            {!! Form::text('limit_line[]',null, ['class' => 'form-control' ]) !!}
                                            {!! $errors->first('limit_line[]', '<p class="help-block">:message</p>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group {{ $errors->has('use_range[]') ? 'has-error' : ''}}">
                                            {!! Form::label('use_range[]', 'ช่วงการใช้งาน: ', ['class' => ' control-label']) !!}
                                            {!! Form::text('use_range[]',null, ['class' => 'form-control' ]) !!}
                                            {!! $errors->first('use_range[]', '<p class="help-block">:message</p>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group {{ $errors->has('standard_accept[]') ? 'has-error' : ''}}">
                                            {!! Form::label('standard_accept[]', 'เกณฑ์การยอมรับ: ', ['class' => ' control-label']) !!}
                                            {!! Form::text('standard_accept[]',null, ['class' => 'form-control' ]) !!}
                                            {!! $errors->first('standard_accept[]', '<p class="help-block">:message</p>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group {{ $errors->has('calibrate_freq[]') ? 'has-error' : ''}}">
                                            {!! Form::label('calibrate_freq[]', 'ความถี่ของการสอบเทียบ: ', ['class' => ' control-label']) !!}
                                            {!! Form::text('calibrate_freq[]',null, ['class' => 'form-control' ]) !!}
                                            {!! $errors->first('calibrate_freq[]', '<p class="help-block">:message</p>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group {{ $errors->has('last_calibrate[]') ? 'has-error' : ''}}">
                                            {!! Form::label('last_calibrate[]', 'สอบเทียบล่าสุด: ', ['class' => ' control-label']) !!}
                                            {!! Form::text('last_calibrate[]',null, ['class' => 'form-control mydatepicker' ]) !!}
                                            {!! $errors->first('last_calibrate[]', '<p class="help-block">:message</p>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group {{ $errors->has('calibrate_department[]') ? 'has-error' : ''}}">
                                            {!! Form::label('calibrate_department[]', 'หน่วยงานที่สอบเทียบ: ', ['class' => ' control-label']) !!}
                                            {!! Form::text('calibrate_department[]',null, ['class' => 'form-control' ]) !!}
                                            {!! $errors->first('calibrate_department[]', '<p class="help-block">:message</p>') !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php $key92++ ?>
            </div>
        @endif
    @endif

    <div class="form-group" style="margin-bottom: 10px;margin-left: 10px">
        <div class="col-md-6"> </div>
        <button type="button" class="btn btn-sm btn-success" id="attach-add72">
            <i class="icon-plus"></i>&nbsp;เพิ่ม
        </button>
    </div>

    <div id="other_attach-box72">
        <div class="form-group other_attach_item72">
            <div class="col-md-2">
                {!! Form::text('attachs_desc72[]', null, ['class' => 'form-control m-t-10', 'placeholder' => 'ชื่อไฟล์']) !!}
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
                        {!! Form::file('attachs_sec72[]', null) !!}
                    </span>
                    <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
                </div>
            </div>

            <div class="col-md-2 text-left m-t-15" style="margin-top: 3px">
                <button class="btn btn-danger btn-sm attach-remove72" type="button">
                    <i class="icon-close"></i>
                </button>
            </div>

        </div>
    </div>

    @if($certi_lab_attach_all72->count() > 0)
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
                    @foreach($certi_lab_attach_all72 as $data)
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
            $('#attach-add72').click(function(event) {
                $('.other_attach_item72:first').clone().appendTo('#other_attach-box72');

                $('.other_attach_item72:last').find('input').val('');
                $('.other_attach_item72:last').find('a.fileinput-exists').click();
                $('.other_attach_item72:last').find('a.view-attach').remove();

                ShowHideRemoveBtn92();

            });

            //ลบไฟล์แนบ
            $('body').on('click', '.attach-remove72', function(event) {
                $(this).parent().parent().remove();
                ShowHideRemoveBtn92();
            });

            ShowHideRemoveBtn92();
        });

        function ShowHideRemoveBtn92() { //ซ่อน-แสดงปุ่มลบ

            if ($('.other_attach_item72').length > 1) {
                $('.attach-remove72').show();
            } else {
                $('.attach-remove72').hide();
            }

        }
    </script>

    <script>
        $(document).ready(function () {
            let box = $('.tools-box:first').clone();
            let calibrateAddSize_val = '{!! $certi_lab->certi_tools_calibrate->count() !!}';
            if (calibrateAddSize_val > 0){
                $('#calibrateAddSize').val(calibrateAddSize_val);
            }else{
                $('#calibrateAddSize').val(1);
            }

            //ปฎิทิน
            $('.mydatepicker').datepicker({
                autoclose: true,
                todayHighlight: true,
                format: 'dd/mm/yyyy',
                orientation: 'bottom'
            });

            //เพิ่มตำแหน่งงาน
            $('#tools-add').on('click',function () {
                let newBox = box.clone();
                newBox.find('input.mydatepicker').datepicker({
                    autoclose: true,
                    todayHighlight: true,
                    format: 'dd/mm/yyyy',
                    orientation: 'bottom'
                });
                newBox.find('input').val('');
                newBox.appendTo('#tools-calibrate-container');

                var last_new = $('.tools-box').children(':last');

                {!! $key92+=1 !!}
                //Change Button
                $(last_new).find('button').removeClass('btn-success');
                $(last_new).find('button').addClass('btn-danger tools-remove');
                $(last_new).find('button').html('<i class="icon-close"></i> &nbsp;ลบ');

                if (resetOrder() === 1){
                    last_new.find('button').remove();
                }

            });

            //ลบตำแหน่ง
            $('body').on('click', '.tools-remove', function() {
                $(this).parent().parent().parent().parent().parent().remove();

                if (resetOrder() === 0){
                    $('#tools-add').trigger('click');
                    $('#calibrateAddSize').val(1);
                }
            });
        });

        function resetOrder(){//รีเซตลำดับของตำแหน่ง
            let new_val = 0;
            $('.tools-box').each(function(index, el) {
                new_val ++;
            });
            $('#calibrateAddSize').val(new_val);
            return new_val;
        }
    </script>
@endpush
