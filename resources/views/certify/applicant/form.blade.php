{{-- work on Certify\ApplicantController --}}
@push('css')
    <link href="{{asset('plugins/components/bootstrap-datepicker-thai/css/datepicker.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('plugins/components/icheck/skins/all.css')}}" rel="stylesheet">
    <link href="{{asset('plugins/components/summernote/summernote.css')}}" rel="stylesheet" type="text/css" />
 

    <style type="text/css">
        .input_background_color{
            background-color: rgb(232, 253, 246);
        }
        .input-show[disabled]{
            background-color: #FFFFFF;
        }

        .label-height{
            line-height: 16px;
        }

        .font_size{
            font-size: 10px;
        }

        .modal-xl {
            width: 80%; /* กำหนดความกว้างตามที่คุณต้องการ */
            max-width: none; /* ยกเลิกค่า max-width เริ่มต้น */
        }
        .modal-xxl {
            width: 90%; /* กำหนดความกว้างตามที่คุณต้องการ */
            max-width: none; /* ยกเลิกค่า max-width เริ่มต้น */
        }

    </style>
@endpush


@php
    $attach_path = 'files/applicants/check_files/';

    if( !isset($certi_lab->id) ){

        $certi_lab = new stdClass;

        $certi_lab->applicanttype_id = $tis_data->applicanttype_id;
        $certi_lab->app_name = $tis_data->name;
        $certi_lab->tax_number = !empty($tis_data->tax_number) ? $tis_data->tax_number : null;

        $certi_lab->hq_subdistrict_id = !empty($tis_data->subdistrict_id)? $tis_data->subdistrict_id : null;
        $certi_lab->hq_district_id = !empty($tis_data->district_id)? $tis_data->district_id : null;
        $certi_lab->hq_province_id = !empty($tis_data->province_id)? $tis_data->province_id : null;

        $certi_lab->address_headquarters = !empty($tis_data->address_no)? $tis_data->address_no : null;
        $certi_lab->headquarters_alley = !empty($tis_data->soi)? $tis_data->soi : null;
        $certi_lab->headquarters_road = !empty($tis_data->street)? $tis_data->street : null;
        $certi_lab->headquarters_village_no = !empty($tis_data->moo)? $tis_data->moo : null;

        $certi_lab->headquarters_district = !empty($tis_data->subdistrict)? $tis_data->subdistrict : null;
        $certi_lab->headquarters_amphur = !empty($tis_data->district)? $tis_data->district : null;
        $certi_lab->headquarters_province = !empty($tis_data->province)? $tis_data->province : null;
        $certi_lab->headquarters_postcode = !empty($tis_data->zipcode)? $tis_data->zipcode : null;

        $certi_lab->headquarters_tel_fax = !empty($tis_data->fax)? $tis_data->fax : null;
        $certi_lab->headquarters_tel = !empty($tis_data->tel)? $tis_data->tel : null;
        $certi_lab->registerDate = !empty($tis_data->date_niti)? $tis_data->date_niti : null;

        $certi_lab->contactor_name = !empty($tis_data->contact_name)?$tis_data->contact_name:null;
        $certi_lab->email = !empty($tis_data->email)?$tis_data->email:null;
        $certi_lab->contact_tel = !empty($tis_data->contact_tel)?$tis_data->contact_tel:null; // โทรศัพท์ผู้ติดต่อ
        $certi_lab->telephone = !empty($tis_data->contact_phone_number)?$tis_data->contact_phone_number:null; // โทรศัพท์มือถือ

    }else{

        // $certi_information = App\Models\Certify\Applicant\Information::where('app_certi_lab_id',$certi_lab->id)->first();

        $certi_lab->app_name   = !empty($certi_lab->name)? $certi_lab->name : null;
        $certi_lab->tax_number = !empty($certi_lab->tax_id)? $certi_lab->tax_id : null;

        $certi_lab->address_headquarters    = !empty($certi_lab->hq_address)?$certi_lab->hq_address:null;
        $certi_lab->headquarters_alley      = !empty($certi_lab->hq_soi)?$certi_lab->hq_soi:null;
        $certi_lab->headquarters_road       = !empty($certi_lab->hq_road)?$certi_lab->hq_road:null;
        $certi_lab->headquarters_village_no = !empty($certi_lab->hq_moo)?$certi_lab->hq_moo:null;

        $certi_lab->headquarters_district = !empty($certi_lab->HqSubdistrictName)?$certi_lab->HqSubdistrictName:null;
        $certi_lab->headquarters_amphur   = !empty($certi_lab->HqDistrictName)?$certi_lab->HqDistrictName:null;
        $certi_lab->headquarters_province = !empty($certi_lab->HqProvinceName)?$certi_lab->HqProvinceName:null;
        $certi_lab->headquarters_postcode = !empty($certi_lab->hq_zipcode)?$certi_lab->hq_zipcode:null;
        
        $certi_lab->headquarters_tel_fax = !empty($certi_lab->hq_fax)?$certi_lab->hq_fax:null;
        $certi_lab->headquarters_tel     = !empty($certi_lab->hq_telephone)?$certi_lab->hq_telephone:null;
        $certi_lab->registerDate         = !empty($certi_lab->hq_date_registered)?$certi_lab->hq_date_registered:null;

    }   

    

@endphp

@php
    function checkUrl() {
        $currentUrl = url()->current();

        // ตรวจสอบว่า URL มี applicant/create หรือไม่
        if (strpos($currentUrl, 'applicant/create') !== false) {
            return 'create';
        }

        // ตรวจสอบว่า URL มี applicant/edit หรือไม่
        if (strpos($currentUrl, 'applicant/edit') !== false) {
            return 'edit';
        }

        // ตรวจสอบว่า URL มี applicant/show หรือไม่
        if (strpos($currentUrl, 'applicant/show') !== false) {
            return 'show';
        }

        // ถ้าไม่ตรงทั้ง "create", "edit" และ "show"
        return null;
    }

    $urlType = checkUrl();
@endphp
<div style="display: none;">
    @include('certify.applicant.forms.form_infomation')
</div>
@include ('certify.applicant.forms.form_request')
@include ('certify.applicant.forms.form_model')
@include ('certify.applicant.forms.form_evidence')

@if( isset($certi_lab->desc_delete) && isset($certi_lab->id) && !is_null($certi_lab->desc_delete))

<fieldset class="white-box">
    <legend>
        <h4>
            ยกเลิกคำขอ  
        </h4>
    </legend>

    <div class="col-md-12">
        <div class="col-md-4 text-right"> สาเหตุ :</div>
        <div class="col-md-6 text-light">
            <p> {{  !empty($certi_lab->desc_delete)  ? $certi_lab->desc_delete : '-' }}</p>
        </div>
    </div>

    <div class="clearfix"></div>

    @if (isset($certi_lab->id) && $CertiLabDeleteFile->count() > 0)
        <div class="row">
            @foreach($CertiLabDeleteFile as $data)
                @if ($data->path)
                    <div class="col-md-12 form-group">
                        <div class="col-md-4 text-light"> </div>
                        <div class="col-md-6 text-light">
                            {{ @$data->name }}
                            <a href="{{url('certify/check/files/'.$data->path)}}" target="_blank">
                                {!! HP::FileExtension($data->path)  ?? '' !!}
                                    {{ basename($data->path) }}
                            </a>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    @endif

</fieldset>

@endif

{{-- <center> --}}
    <div class="row form-group">
        <div class="col-md-12">
            <div class="checkbox checkbox-success">
                <input id="checkbox_confirm" class="checkbox_confirm" type="checkbox" name="checkbox_confirm"  required value="1" 
                    {{ (isset($certi_lab->id) && $certi_lab->checkbox_confirm  == 1) ? 'checked': '' }}
                >
                <label for="checkbox_confirm"> &nbsp; ห้องปฏิบัติการทดสอบและสอบเทียบขอรับรองว่า (LAB hereby affirms certify that)
                    <button type="button" class="btn btn-link" data-toggle="modal" data-target="#myModal"><b>คลิก</b> </button>
                </label>
            </div>
        </div>
    </div>
{{-- </center> --}}


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

<script>
    let labCalRequest
    let labTestRequest
    let labRequestMain 
    let labRequestBranchs 
    let labRequestType = "test"
    let mainLabScopeTransaction 
    let branchLabScopeTransactions
    let mainLabTypes
    let branchLabScopeTransactions


    let mainLabScopeTransaction;
    let branchLabScopeTransactions ;

    // แปลงโครงสร้างของ lab_types


    $(document).ready(function () {
 
        // ตัวแปร labCalRequest และ labTestRequest ที่ได้รับค่าจาก PHP
        let labCalRequest = @json($labCalRequest ?? []);
        let labTestRequest = @json($labTestRequest ?? []);
    

         transformedMainLabTypes = transformLabTypes(mainLabScopeTransaction.lab_types);
         transformedBranchLabTypesArray = branchLabScopeTransactions.map(branch => transformLabTypes(branch.lab_types));

        // alert('dddd');
        // ตรวจสอบความยาวของ labTestRequest
        // console.log('Lab Test Request Length 777777:', labTestRequest.length);

        // หาก labTestRequest ว่าง หรือไม่มีค่า ใช้ labCalRequest แทน
        if (labTestRequest.length > 0) {
            labRequestType = "test"
            console.log('LabTestRequest มีข้อมูล:', labTestRequest);
            labRequestMain = labTestRequest.filter(request => request.type === "1")[0];
            labRequestBranchs = labTestRequest.filter(request => request.type === "2");
        } else if (labCalRequest.length > 0) {
            labRequestType = "cal"
            console.log('LabCalRequest มีข้อมูล:', labCalRequest);
            labRequestMain = labCalRequest.filter(request => request.type === "1")[0];
            labRequestBranchs = labCalRequest.filter(request => request.type === "2");
        } 

    });
</script>


    <script src="{{asset('plugins/components/icheck/icheck.min.js')}}"></script>
    <script src="{{asset('plugins/components/icheck/icheck.init.js')}}"></script>
    <script src="{{asset('js/mask/jquery.inputmask.bundle.min.js')}}"></script>
    <script src="{{asset('js/mask/mask.init.js')}}"></script>
    <!-- input calendar thai -->
    <script src="{{ asset('plugins/components/bootstrap-datepicker-thai/js/bootstrap-datepicker.js') }}"></script>
    <!-- thai extension -->
    <script src="{{ asset('plugins/components/bootstrap-datepicker-thai/js/bootstrap-datepicker-thai.js') }}"></script>
    <script src="{{ asset('plugins/components/bootstrap-datepicker-thai/js/locales/bootstrap-datepicker.th.js') }}"></script>

    <script src="{{ asset('plugins/components/summernote/summernote.js') }}"></script>
    <script src="{{ asset('plugins/components/summernote/summernote-ext-specialchars.js') }}"></script>

    <script src="{{asset('plugins/components/repeater/jquery.repeater.min.js')}}"></script>

    <script src="{{asset('js/jasny-bootstrap.js')}}"></script>


    <script>
       let transformedMainLabTypes ;
       let transformedBranchLabTypesArray ;
        $(document).ready(function () {

            mainLabScopeTransaction = @json($mainLabScopeTransaction ?? []);
            branchLabScopeTransactions = @json($branchLabScopeTransactions ?? []);

            console.log('mainLabScopeTransaction ===> ',mainLabScopeTransaction);

            // alert('111');
            $('.mydatepicker_th').datepicker({
                toggleActive: true,
                language:'th-th',
                format: 'dd/mm/yyyy'
            });
            $('.check-readonly').prop('disabled', true);//checkbox ความคิดเห็น
            $('.check-readonly').parent().removeClass('disabled');
            $('.check-readonly').css({"background-color": "rgb(238, 238, 238);","border-radius":"50%", "cursor": "not-allowed"});

        
            $('#checkbox_confirm').click(function(){
                button_save();
            });button_save();

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

            $('.repeater-form-file').repeater({
                show: function () {
                    $(this).slideDown();
                    box_section4_remove();
                    box_section5_remove();
                    
                    box_section61_remove();
                    box_section62_remove();

                    box_section71_remove();
                    box_section72_remove();
                    box_section8_remove();
                    box_section9_remove();
                    box_section10_remove();
                    box_more_remove();
                },
                hide: function (deleteElement) {
                    if (confirm('คุณต้องการลบแถวนี้ ?')) {
                        $(this).slideUp(deleteElement);
                       
                        setTimeout(function(){

                            box_section4_remove();
                            box_section5_remove();
                            
                            box_section61_remove();
                            box_section62_remove();

                            box_section71_remove();
                            box_section72_remove();

                            box_section8_remove();
                            box_section9_remove();
                            box_section10_remove();
                            box_more_remove();

                        }, 400);
                    }
                }
            });

            box_section4_remove();
            box_section5_remove();
            box_section71_remove();
            box_section72_remove();

            box_section61_remove();
            box_section62_remove();

            box_section8_remove();
            box_section9_remove();
            box_section10_remove();
            box_more_remove();

        });

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

        function box_section71_remove(){

            if($('.attachs_sec71').length > 1){
                $('button.delete-sec71').show();
            }else{
                $('button.delete-sec71').hide();
            }

        }

        function box_section72_remove(){

            if($('.attachs_sec72').length > 1){
                $('button.delete-sec72').show();
            }else{
                $('button.delete-sec72').hide();
            }

        }

        function box_section61_remove(){

            if($('.attachs_sec61').length > 1){
                $('button.delete-sec61').show();
            }else{
                $('button.delete-sec61').hide();
            }

        }

        function box_section62_remove(){

            if($('.attachs_sec62').length > 1){
                $('button.delete-sec62').show();
            }else{
                $('button.delete-sec62').hide();
            }

        }

        function box_section8_remove(){

            if($('.attachs_sec8').length > 1){
                $('button.delete-sec8').show();
            }else{
                $('button.delete-sec8').hide();
            }

        }

        function box_section9_remove(){

            if($('.attachs_sec9').length > 1){
                $('button.delete-sec9').show();
            }else{
                $('button.delete-sec9').hide();
            }

        }

           function box_section10_remove(){

            if($('.attachs_sec10').length > 1){
                $('button.delete-sec10').show();
            }else{
                $('button.delete-sec10').hide();
            }

        }

        function box_more_remove(){

            if($('.another_attach_files').length > 1){
                $('button.delete-more').show();
            }else{
                $('button.delete-more').hide();
            }

        }

        function checkNone(value) {
            return value !== '' && value !== null && value !== undefined;
        }

        function  CheckFile(){
            $('.check_file').bind('change', function() {
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


        // $('#app_certi_form').on('submit', function(event) {
        //     console.log('Form is being submitted...');
        // });

        // function submit_form(status) {


        //     let purpose = $('input[name="purpose"]:checked').val();

        //     console.log(purpose);
        //     return;

        //     // return
        //     if(validateAddressesAndMainScope() == false){
        //         alert('รูปแบบขอบข่ายไม่ถูกต้อง โปรดแก้ไข');
        //         return
        //     }
        //     var lab_addresses_array = JSON.stringify(JSON.parse(sessionStorage.getItem('lab_addresses_array')) || []);
        //     var lab_main_address = JSON.stringify(JSON.parse(sessionStorage.getItem('lab_main_address')) || { lab_types: {} });

        //     // ใส่ค่าสตริง JSON ลงใน input fields แบบซ่อน
        //     $('#lab_addresses_input').val(lab_addresses_array);
        //     $('#lab_main_address_input').val(lab_main_address);


        //     var  number =  1;
        //     var max_size = "{{ ini_get('post_max_size') }}";
        //     var res = max_size.replace("M", "");
        //     $('#app_certi_form').find('input[type="file"]').each(function(index, el) {
        //         if(checkNone($(el).val()) && $(el).prop("tagName")=="INPUT" && $(el).prop("type")=="file"   ){
        //             number +=  (el.files[0].size /1024/1024);
        //         }
        //     });

        //     var row = $("input[name=lab_ability]:checked").val();
        //     if(row == 'test'){ // ห้องปฏิบัติการ (ทดสอบ)
        //         var test_scope_branch_id = $(".test_scope_branch_id").length;
        //         if(test_scope_branch_id > 0){
        //                 if(number < res){
        //                     $('div#status_btn').html('<input type="text" name="save" value="' + status + '" hidden>');
        //                     setTimeout(function () {
        //                         $('#app_certi_form').submit();
        //                     }, 500);
        //                 }else{
        //                     Swal.fire(
        //                         'ขนาดไฟล์รวม '+number.toFixed(2)+' MB ไม่สามารถบันทึกได้ ต้องไม่เกิน ' + res + ' MB',
        //                         '',
        //                         'warning'
        //                     )
        //                 }
        //         }else{
        //             Swal.fire(
        //                 'กรุณาเลือก ขอบข่ายที่ยื่นขอรับการรับรองห้องปฏิบัติการ (ทดสอบ)',
        //                 '',
        //                 'info'
        //             )
        //         }
        //     }else{  //ห้องปฏิบัติการ (สอบเทียบ)
            
        //         var calibrate_branch_id = $(".calibrate_branch_id").length;
                
        //         if(calibrate_branch_id > 0){
        //             console.log('submit สอบเทียบ ' + calibrate_branch_id);
        //             console.log('number ' + number);
        //             console.log('res ' + res);
        //             if(number < res){
        //                     $('div#status_btn').html('<input type="text" name="save" value="' + status + '" hidden>');
        //                     setTimeout(function () {
        //                         $('#app_certi_form').submit();
        //                     }, 500);
        //                 }else{
        //                     Swal.fire(
        //                         'ขนาดไฟล์รวม '+number.toFixed(2)+' MB ไม่สามารถบันทึกได้ ต้องไม่เกิน ' + res + ' MB',
        //                         '',
        //                         'warning'
        //                     )
        //                 }
        //         }else{
        //             Swal.fire(
        //                 'กรุณาเลือก ขอบข่ายที่ยื่นขอรับการรับรองห้องปฏิบัติการ (สอบเทียบ)',
        //                 '',
        //                 'info'
        //             )
        //         }
        //     }
        //     }

        function getUniqueCalMainBranches(lab_addresses_json, lab_main_address_json) {
            var resultArray = [];

            // กำหนด keys สำหรับ lab_types
            var keys = ['pl_2_1_info', 'pl_2_2_info', 'pl_2_3_info', 'pl_2_4_info', 'pl_2_5_info'];

            // ฟังก์ชันสำหรับดึง cal_main_branch.id จากสาขา
            function extractCalBranches(jsonData, keysArray) {
                jsonData.forEach(function(address) {
                    if (address.lab_types) {
                        keysArray.forEach(function(keyId) {
                            if (Array.isArray(address.lab_types[keyId]) && address.lab_types[keyId].length > 0) {
                                address.lab_types[keyId].forEach(function(item) {
                                    if (item.cal_main_branch && item.cal_main_branch.id) {
                                        resultArray.push(item.cal_main_branch.id);
                                    }
                                });
                            }
                        });
                    }
                });
            }

            // ฟังก์ชันสำหรับดึง cal_main_branch.id จากสำนักงานใหญ่
            function extractCalMain(jsonData, keysArray) {
                if (jsonData.lab_types) {
                    keysArray.forEach(function(keyId) {
                        if (Array.isArray(jsonData.lab_types[keyId]) && jsonData.lab_types[keyId].length > 0) {
                            jsonData.lab_types[keyId].forEach(function(item) {
                                if (item.cal_main_branch && item.cal_main_branch.id) {
                                    resultArray.push(item.cal_main_branch.id);
                                }
                            });
                        }
                    });
                }
            }

            // เรียกใช้งานทั้งสองฟังก์ชัน
            extractCalBranches(lab_addresses_json, keys);
            extractCalMain(lab_main_address_json, keys);

            // กำจัดค่าซ้ำและแปลงเป็น integer
            resultArray = Array.from(new Set(resultArray)).map(function(value) {
                return parseInt(value, 10);
            });

            return resultArray;
        }

        function getUniqueTestMainBranches(lab_addresses_json, lab_main_address_json) {
            var resultArray = [];

            // กำหนด keys สำหรับ lab_types
            var keys = ['pl_2_1_info', 'pl_2_2_info', 'pl_2_3_info', 'pl_2_4_info', 'pl_2_5_info'];

            // ฟังก์ชันสำหรับดึง test_main_branch.id จากสาขา
            function extractTestBranches(jsonData, keysArray) {
                jsonData.forEach(function(address) {
                    if (address.lab_types) {
                        keysArray.forEach(function(keyId) {
                            if (Array.isArray(address.lab_types[keyId]) && address.lab_types[keyId].length > 0) {
                                address.lab_types[keyId].forEach(function(item) {
                                    if (item.test_main_branch && item.test_main_branch.id) {
                                        resultArray.push(item.test_main_branch.id);
                                    }
                                });
                            }
                        });
                    }
                });
            }

            // ฟังก์ชันสำหรับดึง test_main_branch.id จากสำนักงานใหญ่
            function extractTestMain(jsonData, keysArray) {
                if (jsonData.lab_types) {
                    keysArray.forEach(function(keyId) {
                        if (Array.isArray(jsonData.lab_types[keyId]) && jsonData.lab_types[keyId].length > 0) {
                            jsonData.lab_types[keyId].forEach(function(item) {
                                if (item.test_main_branch && item.test_main_branch.id) {
                                    resultArray.push(item.test_main_branch.id);
                                }
                            });
                        }
                    });
                }
            }

            // เรียกใช้งานทั้งสองฟังก์ชัน
            extractTestBranches(lab_addresses_json, keys);
            extractTestMain(lab_main_address_json, keys);

            // กำจัดค่าซ้ำและแปลงเป็น integer
            resultArray = Array.from(new Set(resultArray)).map(function(value) {
                return parseInt(value, 10);
            });

            return resultArray;
        }
     
        // function getUniqueCalMainBranches(lab_addresses_json, lab_main_address_json) {
        //     var resultArray = [];

        //     // สร้าง array ของ branch IDs และ main facilities
        //     var branches = ['pl_2_1_branch', 'pl_2_2_branch', 'pl_2_3_branch', 'pl_2_4_branch', 'pl_2_5_branch'];
        //     var main_facilities = ['pl_2_1_main', 'pl_2_2_main', 'pl_2_3_main', 'pl_2_4_main', 'pl_2_5_main'];

        //     // ฟังก์ชันที่ใช้ในการวน loop และดึงค่า cal_main_branch
        //     function extractCalBranches(jsonData, keysArray) {
        //         jsonData.forEach(function(address) {
        //             if (address.lab_types) {
        //                 keysArray.forEach(function(keyId) {
        //                     if (Array.isArray(address.lab_types[keyId]) && address.lab_types[keyId].length > 0) {
        //                         address.lab_types[keyId].forEach(function(item) {
        //                             // ตรวจสอบว่า item มี category และดึงค่าของ category
        //                             if (item.category) {
        //                                 resultArray.push(item.category);
        //                             }
        //                         });
        //                     }
        //                 });
        //             }
        //         });
        //     }


        //     function extractCalMain(jsonData, keysArray) {
        //         if (jsonData.lab_types) {
        //             keysArray.forEach(function(keyId) {
        //                 if (Array.isArray(jsonData.lab_types[keyId]) && jsonData.lab_types[keyId].length > 0) {
        //                     jsonData.lab_types[keyId].forEach(function(item) {
        //                         // ตรวจสอบว่า item มี category และดึงค่าของ category
        //                         if (item.category) {
        //                             resultArray.push(item.category);
        //                         }
        //                     });
        //                 }
        //             });
        //         }
        //     }


        //     extractCalBranches(lab_addresses_json, branches);
        //     extractCalMain(lab_main_address_json, main_facilities);

        //     resultArray = Array.from(new Set(resultArray)).map(function(value) {
        //         return parseInt(value, 10);
        //     });


        //     return resultArray;
        // }

        function renderHiddenInputs(uniqueCalMainBranches) {
            // ล้างค่าใน <div id="unique-cal-main-branche"> ก่อน
            $('#unique-cal-main-branche').empty();

            // วนลูปสร้าง <input type="hidden"> สำหรับแต่ละค่าใน uniqueCalMainBranches
            uniqueCalMainBranches.forEach(function(value) {
                // สร้าง input element
                var input = $('<input>').attr({
                    type: 'hidden',
                    name: 'uniqueCalMainBranches[branch_id][]',
                    value: value
                });

                // เพิ่ม input ลงใน <div id="unique-cal-main-branche">
                $('#unique-cal-main-branche').append(input);
            });
        }



        function validateLabData() {
            // ตรวจสอบ main_lab_info
            const mainLabInfo = JSON.parse(sessionStorage.getItem('main_lab_info')) || {
                lab_types: {
                    pl_2_1_info: [],
                    pl_2_2_info: [],
                    pl_2_3_info: [],
                    pl_2_4_info: [],
                    pl_2_5_info: []
                }
            };
            const mainLabTypes = mainLabInfo.lab_types || {
                pl_2_1_info: [],
                pl_2_2_info: [],
                pl_2_3_info: [],
                pl_2_4_info: [],
                pl_2_5_info: []
            };

            // ตรวจสอบว่า main_lab_info มี labtype อย่างน้อย 1 รายการที่ไม่ว่าง
            let hasMainLabType = false;
            for (let i = 1; i <= 5; i++) {
                const key = `pl_2_${i}_info`;
                if (Array.isArray(mainLabTypes[key]) && mainLabTypes[key].length > 0) {
                    hasMainLabType = true;
                    break;
                }
            }

            // if (!hasMainLabType) {
            //     alert('กรุณาเพิ่มข้อมูล labtype อย่างน้อย 1 รายการสำหรับสำนักงานใหญ่');
            //     return false;
            // }

            // ตรวจสอบ branch_lab_infos
            const branchData = JSON.parse(sessionStorage.getItem('branch_lab_infos')) || [];

            // ถ้ามีสาขา ตรวจสอบว่าแต่ละสาขามี labtype อย่างน้อย 1 รายการ
            if (branchData.length > 0) {
                for (let branchIndex = 0; branchIndex < branchData.length; branchIndex++) {
                    const branch = branchData[branchIndex];
                    const branchLabTypes = branch.lab_types || {
                        pl_2_1_info: [],
                        pl_2_2_info: [],
                        pl_2_3_info: [],
                        pl_2_4_info: [],
                        pl_2_5_info: []
                    };

                    let hasBranchLabType = false;
                    for (let i = 1; i <= 5; i++) {
                        const key = `pl_2_${i}_info`;
                        if (Array.isArray(branchLabTypes[key]) && branchLabTypes[key].length > 0) {
                            hasBranchLabType = true;
                            break;
                        }
                    }

                    if (!hasBranchLabType) {
                        const branchName = branch.address_city_text_add || `สาขาที่ ${branchIndex + 1}`;
                        alert(`กรุณาเพิ่มข้อมูล labtype อย่างน้อย 1 รายการสำหรับ${branchName}`);
                        return false;
                    }
                }
            }

            // ถ้าผ่านทุกเงื่อนไข
            return true;
        }

        // function transformLabTypes(labTypes) {
        //     const transformed = {
        //         pl_2_1_info: [],
        //         pl_2_2_info: [],
        //         pl_2_3_info: [],
        //         pl_2_4_info: [],
        //         pl_2_5_info: []
        //     };

        //     for (let i = 1; i <= 5; i++) {
        //         const key = `pl_2_${i}_info`;
        //         if (Array.isArray(labTypes[key])) {
        //             transformed[key] = labTypes[key].map(item => ({
        //                 cal_main_branch_id: item.cal_main_branch?.id || null,
        //                 cal_main_branch_text: item.cal_main_branch?.text || '',
        //                 cal_instrumentgroup_id: item.cal_instrumentgroup?.id || null,
        //                 cal_instrumentgroup_text: item.cal_instrumentgroup?.text || '',
        //                 cal_instrument_id: item.cal_instrument?.id || null,
        //                 cal_instrument_text: item.cal_instrument?.text || '',
        //                 cal_parameter_one_id: item.cal_parameter_one?.id || null,
        //                 cal_parameter_one_text: item.cal_parameter_one?.text || '',
        //                 cal_parameter_two_id: item.cal_parameter_two?.id || null,
        //                 cal_parameter_two_text: item.cal_parameter_two?.text || '',
        //                 cal_standard: item.cal_standard || '',
        //                 cal_cmc_info: item.cal_cmc_info || []
        //             }));
        //         }
        //     }

        //     return transformed;
        // }

        function transformLabTypes(labTypes) {
            const transformed = {
                pl_2_1_info: [],
                pl_2_2_info: [],
                pl_2_3_info: [],
                pl_2_4_info: [],
                pl_2_5_info: []
            };

            for (let i = 1; i <= 5; i++) {
                const key = `pl_2_${i}_info`;
                if (Array.isArray(labTypes[key]) && labTypes[key].length > 0) {
                    transformed[key] = labTypes[key].map(item => {
                        // ตรวจสอบประเภทของ lab โดยดูจากฟิลด์ใน item
                        const isCalLab = item.hasOwnProperty('cal_main_branch') || item.hasOwnProperty('cal_instrumentgroup');
                        const isTestLab = item.hasOwnProperty('test_main_branch') || item.hasOwnProperty('test_category');

                        if (isCalLab) {
                            // กรณี Calibration Lab (cal_)
                            return {
                                cal_main_branch_id: item.cal_main_branch?.id || null,
                                cal_main_branch_text: item.cal_main_branch?.text || '',
                                cal_main_branch_text_en: item.cal_main_branch?.text_en || '',
                                cal_instrumentgroup_id: item.cal_instrumentgroup?.id || null,
                                cal_instrumentgroup_text: item.cal_instrumentgroup?.text || '',
                                cal_instrument_id: item.cal_instrument?.id || null,
                                cal_instrument_text: item.cal_instrument?.text || '',
                                cal_parameter_one_id: item.cal_parameter_one?.id || null,
                                cal_parameter_one_text: item.cal_parameter_one?.text || '',
                                cal_parameter_two_id: item.cal_parameter_two?.id || null,
                                cal_parameter_two_text: item.cal_parameter_two?.text || '',
                                cal_standard: item.cal_standard || '',
                                cal_cmc_info: item.cal_cmc_info || []
                            };
                        } else if (isTestLab) {
                            // กรณี Test Lab (test_)
                            return {
                                test_main_branch_id: item.test_main_branch?.id || null,
                                test_main_branch_text: item.test_main_branch?.text || '',
                                test_main_branch_text_en: item.test_main_branch?.text_en || '',
                                test_category_id: item.test_category?.id || null,
                                test_category_text: item.test_category?.text || '',
                                test_category_text_en: item.test_category?.text_en || '',
                                test_parameter_id: item.test_parameter?.id || null,
                                test_parameter_text: item.test_parameter?.text || '',
                                test_parameter_text_en: item.test_parameter?.text_en || '',
                                test_condition_description: item.test_condition_description || '',
                                test_param_detail: item.test_param_detail || '',
                                test_standard: item.test_standard || ''
                            };
                        } else {
                            // กรณีไม่สามารถระบุประเภทของ lab ได้
                            console.error('Cannot determine lab type for item:', item);
                            return {};
                        }
                    });
                }
            }

            return transformed;
        }


        function submit_form(status) 
        {
            var accordingFormula_data = $('#according_formula').val();
            var labAbility_data = $('input[name="lab_ability"]:checked').val();
            var purpose_data = $('input[name="purpose"]:checked').val();

            fetch("{!! route('certify.applicant.download-html-template') !!}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        accordingFormula: accordingFormula_data,
                        labAbility: labAbility_data,
                        purpose: purpose_data,
                    })
                })
                .then(response => {
                    
                    if (response.ok) {
                            if (!validateLabData()) { 
                                return; // หยุดการทำงานถ้าไม่ผ่านการตรวจสอบ
                            }

                            let purpose = $('input[name="purpose"]:checked').val();

                            if(purpose == 6)
                            {
                                if($('#transferee_name').val() == "")
                                {
                                    alert("โปรดตรวสอบข้อมูลผู้โอน");
                                    return;
                                }
                            }


                            const mainLabInfo = JSON.parse(sessionStorage.getItem('main_lab_info')) || {};

                            const branchData = JSON.parse(sessionStorage.getItem('branch_lab_infos')) || [];

                            var uniqueCalMainBranches;

                            if($("input[name=lab_ability]:checked").val() == "calibrate"){
                                uniqueCalMainBranches = getUniqueCalMainBranches(branchData, mainLabInfo);
                            }else if($("input[name=lab_ability]:checked").val() == "test")
                            {
                                uniqueCalMainBranches = getUniqueTestMainBranches(branchData, mainLabInfo);
                            }
                
                            renderHiddenInputs(uniqueCalMainBranches);


                            // แปลง lab_types ของ main_lab_info
                            mainLabInfo.lab_types = transformLabTypes(mainLabInfo.lab_types);

                            // แปลง lab_types ของแต่ละสาขา
                            branchData.forEach(branch => {
                                branch.lab_types = transformLabTypes(branch.lab_types);
                            });

                            // ล้าง hidden input เดิม (ถ้ามี)
                            $('#app_certi_form').find('input[name="main_lab_info"]').remove();
                            $('#app_certi_form').find('input[name="branch_lab_infos"]').remove();

                            // เพิ่ม hidden input สำหรับ main_lab_info
                            $('<input>').attr({
                                type: 'hidden',
                                name: 'main_lab_info',
                                value: JSON.stringify(mainLabInfo)
                            }).appendTo('#app_certi_form');

                            // เพิ่ม hidden input สำหรับ branch_lab_infos
                            $('<input>').attr({
                                type: 'hidden',
                                name: 'branch_lab_infos',
                                value: JSON.stringify(branchData)
                            }).appendTo('#app_certi_form');

                            var  number =  1;
                            var max_size = "{{ ini_get('post_max_size') }}";
                            var res = max_size.replace("M", "");
                            $('#app_certi_form').find('input[type="file"]').each(function(index, el) {
                                if(checkNone($(el).val()) && $(el).prop("tagName")=="INPUT" && $(el).prop("type")=="file"   ){
                                    number +=  (el.files[0].size /1024/1024);
                                }
                            });
                            
                            var row = $("input[name=lab_ability]:checked").val();
                            if(row == 'test'){ 
                                // var test_scope_branch_id = $(".test_scope_branch_id").length;
                                // if(test_scope_branch_id > 0){
                                if(number < res){
                                    $('div#status_btn').html('<input type="text" name="save" value="' + status + '" hidden>');
                                    setTimeout(function () {
                                        $('#app_certi_form').submit();
                                    }, 500);
                                }else{
                                    Swal.fire(
                                        'ขนาดไฟล์รวม '+number.toFixed(2)+' MB ไม่สามารถบันทึกได้ ต้องไม่เกิน ' + res + ' MB',
                                        '',
                                        'warning'
                                    )
                                }
                            }else{ 
                            
                                var calibrate_branch_id = $(".calibrate_branch_id").length;
                                
                                // if(calibrate_branch_id > 0){
                                console.log('submit สอบเทียบ ' + calibrate_branch_id);
                                console.log('number ' + number);
                                console.log('res ' + res);
                                if(number < res){
                                    $('div#status_btn').html('<input type="text" name="save" value="' + status + '" hidden>');
                                    console.log('aha');
                                    setTimeout(function () {
                                        $('#app_certi_form').submit();
                                    }, 500);
                                }else{
                                    Swal.fire(
                                        'ขนาดไฟล์รวม '+number.toFixed(2)+' MB ไม่สามารถบันทึกได้ ต้องไม่เกิน ' + res + ' MB',
                                        '',
                                        'warning'
                                    )
                                }
                            }
                    }else{
                        alert("ยังไม่ได้เพิ่มขอบข่าย");
                    }
                });
        }

        //ฉบับร่าง
        function  submit_form_draft(status){

            var accordingFormula_data = $('#according_formula').val();
            var labAbility_data = $('input[name="lab_ability"]:checked').val();
            var purpose_data = $('input[name="purpose"]:checked').val();

            console.log(accordingFormula_data,labAbility_data,purpose_data)

             fetch("{!! route('certify.applicant.download-html-template') !!}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        accordingFormula: accordingFormula_data,
                        labAbility: labAbility_data,
                        purpose: purpose_data,
                    })
                })
                .then(response => {
                    if (response.ok) {
                        // ตรวจสอบข้อมูลก่อนส่ง
                        if (!validateLabData()) { 
                            return; // หยุดการทำงานถ้าไม่ผ่านการตรวจสอบ
                        }

                        let purpose = $('input[name="purpose"]:checked').val();

                        if(purpose == 6)
                        {
                            if($('#transferee_name').val() == "")
                            {
                                alert("โปรดตรวสอบข้อมูลผู้โอน");
                                return;
                            }
                        }


                        const mainLabInfo = JSON.parse(sessionStorage.getItem('main_lab_info')) || {};

                        const branchData = JSON.parse(sessionStorage.getItem('branch_lab_infos')) || [];


                        // var uniqueCalMainBranches = getUniqueCalMainBranches(branchData, mainLabInfo);
                        var uniqueCalMainBranches;
                        if($("input[name=lab_ability]:checked").val() == "calibrate"){
                            uniqueCalMainBranches = getUniqueCalMainBranches(branchData, mainLabInfo);
                        }else if($("input[name=lab_ability]:checked").val() == "test")
                        {
                            uniqueCalMainBranches = getUniqueTestMainBranches(branchData, mainLabInfo);
                        }

                        renderHiddenInputs(uniqueCalMainBranches);

                        // แปลง lab_types ของ main_lab_info
                        mainLabInfo.lab_types = transformLabTypes(mainLabInfo.lab_types);

                        // แปลง lab_types ของแต่ละสาขา
                        branchData.forEach(branch => {
                            branch.lab_types = transformLabTypes(branch.lab_types);
                        });

                        // ล้าง hidden input เดิม (ถ้ามี)
                        $('#app_certi_form').find('input[name="main_lab_info"]').remove();
                        $('#app_certi_form').find('input[name="branch_lab_infos"]').remove();

                        // เพิ่ม hidden input สำหรับ main_lab_info
                        $('<input>').attr({
                            type: 'hidden',
                            name: 'main_lab_info',
                            value: JSON.stringify(mainLabInfo)
                        }).appendTo('#app_certi_form');

                        // เพิ่ม hidden input สำหรับ branch_lab_infos
                        $('<input>').attr({
                            type: 'hidden',
                            name: 'branch_lab_infos',
                            value: JSON.stringify(branchData)
                        }).appendTo('#app_certi_form');



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
                                        $('div#status_btn').html('<input type="text" name="draft" value="' + status + '" hidden>');
                                        setTimeout(function () {
                                            $('#app_certi_form').submit();
                                        }, 500);
                                    }else{
                                        Swal.fire(
                                                    'ขนาดไฟล์รวม '+number.toFixed(2)+' MB ไม่สามารถบันทึกได้ ต้องไม่เกิน ' + res + ' MB',
                                                    '',
                                                    'warning'
                                                )
                                    }
                                }
                        })
                    }else{
                        alert("ยังไม่ได้เพิ่มขอบข่าย");
                    }

                });


        }

        function button_save(){
            if($('#checkbox_confirm').is(':checked')){
                $('button[name="save"]').attr('disabled', false);
                $('button[name="save"]').removeClass('btn-default').addClass('btn-primary');
            }else{
                $('button[name="save"]').attr('disabled', true);
                $('button[name="save"]').removeClass('btn-primary').addClass('btn-default');
            }
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

<script src="{{asset('assets/js/lab/applicant.js?v=1.12')}}"></script>
@endpush