@push('css')
    <link href="{{asset('plugins/components/bootstrap-datepicker-thai/css/datepicker.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('plugins/components/icheck/skins/all.css')}}" rel="stylesheet">
    <style type="text/css">
        .label-height{
            line-height: 16px;
        }

        .font_size{
            font-size: 10px;
        }

    </style>
@endpush

@php
    $attach_path = 'files/applicants/check_files_cb/';

    if( !isset($certi_cb->id) ){

        $certi_cb = new stdClass;

        $certi_cb->applicanttype_id = $tis_data->applicanttype_id;
        $certi_cb->name = $tis_data->name;
        $certi_cb->tax_number = !empty($tis_data->tax_number) ? $tis_data->tax_number : null;
        
        $certi_cb->hq_address = !empty($tis_data->address_no)? $tis_data->address_no : null;
        $certi_cb->hq_soi = !empty($tis_data->soi)? $tis_data->soi : null;
        $certi_cb->hq_road = !empty($tis_data->street)? $tis_data->street : null;
        $certi_cb->hq_moo = !empty($tis_data->moo)? $tis_data->moo : null;

        $certi_cb->hq_subdistrict_txt = !empty($tis_data->subdistrict)? $tis_data->subdistrict : null;
        $certi_cb->hq_district_txt = !empty($tis_data->district)? $tis_data->district : null;
        $certi_cb->hq_province_txt = !empty($tis_data->province)? $tis_data->province : null;

        $certi_cb->hq_subdistrict_id = !empty($tis_data->subdistrict_id)? $tis_data->subdistrict_id : null;
        $certi_cb->hq_district_id = !empty($tis_data->district_id)? $tis_data->district_id : null;
        $certi_cb->hq_province_id = !empty($tis_data->province_id)? $tis_data->province_id : null;
        $certi_cb->hq_zipcode = !empty($tis_data->zipcode)? $tis_data->zipcode : null;

        $certi_cb->hq_fax = !empty($tis_data->fax)? $tis_data->fax : null;
        $certi_cb->hq_telephone = !empty($tis_data->fax)? $tis_data->tel : null;
        $certi_cb->hq_date_registered = !empty($tis_data->date_niti)? $tis_data->date_niti : null;

        $certi_cb->contactor_name = !empty($tis_data->contact_name)?$tis_data->contact_name:null;
        $certi_cb->email = !empty($tis_data->email)?$tis_data->email:null;
        $certi_cb->contact_tel = !empty($tis_data->contact_tel)?$tis_data->contact_tel:null;
        $certi_cb->telephone = !empty($tis_data->contact_phone_number)?$tis_data->contact_phone_number:null;

        $certi_cb->contactor_name = !empty($tis_data->contact_name)?$tis_data->contact_name:null;
        $certi_cb->email = !empty($tis_data->email)?$tis_data->email:null;
        $certi_cb->contact_tel = !empty($tis_data->contact_tel)?$tis_data->contact_tel:null;
        $certi_cb->telephone = !empty($tis_data->contact_phone_number)?$tis_data->contact_phone_number:null;

        $certi_cb->branch_type = !empty($tis_data->branch_type)?$tis_data->branch_type:null;

    } else{

        $certi_cb->tax_number = !empty($certi_cb->tax_id) ? $certi_cb->tax_id : null;
        $certi_cb->hq_subdistrict_txt = !empty($certi_cb->HqSubdistrictName)? $certi_cb->HqSubdistrictName : null;
        $certi_cb->hq_district_txt = !empty($certi_cb->HqDistrictName)? $certi_cb->HqDistrictName : null;
        $certi_cb->hq_province_txt = !empty($certi_cb->HqProvinceName)? $certi_cb->HqProvinceName : null;

        
    }  
@endphp


{{-- @include ('certify.applicant_cb.doc-review.froms.form_infomation') --}}

{{-- @include ('certify.applicant_cb.doc-review.froms.form_request') --}}

@include ('certify.applicant_cb.doc-review.froms.form_modal_map')

@include ('certify.applicant_cb.doc-review.froms.form_evidence')

@if (isset($certi_cb->id) && !is_null($certi_cb->desc_delete))

<fieldset class="white-box">
    <legend>
        <h4>
            ยกเลิกคำขอ  
        </h4>
    </legend>

    <div class="col-md-12">
        <div class="col-md-4 text-right"> สาเหตุ :</div>
        <div class="col-md-6 text-light">
            <p> {{  !empty($certi_cb->desc_delete)  ? $certi_cb->desc_delete : '-' }}</p>
        </div>
    </div>

    <div class="clearfix"></div>

    @if (isset($certi_cb->id) && $certi_cb->FileAttach5->count() > 0)
        <div class="row">
            @foreach($certi_cb->FileAttach5 as $data)
                @if ($data->file)
                    <div class="col-md-12 form-group">
                        <div class="col-md-4 text-light"> </div>
                        <div class="col-md-6 text-light">
                            {{  @$data->file_desc }}
                            <a href="{{url('certify/check/file_cb_client/'.$data->file.'/'.( !empty($data->file_client_name) ? $data->file_client_name :  basename($data->file)  ))}}" target="_blank">
                                {{  !empty($data->file_client_name) ? $data->file_client_name :  basename($data->file)   }}
                            </a>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    @endif

</fieldset>
@endif



@push('js')
    <script src="{{asset('plugins/components/icheck/icheck.min.js')}}"></script>
    <script src="{{asset('plugins/components/icheck/icheck.init.js')}}"></script>
    <script src="{{asset('js/mask/jquery.inputmask.bundle.min.js')}}"></script>
    <script src="{{asset('plugins/components/sweet-alert2/sweetalert2.all.min.js')}}"></script>
    <script src="{{asset('js/mask/mask.init.js')}}"></script>
    <!-- input calendar thai -->
    <script src="{{ asset('plugins/components/bootstrap-datepicker-thai/js/bootstrap-datepicker.js') }}"></script>
    <!-- thai extension -->
    <script src="{{ asset('plugins/components/bootstrap-datepicker-thai/js/bootstrap-datepicker-thai.js') }}"></script>
    <script src="{{ asset('plugins/components/bootstrap-datepicker-thai/js/locales/bootstrap-datepicker.th.js') }}"></script>

    <script src="{{asset('js/jasny-bootstrap.js')}}"></script>

    <script src="{{asset('plugins/components/repeater/jquery.repeater.min.js')}}"></script>

    <script>
        $(document).ready(function () {

            $('.repeater-form-file').repeater({
                show: function () {
                    $(this).slideDown();
                    box_section1_remove();
                    box_section2_remove();
                    box_section3_remove();
                    box_section4_remove();
                },
                hide: function (deleteElement) {
                    if (confirm('คุณต้องการลบแถวนี้ ?')) {
                        $(this).slideUp(deleteElement);
                       
                        setTimeout(function(){
                            box_section1_remove();
                            box_section2_remove();
                            box_section3_remove();
                            box_section4_remove();

                        }, 400);
                    }
                }
            });
            //ปฎิทิน
            $('.mydatepicker_th').datepicker({
                toggleActive: true,
                language:'th-th',
                format: 'dd/mm/yyyy'
            });

            $('#checkbox_confirm').click(function(){
                $('#send_data').toggleClass('btn-primary btn-default', 'btn-default btn-primary');
                if($(this).prop('checked')){
                    $('#send_data').attr('disabled',false);
                }else{
                    $('#send_data').attr('disabled',true);
                }
            });

            //Validate
            $('#app_certi_form').parsley().on('field:validated', function() {
                var ok = $('.parsley-error').length === 0;
                $('.bs-callout-info').toggleClass('hidden', !ok);
                $('.bs-callout-warning').toggleClass('hidden', ok);
            }).on('form:submit', function() {
                // Text
                $.LoadingOverlay("show", {
                    image       : "",
                    text        : "กำลังบันทึก กรุณารอสักครู่..."
                });
                return true; // Don't submit form for this demo
            });

            box_section1_remove();
            box_section2_remove();
            box_section3_remove();
            box_section4_remove();
            
        });

        function box_section1_remove(){

            if($('.attachs_sec1').length > 1){
                $('button.delete-sec1').show();
            }else{
                $('button.delete-sec1').hide();
            }

        }

        function box_section2_remove(){

            if($('.attachs_sec2').length > 1){
                $('button.delete-sec2').show();
            }else{
                $('button.delete-sec2').hide();
            }

        }

        function box_section3_remove(){

            if($('.attachs_sec3').length > 1){
                $('button.delete-sec3').show();
            }else{
                $('button.delete-sec3').hide();
            }

        }

        function box_section4_remove(){

            if($('.attachs_sec4').length > 1){
                $('button.delete-sec4').show();
            }else{
                $('button.delete-sec4').hide();
            }

        }
        function checkNone(value) {
            return value !== '' && value !== null && value !== undefined;
        }


        function submit_form(status) {
            var  number =  1;
            var max_size = "{{ ini_get('post_max_size') }}";
            var res = max_size.replace("M", "");
            $('#app_certi_form').find('input[type="file"]').each(function(index, el) {
                if(checkNone($(el).val()) && $(el).prop("tagName")=="INPUT" && $(el).prop("type")=="file"   ){
                    number +=  (el.files[0].size /1024/1024);
                }
            });

            Swal.fire({
                title: 'ยืนยันการทำรายงาน !',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'บันทึก',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.value) {
                    if(number < res){
                        $('#status_btn').html('<input type="text" name="status" value="' + status + '" hidden>');
                        $('#app_certi_form').submit();
                    }else{
                        Swal.fire(
                            'ขนาดไฟล์รวม '+number.toFixed(2)+' MB ไม่สามารถบันทึกได้ ต้องไม่เกิน ' + res + ' MB',
                            '',
                            'warning'
                        );
                    }
                          
                }
            });

        }

        //ฉบับร่าง
        function  submit_form_draft(status){
            var number =  1;
            var max_size = "{{ ini_get('post_max_size') }}";
            var res = max_size.replace("M", "");
            $('#app_certi_form').find('input[type="file"]').each(function(index, el) {
                if(checkNone($(el).val()) && $(el).prop("tagName")=="INPUT" && $(el).prop("type")=="file"   ){
                    number +=  (el.files[0].size /1024/1024);
                }
            });

            Swal.fire({
                title: 'ยืนยันการทำรายงาน ฉบับร่าง!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'บันทึก',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.value) {
                    if(number < res){
                        $('#checkbox_confirm').attr('required',false);
                        $('#status_btn').html('<input type="text" name="status" value="' + status + '" hidden>');
                        $('#app_certi_form').submit();
                    }else{
                        Swal.fire(
                            'ขนาดไฟล์รวม '+number.toFixed(2)+' MB ไม่สามารถบันทึกได้ ต้องไม่เกิน ' + res + ' MB',
                            '',
                            'warning'
                        )
                    }
                }
            });
        }
        
        function filterEngAndNumberOnlyCustomForPage(obj){
            var orgi_text     = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ\/,.':;_()-&0123456789 ";
            var str           = $(obj).val();
            var str_length    = str.length;
            var Result = "";
            for(i=0;i<str_length;i++){
                var Char_At = str.charAt(i);
                if(orgi_text.indexOf(Char_At)!==-1){//อักษรเป็นภาษาไทย
                    Result += Char_At;
                }
            }
            $(obj).val(Result);
        }

    </script>
@endpush