<!-- Modal เลข 7 รอชำระค่าธรรมเนียม -->
<div class="modal fade actionSeven"  tabindex="-1" role="dialog" aria-labelledby="addBrand">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel1">แจ้งรายละเอียดการชำระเงินค่าธรรมเนียมดำเนินการ</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            {!! Form::open(['url' => 'certify/applicant/update/status/to/eight', 'class' => 'form-horizontal','id'=>'app_certi_form', 'files' => true]) !!}

            <div class="modal-body">
                <div class="container-fluid">
                    <p>เรียน <span id="nameInfornation"></span> </p>
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ตามที่ท่านได้ยื่นคำขอรับใบรับรองระบบงานห้องปฏิบัติการ หมายเลขคำขอที่ <span id="no"></span>
                        เมื่อวันที่ <span id="date"></span> นั้น มีค่าธรรมเนียมใบอนุญาต จำนวนเงิน <span id="money"></span> บาท โดยมีรายละเอียดการชำระตาม invoice ที่แนบมา
                        <span id="payment"></span>
                    </p>


                    <br>
                    <p>เรียน กลุ่มการคลัง</p>
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ดำเนินการชำระค่าธรรมเนียบใบอนุญาตเรียบร้อยแล้ว ตามหลักฐานที่แนบมา โปรดออกใบเสร็จรับเงินในนาม
                        <span id="company"></span> เป็นค่าธรรมเนียมใบอนุญาต จำนวนเงิน <span id="company_money"></span> บาท อ้างอิงเลขคำขอที่ <span id="company_id"></span>
                    </p>
                    <br>

                    <div class=" form-group {{ $errors->has('activity_file') ? 'has-error' : ''}}">
                        <label for="activity_file" class="col-md-12" style="padding-top: 7px;margin-bottom: 13px">หลักฐานการชำระเงิน :</label>
                        <div class="col-md-6">
                            <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                <div class="form-control" data-trigger="fileinput">
                                    <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                    <span class="fileinput-filename"></span>
                                </div>
                                <span class="input-group-addon btn btn-default btn-file">
                                    <span class="fileinput-new">เลือกไฟล์</span>
                                    <span class="fileinput-exists">เปลี่ยน</span>
                                        {!! Form::file('activity_file', null) !!}
                                    </span>
                                <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
                            </div>
                            {!! $errors->first('activity_file', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" name="findCertiLab" id="findCertiLab">
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
                <button type="submit" class="btn btn-success" >แจ้งชำระเงิน</button>
            </div>
            {!! Form::close() !!}

        </div>
    </div>
</div>


@push('js')


    <script>


        function baseName(str)
        {
            var base = new String(str).substring(str.lastIndexOf('/') + 1);
            // if(base.lastIndexOf(".") != -1)
            //     base = base.substring(0, base.lastIndexOf("."));
            return base;
        }


        $('.btn7').on('click',function () {
            $('#findCertiLab').val($(this).attr('data-id'));
            $('#nameInfornation').text($(this).attr('data-information'));
            $('#no').text($(this).attr('data-no'));
            $('#date').text($(this).attr('data-date'));
            $('#money').text($(this).attr('data-invoice'));
            $('#company').text($(this).attr('data-information'));
            $('#company_money').text($(this).attr('data-invoice'));
            $('#company_id').text($(this).attr('data-no'));

            $('#payment').empty();
            console.log($(this).attr('data-payment'));
            
            var path = '{{ url('certify/check/files/') }}' + "/" + baseName($(this).attr('data-payment'));
            $('#payment').append('<a target="_blank" href="'+path+'">'+baseName($(this).attr('data-payment'))+' </a>')


        })
    </script>
@endpush