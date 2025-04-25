<!-- Modal เลข 19 -->
{{--@if ($showmodal19 == 19)--}}
    <div class="modal fade text-left" id="action19{{$id}}" tabindex="-1" role="dialog" aria-labelledby="addBrand">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel1">แจ้งรายละเอียดการชำระเงินค่าใบรับรอง</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>

                {!! Form::open(['url' => 'certify/applicant/update/status/cost/certificate', 'class' => 'form-horizontal','id'=>'app_certi_form', 'files' => true]) !!}

                <div class="modal-body">
                    <div class="container-fluid">
                        <p>เรียน <span>{{ $applicant->information->name }}</span> </p>
                        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ตามที่ท่านได้ยื่นคำขอรับใบรับรองระบบงานห้องปฏิบัติการ หมายเลขคำขอที่ <span style="color:#26ddf5;">{{ $applicant->app_no }}</span>
                            เมื่อวันที่ <span >{{ $show }}</span> นั้น มีค่าใช้จ่ายในการตรวจประเมิน จำนวนเงิน <span style="color:#26ddf5;">{{ number_format($find_cost_certificate->amount,2) ??'0.00' }}</span> บาท โดยมีรายละเอียดการชำระตาม invoice ที่แนบมา
                            <span >
                                <p>ค่าธรรมเนียมสมัคร : <a href="{{ url('check/files/'.basename($find_cost_certificate->amount_file)) }}"> 
                                    {!! HP::FileExtension($find_cost_certificate->amount_file)  ?? '' !!}
                                    {{basename($find_cost_certificate->amount_file)}}
                                </a>
                                </p>
                                <p>ค่าธรรมเนียมใบรับรอง : <a href="{{ url('check/files/'.basename($find_cost_certificate->attach)) }}"> 
                                    {!! HP::FileExtension($find_cost_certificate->attach)  ?? '' !!}
                                    {{basename($find_cost_certificate->attach)}}
                                </a>
                                </p>
                            </span>
                        </p>


                        <br>
                        <p>เรียน กลุ่มการคลัง</p>
                        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ดำเนินการชำระค่าใช้จ่ายในการตรวจประเมินเรียบร้อยแล้ว ตามหลักฐานที่แนบมา โปรดออกใบเสร็จรับเงินในนาม
                            <span style="color:#26ddf5;">{{ $applicant->information->name }}</span> เป็นค่าใช้จ่ายในการตรวจประเมิน จำนวนเงิน <span style="color:#26ddf5;">{{  number_format($find_cost_certificate->amount,2) ??'0.00'  }}</span> บาท อ้างอิงเลขคำขอที่ <span style="color:#26ddf5;">{{ $applicant->app_no }}</span>
                        </p>
                        <br>

                        <div class=" form-group {{ $errors->has('activity_file19') ? 'has-error' : ''}}">
                            <label for="activity_file19" class="col-md-12" style="padding-top: 7px;margin-bottom: 13px">หลักฐานค่าธรรมเนียมใบสมัคร :</label>
                            <div class="col-md-6">
                                <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                    <div class="form-control" data-trigger="fileinput">
                                        <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                        <span class="fileinput-filename"></span>
                                    </div>
                                    <span class="input-group-addon btn btn-default btn-file">
                                    <span class="fileinput-new">เลือกไฟล์</span>
                                    <span class="fileinput-exists">เปลี่ยน</span>
                                        {!! Form::file('activity_file19', null) !!}
                                    </span>
                                    <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
                                </div>
                                {!! $errors->first('activity_file19', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>
                        <div class=" form-group {{ $errors->has('attach_certification') ? 'has-error' : ''}}">
                            <label for="attach_certification" class="col-md-12" style="padding-top: 7px;margin-bottom: 13px">หลักฐานค่าธรรมเนียมใบรับรอง :</label>
                            <div class="col-md-6">
                                <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                    <div class="form-control" data-trigger="fileinput">
                                        <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                        <span class="fileinput-filename"></span>
                                    </div>
                                    <span class="input-group-addon btn btn-default btn-file">
                                    <span class="fileinput-new">เลือกไฟล์</span>
                                    <span class="fileinput-exists">เปลี่ยน</span>
                                        {!! Form::file('attach_certification', null) !!}
                                    </span>
                                    <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
                                </div>
                                {!! $errors->first('attach_certification', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="findCertiLab19" id="findCertiLab19" value="{{ $token }}">

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-success" >แจ้งชำระเงิน</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
{{--@endif--}}



@push('js')
    <script>
        $('#btn3').on('click',function () {
            $('#msg3').text($(this).val());
            var token = $(this).attr('data-id');
            let web_url = '{{ url('certify/applicant/edit/') }}' + "/" + token;
            $('#checkid').empty();
            $('#checkid').append('<a href="'+web_url+'" >(แก้ไขคำขอ)</a>')

        })
    </script>
@endpush