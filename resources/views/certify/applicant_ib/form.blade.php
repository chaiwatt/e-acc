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
    $attach_path = 'files/applicants/check_files_ib/';

    if( !isset($certi_ib->id) ){

        $certi_ib = new stdClass;

        $certi_ib->applicanttype_id = $tis_data->applicanttype_id;
        $certi_ib->name = $tis_data->name;
        $certi_ib->tax_number = !empty($tis_data->tax_number) ? $tis_data->tax_number : null;
        
        $certi_ib->hq_address = !empty($tis_data->address_no)? $tis_data->address_no : null;
        $certi_ib->hq_soi = !empty($tis_data->soi)? $tis_data->soi : null;
        $certi_ib->hq_road = !empty($tis_data->street)? $tis_data->street : null;
        $certi_ib->hq_moo = !empty($tis_data->moo)? $tis_data->moo : null;

        $certi_ib->hq_subdistrict_txt = !empty($tis_data->subdistrict)? $tis_data->subdistrict : null;
        $certi_ib->hq_district_txt = !empty($tis_data->district)? $tis_data->district : null;
        $certi_ib->hq_province_txt = !empty($tis_data->province)? $tis_data->province : null;

        $certi_ib->hq_subdistrict_id = !empty($tis_data->subdistrict_id)? $tis_data->subdistrict_id : null;
        $certi_ib->hq_district_id = !empty($tis_data->district_id)? $tis_data->district_id : null;
        $certi_ib->hq_province_id = !empty($tis_data->province_id)? $tis_data->province_id : null;
        $certi_ib->hq_zipcode = !empty($tis_data->zipcode)? $tis_data->zipcode : null;

        $certi_ib->hq_fax = !empty($tis_data->fax)? $tis_data->fax : null;
        $certi_ib->hq_telephone = !empty($tis_data->fax)? $tis_data->tel : null;
        $certi_ib->hq_date_registered = !empty($tis_data->date_niti)? $tis_data->date_niti : null;

        $certi_ib->contactor_name = !empty($tis_data->contact_name)?$tis_data->contact_name:null;
        $certi_ib->email = !empty($tis_data->email)?$tis_data->email:null;
        $certi_ib->contact_tel = !empty($tis_data->contact_tel)?$tis_data->contact_tel:null;
        $certi_ib->telephone = !empty($tis_data->contact_phone_number)?$tis_data->contact_phone_number:null;

        $certi_ib->branch_type = !empty($tis_data->branch_type)?$tis_data->branch_type:null;

    }else{

        $certi_ib->tax_number = !empty($certi_ib->tax_id) ? $certi_ib->tax_id : null;
        $certi_ib->hq_subdistrict_txt = !empty($certi_ib->HqSubdistrictName)? $certi_ib->HqSubdistrictName : null;
        $certi_ib->hq_district_txt = !empty($certi_ib->HqDistrictName)? $certi_ib->HqDistrictName : null;
        $certi_ib->hq_province_txt = !empty($certi_ib->HqProvinceName)? $certi_ib->HqProvinceName : null;

        
    } 
@endphp

<input type="hidden" name="_token" value="{{ csrf_token() }}"/>

@if ($certi_ib == null || empty($certi_ib->doc_review_reject))
    @include ('certify.applicant_ib/froms.infomation')
    @include ('certify.applicant_ib/froms.form_request')
@endif


@include ('certify.applicant_ib/froms.form_modal_map')
@include ('certify.applicant_ib/froms.form_evidence')

@if (isset($certi_ib->id) && !is_null($certi_ib->desc_delete))

<fieldset class="white-box">
    <legend>
        <h4>
            ยกเลิกคำขอ  
        </h4>
    </legend>

    <div class="col-md-12">
        <div class="col-md-4 text-right"> สาเหตุ :</div>
        <div class="col-md-6 text-light">
                <p> {{  !empty($certi_ib->desc_delete)  ? $certi_ib->desc_delete : '-' }}</p>
        </div>
    </div>

    <div class="clearfix"></div>

    @if (isset($certi_ib) && $certi_ib->FileAttach8->count() > 0)
        <div class="row">
            @foreach($certi_ib->FileAttach8 as $data)
            @if ($data->file)
                <div class="col-md-12 form-group">
                    <div class="col-md-4 text-light"> </div>
                    <div class="col-md-6 text-light">
                            {{  @$data->file_desc }}
                            <a href="{{url('certify/check/file_ib_client/'.$data->file.'/'.( !empty($data->file_client_name) ? $data->file_client_name :  basename($data->file)  ))}}" target="_blank">
                                {!! HP::FileExtension($data->file)  ?? '' !!}
                                {{ basename($data->file) }}
                            </a>
                    </div>
                </div>
                @endif
            @endforeach
        </div>
    @endif

</fieldset>
@endif

<center>
    <div class="row form-group">
        <div class="col-md-12">
            <div class="checkbox checkbox-success">
                <input id="checkbox_confirm" class="checkbox_confirm" type="checkbox" name="checkbox_confirm"  required  value="1"  {{ (isset($certi_ib->id) && $certi_ib->checkbox_confirm  == 1) ? 'checked': '' }}>
                <label for="checkbox_confirm"> &nbsp;  หน่วยตรวจขอรับรองว่า (IB hereby affirms certify that)
                    <button type="button" class="btn btn-link" data-toggle="modal" data-target="#myModal"><b>คลิก</b> </button>
                </label>
            </div>
        </div>
    </div>
</center>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog  modal-lg" role="document">
      <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-body">
                <p>
                    (1) ข้าพเจ้ารับทราบและให้คำมั่นจะปฏิบัติตามพระราชบัญญัติการมาตรฐานแห่งชาติ พ.ศ. 2551 รวมถึงกฎกระทรวง ประกาศ หลักเกณฑ์ วิธีการ และเงื่อนไข มาตรฐานข้อกำหนดสำหรับการรับรองระบบงาน ข้อกำหนดอื่น ๆ และ/หรือ ที่จะมีการกำหนด แก้ไขเพิ่มเติมในภายหลังด้วย 
                    <br>
                    I have acknowledged and committed to continually fulfil the requirements for accreditation and the other obligations of the conformity assessment body, and to comply with National Standardization Act, B.E.2551 (2008) including ministerial regulations, notification, criteria methods and conditions according to the act, standard requirement, conditions determined by TISI and/or any changes in future
                </p>
                <p>
                    (2) ข้าพเจ้าจะชำระค่าธรรมเนียมคำขอรับใบรับรองและใบรับรองทันทีที่ได้รับใบแจ้งการชำระเงินจากสำนักงานมาตรฐานผลิตภัณฑ์อุตสาหกรรม 
                    <br>
                    I will pay application fee, and certificate document fee upon receiving the Pay-in Slip from TISI without delays.
                </p>
            </div>
        </div>
    </div>
  </div>


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
                    box_section5_remove();
                    box_section6_remove();
                    box_section7_remove();
                },
                hide: function (deleteElement) {
                    if (confirm('คุณต้องการลบแถวนี้ ?')) {
                        $(this).slideUp(deleteElement);
                       
                        setTimeout(function(){
                            box_section1_remove();
                            box_section2_remove();
                            box_section3_remove();
                            box_section4_remove();
                            box_section5_remove();
                            box_section6_remove();
                            box_section7_remove();

                        }, 400);
                    }
                }
            });

            box_section1_remove();
            box_section2_remove();
            box_section3_remove();
            box_section4_remove();
            box_section5_remove();
            box_section6_remove();
            box_section7_remove();

            $('#checkbox_confirm').click(function(){
                $('#send_data').toggleClass('btn-primary btn-default', 'btn-default btn-primary');
                if($(this).prop('checked')){
                    $('#send_data').attr('disabled',false);
                }else{
                    $('#send_data').attr('disabled',true);
                }
            });

            //Validate
            if($('form').length > 0){
                $('form:first:not(.not_validated)').parsley().on('field:validated', function() {
                var ok = $('.parsley-error').length === 0;
                $('.bs-callout-info').toggleClass('hidden', !ok);
                $('.bs-callout-warning').toggleClass('hidden', ok);
                })
                .on('form:submit', function() {
                    // Text
                    $.LoadingOverlay("show", {
                        image       : "",
                        text        : "กำลังบันทึก กรุณารอสักครู่..."
                    });
                return true; // Don't submit form for this demo
                });
            }
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

        function box_section5_remove(){

            if($('.attachs_sec5').length > 1){
                $('button.delete-sec5').show();
            }else{
                $('button.delete-sec5').hide();
            }

        }

        function box_section6_remove(){

            if($('.attachs_sec6').length > 1){
                $('button.delete-sec6').show();
            }else{
                $('button.delete-sec6').hide();
            }

        }

        function box_section7_remove(){

            if($('.attachs_sec7').length > 1){
                $('button.delete-sec7').show();
            }else{
                $('button.delete-sec7').hide();
            }

        }

        function checkNone(value) {
            return value !== '' && value !== null && value !== undefined;
        }

        // function createTransactionInput()
        // {
        //     const filteredTransactions = transactions.map(transaction => ({
        //         ib_main_category_scope_id: transaction.ib_main_category_scope_id,
        //         ib_sub_category_scope_id: transaction.ib_sub_category_scope_id,
        //         ib_scope_topic_id: transaction.ib_scope_topic_id,
        //         ib_scope_detail_id: transaction.ib_scope_detail_id,
        //         standard: transaction.standard,
        //         standard_en: transaction.standard_en
        //     }));

        //     const transactionsJson = JSON.stringify(filteredTransactions);

        //     // ลบ input เดิมที่มี name="transactions" ถ้ามี
        //     $('#app_certi_form').find('input[name="transactions"]').remove();

        //     // เพิ่ม input hidden สำหรับ transactions
        //     $('#app_certi_form').append(`<input type="hidden" name="transactions" value='${transactionsJson.replace(/'/g, "'")}'>`);

        // }

        function createTransactionInput() {
            const filteredTransactions = transactions.map(transaction => ({
                ib_main_category_scope_id: transaction.ib_main_category_scope_id,
                ib_sub_category_scope_id: transaction.ib_sub_category_scope_id,
                ib_scope_topic_id: transaction.ib_scope_topic_id,
                ib_scope_detail_id: transaction.ib_scope_detail_id,
                standard: transaction.standard,
                standard_en: transaction.standard_en
            }));

            const transactionsJson = JSON.stringify(filteredTransactions);

            // ตรวจสอบว่ามีรายการใน transactionsJson หรือไม่
            if (filteredTransactions.length === 0) {
                alert("ไม่มีรายการขอบข่ายโปรดเพิ่มข้อมูลก่อนดำเนินการ");
                return false; // คืนค่า false เพื่อบอกว่าไม่สำเร็จ
            }

            // ลบ input เดิมที่มี name="transactions" ถ้ามี
            $('#app_certi_form').find('input[name="transactions"]').remove();

            // เพิ่ม input hidden สำหรับ transactions
            $('#app_certi_form').append(`<input type="hidden" name="transactions" value='${transactionsJson.replace(/'/g, "'")}'>`);
            
            return true; // คืนค่า true เพื่อบอกว่าสำเร็จ
        }

        function submit_form(status) {
            // console.log(transactions)

            // createTransactionInput()
            if (!createTransactionInput()) {
                return; // ออกถ้า createTransactionInput คืนค่า false
            }

            // return;
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
                                )
                    }
                          
                }
            });

        }

        //ฉบับร่าง
        function  submit_form_draft(status){
            if (!createTransactionInput()) {
                return; // ออกถ้า createTransactionInput คืนค่า false
            }
            var  number =  1;
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

        function  CheckFile(){
            $('.check_max_size_file').bind('change', function() {
                var size =   this.files[0].size/1024/1024 ; // หน่วย MB
                if(size > 4){
                    Swal.fire(
                            'ขนาดไฟล์เกินกว่า 4 GB',
                            '',
                            'info'
                            )
                    this.value = '';
                    return false;
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