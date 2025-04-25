<!-- Modal เลข 19 -->
@push('css')
    <!-- ===== Parsley js ===== -->
    <link href="{{asset('plugins/components/parsleyjs/parsley.css?20200630')}}" rel="stylesheet" />
    @endpush


<!-- Modal เลข 15 -->
<div class="modal fade" id="action15{{$id}}" tabindex="-1" role="dialog" aria-labelledby="addBrand">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel1">แจ้งรายละเอียดค่าบริการในการตรวจประเมิน
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </h4>
            </div>
            {!! Form::open(['url' => 'certify/applicant/update/status/cost/assessment', 'class' => 'form-horizontal app_assessment_form', 'files' => true]) !!}

            <div class="modal-body text-left">
                <div class="container-fluid">
                    <p>เรียน <span class="nameCertiLab">{{ $name }}</span> </p>
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ตามที่ท่านได้ยื่นคำขอรับใบรับรองระบบงานห้องปฏิบัติการ หมายเลขคำขอที่ <span class="noCertiLab" style="color:blue">{{ $appNo }}</span>
                        เมื่อวันที่ <span id="certiDate" style="color:blue">{{!empty($report_date) ? HP::DateThai($report_date) : '-' }}</span> นั้น มีค่าใช้จ่ายในการตรวจประเมิน จำนวนเงิน <span class="costAssessment" style="color:blue">{{ number_format($cost,2) }}</span> บาท โดยมีรายละเอียดการชำระตาม invoice ที่แนบมา
                        <span id="showInvoiceAssessment"><a href="{{ url('certify/check/files/'.$path) }}">  {!! HP::FileExtension($path)  ?? 'หลักฐาน' !!} </a></span>
                    </p>


                    <br>
                    <p>เรียน กลุ่มการคลัง</p>
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ดำเนินการชำระค่าใช้จ่ายในการตรวจประเมินเรียบร้อยแล้ว ตามหลักฐานที่แนบมา โปรดออกใบเสร็จรับเงินในนาม
                        <span class="nameCertiLab">{{ $name }}</span> เป็นค่าใช้จ่ายในการตรวจประเมิน จำนวนเงิน <span class="costAssessment" style="color:blue">{{ number_format($cost,2) }}</span> บาท อ้างอิงเลขคำขอที่ <span class="noCertiLab"  style="color:blue">{{ $appNo }}</span>
                    </p>
                    <br>

                    <div class=" form-group {{ $errors->has('activity_file15') ? 'has-error' : ''}}">
                        <label for="activity_file15" class="col-md-12" style="padding-top: 7px;margin-bottom: 13px">หลักฐานการชำระเงิน :</label>
                        <div class="col-md-6">
                            <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                <div class="form-control" data-trigger="fileinput">
                                    <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                    <span class="fileinput-filename"></span>
                                </div>
                                <span class="input-group-addon btn btn-default btn-file">
                                    <span class="fileinput-new">เลือกไฟล์</span>
                                    <span class="fileinput-exists">เปลี่ยน</span>
                                        {!! Form::file('activity_file15', null) !!}
                                    </span>
                                <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
                            </div>
                            {!! $errors->first('activity_file15', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                  
                 
                    @if(!is_null($detail))
                         <br>
                        <p>หมายเหตุ :</p>
                        <p>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{  $detail ?? '-' }}
                        </p>
                    @endif
                  

                </div>
            </div>
            <input type="hidden" name="findCertiLab15" id="findCertiLab15" value="{{$token}}">

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
                <button type="submit" class="btn btn-success" >แจ้งชำระเงิน</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

@push('js')
<script src="{{asset('js/jasny-bootstrap.js')}}"></script>
<script>
    $(document).ready(function () {
        //เพิ่มไฟล์แนบ
             //แจ้งรายละเอียดค่าบริการในการตรวจประเมิน modal 15
             $('.app_assessment_form').parsley().on('field:validated', function() {
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
 
</script>

@endpush
