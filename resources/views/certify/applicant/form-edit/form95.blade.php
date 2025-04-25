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

<div class="form-group" style="margin-bottom: 10px; margin-left: 10px">
    <div class="col-md-6"> </div>
    <button type="button" class="btn btn-sm btn-success" id="attach-add9">
        <i class="icon-plus"></i>&nbsp;เพิ่ม
    </button>
</div>

<div id="other_attach-box9">
    <div class="form-group other_attach_item9">
        <div class="col-md-2">
            {!! Form::text('attachs_desc9[]', null, ['class' => 'form-control m-t-10', 'placeholder' => 'ชื่อไฟล์']) !!}
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
                    {{-- {!! Form::file('attachs_sec9[]', null) !!} --}}
                    <input type="file" name="attachs_sec9[]" class="check_max_size_file">
                </span>
                <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
            </div>
        </div>

        <div class="col-md-2 text-left m-t-15" style="margin-top: 3px">
            <button class="btn btn-danger btn-sm attach-remove9" type="button">
                <i class="icon-close"></i>
            </button>
        </div>

    </div>
</div>

@if ($certi_lab_attach_all9->count() > 0)
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
                @foreach($certi_lab_attach_all9 as $data)
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

@push('js')
    <script src="{{ asset('plugins/components/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            //เพิ่มไฟล์แนบ
            $('#attach-add9').click(function(event) {
                $('.other_attach_item9:first').clone().appendTo('#other_attach-box9');

                $('.other_attach_item9:last').find('input').val('');
                $('.other_attach_item9:last').find('a.fileinput-exists').click();
                $('.other_attach_item9:last').find('a.view-attach').remove();

                ShowHideRemoveBtn95();
                check_max_size_file();
            });

            //ลบไฟล์แนบ
            $('body').on('click', '.attach-remove9', function(event) {
                $(this).parent().parent().remove();
                ShowHideRemoveBtn95();
            });

            ShowHideRemoveBtn95();
        });

        function ShowHideRemoveBtn95() { //ซ่อน-แสดงปุ่มลบ

            if ($('.other_attach_item9').length > 1) {
                $('.attach-remove9').show();
            } else {
                $('.attach-remove9').hide();
            }

        }
    </script>
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
