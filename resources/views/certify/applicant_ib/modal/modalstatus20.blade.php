<!-- Modal เลข 19 -->
{{--@if ($showmodal19 == 19)--}}
<div class="modal fade text-left" id="PayIn2Modal{{$id}}" tabindex="-1" role="dialog" aria-labelledby="addBrand">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel1">
                    แจ้งรายละเอียดการชำระเงินค่าใบรับรอง
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </h4>
            </div>
            @if(!is_null($PayIn2))
            {!! Form::open(['url' => 'certify/applicant-ib/update/pay-in2/'.$PayIn2->id, 'class' => 'form-horizontal','id'=>'pay_in2_form', 'files' => true]) !!}
            @php
            $formula = App\Models\Bcertify\Formula::Where([['applicant_type',2],['state',1]])->first();
            $amount  =  !empty($PayIn2->amount) ? $PayIn2->amount :  '0';
            $amount_fee  =  !empty($PayIn2->amount_fee) ?$PayIn2->amount_fee :  '0';
            $sum =   ((string)$amount +   (string)$amount_fee);
            @endphp
            <div class="modal-body">
                <div class="container-fluid">
                   <h3 class="text-center"><span >{{ HP::formatDateThai($PayIn2->report_date) ?? '-' }}</span></h3>
                        <p>&nbsp;</p>
                        <p>เรียน <span> {{ $name }}</span></p>
                        <p>เรื่อง <span>การยืนยันความสามารถ และการขอรับใบรับรองระบบงาน</span></p>
                        <p style="text-indent: 50px;">ตามที่  {{ $name }} ได้แจ้งขอรับบริการการตรวจประเมินความสามารถ 
                            ตามมาตรฐาน มอก. {{ !is_null($formula)?$formula->title:'-'  }}  ลงรับวันที่  {{ !empty($save_date) ?  HP::formatDateThai($save_date) : '-' }} </span>นั้น
                        </p>
                        <p style="text-indent: 50px;"> สำนักงานขอยืนยันว่าหน่วยงานของท่าน มีความสามารถครบถ้วนตามหลักเกณฑ์ที่สำนักงานกำหนด หากท่านประสงค์จะขอรับใบรับรอง โปรดชำระค่าธรรมเนียมตามรายละเอียดที่แจ้งมาพร้อมนี้ ภายใน 30 วัน นับจากวันที่ที่ระบุไว้ในหนังสือฉบับนี้</p>
                        <p style="text-indent: 50px;"> จึงเรียนมาเพื่อโปรดดำเนินการ </p>
                        
                        @if ($PayIn2->conditional_type == 1) <!--  เรียกเก็บค่าธรรมเนียม -->
                            <p>	ค่าธรรมเนียมคำขอการใบรับรอง สก. :
                                <span style="color:#26ddf5;">{{ number_format($PayIn2->amount_fixed,2).' บาท ' ??'0.00' }}</span>
                            </p>
                            <p>	ค่าตรวจสอบคำขอ :
                                <span style="color:#26ddf5;">{{ number_format($PayIn2->amount,2).' บาท '  ??'0.00' }}</span>
                            </p>
                            <p>ค่าธรรมเนียมใบรับรอง สก. :
                                <span style="color:#26ddf5;">{{ number_format($PayIn2->amount_fee,2).' บาท '  ??'0.00' }}</span>
                            </p>
                            <p>ใบแจ้งหนี้ค่าธรรมเนียม :
                                @if(!is_null($files1))
                                <a href="{{url('certify/check/file_ib_client/'.$files1.'/'.( !empty($file_client_name) ? $file_client_name :   basename($files1) ))}}" target="_blank">
                                    {!! HP::FileExtension($files1)  ?? '' !!}
                                </a>
                                @endif 
                            </p>
                        @elseif ($PayIn2->conditional_type == 2) <!--  ยกเว้นค่าธรรมเนียม -->
                             <p>เอกสารยกเว้นค่าธรรมเนียม :
                                @if(!is_null($files1))
                                    <a href="{{url('funtions/get-view-file/'.base64_encode($files1).'/'.( !empty($file_client_name) ? $file_client_name : basename($files1) ))}}" target="_blank">
                                        {!! HP::FileExtension($files1)  ?? '' !!}
                                    </a>
                                @endif 
                            </p>
                         @elseif ($PayIn2->conditional_type == 3) <!--  ชำระเงินนอกระบบ, ไม่เรียกชำระเงิน หรือ กรณีอื่น -->
                            <p>
                                	หมายเหตุ :  {{!empty($PayIn2->remark) ? $PayIn2->remark: null}} 
                            </p>
                            <p>ไฟล์แนบ :
                                @if(!is_null($files1))
                                <a href="{{url('certify/check/file_ib_client/'.$files1.'/'.( !empty($file_client_name) ? $file_client_name :   basename($files1) ))}}" target="_blank">
                                    {!! HP::FileExtension($files1)  ?? '' !!}
                                </a>
                                @endif 
                            </p>
                        @endif

  
                    <br>
                    <div class=" form-group {{ $errors->has('attach') ? 'has-error' : ''}}">
                        <label for="attach" class="col-md-12" style="padding-top: 7px;margin-bottom: 13px">หลักฐานค่าธรรมเนียม :</label>
                        <div class="col-md-10">
                            <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                <div class="form-control" data-trigger="fileinput">
                                    <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                    <span class="fileinput-filename"></span>
                                </div>
                                <span class="input-group-addon btn btn-default btn-file">
                                <span class="fileinput-new">เลือกไฟล์</span>
                                <span class="fileinput-exists">เปลี่ยน</span>
                                    <input type="file" name="attach" required>
                                </span>
                                <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
                            </div>
                            {!! $errors->first('attach', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                </div>
                @if(!is_null($PayIn2->detail))
                     <br>
                    <p>หมายเหตุ :</p>
                    <p>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{  $PayIn2->detail ?? '-' }}
                    </p>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
                <button type="submit" class="btn btn-success"  onclick="submit_form_pay_in2();return false">แจ้งชำระเงิน</button>
            </div>
            {!! Form::close() !!}
            @endif

        </div>
    </div>
</div>


@push('js')
<script src="{{asset('js/function.js')}}"></script>
    <script type="text/javascript">
    jQuery(document).ready(function() {
        // แนบใบ Pay-in ครั้งที่ 2
        $('#pay_in2_form').parsley().on('field:validated', function() {
                    var ok = $('.parsley-error').length === 0;
                    $('.bs-callout-info').toggleClass('hidden', !ok);
                    $('.bs-callout-warning').toggleClass('hidden', ok);
                })
                .on('form:submit', function() {
                        // Text
                        $.LoadingOverlay("show", {
                        image       : "",
                        text  : "กำลังบันทึก กรุณารอสักครู่..."
                        });
                    return true; // Don't submit form for this demo
         });

     });


             function submit_form_pay_in2() {
            Swal.fire({
                    title: 'ยืนยันทำรายการ !',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'บันทึก',
                    cancelButtonText: 'ยกเลิก'
                    }).then((result) => {
                        if (result.value) {
                            $('#pay_in2_form').submit();
                        }
                    })
           }
    </script>
@endpush
