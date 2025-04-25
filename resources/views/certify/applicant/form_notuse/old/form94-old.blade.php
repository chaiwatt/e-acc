<?php $key94=0?>
<div class="m-l-10 m-t-20 form-group" style="margin-bottom: 0">
    {{--    <div class="col-md-3"></div>--}}
    <h4 class="m-l-5">8. วัสดุอ้างอิง/วัสดุอ้างอิงรับรอง</h4>

</div>
<div id="material_ref_box">
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
                            <i class="icon-close"></i> ลบ
                        </button>
                    @endif
                </div>
            </div>
        </div>
        {{--        <div class="col-md-10 col-md-offset-1">--}}
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
                            {!! Form::text('material_ref_name[]',null, ['class' => 'form-control']) !!}
                            {!! $errors->first('material_ref_name[]', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->has('value_ref_certificate[]') ? 'has-error' : ''}}">
                            {!! Form::label('value_ref_certificate[]', 'ค่าอ้างอิงที่ระบุในใบรับรอง: ', ['class' => ' control-label']) !!}
                            {!! Form::text('value_ref_certificate[]',null, ['class' => 'form-control']) !!}
                            {!! $errors->first('value_ref_certificate[]', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->has('firm_produce[]') ? 'has-error' : ''}}">
                            {!! Form::label('firm_produce[]', 'บริษัทผู้ผลิต: ', ['class' => ' control-label']) !!}
                            {!! Form::text('firm_produce[]',null, ['class' => 'form-control']) !!}
                            {!! $errors->first('firm_produce[]', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->has('lot_batch_no[]') ? 'has-error' : ''}}">
                            {!! Form::label('lot_batch_no[]', 'Lot/Batch No.: ', ['class' => ' control-label']) !!}
                            {!! Form::text('lot_batch_no[]',null, ['class' => 'form-control']) !!}
                            {!! $errors->first('lot_batch_no[]', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->has('traceability[]') ? 'has-error' : ''}}">
                            {!! Form::label('traceability[]', 'ความสอบกลับได้: ', ['class' => ' control-label']) !!}
                            {!! Form::text('traceability[]',null, ['class' => 'form-control']) !!}
                            {!! $errors->first('traceability[]', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->has('test_matured_material[]') ? 'has-error' : ''}}">
                            {!! Form::label('test_matured_material[]', 'วันที่ครบอายุสอบเทียบ: ', ['class' => ' control-label']) !!}
                            {!! Form::text('test_matured_material[]',null, ['class' => 'form-control mydatepicker']) !!}
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
                            {!! $errors->first('certificate_ref_file', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('js')
    <script src="{{ asset('js/jasny-bootstrap.js') }}"></script>
    <script src="{{ asset('plugins/components/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            //ปฎิทิน
            $('.mydatepicker').datepicker({
                autoclose: true,
                todayHighlight: true,
                format: 'dd/mm/yyyy',
                orientation: 'bottom'
            });

            //เพิ่มตำแหน่งงาน
            $('#material_ref_add').click(function() {

                let newBox = $('#material_ref_box').children(':first').clone(); //Clone Element
                newBox.find('input.mydatepicker').datepicker({
                    autoclose: true,
                    todayHighlight: true,
                    format: 'dd/mm/yyyy',
                    orientation: 'bottom'
                });
                newBox.find('input[type=file]').val('');
                newBox.find('div.fileinput-exists').removeClass('fileinput-exists').addClass('fileinput-new');
                newBox.find('span.fileinput-filename').text('');
                newBox.find('input').val('');
                newBox.appendTo('#material_ref_box');

                var last_new = $('#material_ref_box').children(':last');
                {!! $key94+=1 !!}
                //Change Button
                $(last_new).find('button').removeClass('btn-success');
                $(last_new).find('button').addClass('btn-danger material_ref_remove');
                $(last_new).find('button').html('<i class="icon-close"></i> ลบ');
                reOrderMaterial();

            });

            //ลบตำแหน่ง
            $('body').on('click', '.material_ref_remove', function() {

                $(this).parent().parent().parent().parent().remove();

                reOrderMaterial();

            });


        });

        function reOrderMaterial(){//รีเซตลำดับของตำแหน่ง
            $('#material_ref_box').children().each(function(index, el) {
                $(el).find('input[name="material_ref_no[]"]').val(index+1)
            });
        }
    </script>
@endpush