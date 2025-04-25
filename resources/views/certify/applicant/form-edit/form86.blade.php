<div class="m-l-10 form-group {{ $errors->has('man_applicant') ? 'has-error' : ''}}">
    <h4 class="m-l-5">1.ข้อมูลทั่วไป</h4>
    <label for="man_applicant" class="col-md-12" style="padding-top: 7px;margin-bottom: 5px;font-size: 16px">1.ผู้ยื่นคำขอ</label>
    <div class="col-md-6 ">
        <select name="man_applicant" id="man_applicant" class="form-control pull-left" required>
            <option value="" selected>- ผู้ยื่นคำขอ -</option>
            <option value="1">เป็นนิติบุคคล</option>
            <option value="2">เป็นนิติบุคคลที่มีกิจกรรมอื่นนอกเหนือจากกิจกรรม ทดสอบ/สอบเทียบ</option>
            <option value="3">เป็นหน่วยงานของรัฐ</option>
            <option value="4">เป็นรัฐวิสาหกิจ</option>
            <option value="5">เป็นสถาบันการศึกษา</option>
            <option value="6">เป็นสถาบันวิชาชีพ</option>
            <option value="7">อื่นๆ</option>
        </select>
        {!! $errors->first('man_applicant', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div id="extra_value_two" style="display: none;">
    <div class="m-l-15 form-group {{ $errors->has('at_1_1_1') ? 'has-error' : ''}}">
        <label for="at_1_1_1" class="col-md-12" style="padding-top: 7px;margin-bottom: 5px">(1) มีกิจกรรมที่นอกเหนือจากกิจกรรมทดสอบ/สอบเทียบ เป็นกิจกรรมหลัก</label>
        <div class="col-md-12 m-t-5 m-l-15">
            @if ($certi_lab_info->lab_type_other == 1)
                <label>{!! Form::radio('at_1_1_1', '0', true, ['class'=>'check', 'data-radio'=>'iradio_square-green']) !!} &nbsp;มี &nbsp;</label>
                <label>{!! Form::radio('at_1_1_1', '1', false, ['class'=>'check', 'data-radio'=>'iradio_square-red']) !!} &nbsp;ไม่มี &nbsp;</label>
            @elseif ($certi_lab_info->lab_type_other === 0)
                <label>{!! Form::radio('at_1_1_1', '0', false, ['class'=>'check', 'data-radio'=>'iradio_square-green']) !!} &nbsp;มี &nbsp;</label>
                <label>{!! Form::radio('at_1_1_1', '1', true, ['class'=>'check', 'data-radio'=>'iradio_square-red']) !!} &nbsp;ไม่มี &nbsp;</label>
            @else
                <label>{!! Form::radio('at_1_1_1', '0', false, ['class'=>'check', 'data-radio'=>'iradio_square-green']) !!} &nbsp;มี &nbsp;</label>
                <label>{!! Form::radio('at_1_1_1', '1', false, ['class'=>'check', 'data-radio'=>'iradio_square-red']) !!} &nbsp;ไม่มี &nbsp;</label>
            @endif
            {!! $errors->first('at_1_1_1', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    <div class="m-l-15 form-group {{ $errors->has('activity_file') ? 'has-error' : ''}}">
        <label for="activity_file" class="col-md-12" style="padding-top: 7px;margin-bottom: 13px">(2) อธิบายรายละเอียดกิจกรรมหลัก (โปรดแนบเอกสาร)</label>
        <div class="col-md-6">
            <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                <div class="form-control" data-trigger="fileinput">
                    <i class="glyphicon glyphicon-file fileinput-exists"></i>
                    <span class="fileinput-filename"></span>
                </div>
                <span class="input-group-addon btn btn-default btn-file">
                    <span class="fileinput-new">เลือกไฟล์</span>
                    <span class="fileinput-exists">เปลี่ยน</span>
                    @if ($certi_lab_info->desc_main_file)
                        <input type="file" name="activity_file" id="activity_file" onchange="alert('คุณกำลังเปลี่ยนไฟล์')">
                    @else
                        {!! Form::file('activity_file', null) !!}
                    @endif
                </span>
                <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
            </div>
            @if ($certi_lab_info->desc_main_file)
                <small class="text-danger">* อัพโหลดไฟล์ใหม่ หากต้องการเปลี่ยนไฟล์</small>
                <div style="margin-top: 1.1rem;margin-left: 0.5rem;">
                    <a href="{{url('check/files/'.basename($certi_lab_info->desc_main_file))}}" target="_blank">
                        <i class="fa fa-file-pdf-o" style="font-size:25px; color:red" aria-hidden="true"></i>
                        {{basename($certi_lab_info->desc_main_file)}}
                    </a>
                </div>
                @else
                    <span class="badge badge-danger" style="padding: 8px">ยังไม่มีไฟล์</span>
            @endif
            {!! $errors->first('activity_file', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    <div class="m-l-15 form-group {{ $errors->has('at_1_1_3') ? 'has-error' : ''}}">
        <label for="at_1_1_3" class="col-md-12" style="padding-top: 7px;margin-bottom: 5px">(3) ทดสอบ/สอบเทียบให้หน่วยงานของตนเองเท่านั้น</label>
        <div class="col-md-12 m-t-5 m-l-15">
            @if ($certi_lab_info->only_own_depart == 1)
                <label>{!! Form::radio('at_1_1_3', '0', true, ['class'=>'check', 'data-radio'=>'iradio_square-green']) !!} &nbsp;ใช่ &nbsp;</label>
                <label>{!! Form::radio('at_1_1_3', '1', false, ['class'=>'check', 'data-radio'=>'iradio_square-red']) !!} &nbsp;ไม่ใช่ &nbsp;</label>
            @elseif($certi_lab_info->only_own_depart === 0)
                <label>{!! Form::radio('at_1_1_3', '0', false, ['class'=>'check', 'data-radio'=>'iradio_square-green']) !!} &nbsp;ใช่ &nbsp;</label>
                <label>{!! Form::radio('at_1_1_3', '1', true, ['class'=>'check', 'data-radio'=>'iradio_square-red']) !!} &nbsp;ไม่ใช่ &nbsp;</label>
            @else
                <label>{!! Form::radio('at_1_1_3', '0', false, ['class'=>'check', 'data-radio'=>'iradio_square-green']) !!} &nbsp;ใช่ &nbsp;</label>
                <label>{!! Form::radio('at_1_1_3', '1', false, ['class'=>'check', 'data-radio'=>'iradio_square-red']) !!} &nbsp;ไม่ใช่ &nbsp;</label>
            @endif
            {!! $errors->first('at_1_1_3', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    <div class="m-l-15 form-group {{ $errors->has('at_1_1_4') ? 'has-error' : ''}}">
        <label for="at_1_1_4" class="col-md-12" style="padding-top: 7px;margin-bottom: 5px">(4) ทดสอบ/สอบเทียบให้หน่วยงานอื่นด้วย</label>
        <div class="col-md-12 m-t-5 m-l-15">
            @if ($certi_lab_info->depart_other == 1)
                <label>{!! Form::radio('at_1_1_4', '0', true, ['class'=>'check', 'data-radio'=>'iradio_square-green']) !!} &nbsp;ใช่ &nbsp;</label>
                <label>{!! Form::radio('at_1_1_4', '1', false, ['class'=>'check', 'data-radio'=>'iradio_square-red']) !!} &nbsp;ไม่ใช่ &nbsp;</label>
            @elseif ($certi_lab_info->depart_other === 0)
                <label>{!! Form::radio('at_1_1_4', '0', false, ['class'=>'check', 'data-radio'=>'iradio_square-green']) !!} &nbsp;ใช่ &nbsp;</label>
                <label>{!! Form::radio('at_1_1_4', '1', true, ['class'=>'check', 'data-radio'=>'iradio_square-red']) !!} &nbsp;ไม่ใช่ &nbsp;</label>
            @else
                <label>{!! Form::radio('at_1_1_4', '0', false, ['class'=>'check', 'data-radio'=>'iradio_square-green']) !!} &nbsp;ใช่ &nbsp;</label>
                <label>{!! Form::radio('at_1_1_4', '1', false, ['class'=>'check', 'data-radio'=>'iradio_square-red']) !!} &nbsp;ไม่ใช่ &nbsp;</label>
            @endif
            {!! $errors->first('at_1_1_4', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
</div>



<div id="extra_value_other" style="display: none;">
    <div class="m-l-15 form-group {{ $errors->has('at_1_1_5') ? 'has-error' : ''}}">
        <div class="col-md-12 m-l-15">
            @if ($certi_lab_info->over_twenty === 0)
                <label>{!! Form::checkbox('at_1_1_5', '0', true, ['class'=>'check', 'data-radio'=>'iradio_square-green']) !!} &nbsp;อายุไม่ต่ำกว่า 20 ปี &nbsp;</label>
            @else
                <label>{!! Form::checkbox('at_1_1_5', '0', false, ['class'=>'check', 'data-radio'=>'iradio_square-green']) !!} &nbsp;อายุไม่ต่ำกว่า 20 ปี &nbsp;</label>
            @endif
            {!! $errors->first('at_1_1_5', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    <div class="m-l-15 form-group {{ $errors->has('at_1_1_6') ? 'has-error' : ''}}">
        <div class="col-md-12 m-l-15">
            @if ($certi_lab_info->not_bankrupt === 0)
                <label>{!! Form::checkbox('at_1_1_6', '0', true, ['class'=>'check', 'data-radio'=>'iradio_square-green']) !!} &nbsp;ไม่เป็นบุคคลล้มละลาย &nbsp;</label>
            @else
                <label>{!! Form::checkbox('at_1_1_6', '0', false, ['class'=>'check', 'data-radio'=>'iradio_square-green']) !!} &nbsp;ไม่เป็นบุคคลล้มละลาย &nbsp;</label>
            @endif
            {!! $errors->first('at_1_1_6', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    <div class="m-l-15 form-group {{ $errors->has('at_1_1_7') ? 'has-error' : ''}}">
        <div class="col-md-12 m-l-15">
            @if ($certi_lab_info->not_being_incompetent === 0)
                <label>{!! Form::checkbox('at_1_1_7', '0', true, ['class'=>'check', 'data-radio'=>'iradio_square-green']) !!} &nbsp;ไม่เป็นคนไร้ความสามารถหรือคนเสมือนไร้ความสามารถ &nbsp;</label>
            @else
                <label>{!! Form::checkbox('at_1_1_7', '0', false, ['class'=>'check', 'data-radio'=>'iradio_square-green']) !!} &nbsp;ไม่เป็นคนไร้ความสามารถหรือคนเสมือนไร้ความสามารถ &nbsp;</label>
            @endif
            {!! $errors->first('at_1_1_7', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    <div class="m-l-15 form-group {{ $errors->has('at_1_1_8') ? 'has-error' : ''}}">
        <div class="col-md-12 m-l-15">
            @if ($certi_lab_info->suspended_using_a_certificate === 0)
                <label>{!! Form::checkbox('at_1_1_8', '0', true, ['class'=>'check', 'data-radio'=>'iradio_square-green']) !!} &nbsp;ไม่เป็นผู้อยู่ในระหว่างถูกสั่งพักใช้ใบรับรอง &nbsp;</label>
            @else
                <label>{!! Form::checkbox('at_1_1_8', '0', false, ['class'=>'check', 'data-radio'=>'iradio_square-green']) !!} &nbsp;ไม่เป็นผู้อยู่ในระหว่างถูกสั่งพักใช้ใบรับรอง &nbsp;</label>
            @endif
            {!! $errors->first('at_1_1_8', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    <div class="m-l-15 form-group {{ $errors->has('at_1_1_9') ? 'has-error' : ''}}">
        <div class="col-md-12 m-l-15">
            @if ($certi_lab_info->never_revoke_a_certificate === 0)
                <label>{!! Form::checkbox('at_1_1_9', '0', true, ['class'=>'check', 'data-radio'=>'iradio_square-green']) !!} &nbsp;ไม่เคยถูกเพิกถอนใบรับรองหรือเคยถูกเพิกถอนใบรับรอง แต่เวลาได้ล่วงพ้นมาแล้วไม่น้อยกว่า 6 เดือน &nbsp;</label>
            @else
                <label>{!! Form::checkbox('at_1_1_9', '0', false, ['class'=>'check', 'data-radio'=>'iradio_square-green']) !!} &nbsp;ไม่เคยถูกเพิกถอนใบรับรองหรือเคยถูกเพิกถอนใบรับรอง แต่เวลาได้ล่วงพ้นมาแล้วไม่น้อยกว่า 6 เดือน &nbsp;</label>
            @endif
            {!! $errors->first('at_1_1_9', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
</div>


@push('js')

    <script>
        $(document).ready(function () {
            $('#man_applicant').val({!! $certi_lab_info->petitioner !!}).change();
        })
    </script>
    <script>
        $('#man_applicant').on('change',function () {
            if ($(this).val() === "2"){
                $('#extra_value_two').fadeIn();
                $('#extra_value_other').fadeOut();
            }
            else if ($(this).val() === "7") {
                $('#extra_value_other').fadeIn();
                $('#extra_value_two').fadeOut();
            }
            else {
                $('#extra_value_two').fadeOut();
                $('#extra_value_other').fadeOut();
            }
        })
    </script>
@endpush