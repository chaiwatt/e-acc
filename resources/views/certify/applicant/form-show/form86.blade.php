<div class="m-l-10 form-group {{ $errors->has('man_applicant') ? 'has-error' : ''}}">
    <h4 class="m-l-5">1.ข้อมูลทั่วไป</h4>
    <label for="man_applicant" class="col-md-12" style="padding-top: 7px;margin-bottom: 5px;font-size: 16px">1.ผู้ยื่นคำขอ : {{ $certi_lab_info->petitioner_name }}</label>
</div>

@if ($certi_lab_info->petitioner == 2)
    <div id="extra_value_two">
        <div class="m-l-15 form-group {{ $errors->has('at_1_1_1') ? 'has-error' : ''}}">
            <label for="at_1_1_1" class="col-md-12" style="padding-top: 7px;margin-bottom: 5px">(1) มีกิจกรรมที่นอกเหนือจากกิจกรรมทดสอบ/สอบเทียบ เป็นกิจกรรมหลัก</label>
            <div class="col-md-12 m-t-5 m-l-15">
                @if ($certi_lab_info->lab_type_other == 0)
                    <label><input type="radio" class="check" data-radio="iradio_square-green" disabled> &nbsp;มี &nbsp;</label>
                    <label><input type="radio" class="check" data-radio="iradio_square-red" disabled checked> &nbsp;ไม่มี &nbsp;</label>
                @elseif ($certi_lab_info->lab_type_other == 1)
                    <label><input type="radio" class="check" data-radio="iradio_square-green" disabled checked> &nbsp;มี &nbsp;</label>
                    <label><input type="radio" class="check" data-radio="iradio_square-red" disabled > &nbsp;ไม่มี &nbsp;</label>
                @endif
            </div>
            {{--    <div class="col-md-4"></div>--}}
        </div>
        <div class="m-l-15 form-group">
            <label for="activity_file" class="col-md-12" style="padding-top: 7px;margin-bottom: 13px">(2) อธิบายรายละเอียดกิจกรรมหลัก (โปรดแนบเอกสาร)</label>
            <div class="col-md-6">
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
            </div>
        </div>

        <div class="m-l-15 form-group {{ $errors->has('at_1_1_3') ? 'has-error' : ''}}">
            <label for="at_1_1_3" class="col-md-12" style="padding-top: 7px;margin-bottom: 5px">(3) ทดสอบ/สอบเทียบให้หน่วยงานของตนเองเท่านั้น</label>
            <div class="col-md-12 m-t-5 m-l-15">
                @if ($certi_lab_info->only_own_depart == 0)
                    <label><input type="radio" class="check" data-radio="iradio_square-green" disabled> &nbsp;มี &nbsp;</label>
                    <label><input type="radio" class="check" data-radio="iradio_square-red" disabled checked> &nbsp;ไม่มี &nbsp;</label>
                @elseif ($certi_lab_info->only_own_depart == 1)
                    <label><input type="radio" class="check" data-radio="iradio_square-green" disabled checked> &nbsp;มี &nbsp;</label>
                    <label><input type="radio" class="check" data-radio="iradio_square-red" disabled > &nbsp;ไม่มี &nbsp;</label>
                @endif
            </div>
        </div>

        <div class="m-l-15 form-group {{ $errors->has('at_1_1_4') ? 'has-error' : ''}}">
            <label for="at_1_1_4" class="col-md-12" style="padding-top: 7px;margin-bottom: 5px">(4) ทดสอบ/สอบเทียบให้หน่วยงานอื่นด้วย</label>
            <div class="col-md-12 m-t-5 m-l-15">
                @if ($certi_lab_info->depart_other == 0)
                    <label><input type="radio" class="check" data-radio="iradio_square-green" disabled> &nbsp;มี &nbsp;</label>
                    <label><input type="radio" class="check" data-radio="iradio_square-red" disabled checked> &nbsp;ไม่มี &nbsp;</label>
                @elseif ($certi_lab_info->depart_other == 1)
                    <label><input type="radio" class="check" data-radio="iradio_square-green" disabled checked> &nbsp;มี &nbsp;</label>
                    <label><input type="radio" class="check" data-radio="iradio_square-red" disabled > &nbsp;ไม่มี &nbsp;</label>
                @endif
            </div>
        </div>
    </div>

@endif


@if ($certi_lab_info->petitioner == 7)
    <div id="extra_value_other" >
        @if ($certi_lab_info->over_twenty === 0 )
        <div class="m-l-15 form-group {{ $errors->has('at_1_1_5') ? 'has-error' : ''}}">
            <div class="col-md-12 m-l-15">
                <label><input type="checkbox" id="address_same_headquarter" name="address_same_headquarter" disabled="" checked> &nbsp;อายุไม่ต่ำกว่า 20 ปี &nbsp;</label>
            </div>
        </div>
        @endif

        @if ($certi_lab_info->not_bankrupt === 0 )
        <div class="m-l-15 form-group {{ $errors->has('at_1_1_6') ? 'has-error' : ''}}">
            <div class="col-md-12 m-l-15">
                <label><input type="checkbox" id="address_same_headquarter" name="address_same_headquarter" disabled="" checked> &nbsp;ไม่เป็นบุคคลล้มละลาย &nbsp;</label>
            </div>
        </div>
        @endif

        @if ($certi_lab_info->not_being_incompetent === 0 )
        <div class="m-l-15 form-group {{ $errors->has('at_1_1_7') ? 'has-error' : ''}}">
            <div class="col-md-12 m-l-15">
                <label><input type="checkbox" id="address_same_headquarter" name="address_same_headquarter" disabled="" checked> &nbsp;ไม่เป็นคนไร้ความสามารถหรือคนเสมือนไร้ความสามารถ &nbsp;</label>
            </div>
        </div>
        @endif

        @if ($certi_lab_info->suspended_using_a_certificate === 0 )
        <div class="m-l-15 form-group {{ $errors->has('at_1_1_8') ? 'has-error' : ''}}">
            <div class="col-md-12 m-l-15">
                <label><input type="checkbox" id="address_same_headquarter" name="address_same_headquarter" disabled="" checked> &nbsp;ไม่เป็นผู้อยู่ในระหว่างถูกสั่งพักใช้ใบรับรอง &nbsp;</label>
            </div>
        </div>
        @endif

        @if ($certi_lab_info->never_revoke_a_certificate === 0 )
        <div class="m-l-15 form-group {{ $errors->has('at_1_1_9') ? 'has-error' : ''}}">
            <div class="col-md-12 m-l-15">
                <label><input type="checkbox" id="address_same_headquarter" name="address_same_headquarter" disabled="" checked> &nbsp;ไม่เคยถูกเพิกถอนใบรับรองหรือเคยถูกเพิกถอนใบรับรอง แต่เวลาได้ล่วงพ้นมาแล้วไม่น้อยกว่า 6 เดือน &nbsp;</label>
            </div>
        </div>
        @endif
    </div>
@endif


@push('js')
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