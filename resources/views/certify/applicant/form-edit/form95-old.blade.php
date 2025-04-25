<?php $key95=0?>
<div class="m-l-10 m-t-20 form-group" style="margin-bottom: 0">
    <h4 class="m-l-5">9. การเข้าร่วมโปรแกรมการทดสอบความสามารถ/การเปรียบเทียบผลระหว่างห้องปฏิบัติการ</h4>
</div>
@if ($certi_lab)
    @if($certi_lab->program->count() > 0)
        <button class="btn btn-success btn-sm pull-right m-b-10 m-l-5" id="test_program_add" type="button">
            <i class="icon-plus"></i> เพิ่ม
        </button>
        <div id="test_program_container">
            @foreach ($certi_lab->program as $program)
                <?php $key95++ ?>
                <div class="test_program_box">
                    <div class="row test_program_item">
                        <div class="col-md-12 m-b-10">
                            <div class="row">
                                <div class="col-md-8"></div>
                                {!! $errors->first('test_program[]', '<p class="help-block">:message</p>') !!}
                                <div class="col-md-4">
                                    @if($key95==0)
                                        <button class="btn btn-success pull-right btn-sm" id="test_program_add" type="button">
                                            <i class="icon-plus"></i> เพิ่ม
                                        </button>
                                    @else
                                        <button class="btn btn-danger pull-right btn-sm test_program_remove" type="button">
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
                                        <div class="form-group {{ $errors->has('test_program_no[]') ? 'has-error' : ''}}">
                                            {!! Form::label('test_program_no', 'ลำดับที่: ', ['class' => ' control-label']) !!}
                                            <input type="number" name="test_program_no[]" class="form-control text-center" readonly value="{{$program->no ?? ''}}">
                                            {!! $errors->first('test_program_no[]', '<p class="help-block">:message</p>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group {{ $errors->has('test_program_date[]') ? 'has-error' : ''}}">
                                            {!! Form::label('test_program_date[]', 'วันที่ดำเนินการ: ', ['class' => ' control-label']) !!}
                                            {!! Form::text('test_program_date[]',$program->process_date ? \Carbon\Carbon::parse($program->process_date)->format('d/m/Y'):'', ['class' => 'form-control mydatepicker']) !!}
                                            {!! $errors->first('test_program_date[]', '<p class="help-block">:message</p>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group {{ $errors->has('program_product_branch[]') ? 'has-error' : ''}}">
                                            {!! Form::label('program_product_branch[]', 'ผลิตภัณฑ์/สาขาการวัด: ', ['class' => ' control-label']) !!}
                                            {!! Form::text('program_product_branch[]',$program->product ?? '', ['class' => 'form-control']) !!}
                                            {!! $errors->first('program_product_branch[]', '<p class="help-block">:message</p>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group {{ $errors->has('program_test_calibrate_list[]') ? 'has-error' : ''}}">
                                            {!! Form::label('program_test_calibrate_list[]', 'รายการทดสอบ/รายการวัด: ', ['class' => ' control-label']) !!}
                                            {!! Form::text('program_test_calibrate_list[]',$program->item ?? '', ['class' => 'form-control']) !!}
                                            {!! $errors->first('program_test_calibrate_list[]', '<p class="help-block">:message</p>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group {{ $errors->has('organization_program[]') ? 'has-error' : ''}}">
                                            {!! Form::label('organization_program[]', 'หน่วยงานที่จัด: ', ['class' => ' control-label']) !!}
                                            {!! Form::text('organization_program[]',$program->depart ?? '', ['class' => 'form-control']) !!}
                                            {!! $errors->first('organization_program[]', '<p class="help-block">:message</p>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group {{ $errors->has('result_participation[]') ? 'has-error' : ''}}">
                                            {!! Form::label('result_participation[]', 'ผลการเข้าร่วม: ', ['class' => ' control-label']) !!}
                                            {!! Form::text('result_participation[]',$program->result ?? '', ['class' => 'form-control']) !!}
                                            {!! $errors->first('result_participation[]', '<p class="help-block">:message</p>') !!}
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
        <div id="test_program_container">
            <div class="test_program_box">
                <div class="row test_program_item">
                    <div class="col-md-12 m-b-10">
                        <div class="row">
                            <div class="col-md-8"></div>
                            {!! $errors->first('test_program[]', '<p class="help-block">:message</p>') !!}
                            <div class="col-md-4">
                                @if($key95==0)
                                    <button class="btn btn-success pull-right btn-sm" id="test_program_add" type="button">
                                        <i class="icon-plus"></i> เพิ่ม
                                    </button>
                                @else
                                    <button class="btn btn-danger pull-right btn-sm test_program_remove" type="button">
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
                                    <div class="form-group {{ $errors->has('test_program_no[]') ? 'has-error' : ''}}">
                                        {!! Form::label('test_program_no', 'ลำดับที่: ', ['class' => ' control-label']) !!}
                                        <input type="number" name="test_program_no[]" class="form-control text-center" readonly value="1">
                                        {!! $errors->first('test_program_no[]', '<p class="help-block">:message</p>') !!}
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group {{ $errors->has('test_program_date[]') ? 'has-error' : ''}}">
                                        {!! Form::label('test_program_date[]', 'วันที่ดำเนินการ: ', ['class' => ' control-label']) !!}
                                        {!! Form::text('test_program_date[]',null, ['class' => 'form-control mydatepicker']) !!}
                                        {!! $errors->first('test_program_date[]', '<p class="help-block">:message</p>') !!}
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group {{ $errors->has('program_product_branch[]') ? 'has-error' : ''}}">
                                        {!! Form::label('program_product_branch[]', 'ผลิตภัณฑ์/สาขาการวัด: ', ['class' => ' control-label']) !!}
                                        {!! Form::text('program_product_branch[]',null, ['class' => 'form-control']) !!}
                                        {!! $errors->first('program_product_branch[]', '<p class="help-block">:message</p>') !!}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group {{ $errors->has('program_test_calibrate_list[]') ? 'has-error' : ''}}">
                                        {!! Form::label('program_test_calibrate_list[]', 'รายการทดสอบ/รายการวัด: ', ['class' => ' control-label']) !!}
                                        {!! Form::text('program_test_calibrate_list[]',null, ['class' => 'form-control']) !!}
                                        {!! $errors->first('program_test_calibrate_list[]', '<p class="help-block">:message</p>') !!}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group {{ $errors->has('organization_program[]') ? 'has-error' : ''}}">
                                        {!! Form::label('organization_program[]', 'หน่วยงานที่จัด: ', ['class' => ' control-label']) !!}
                                        {!! Form::text('organization_program[]',null, ['class' => 'form-control']) !!}
                                        {!! $errors->first('organization_program[]', '<p class="help-block">:message</p>') !!}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group {{ $errors->has('result_participation[]') ? 'has-error' : ''}}">
                                        {!! Form::label('result_participation[]', 'ผลการเข้าร่วม: ', ['class' => ' control-label']) !!}
                                        {!! Form::text('result_participation[]',null, ['class' => 'form-control']) !!}
                                        {!! $errors->first('result_participation[]', '<p class="help-block">:message</p>') !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php $key95++ ?>
        </div>
    @endif
@endif

@push('js')
    <script src="{{ asset('plugins/components/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            let test_program_box = $('.test_program_box:first').clone();
            //ปฎิทิน
            $('.mydatepicker').datepicker({
                autoclose: true,
                todayHighlight: true,
                format: 'dd/mm/yyyy',
                orientation: 'bottom'
            });

            //เพิ่มตำแหน่งงาน
            $('#test_program_add').click(function() {

                let newBox = test_program_box.clone(); //Clone Element
                newBox.find('input.mydatepicker').datepicker({
                    autoclose: true,
                    todayHighlight: true,
                    format: 'dd/mm/yyyy',
                    orientation: 'bottom'
                });
                newBox.find('input').val('');
                newBox.appendTo('#test_program_container');

                var last_new = $('.test_program_box').children(':last');
                {!! $key95+=1 !!}
                //Change Button
                $(last_new).find('button').removeClass('btn-success');
                $(last_new).find('button').addClass('btn-danger test_program_remove');
                $(last_new).find('button').html('<i class="icon-close"></i> &nbsp;ลบ');

                if (reOrderTestProgram() === 1){
                    last_new.find('button').remove();
                }

            });

            //ลบตำแหน่ง
            $('body').on('click', '.test_program_remove', function() {

                $(this).parent().parent().parent().parent().parent().remove();

                if (reOrderTestProgram() === 0){
                    $('#test_program_add').trigger('click');
                }

            });


        });

        function reOrderTestProgram(){//รีเซตลำดับของตำแหน่ง
            let new_val = 0;
            $('.test_program_box').children().each(function(index, el) {
                $(el).find('input[name="test_program_no[]"]').val(index+1);
                new_val++;
            });
            return new_val;
        }
    </script>
@endpush