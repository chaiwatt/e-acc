

<div class="row form-group">
    <div class="col-md-12">
        <div class="white-box" style="border: 2px solid #e5ebec;">
            <legend><h4>1. ข้อมูลทั่วไป (General information)</h4></legend>

<div class="m-l-10 form-group {{ $errors->has('man_applicant') ? 'has-error' : ''}}">
    <label for="man_applicant" class="col-md-12" style="padding-top: 7px;margin-bottom: 5px;font-size: 16px"><span class="text-danger">*</span> ผู้ยื่นคำขอ (Qualifications of Applicant)</label>
    <div class="col-md-6 ">
        <select name="man_applicant" id="man_applicant" class="form-control pull-left" required>
            <option value="" selected>- ผู้ยื่นคำขอ -</option>
            <option value="1">เป็นนิติบุคคล (A legal Entity)</option>
            <option value="2">เป็นนิติบุคคลที่มีกิจกรรมอื่นนอกเหนือจากกิจกรรม ทดสอบ/สอบเทียบ (A legal entity having other types of business apart from testing / calibration)</option>
            <option value="3">เป็นหน่วยงานของรัฐ (A Government Agency)</option>
            <option value="4">เป็นรัฐวิสาหกิจ (A State Enterprise)</option>
            <option value="5">เป็นสถาบันการศึกษา (An Academic Institution)</option>
            <option value="6">เป็นสถาบันวิชาชีพ (A Professional Institution)</option>
            <option value="7">อื่นๆ (Others)</option>
        </select>
        {!! $errors->first('man_applicant', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div id="extra_value_two" style="display: none;">
    <div class="m-l-15 form-group {{ $errors->has('at_1_1_1') ? 'has-error' : ''}}">
        <label for="at_1_1_1" class="col-md-12" style="padding-top: 7px;margin-bottom: 5px">(1) มีกิจกรรมที่นอกเหนือจากกิจกรรมทดสอบ/สอบเทียบ เป็นกิจกรรมหลัก (major type of business apart from testing / calibration)</label>
        <div class="col-md-12 m-t-5 m-l-15">
            <label>{!! Form::radio('at_1_1_1', '0', false, ['class'=>'check', 'data-radio'=>'iradio_square-green']) !!} &nbsp;มี &nbsp;</label>
            <label>{!! Form::radio('at_1_1_1', '1', false, ['class'=>'check', 'data-radio'=>'iradio_square-red']) !!} &nbsp;ไม่มี &nbsp;</label>
            {!! $errors->first('at_1_1_1', '<p class="help-block">:message</p>') !!}
        </div>
        {{--    <div class="col-md-4"></div>--}}
    </div>
    <div class="m-l-15 form-group {{ $errors->has('activity_file') ? 'has-error' : ''}}">
        <label for="activity_file" class="col-md-12" style="padding-top: 7px;margin-bottom: 13px">(2) อธิบายรายละเอียดกิจกรรมหลัก  (please specify major type of business)</label>
        <div class="col-md-6">
            <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                <div class="form-control" data-trigger="fileinput">
                    <i class="glyphicon glyphicon-file fileinput-exists"></i>
                    <span class="fileinput-filename"></span>
                </div>
                <span class="input-group-addon btn btn-default btn-file">
                     <span class="fileinput-new">เลือกไฟล์</span> 
                     <span class="fileinput-exists">เปลี่ยน</span>
                     {{-- {!! Form::file('activity_file', null) !!} --}}
                     <input type="file" name="activity_file" class="  check_max_size_file" >
                 </span>
                <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
            </div>
            {!! $errors->first('activity_file', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    <div class="m-l-15 form-group {{ $errors->has('at_1_1_3') ? 'has-error' : ''}}">
        <label for="at_1_1_3" class="col-md-12" style="padding-top: 7px;margin-bottom: 5px">(3) ทดสอบ/สอบเทียบให้หน่วยงานของตนเองเท่านั้น (Testing / Calibration services are restricted to own use )</label>
        <div class="col-md-12 m-t-5 m-l-15">
            <label>{!! Form::radio('at_1_1_3', '0', false, ['class'=>'check', 'data-radio'=>'iradio_square-green']) !!} &nbsp;ใช่ &nbsp;</label>
            <label>{!! Form::radio('at_1_1_3', '1', false, ['class'=>'check', 'data-radio'=>'iradio_square-red']) !!} &nbsp;ไม่ใช่ &nbsp;</label>
            {!! $errors->first('at_1_1_3', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    <div class="m-l-15 form-group {{ $errors->has('at_1_1_4') ? 'has-error' : ''}}">
        <label for="at_1_1_4" class="col-md-12" style="padding-top: 7px;margin-bottom: 5px">(4) ทดสอบ/สอบเทียบให้หน่วยงานอื่นด้วย (Testing / Calibration services are open for public)</label>
        <div class="col-md-12 m-t-5 m-l-15">
            <label>{!! Form::radio('at_1_1_4', '0', false, ['class'=>'check', 'data-radio'=>'iradio_square-green']) !!} &nbsp;ใช่ &nbsp;</label>
            <label>{!! Form::radio('at_1_1_4', '1', false, ['class'=>'check', 'data-radio'=>'iradio_square-red']) !!} &nbsp;ไม่ใช่ &nbsp;</label>
            {!! $errors->first('at_1_1_4', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
</div>

<div id="extra_value_three" style="display: none;">
    <div class="m-l-15 form-group {{ $errors->has('file_section') ? 'has-error' : ''}}">
        {{-- <label for="activity_file" class="col-md-12" style="padding-top: 7px;margin-bottom: 13px"></label> --}}
        <div class="col-md-6">
            <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                <div class="form-control" data-trigger="fileinput">
                    <i class="glyphicon glyphicon-file fileinput-exists"></i>
                    <span class="fileinput-filename"></span>
                </div>
                <span class="input-group-addon btn btn-default btn-file">
                    <span class="fileinput-new">เลือกไฟล์</span>
                    <span class="fileinput-exists">เปลี่ยน</span>
                    <input type="file" name="file_section" accept=".doc,.docx" class="file_section check_max_size_file" >
                    </span>
                <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
            </div>
            {!! $errors->first('file_section', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
</div>

<div id="extra_value_other" style="display: none;">
    <div class="m-l-15 form-group {{ $errors->has('at_1_1_5') ? 'has-error' : ''}}">
        <div class="col-md-12 m-l-15">
            <label>{!! Form::checkbox('at_1_1_5', '0', false, ['class'=>'check','data-checkbox'=>"icheckbox_flat-red"]) !!} &nbsp;มีอายุไม่ต่ำกว่ายี่สิบปีบริบูรณ์ (being not less than twenty years of age) &nbsp;</label>
            {!! $errors->first('at_1_1_5', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    <div class="m-l-15 form-group {{ $errors->has('at_1_1_6') ? 'has-error' : ''}}">
        <div class="col-md-12 m-l-15">
            <label>{!! Form::checkbox('at_1_1_6', '0', false, ['class'=>'check', 'data-checkbox'=>"icheckbox_flat-red"]) !!} &nbsp;ไม่เป็นบุคคลล้มละลาย (not being bankrupt) &nbsp;</label>
            {!! $errors->first('at_1_1_6', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    <div class="m-l-15 form-group {{ $errors->has('at_1_1_7') ? 'has-error' : ''}}">
        <div class="col-md-12 m-l-15">
            <label>{!! Form::checkbox('at_1_1_7', '0', false, ['class'=>'check','data-checkbox'=>"icheckbox_flat-red"]) !!} &nbsp;ไม่เป็นคนไร้ความสามารถหรือคนเสมือนไร้ความสามารถ (not being an incompetent or quasi-incompetent person) &nbsp;</label>
            {!! $errors->first('at_1_1_7', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    <div class="m-l-15 form-group {{ $errors->has('at_1_1_8') ? 'has-error' : ''}}">
        <div class="col-md-12 m-l-15">
            <label>{!! Form::checkbox('at_1_1_8', '0', false, ['class'=>'check','data-checkbox'=>"icheckbox_flat-red"]) !!}&nbsp;ไม่เป็นผู้อยู่ในระหว่างถูกสั่งพักใช้ใบรับรอง (not being a person whose Certificate is suspended) &nbsp;</label>
            {!! $errors->first('at_1_1_8', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    <div class="m-l-15 form-group {{ $errors->has('at_1_1_9') ? 'has-error' : ''}}">
        <div class="col-md-12 m-l-15">
            <label>{!! Form::checkbox('at_1_1_9', '0', false, ['class'=>'check','data-checkbox'=>"icheckbox_flat-red"]) !!}&nbsp;ไม่เคยถูกเพิกถอนใบรับรองหรือเคยถูกเพิกถอนใบรับรอง แต่เวลาได้ล่วงพ้นมาแล้วไม่น้อยกว่า 6 เดือน (not being subjected to Certificate withdrawal or in case of having been subjected to Certificate withdrawal, not less than six month shall have elapsed since the date of Certificate withdrawal)&nbsp;</label>
            {!! $errors->first('at_1_1_9', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
</div>



        </div>
    </div>
</div>


@push('js')
    <script>
        $('#man_applicant').on('change',function () {
            if ($(this).val() === "2"){
                $('#extra_value_two').fadeIn();
                $('#extra_value_other').fadeOut();
                $('#extra_value_three').fadeOut();
            }
            else if ($(this).val() === "3") {
                $('#extra_value_three').fadeIn();
                $('#extra_value_two').fadeOut();
                $('#extra_value_other').fadeOut();
            }
            else if ($(this).val() === "7") {
                $('#extra_value_other').fadeIn();
                $('#extra_value_two').fadeOut();
                $('#extra_value_three').fadeOut();
            }
            else {
                $('#extra_value_two').fadeOut();
                $('#extra_value_other').fadeOut();
                $('#extra_value_three').fadeOut();
            }
        }) 
    </script>
    <script>
  $(document).ready(function () {
          file_section();
   });
//  Attach File
function  file_section(){
    $('.file_section').change( function () {
            var fileExtension = ['docx','doc'];
            if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
                Swal.fire(
                'ไม่ใช่หลักฐานประเภทไฟล์ที่อนุญาต .doc หรือ .docx',
                '',
                'info'
                )
            this.value = '';
            return false;
            }
        }); 
}
</script>
@endpush