<?php $key94=0?>
<div class="m-l-10 m-t-20 form-group" style="margin-bottom: 0">
    <h4 class="m-l-5">8. วัสดุอ้างอิง/วัสดุอ้างอิงรับรอง</h4>
</div>
@if ($certi_lab)
    @if($certi_lab->material->count() > 0)
        <button class="btn btn-success pull-right btn-sm m-b-10 m-l-5" id="material_ref_add" type="button">
            <i class="icon-plus"></i> เพิ่ม
        </button>
        <div id="materail_ref_container">
            @foreach ($certi_lab->material as $material)
                <?php $key94++ ?>
                <div class="material_ref_box">
                    <div class="row material_ref_item">
                        <div class="col-md-12 m-b-10">
                            <div class="row">
                                <div class="col-md-8"></div>
                                {!! $errors->first('material_ref[]', '<p class="help-block">:message</p>') !!}
                                <div class="col-md-4">
                                    @if($key94==0)
                                        <button class="btn btn-success pull-right btn-sm" id="material_ref_add" type="button">
                                            <i class="icon-plus"></i> เพิ่ม
                                        </button>
                                    @else
                                        <button class="btn btn-danger pull-right btn-sm material_ref_remove" type="button">
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
                                        <div class="form-group {{ $errors->has('material_ref_no[]') ? 'has-error' : ''}}">
                                            {!! Form::label('material_ref_no', 'ลำดับที่: ', ['class' => ' control-label']) !!}
                                            <input type="number" name="material_ref_no[]" class="form-control text-center" readonly value="{{$material->no ?? ''}}">
                                            {!! $errors->first('material_ref_no[]', '<p class="help-block">:message</p>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="form-group {{ $errors->has('material_ref_name[]') ? 'has-error' : ''}}">
                                            {!! Form::label('material_ref_name[]', 'ชื่อวัสดุอ้างอิงรับรอง/วัสดุอ้างอิง: ', ['class' => ' control-label']) !!}
                                            {!! Form::text('material_ref_name[]',$material->name ?? '', ['class' => 'form-control'  ]) !!}
                                            {!! $errors->first('material_ref_name[]', '<p class="help-block">:message</p>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group {{ $errors->has('value_ref_certificate[]') ? 'has-error' : ''}}">
                                            {!! Form::label('value_ref_certificate[]', 'ค่าอ้างอิงที่ระบุในใบรับรอง: ', ['class' => ' control-label']) !!}
                                            {!! Form::text('value_ref_certificate[]',$material->ref_value ?? '', ['class' => 'form-control'  ]) !!}
                                            {!! $errors->first('value_ref_certificate[]', '<p class="help-block">:message</p>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group {{ $errors->has('firm_produce[]') ? 'has-error' : ''}}">
                                            {!! Form::label('firm_produce[]', 'บริษัทผู้ผลิต: ', ['class' => ' control-label']) !!}
                                            {!! Form::text('firm_produce[]',$material->manufacturer ?? '', ['class' => 'form-control'  ]) !!}
                                            {!! $errors->first('firm_produce[]', '<p class="help-block">:message</p>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group {{ $errors->has('lot_batch_no[]') ? 'has-error' : ''}}">
                                            {!! Form::label('lot_batch_no[]', 'Lot/Batch No.: ', ['class' => ' control-label']) !!}
                                            {!! Form::text('lot_batch_no[]',$material->batch_no ?? '', ['class' => 'form-control'  ]) !!}
                                            {!! $errors->first('lot_batch_no[]', '<p class="help-block">:message</p>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group {{ $errors->has('traceability[]') ? 'has-error' : ''}}">
                                            {!! Form::label('traceability[]', 'ความสอบกลับได้: ', ['class' => ' control-label']) !!}
                                            {!! Form::text('traceability[]',$material->testing ?? '', ['class' => 'form-control'  ]) !!}
                                            {!! $errors->first('traceability[]', '<p class="help-block">:message</p>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group {{ $errors->has('test_matured_material[]') ? 'has-error' : ''}}">
                                            {!! Form::label('test_matured_material[]', 'วันที่ครบอายุสอบเทียบ: ', ['class' => ' control-label']) !!}
                                            {!! Form::text('test_matured_material[]',$material->cali_anni_date ? \Carbon\Carbon::parse($material->cali_anni_date)->format('d/m/Y'):'', ['class' => 'form-control mydatepicker'  ]) !!}
                                            {!! $errors->first('test_matured_material[]', '<p class="help-block">:message</p>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group {{ $errors->has('certificate_ref_file[]') ? 'has-error' : ''}}">
                                            {!! Form::label('certificate_ref_file[]', 'ใบรับรองวัสดุ: ', ['class' => ' control-label']) !!}
                                            <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                                <div class="form-control" data-trigger="fileinput">
                                                    <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                                    <span class="fileinput-filename"></span>
                                                </div>
                                                <span class="input-group-addon btn btn-default btn-file">
                                            <span class="fileinput-new">เลือกไฟล์</span>
                                            <span class="fileinput-exists">เปลี่ยน</span>
                                                @if ($material->certi_material_file)
                                                        <input type="file" id="certi_material_file[]" name="certi_material_file[]" onchange="alert('คุณกำลังเปลี่ยนไฟล์')">
                                                    @else
                                                        {!! Form::file('certi_material_file[]', null) !!}
                                                    @endif
                                            </span>
                                                <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
                                            </div>
                                            <input type="hidden" name="has_old_mat_file[]" id="has_old_mat_file" value="{{$material->certi_material_file ?? 'no'}}">
                                            @if ($material->certi_material_file)
                                                <small class="text-danger">* อัพโหลดไฟล์ใหม่ หากต้องการเปลี่ยนไฟล์</small>
                                            @endif
                                            {!! $errors->first('certificate_ref_file', '<p class="help-block">:message</p>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="control-label">ไฟล์แนบใบรับรองวัสดุ:</label>
                                        <div class="text-center" style="margin-top: 5px">
                                            @if ($material->certi_material_file)
                                                <a href="{{url('check/files/'.basename($material->certi_material_file))}}" class="text-white" target="_blank">
                                            <span class="badge badge-success" style="padding: 6px;white-space: initial;text-transform: initial;">
                                                <i class="mdi mdi-file"></i> {{basename($material->certi_material_file)}}
                                            </span>
                                                </a>
                                            @else
                                                <span class="badge badge-danger" style="padding: 8px">
                                            ยังไม่มีไฟล์
                                        </span>
                                            @endif
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
        <div id="materail_ref_container">
            <div class="material_ref_box">
                <div class="row material_ref_item">
                    <div class="col-md-12 m-b-10">
                        <div class="row">
                            <div class="col-md-8"></div>
                            {!! $errors->first('material_ref[]', '<p class="help-block">:message</p>') !!}
                            <div class="col-md-4">
                                @if($key94==0)
                                    <button class="btn btn-success pull-right btn-sm" id="material_ref_add" type="button">
                                        <i class="icon-plus"></i> เพิ่ม
                                    </button>
                                @else
                                    <button class="btn btn-danger pull-right btn-sm material_ref_remove" type="button">
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
                                    <div class="form-group {{ $errors->has('material_ref_no[]') ? 'has-error' : ''}}">
                                        {!! Form::label('material_ref_no', 'ลำดับที่: ', ['class' => ' control-label']) !!}
                                        <input type="number" name="material_ref_no[]" class="form-control text-center" readonly value="1">
                                        {!! $errors->first('material_ref_no[]', '<p class="help-block">:message</p>') !!}
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <div class="form-group {{ $errors->has('material_ref_name[]') ? 'has-error' : ''}}">
                                        {!! Form::label('material_ref_name[]', 'ชื่อวัสดุอ้างอิงรับรอง/วัสดุอ้างอิง: ', ['class' => ' control-label']) !!}
                                        {!! Form::text('material_ref_name[]',null, ['class' => 'form-control'  ]) !!}
                                        {!! $errors->first('material_ref_name[]', '<p class="help-block">:message</p>') !!}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group {{ $errors->has('value_ref_certificate[]') ? 'has-error' : ''}}">
                                        {!! Form::label('value_ref_certificate[]', 'ค่าอ้างอิงที่ระบุในใบรับรอง: ', ['class' => ' control-label']) !!}
                                        {!! Form::text('value_ref_certificate[]',null, ['class' => 'form-control'  ]) !!}
                                        {!! $errors->first('value_ref_certificate[]', '<p class="help-block">:message</p>') !!}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group {{ $errors->has('firm_produce[]') ? 'has-error' : ''}}">
                                        {!! Form::label('firm_produce[]', 'บริษัทผู้ผลิต: ', ['class' => ' control-label']) !!}
                                        {!! Form::text('firm_produce[]',null, ['class' => 'form-control'  ]) !!}
                                        {!! $errors->first('firm_produce[]', '<p class="help-block">:message</p>') !!}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group {{ $errors->has('lot_batch_no[]') ? 'has-error' : ''}}">
                                        {!! Form::label('lot_batch_no[]', 'Lot/Batch No.: ', ['class' => ' control-label']) !!}
                                        {!! Form::text('lot_batch_no[]',null, ['class' => 'form-control'  ]) !!}
                                        {!! $errors->first('lot_batch_no[]', '<p class="help-block">:message</p>') !!}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group {{ $errors->has('traceability[]') ? 'has-error' : ''}}">
                                        {!! Form::label('traceability[]', 'ความสอบกลับได้: ', ['class' => ' control-label']) !!}
                                        {!! Form::text('traceability[]',null, ['class' => 'form-control'  ]) !!}
                                        {!! $errors->first('traceability[]', '<p class="help-block">:message</p>') !!}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group {{ $errors->has('test_matured_material[]') ? 'has-error' : ''}}">
                                        {!! Form::label('test_matured_material[]', 'วันที่ครบอายุสอบเทียบ: ', ['class' => ' control-label']) !!}
                                        {!! Form::text('test_matured_material[]',null, ['class' => 'form-control mydatepicker'  ]) !!}
                                        {!! $errors->first('test_matured_material[]', '<p class="help-block">:message</p>') !!}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group {{ $errors->has('certificate_ref_file[]') ? 'has-error' : ''}}">
                                        {!! Form::label('certificate_ref_file[]', 'ใบรับรองวัสดุ: ', ['class' => ' control-label']) !!}
                                        <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                            <div class="form-control" data-trigger="fileinput">
                                                <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                                <span class="fileinput-filename"></span>
                                            </div>
                                            <span class="input-group-addon btn btn-default btn-file">
                                    <span class="fileinput-new">เลือกไฟล์</span>
                                    <span class="fileinput-exists">เปลี่ยน</span>
                                        {!! Form::file('certi_material_file[]', null) !!}
                                    </span>
                                            <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
                                        </div>
                                        <input type="hidden" name="has_old_mat_file[]" id="has_old_mat_file" value="no">
                                        {!! $errors->first('certificate_ref_file', '<p class="help-block">:message</p>') !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php $key94++ ?>
        </div>
    @endif
@endif

@push('js')
    <script src="{{ asset('js/jasny-bootstrap.js') }}"></script>
    <script src="{{ asset('plugins/components/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            // let material_ref_box = $('.material_ref_box:first').clone();
            let material_ref_box = "<div id=\"materail_ref_container\">\n" +
                "    <div class=\"material_ref_box\">\n" +
                "        <div class=\"row material_ref_item\">\n" +
                "            <div class=\"col-md-12 m-b-10\">\n" +
                "                <div class=\"row\">\n" +
                "                    <div class=\"col-md-8\"></div>\n" +
                "                    <div class=\"col-md-4\">\n" +
                "                        <button class=\"btn btn-danger pull-right btn-sm material_ref_remove\" type=\"button\">\n" +
                "                            <i class=\"icon-close\"></i> &nbsp;ลบ\n" +
                "                        </button>\n" +
                "                    </div>\n" +
                "                </div>\n" +
                "            </div>\n" +
                "            <div class=\"col-md-12\">\n" +
                "                <div class=\"white-box\" style=\"border: 2px solid #e5ebec;\">\n" +
                "                    <div class=\"row\">\n" +
                "                        <div class=\"col-md-2\">\n" +
                "                            <div class=\"form-group\">\n" +
                "                                <label for=\"material_ref_no[]\" class=\"control-label\">ลำดับที่: </label>\n" +
                "                                <input type=\"number\" name=\"material_ref_no[]\" id=\"material_ref_no[]\" class=\"form-control text-center\" readonly value=\"1\">\n" +
                "                            </div>\n" +
                "                        </div>\n" +
                "                        <div class=\"col-md-10\">\n" +
                "                            <div class=\"form-group\">\n" +
                "                                <label for=\"material_ref_name[]\" class=\"control-label\">ชื่อวัสดุอ้างอิงรับรอง/วัสดุอ้างอิง: </label>\n" +
                "                                <input type=\"text\" name=\"material_ref_name[]\" id=\"material_ref_name[]\" class=\"form-control\">\n" +
                "                            </div>\n" +
                "                        </div>\n" +
                "                        <div class=\"col-md-4\">\n" +
                "                            <div class=\"form-group\">\n" +
                "                                <label for=\"value_ref_certificate[]\" class=\"control-label\">ค่าอ้างอิงที่ระบุในใบรับรอง: </label>\n" +
                "                                <input type=\"text\" name=\"value_ref_certificate[]\" id=\"value_ref_certificate[]\" class=\"form-control\">\n" +
                "                            </div>\n" +
                "                        </div>\n" +
                "                        <div class=\"col-md-4\">\n" +
                "                            <div class=\"form-group\">\n" +
                "                                <label for=\"firm_produce[]\" class=\"control-label\">บริษัทผู้ผลิต: </label>\n" +
                "                                <input type=\"text\" name=\"firm_produce[]\" id=\"firm_produce[]\" class=\"form-control\">\n" +
                "                            </div>\n" +
                "                        </div>\n" +
                "                        <div class=\"col-md-4\">\n" +
                "                            <div class=\"form-group\">\n" +
                "                                <label for=\"lot_batch_no[]\" class=\"control-label\">Lot/Batch No.: </label>\n" +
                "                                <input type=\"text\" name=\"lot_batch_no[]\" id=\"lot_batch_no[]\" class=\"form-control\">\n" +
                "                            </div>\n" +
                "                        </div>\n" +
                "                        <div class=\"col-md-4\">\n" +
                "                            <div class=\"form-group\">\n" +
                "                                <label for=\"traceability[]\" class=\"control-label\">ความสอบกลับได้: </label>\n" +
                "                                <input type=\"text\" name=\"traceability[]\" id=\"traceability[]\" class=\"form-control\">\n" +
                "                            </div>\n" +
                "                        </div>\n" +
                "                        <div class=\"col-md-4\">\n" +
                "                            <div class=\"form-group\">\n" +
                "                                <label for=\"test_matured_material[]\" class=\"control-label\">วันที่ครบอายุสอบเทียบ: </label>\n" +
                "                                <input type=\"text\" name=\"test_matured_material[]\" id=\"test_matured_material[]\" class=\"form-control mydatepicker\">\n" +
                "                            </div>\n" +
                "                        </div>\n" +
                "                        <div class=\"col-md-4\">\n" +
                "                            <div class=\"form-group\">\n" +
                "                                <label for=\"certificate_ref_file[]\" class=\"control-label\">ใบรับรองวัสดุ: </label>\n" +
                "                                <div class=\"fileinput fileinput-new input-group\" data-provides=\"fileinput\">\n" +
                "                                    <div class=\"form-control\" data-trigger=\"fileinput\">\n" +
                "                                        <i class=\"glyphicon glyphicon-file fileinput-exists\"></i>\n" +
                "                                        <span class=\"fileinput-filename\"></span>\n" +
                "                                    </div>\n" +
                "                                    <span class=\"input-group-addon btn btn-default btn-file\">\n" +
                "                                    <span class=\"fileinput-new\">เลือกไฟล์</span>\n" +
                "                                    <span class=\"fileinput-exists\">เปลี่ยน</span>\n" +
                "                                        <input type=\"file\" name=\"certi_material_file[]\" id=\"certi_material_file[]\">\n" +
                "                                    </span>\n" +
                "                                    <a href=\"#\" class=\"input-group-addon btn btn-default fileinput-exists\" data-dismiss=\"fileinput\">ลบ</a>\n" +
                "                                </div>\n" +
                "                                <input type=\"hidden\" name=\"has_old_mat_file[]\" id=\"has_old_mat_file\" value=\"no\">\n" +
                "                            </div>\n" +
                "                        </div>\n" +
                "                    </div>\n" +
                "                </div>\n" +
                "            </div>\n" +
                "        </div>\n" +
                "    </div>\n" +
                "</div>";
            //ปฎิทิน
            $('.mydatepicker').datepicker({
                autoclose: true,
                todayHighlight: true,
                format: 'dd/mm/yyyy',
                orientation: 'bottom'
            });

            //เพิ่มตำแหน่งงาน
            $('#material_ref_add').click(function() {
                // newBox.find('input.mydatepicker').datepicker({
                //     autoclose: true,
                //     todayHighlight: true,
                //     format: 'dd/mm/yyyy',
                //     orientation: 'bottom'
                // });
                // newBox.find('input[type=file]').val('');
                // newBox.find('div.fileinput-exists').removeClass('fileinput-exists').addClass('fileinput-new');
                // newBox.find('span.fileinput-filename').text('');
                // newBox.find('input').val('');
                //newBox.appendTo('#materail_ref_container');
                $('#materail_ref_container').append(material_ref_box);

                var last_new = $('.material_ref_box').children(':last');
                {!! $key94+=1 !!}
                last_new.find('input.mydatepicker').datepicker({
                    autoclose: true,
                    todayHighlight: true,
                    format: 'dd/mm/yyyy',
                    orientation: 'bottom'
                });
                //Change Button
                $(last_new).find('button').removeClass('btn-success');
                $(last_new).find('button').addClass('btn-danger material_ref_remove');
                $(last_new).find('button').html('<i class="icon-close"></i> &nbsp;ลบ');
                if (reOrderMaterial() === 1){
                    last_new.find('button').remove();
                }
            });

            //ลบตำแหน่ง
            $('body').on('click', '.material_ref_remove', function() {

                $(this).parent().parent().parent().parent().parent().remove();

                if (reOrderMaterial() === 0){
                    $('#material_ref_add').trigger('click');
                }
            });


        });

        function reOrderMaterial(){//รีเซตลำดับของตำแหน่ง
            let new_val = 0;
            $('.material_ref_box').children().each(function(index, el) {
                $(el).find('input[name="material_ref_no[]"]').val(index+1);
                new_val++;
            });
            return new_val;
        }
    </script>
@endpush