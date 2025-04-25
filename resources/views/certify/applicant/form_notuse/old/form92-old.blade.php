<?php $key92=0?>
<div id="viewForm92" style="display: none">
    <div class="m-l-10 m-t-20 form-group" style="margin-bottom: 0">
        {{--    <div class="col-md-3"></div>--}}
        <h4 class="m-l-5">7. เครื่องมือ (สอบเทียบ)</h4>

    </div>
    <input type="hidden" name="calibrateAddSize" id="calibrateAddSize" value="1">
    <div id="tools-box">
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
                        <div class="col-md-4">
                            <div class="form-group {{ $errors->has('name_trader[]') ? 'has-error' : ''}}">
                                {!! Form::label('name_trader[]', 'รายการ (ชื่อและเครื่องหมายการค้า): ', ['class' => ' control-label']) !!}
                                {!! Form::text('name_trader[]',null, ['class' => 'form-control']) !!}
                                {!! $errors->first('name_trader[]', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group {{ $errors->has('type_model_layout[]') ? 'has-error' : ''}}">
                                {!! Form::label('type_model_layout[]', 'ประเภท/รุ่น/แบบ: ', ['class' => ' control-label']) !!}
                                {!! Form::text('type_model_layout[]',null, ['class' => 'form-control']) !!}
                                {!! $errors->first('type_model_layout[]', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group {{ $errors->has('number_code[]') ? 'has-error' : ''}}">
                                {!! Form::label('number_code[]', 'เลขที่/รหัส: ', ['class' => ' control-label']) !!}
                                {!! Form::text('number_code[]',null, ['class' => 'form-control']) !!}
                                {!! $errors->first('number_code[]', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group {{ $errors->has('limit_line[]') ? 'has-error' : ''}}">
                                {!! Form::label('limit_line[]', 'ขีดความสามารถ: ', ['class' => ' control-label']) !!}
                                {!! Form::text('limit_line[]',null, ['class' => 'form-control']) !!}
                                {!! $errors->first('limit_line[]', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group {{ $errors->has('use_range[]') ? 'has-error' : ''}}">
                                {!! Form::label('use_range[]', 'ช่วงการใช้งาน: ', ['class' => ' control-label']) !!}
                                {!! Form::text('use_range[]',null, ['class' => 'form-control']) !!}
                                {!! $errors->first('use_range[]', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group {{ $errors->has('standard_accept[]') ? 'has-error' : ''}}">
                                {!! Form::label('standard_accept[]', 'เกณฑ์การยอมรับ: ', ['class' => ' control-label']) !!}
                                {!! Form::text('standard_accept[]',null, ['class' => 'form-control']) !!}
                                {!! $errors->first('standard_accept[]', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group {{ $errors->has('calibrate_freq[]') ? 'has-error' : ''}}">
                                {!! Form::label('calibrate_freq[]', 'ความถี่ของการสอบเทียบ: ', ['class' => ' control-label']) !!}
                                {!! Form::text('calibrate_freq[]',null, ['class' => 'form-control']) !!}
                                {!! $errors->first('calibrate_freq[]', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group {{ $errors->has('last_calibrate[]') ? 'has-error' : ''}}">
                                {!! Form::label('last_calibrate[]', 'สอบเทียบล่าสุด: ', ['class' => ' control-label']) !!}
                                {!! Form::text('last_calibrate[]',null, ['class' => 'form-control mydatepicker']) !!}
                                {!! $errors->first('last_calibrate[]', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group {{ $errors->has('calibrate_department[]') ? 'has-error' : ''}}">
                                {!! Form::label('calibrate_department[]', 'หน่วยงานที่สอบเทียบ: ', ['class' => ' control-label']) !!}
                                {!! Form::text('calibrate_department[]',null, ['class' => 'form-control']) !!}
                                {!! $errors->first('calibrate_department[]', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('js')
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
            $('#tools-add').click(function() {

                //$('#tools-box').children(':first').clone().appendTo('#tools-box'); //Clone Element

                let newBox = $('#tools-box').children(':first').clone(); //Clone Element
                newBox.find('input.mydatepicker').datepicker({
                    autoclose: true,
                    todayHighlight: true,
                    format: 'dd/mm/yyyy',
                    orientation: 'bottom'
                });
                newBox.find('input').val('');
                newBox.appendTo('#tools-box');

                var last_new = $('#tools-box').children(':last');

                //Clear value text
                // $(last_new).find('input[type="text"]').val('');
                //
                // //Clear value select
                // $(last_new).find('select').val('');
                // $(last_new).find('select').prev().remove();
                // $(last_new).find('select').removeAttr('style');
                //
                // //Clear Radio
                // $(last_new).find('.check').each(function(index, el) {
                //     $(el).prependTo($(el).parent().parent());
                //     $(el).removeAttr('style');
                //     $(el).parent().find('div').remove();
                //     $(el).parent().addClass($(el).attr('data-radio'));
                // });
                {!! $key92+=1 !!}
                //Change Button
                $(last_new).find('button').removeClass('btn-success');
                $(last_new).find('button').addClass('btn-danger tools-remove');
                $(last_new).find('button').html('<i class="icon-close"></i> ลบ');
                resetOrder();

            });

            //ลบตำแหน่ง
            $('body').on('click', '.tools-remove', function() {

                $(this).parent().parent().parent().parent().remove();

                resetOrder();

            });
        });

        function resetOrder(){//รีเซตลำดับของตำแหน่ง
            let new_val = 0;
            $('#tools-box').children().each(function(index, el) {
                new_val ++;
            });
            $('#calibrateAddSize').val(new_val);
        }
    </script>
@endpush