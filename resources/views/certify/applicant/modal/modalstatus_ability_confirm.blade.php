<!-- Modal เลข 19 -->
{{-- ApplicantController --}}
@push('css')
    <!-- ===== Parsley js ===== -->
    <link href="{{asset('plugins/components/parsleyjs/parsley.css?20200630')}}" rel="stylesheet" />
    @endpush

{{--@if ($showmodal19 == 19)--}}
    <div class="modal fade text-left" id="action19{{$id}}" tabindex="-1" role="dialog" aria-labelledby="addBrand">
        <div class="modal-dialog modal-dialog-centered " style="width:1000px" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel1">
                        แจ้งยืนยันความสามารถ ขอรับใบรับรองระบบงาน
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </h4>
                </div>

                {!! Form::open(['url' => 'certify/applicant/update/status/cost/certificate/'.$certificate->id,   'method' => 'POST', 'class' => 'form-horizontal app_certificate_form','files' => true]) !!}
                @php
                $formula = App\Models\Bcertify\Formula::Where([['applicant_type',3],['state',1]])->first();
                $amount  =  !empty($certificate->amount) ? $certificate->amount :  '0';
                $amount_fee  =  !empty($certificate->amount_fee) ?$certificate->amount_fee :  '0';
                $sum =   ((string)$amount +   (string)$amount_fee);
                // dd($certificate);
              @endphp
                <div class="modal-body">
                    <div class="container-fluid">
                        <h3 class="text-center"><span >{{ HP::formatDateThai($certificate->notification_date) ?? '-' }}</span></h3>
                        <p>&nbsp;</p>
                        <p>เรียน <span> {{ $applicant->information->name }}</span></p>
                        <p>เรื่อง <span>การยืนยันความสามารถ และการขอรับใบรับรองระบบงาน</span></p>
                        <p style="text-indent: 50px;">ตามที่  {{ $applicant->information->name }} ได้แจ้งขอรับบริการการตรวจประเมินความสามารถ 
                            ตามมาตรฐาน มอก. {{ !is_null($formula)?$formula->title:'-' }}  ลงรับวันที่  {{ !empty($applicant->check->report_date) ?  HP::formatDateThai($applicant->check->report_date) : '-' }} </span>นั้น
                        </p>
                        <p style="text-indent: 50px;"> สำนักงานขอยืนยันว่าหน่วยงานของท่าน มีความสามารถครบถ้วนตามหลักเกณฑ์ที่สำนักงานกำหนด หากท่านประสงค์จะขอรับใบรับรอง โปรดยืนยันความสามารถตามรายละเอียดที่แจ้งมาพร้อมนี้ ภายใน 30 วัน นับจากวันที่ที่ระบุไว้ในหนังสือฉบับนี้</p>
                        <p style="text-indent: 50px;"> จึงเรียนมาเพื่อโปรดดำเนินการ </p>
    
                        <hr style="border: 1px dashed #000; margin: 20px 0;">

                        <div style="width: 900px">
                            <div style="text-align: center; margin-top: 20px;">
                                <span style="display: block; font-size: 18px;">คำขอรับใบรับรอง</span>
                                <span style="display: block; font-size: 18px;">ผู้ประกอบการตรวจสอบและรับรอง</span>
                                <span style="display: block; font-size: 14px;">Application form of requesting for the certification document of the conformity assessment body.</span>
                            </div>
                        
                            <div style="margin-top: 30px; font-size: 16px;">
                                <!-- วัตถุประสงค์ -->
                                <div style="display: flex; align-items: center; flex-wrap: wrap; margin-bottom: 10px;">
                                    <span style="margin-right: 10px;">วัตถุประสงค์ในการขอใบรับรอง :</span>
                                    <div style="display: flex; align-items: center; margin-right: 20px;">
                                        <div style="width: 20px; height: 20px; border: 1px solid #000; display: flex; align-items: center; justify-content: center; margin-right: 5px;">@if ($applicant->purpose_type == 1)X @endif</div>
                                        <span>ตรวจประเมินครั้งแรก</span>
                                    </div>
                                    <div style="display: flex; align-items: center; margin-right: 20px;">
                                        <div style="width: 20px; height: 20px; border: 1px solid #000; display: flex; align-items: center; justify-content: center; margin-right: 5px;">@if ($applicant->purpose_type == 2)X @endif</div>
                                        <span>ต่ออายุใบรับรอง</span>
                                    </div>
                                    <div style="display: flex; align-items: center; margin-right: 20px;">
                                        <div style="width: 20px; height: 20px; border: 1px solid #000; display: flex; align-items: center; justify-content: center; margin-right: 5px;">@if ($applicant->purpose_type == 3)X @endif</div>
                                        <span>ขยายขอบข่าย</span>
                                    </div>
                                    <div style="display: flex; align-items: center;">
                                        <div style="width: 20px; height: 20px; border: 1px solid #000; display: flex; align-items: center; justify-content: center; margin-right: 5px;">@if ($applicant->purpose_type != 1 && $applicant->purpose_type != 2 && $applicant->purpose_type != 3)X @endif</div>
                                        <span>อื่น ๆ</span>
                                        <span style="margin-left: 5px;">........................................</span>
                                    </div>
                                </div>
                        
                                <!-- ชื่อผู้ขอใบรับรอง -->
                                <div style="margin-bottom: 10px;">
                                    <!-- ชื่อผู้ขอรับการรับรอง -->
                                    <span>ชื่อผู้ขอรับการรับรอง</span>
                                    <span style="display: inline-block; width: 400px; border-bottom: 1px dotted #000; margin-left: 10px;">
                                        <span style="opacity: 0.5;padding-left:20px">{{$applicant->BelongsInformation->name}}</span>
                                    </span>
                                    <span>เลขทะเบียนนิติบุคคล</span>
                                    <span style="display: inline-block; width: 188px; border-bottom: 1px dotted #000; margin-left: 10px">
                                        <span style="opacity: 0.5;padding-left:10px">{{$applicant->BelongsInformation->tax_indentification_number}}</span>
                                    </span>
                                </div>
                                
                                <div style="font-style: italic; font-size: 0.9em; margin-bottom: 10px;margin-top:-10px;font-weight: 300">
                                    (Name of the applicant conformity assessment body) <span style="margin-left: 200px;">(Juristic ID)</span>
                                </div>
                                
                                <div style="margin-bottom: 10px;">
                                    <!-- ที่อยู่ -->
                                    <span>มีสำนักงานใหญ่ตั้งอยู่ที่</span>
                                    <span style="display: inline-block; width: 725px; border-bottom: 1px dotted #000; margin-left: 10px;">
                                        <span style="opacity: 0.5;">
                                            เลขที่ {{$applicant->BelongsInformation->address_headquarters}}
                                            @if ($applicant->BelongsInformation->headquarters_village_no != null)
                                                หมู่ที่ {{$applicant->BelongsInformation->headquarters_village_no}}
                                            @endif
                                            @if ($applicant->BelongsInformation->headquarters_road != null)
                                                ถนน{{$applicant->BelongsInformation->headquarters_road}}
                                            @endif
                                    
                                            @if ($applicant->BelongsInformation->headquarters_province == 'กรุงเทพมหานคร')
                                                แขวง{{$applicant->BelongsInformation->headquarters_district}} เขต{{$applicant->BelongsInformation->headquarters_amphur}} {{$applicant->BelongsInformation->headquarters_province}}
                                            @else
                                                ตำบล{{$applicant->BelongsInformation->headquarters_district}} อำเภอ{{$applicant->BelongsInformation->headquarters_amphur}} จังหวัด{{$applicant->BelongsInformation->headquarters_province}}
                                            @endif

                                            
                                        </span>
                                    </span>
                                    
                                    {{-- <span style="display: block;">(Address of head office)</span> --}}
                                </div>
                                <div style="font-style: italic; font-size: 0.9em; margin-bottom: 10px;;margin-top:-10px;font-weight: 300">
                                    (Address of head office)
                                </div>
                                
                                <div style="margin-bottom: 10px;">
                                    <!-- กรณีสถานที่ -->
                                    <span>กรณีสถานที่ขอรับการรับรองไม่ได้ตั้งอยู่ที่สำนักงานใหญ่ โปรดระบุชื่อ (Lab/CB/IB)</span>
                                    <span style="display: inline-block; width: 883px; border-bottom: 1px dotted #000; margin-left: 10px;">
                                        <span style="opacity: 0.5;"></span>
                                    </span>
                                </div>
                                <div style="font-style: italic; font-size: 0.9em; margin-bottom: 10px;margin-top:-10px;font-weight: 300">
                                    In case the location is not at the head office address, please specify (Name of Lab/CB/IB)
                                </div>
                                <div style="margin-bottom: 10px;">
                                    <!-- ที่อยู่ -->
                                    <span>ตั้งอยู่เลขที่</span>
                                    <span style="display: inline-block; width: 805px; border-bottom: 1px dotted #000; margin-left: 10px;">
                                        <span style="opacity: 0.5;"> เลขที่ {{$applicant->address_no}}
                                            @if ($applicant->allay != null)
                                                หมู่ที่ {{$applicant->allay}}
                                            @endif
                                            @if ($applicant->road != null)
                                                ถนน{{$applicant->road}}
                                            @endif
                                    
                                            @if ($applicant->province == 'กรุงเทพมหานคร')
                                                แขวง{{$applicant->district}} เขต{{$applicant->amphur}} {{$applicant->province_to->PROVINCE_NAME}}
                                            @else
                                                ตำบล{{$applicant->district}} อำเภอ{{$applicant->amphur}} จังหวัด{{$applicant->province_to->PROVINCE_NAME}}
                                            @endif</span>
                                    </span>
                                    {{-- <span style="display: block;">(Address of head office)</span> --}}
                                </div>
                                <div style="font-style: italic; font-size: 0.9em; margin-bottom: 10px;;margin-top:-10px;font-weight: 300">
                                    (Address)
                                </div>
                                
                                <div style="margin-bottom: 10px;">
                                    <!-- ขอใบรับรอง -->
                                    <span>ข้าพเจ้าประสงค์ขอรับใบรับรองระบบงาน : ตามมาตรฐานเลขที่</span>
                                    <span style="display: inline-block; width: 486px; border-bottom: 1px dotted #000; margin-left: 10px;">
                                        <span style="opacity: 0.5;">{{$applicant->FormulaTo->title}}</span>
                                    </span>
                                </div>
                                <div style="font-style: italic; font-size: 0.9em; margin-bottom: 10px;;margin-top:-10px;font-weight: 300">
                                    (I need to request accreditation certification document: Standard no.)
                                </div>
                                
                                <div style="margin-bottom: 10px;">
                                    <!-- วันที่ -->
                                    <span>หนังสือยืนยันความสามารถ ลงวันที่</span>
                                    <span style="display: inline-block; width: 653px; border-bottom: 1px dotted #000; margin-left: 10px;">
                                        <span style="opacity: 0.5;">{{ HP::formatDateThaiFull($certificate->notification_date) ?? '-' }}</span>
                                    </span>
                                </div>
                                <div style="font-style: italic; font-size: 0.9em; margin-bottom: 10px;;margin-top:-10px;font-weight: 300">
                                    Letter of accreditation dated
                                </div>
                                
                        
                                <!-- เงื่อนไข -->
                                <div style="margin-top: 20px;">
                                   <p>(1) ข้าพเจ้ารับทราบและให้คำมั่นจะปฏิบัติตามพระราชบัญญัติการมาตรฐานแห่งชาติ พ.ศ. 2551 รวมถึงกฎกระทรวง ประกาศ หลักเกณฑ์ วิธีการ และเงื่อนไข มาตรฐานข้อกำหนดสำหรับการรับรองระบบงาน ข้อกำหนดอื่น ๆ และ/หรือ 
                                        ที่จะมีการกำหนด แก้ไขเพิ่มเติมในภายหลังด้วย</p>
                                    <p style="font-weight: 300">I have acknowledged and committed to continually fulfil the requirements for accreditation and the other obligations of the conformity assessment body, and to comply with National Standardization Act, B.E.2551 (2008) including ministerial regulations, notification, criteria methods and conditions according to the act, standard requirement, conditions determined by TISI and/or any changes in future</p>
                                
                                    <p>(2) ข้าพเจ้าจะชำระค่าธรรมเนียมคำขอรับใบรับรองและใบรับรองทันทีที่ได้รับใบแจ้งการชำระเงินจากสำนักงานมาตรฐานผลิตภัณฑ์อุตสาหกรรม </p>
                                    <p style="font-weight: 300">I will pay application fee, and certificate document fee upon receiving the Pay-in Slip from TISI without delays.</p>
                                
                                </div>
                            </div>
                        </div>
                        
                        
                     

                    </div>


                    @if(!is_null($certificate->detail))
                         <br>
                        <p>หมายเหตุ :</p>
                        <p>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{  $certificate->detail ?? '-' }}
                        </p>
                    @endif


            </div>
                <input type="hidden" name="findCertiLab19" id="findCertiLab19" value="{{ $token }}">
                <input type="hidden"  id="app_id" value="{{$applicant->id}}">

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
                    <button type="button" id="ability_confirm_button" class="btn btn-info" >ยืนยัน</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
{{--@endif--}}
    <!-- ===== PARSLEY JS Validation ===== -->

    @push('js')
    <script src="{{asset('plugins/components/parsleyjs/parsley.min.js')}}"></script>
    <script src="{{asset('plugins/components/parsleyjs/language/th.js')}}"></script>

    <script>
        $(document).ready(function () {
            //แจ้งรายละเอียดการชำระเงินค่าใบรับรอง modal 23
            $('.app_certificate_form').parsley().on('field:validated', function() {
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





        });


        $(document).off('click', '#ability_confirm_button').on('click', '#ability_confirm_button', function(e) {
       
            // รับค่าจากฟอร์ม
            const _token = $('input[name="_token"]').val();
            var app_id = $('#app_id').val();

            // แสดง overlay
            $.LoadingOverlay("show", {
                image: "",
                text: "กำลังบันทึก กรุณารอสักครู่..."
            });

            // เรียก AJAX
            $.ajax({
                url: "{{route('assessment.ability-confirm')}}",
                method: "POST",
                data: {
                    _token: _token,
                    id: app_id,
                },
                success: function(result) {
                    // console.log(result);
                    $('#action19{{$id}}').modal('hide');
                    window.location.reload();
                    
                },
                error: function(xhr, status, error) {
                    console.error("Error:", error);
                    alert("เกิดข้อผิดพลาด กรุณาลองใหม่");
                },
                complete: function() {
                    // ซ่อน overlay
                    $.LoadingOverlay("hide");
                }
            });
        });


        // document.addEventListener('click', function(e) {
        // if (e.target.id === 'ability_confirm_button') {
        //     e.preventDefault();

        //     console.log('ok');

        //     // รับค่าจากฟอร์ม
        //     const _token = document.querySelector('input[name="_token"]').value;
        //     const app_id = document.getElementById('app_id').value;

        //     // แสดง overlay
        //     $.LoadingOverlay("show", {
        //         image: "",
        //         text: "กำลังบันทึก กรุณารอสักครู่..."
        //     });

        //     // เรียก AJAX
        //     fetch("{{route('assessment.ability-confirm')}}", {
        //         method: "POST",
        //         headers: {
        //             "Content-Type": "application/json",
        //             "X-CSRF-TOKEN": _token
        //         },
        //         body: JSON.stringify({ id: app_id })
        //     })
        //     .then(response => response.json())
        //     .then(result => {

        //           // รีโหลดหน้าเว็บ
        //         window.location.reload();
        //     })
        //     .catch(error => {
        //         console.error("Error:", error);
        //         alert("เกิดข้อผิดพลาด กรุณาลองใหม่");
        //     })
        //     .finally(() => {
        //         // ซ่อน overlay
        //         $.LoadingOverlay("hide");
        //     });
        // }
        // });

    </script>

    @endpush
