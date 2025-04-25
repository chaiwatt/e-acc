

<div class="row form-group">
    <div class="col-md-12">
        <div class="white-box" style="border: 2px solid #e5ebec;">
            <legend><h4>1. ข้อมูลทั่วไป (General information)</h4></legend>
<div class="m-l-10 form-group {{ $errors->has('petitioner') ? 'has-error' : ''}}">
    <label for="man_applicant" class="col-md-12" style="padding-top: 7px;margin-bottom: 5px;font-size: 16px"><span class="text-danger">*</span> ผู้ยื่นคำขอ (Qualifications of Applicant)</label>
    <div class="col-md-6 ">
        {!! Form::select('certi_lab_info[petitioner]',
        ['1'=>'เป็นนิติบุคคล (A legal Entity)',
         '2'=>'เป็นนิติบุคคลที่มีกิจกรรมอื่นนอกเหนือจากกิจกรรม ทดสอบ/สอบเทียบ (A legal entity having other types of business apart from testing / calibration)',
         '3'=>'เป็นหน่วยงานของรัฐ (A Government Agency)',
         '4'=>'เป็นรัฐวิสาหกิจ (A State Enterprise)',
         '5'=>'เป็นสถาบันการศึกษา (An Academic Institution)',
         '6'=>'เป็นสถาบันวิชาชีพ (A Professional Institution)',
         '7'=>'อื่นๆ (Others)'],
         !empty($certi_lab_info->petitioner) ? $certi_lab_info->petitioner :null, 
         ['class' => 'form-control',
          'id'=>'petitioner',
          'required'=> true,
         'placeholder' =>'- ผู้ยื่นคำขอ -']) !!}
        {!! $errors->first('petitioner', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div id="extra_value_two" style="display: none;">
    <div class="m-l-15 form-group {{ $errors->has('lab_type_other') ? 'has-error' : ''}}">
        <label for="at_1_1_1" class="col-md-12" style="padding-top: 7px;margin-bottom: 5px">(1) มีกิจกรรมที่นอกเหนือจากกิจกรรมทดสอบ/สอบเทียบ เป็นกิจกรรมหลัก (major type of business apart from testing / calibration)</label>
        <div class="col-md-12 m-t-5 m-l-15">
            <label>{!! Form::radio('certi_lab_info[lab_type_other]', '0', !empty($certi_lab_info->lab_type_other=='0') ? true :false, ['class'=>'check', 'data-radio'=>'iradio_square-green']) !!} &nbsp;มี &nbsp;</label>
            <label>{!! Form::radio('certi_lab_info[lab_type_other]', '1', !empty($certi_lab_info->lab_type_other=='1') ? true :false, ['class'=>'check', 'data-radio'=>'iradio_square-red']) !!} &nbsp;ไม่มี &nbsp;</label>
            {!! $errors->first('certi_lab_info[lab_type_other]', '<p class="help-block">:message</p>') !!}
        </div>
        {{--    <div class="col-md-4"></div>--}}
    </div>
    <div class="m-l-15 form-group {{ $errors->has('activity_file') ? 'has-error' : ''}}">
        <label for="activity_file" class="col-md-12" style="padding-top: 7px;margin-bottom: 13px">(2) อธิบายรายละเอียดกิจกรรมหลัก  (please specify major type of business)</label>
        <div class="col-md-6">
            @if ($certi_lab_info->desc_main_file)
                {{-- <small class="text-danger">* อัพโหลดไฟล์ใหม่ หากต้องการเปลี่ยนไฟล์</small> --}}
                <div style="margin-top: 1.1rem;margin-left: 0.5rem;">
                     <a href="{{url('certify/check/file_client/'.$certi_lab_info->desc_main_file.'/'.( !is_null($certi_lab_info->activity_client_name) ? $certi_lab_info->activity_client_name : basename($certi_lab_info->desc_main_file) ))}}" target="_blank">
                        {!! HP::FileExtension($certi_lab_info->desc_main_file)  ?? '' !!}
                        {{basename($certi_lab_info->desc_main_file)}}
                    </a>
                    <a href="{{url('certify/applicant/delete/certi_lab_info').'/'.basename($certi_lab_info->id).'/'.$certi_lab->token}}" 
                    class="btn btn-danger btn-xs {{ ($certi_lab->status >= 1) ? 'hide' : ''  }}" 
                        onclick="return confirm('ต้องการลบไฟล์นี้ใช่หรือไม่ ?')" >
                        <i class="fa fa-remove"></i>
                    </a>
                </div>
            @else
                <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                    <div class="form-control" data-trigger="fileinput">
                        <i class="glyphicon glyphicon-file fileinput-exists"></i>
                        <span class="fileinput-filename"></span>
                    </div>
                    <span class="input-group-addon btn btn-default btn-file">
                        <span class="fileinput-new">เลือกไฟล์</span>
                        <span class="fileinput-exists">เปลี่ยน</span>
                            <input type="file" name="activity_file" id="activity_file">
                    </span>
                    <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
                </div>
            @endif
            {!! $errors->first('activity_file', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    <div class="m-l-15 form-group {{ $errors->has('[only_own_depart]') ? 'has-error' : ''}}">
        <label for="at_1_1_3" class="col-md-12" style="padding-top: 7px;margin-bottom: 5px">(3) ทดสอบ/สอบเทียบให้หน่วยงานของตนเองเท่านั้น (Testing / Calibration services are restricted to own use )</label>
        <div class="col-md-12 m-t-5 m-l-15">
            <label>{!! Form::radio('certi_lab_info[only_own_depart]', '0', !empty($certi_lab_info->only_own_depart=='0') ? true :false, ['class'=>'check', 'data-radio'=>'iradio_square-green']) !!} &nbsp;ใช่ &nbsp;</label>
            <label>{!! Form::radio('certi_lab_info[only_own_depart]', '1', !empty($certi_lab_info->only_own_depart=='1') ? true :false, ['class'=>'check', 'data-radio'=>'iradio_square-red']) !!} &nbsp;ไม่ใช่ &nbsp;</label>
            {!! $errors->first('certi_lab_info[only_own_depart]', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    <div class="m-l-15 form-group {{ $errors->has('certi_lab_info[depart_other]') ? 'has-error' : ''}}">
        <label for="at_1_1_4" class="col-md-12" style="padding-top: 7px;margin-bottom: 5px">(4) ทดสอบ/สอบเทียบให้หน่วยงานอื่นด้วย (Testing / Calibration services are open for public)</label>
        <div class="col-md-12 m-t-5 m-l-15">
            <label>{!! Form::radio('certi_lab_info[depart_other]', '0', !empty($certi_lab_info->depart_other=='0') ? true :false, ['class'=>'check', 'data-radio'=>'iradio_square-green']) !!} &nbsp;ใช่ &nbsp;</label>
            <label>{!! Form::radio('certi_lab_info[depart_other]', '1', !empty($certi_lab_info->depart_other=='1') ? true :false, ['class'=>'check', 'data-radio'=>'iradio_square-red']) !!} &nbsp;ไม่ใช่ &nbsp;</label>
            {!! $errors->first('certi_lab_info[depart_other]', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
</div>

<div id="extra_value_three" style="display: none;">
    <div class="m-l-15 form-group {{ $errors->has('file_section') ? 'has-error' : ''}}">
        {{-- <label for="activity_file" class="col-md-12" style="padding-top: 7px;margin-bottom: 13px"></label> --}}
        <div class="col-md-6">
        
            @if(!is_null($certi_lab_info->file_section)) 
              <a href="{{url('certify/check/file_client/'.$certi_lab_info->file_section.'/'.( !is_null($certi_lab_info->file_client_name) ? $certi_lab_info->file_client_name : basename($certi_lab_info->file_section) ))}}" target="_blank">
                    {!! HP::FileExtension($certi_lab_info->file_section)  ?? '' !!}
                    {{ basename($certi_lab_info->file_section) }}
              </a>
            @else 
              <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                <div class="form-control" data-trigger="fileinput">
                    <i class="glyphicon glyphicon-file fileinput-exists"></i>
                    <span class="fileinput-filename"></span>
                </div>
                <span class="input-group-addon btn btn-default btn-file">
                    <span class="fileinput-new">เลือกไฟล์</span>
                    <span class="fileinput-exists">เปลี่ยน</span>
                    <input type="file" name="file_section" accept=".doc,.docx" class="file_section" >
                    </span>
                <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
            </div>
            @endif
            {!! $errors->first('file_section', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
</div>

<div id="extra_value_other" style="display: none;">
    <div class="m-l-15 form-group {{ $errors->has('[over_twenty]') ? 'has-error' : ''}}">
        <div class="col-md-12 m-l-15">
            <label>{!! Form::checkbox('certi_lab_info[over_twenty]', '0', !empty($certi_lab_info->over_twenty=='0') ? true :false, ['class'=>'check','data-checkbox'=>"icheckbox_flat-red"]) !!} &nbsp;มีอายุไม่ต่ำกว่ายี่สิบปีบริบูรณ์ (being not less than twenty years of age) &nbsp;</label>
            {!! $errors->first('certi_lab_info[over_twenty]', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    <div class="m-l-15 form-group {{ $errors->has('certi_lab_info[not_bankrupt]') ? 'has-error' : ''}}">
        <div class="col-md-12 m-l-15">
            <label>{!! Form::checkbox('certi_lab_info[not_bankrupt]', '0', !empty($certi_lab_info->not_bankrupt=='0') ? true :false, ['class'=>'check','data-checkbox'=>"icheckbox_flat-red"]) !!}  &nbsp;ไม่เป็นบุคคลล้มละลาย (not being bankrupt) &nbsp; </label>
            {!! $errors->first('certi_lab_info[not_bankrupt]', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    <div class="m-l-15 form-group {{ $errors->has('[not_being_incompetent]') ? 'has-error' : ''}}">
        <div class="col-md-12 m-l-15">
            <label>{!! Form::checkbox('[not_being_incompetent]', '0', !empty($certi_lab_info->not_being_incompetent=='0') ? true :false, ['class'=>'check','data-checkbox'=>"icheckbox_flat-red"]) !!} &nbsp;ไม่เป็นคนไร้ความสามารถหรือคนเสมือนไร้ความสามารถ (not being an incompetent or quasi-incompetent person) &nbsp; </label>
            {!! $errors->first('[not_being_incompetent]', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    <div class="m-l-15 form-group {{ $errors->has('certi_lab_info[suspended_using_a_certificate]') ? 'has-error' : ''}}">
        <div class="col-md-12 m-l-15">
            <label>{!! Form::checkbox('certi_lab_info[suspended_using_a_certificate]', '0', !empty($certi_lab_info->suspended_using_a_certificate=='0') ? true :false, ['class'=>'check','data-checkbox'=>"icheckbox_flat-red"]) !!} &nbsp;ไม่เป็นผู้อยู่ในระหว่างถูกสั่งพักใช้ใบรับรอง (not being a person whose Certificate is suspended) &nbsp;</label>
            {!! $errors->first('certi_lab_info[suspended_using_a_certificate]', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    <div class="m-l-15 form-group {{ $errors->has('certi_lab_info[never_revoke_a_certificate]') ? 'has-error' : ''}}">
        <div class="col-md-12 m-l-15">
            <label>{!! Form::checkbox('certi_lab_info[never_revoke_a_certificate]', '0', !empty($certi_lab_info->never_revoke_a_certificate=='0') ? true :false, ['class'=>'check','data-checkbox'=>"icheckbox_flat-red"]) !!} &nbsp;ไม่เคยถูกเพิกถอนใบรับรองหรือเคยถูกเพิกถอนใบรับรอง แต่เวลาได้ล่วงพ้นมาแล้วไม่น้อยกว่า 6 เดือน (not being subjected to Certificate withdrawal or in case of having been subjected to Certificate withdrawal, not less than six month shall have elapsed since the date of Certificate withdrawal)&nbsp;</label>
            {!! $errors->first('certi_lab_info[never_revoke_a_certificate]', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
</div>

        </div>
    </div>
</div>


@push('js')
     <script src="{{asset('js/jasny-bootstrap.js')}}"></script> 
    <script>
        $('#petitioner').on('change',function () {
            if ($(this).val() === "2"){
                $('#extra_value_two').fadeIn();
                $('#activity_file').prop('required',true);
                $('#extra_value_other').fadeOut();
                $('#extra_value_three').fadeOut();
            }
            else if ($(this).val() === "3") {
                $('#extra_value_three').fadeIn();
                $('#activity_file').prop('required',false);
                $('#extra_value_two').fadeOut();
                $('#extra_value_other').fadeOut();
            }
            else if ($(this).val() === "7") {
                $('#extra_value_other').fadeIn();
                $('#activity_file').prop('required',false);
                $('#extra_value_two').fadeOut();
                $('#extra_value_three').fadeOut();
            }
            else {
                $('#extra_value_two').fadeOut();
                $('#activity_file').prop('required',false);
                $('#extra_value_other').fadeOut();
                $('#extra_value_three').fadeOut();
            }
        })
        $('#petitioner').change();
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