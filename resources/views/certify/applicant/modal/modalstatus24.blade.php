<!-- Modal เลข 23 -->
<div class="modal fade " id="action23{{$id}}" tabindex="-1" role="dialog" aria-labelledby="addBrand">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" >แจ้งตรวจสอบความถูกต้องใบรับรอง</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            {!! Form::open(['url' => 'certify/applicant/update/status/certificate', 'class' => 'form-horizontal','id'=>'app_certi_form', 'files' => true]) !!}

            <div class="modal-body text-left">
                <div class="container-fluid">
                    <div class="col-md-12">
                        <p style="margin-left: 11px">ใบรับรอง : <a href="http://153.92.5.18/itisi-center/public/certify/certificate-export/{{$app_no}}/th/pdf" target="_blank">ใบรับรอง (TH)</a></p>
                        <p style="margin-left: 78px"> <a href="http://153.92.5.18/itisi-center/public/certify/certificate-export/{{$app_no}}/en/pdf" target="_blank">ใบรับรอง (EN)</a></p>
                        <p>รายละเอียด : <a href="http://153.92.5.18/itisi-center/public/certify/certificate-export/{{$app_no}}/th/pdf/scope" target="_blank"></a>รายละเอียด (TH)</p>
                        <p style="margin-left: 70px"><a href="http://153.92.5.18/itisi-center/public/certify/certificate-export/{{$app_no}}/en/pdf/scope">รายละเอียด (EN)</a></p>
                        <label>{!! Form::radio('checkStatusCertificate', '1', false, ['class'=>'checkCertificate'.$id, 'data-radio'=>'iradio_square-green']) !!} &nbsp;ยืนยันความถูกต้อง &nbsp;</label>
                        <label>{!! Form::radio('checkStatusCertificate', '2', false, ['class'=>'checkCertificate'.$id, 'data-radio'=>'iradio_square-red']) !!} &nbsp;แก้ไขข้อมูล &nbsp;</label>

                        <div id="view23{{$id}}" style="display: none;">
                            <p>รายละเอียด : <textarea name="remarkCertificate" id="remarkCertificate" cols="30" rows="3" class="form-control"></textarea></p>

                            <div class="col-md-12  form-group" style="margin-bottom: 10px;margin-top: 50px">
                                {!! Form::label('another_attach_files_del23', 'ไฟล์แนบอื่นๆ:', ['class' => 'm-t-5']) !!}
                                <button type="button" class="btn btn-sm btn-success m-l-10" id="attach_add_from_del23{{$id}}">
                                    <i class="icon-plus"></i>&nbsp;เพิ่ม
                                </button>
                                <div class="clearfix"></div>
                                <div id="another_attach_files_box_del23{{$id}}">
                                    <div class="form-group another_attach_files_del23{{$id}}">
                                        <div class="col-md-4">
                                            {!! Form::text('another_attach_name[]', null, ['class' => 'form-control m-t-10', 'placeholder' => 'ชื่อไฟล์']) !!}
                                        </div>
                                        <div class="col-md-6">
                                            <div class="fileinput fileinput-new input-group m-t-10" data-provides="fileinput">
                                                <div class="form-control" data-trigger="fileinput">
                                                    <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                                    <span class="fileinput-filename"></span>
                                                </div>
                                                <span class="input-group-addon btn btn-default btn-file">
                                        <span class="fileinput-new">เลือกไฟล์</span>
                                        <span class="fileinput-exists">เปลี่ยน</span>
                                            {!! Form::file('another_attach_files_del23[]', null) !!}
                                        </span>
                                                <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
                                            </div>
                                            {!! $errors->first('another_attach_files_del23', '<p class="help-block">:message</p>') !!}

                                        </div>
                                        <div class="col-md-2 text-left m-t-15" style="margin-top: 3px">
                                            <button class="btn btn-danger btn-sm another_attach_remove_del23{{$id}}" type="button">
                                                <i class="icon-close"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <input type="hidden" id="findCertiLab23" name="findCertiLab23" value="{{$token}}">
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
                <button type="submit" class="btn btn-success" >ส่ง</button>
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
            $('#attach_add_from_del23{{$id}}').click(function(event) {
                $('.another_attach_files_del23{{$id}}:first').clone().appendTo('#another_attach_files_box_del23{{$id}}');

                $('.another_attach_files_del23{{$id}}:last').find('input').val('');
                $('.another_attach_files_del23{{$id}}:last').find('a.fileinput-exists').click();
                $('.another_attach_files_del23{{$id}}:last').find('a.view-attach').remove();

                ShowHideRemoveBtn23{{$id}}();

            });

            //ลบไฟล์แนบ
            $('body').on('click', '.another_attach_remove_del23{{$id}}', function(event) {
                $(this).parent().parent().remove();
                ShowHideRemoveBtn23{{$id}}();
            });

            ShowHideRemoveBtn23{{$id}}();
        });

        function ShowHideRemoveBtn23{{$id}}() { //ซ่อน-แสดงปุ่มลบ

            if ($('.another_attach_files_del23{{$id}}').length > 1) {
                $('.another_attach_remove_del23{{$id}}').show();
            } else {
                $('.another_attach_remove_del23{{$id}}').hide();
            }

        }

        // $('#btn23').on('click',function () {
        //     $('#findCertiLab23').val($(this).attr('data-id'));
        //     $('#thCerti').empty();
        //     $('#enCerti').empty();
        //
        //     var pathTH = "http://127.0.0.1:8100/certify/certificate-export/"+$(this).attr('data-no')+'/th/pdf';
        //     var pathEN = "http://127.0.0.1:8100/certify/certificate-export/"+$(this).attr('data-no')+'/en/pdf';
        //
        //     console.log(pathTH);
        //     console.log(pathEN);
        //
        //     $('#thCerti').append('<a href="'+pathTH+'" target="_blank">ใบรับรอง (TH)</a>')
        //     $('#enCerti').append('<a href="'+pathEN+'" target="_blank">ใบรับรอง (EN)</a>')
        // });

        $('.checkCertificate{{$id}}').on('click',function () {
            console.log($(this).val());
            if ($(this).val() === "2"){
                $('#view23{{$id}}').fadeIn();
            }
            else {
                $('#view23{{$id}}').fadeOut();
            }
        })
    </script>

@endpush
