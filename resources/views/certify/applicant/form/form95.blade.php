<?php $key95=0?>

<div class="row form-group">
    <div class="col-md-12">
        <div class="white-box" style="border: 2px solid #e5ebec;">
            <legend><h4><span class="text-danger">*</span> 9. การเข้าร่วมการทดสอบความชำนาญ / การเปรียบเทียบผลระหว่างห้องปฏิบัติการ (Participation in Proficiency testing program / Interlaboratory comparison)  
                 {{-- <span class="text-danger" style="font-size: 13px;"> ขนาดไฟล์ต้องไม่เกิน 4 MB</span> --}}
            </h4></legend>
        
           <div id="test_program_box">
            <div class="row">
                <div class="col-md-12 ">
                    <div id="other_attach-box9">
                        <div class="form-group other_attach_item9">
                            <div class="col-md-4 text-light">
                                {{-- {!! Form::text('attachs_desc9[]', null, ['class' => 'form-control m-t-10', 'placeholder' => 'ชื่อไฟล์']) !!} --}}
                            </div>
                            <div class="col-md-6">
                                <div class="fileinput fileinput-new input-group " data-provides="fileinput">
                                    <div class="form-control" data-trigger="fileinput">
                                        <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                        <span class="fileinput-filename"></span>
                                    </div>
                                    <span class="input-group-addon btn btn-default btn-file">
                                        <span class="fileinput-new">เลือกไฟล์</span>
                                        <span class="fileinput-exists">เปลี่ยน</span>
                                        {{-- {!! Form::file('attachs_sec9[]', null) !!} --}}
                                        <input type="file" name="attachs_sec9[]" class="attachs_sec9 check_max_size_file"    required>
                                    </span>
                                    <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
                                </div>
                                {!! $errors->first('attachs_sec9', '<p class="help-block">:message</p>') !!}
                            </div>
                            <div class="col-md-2 text-left">
                                <button type="button" class="btn btn-sm btn-success attach-add9" id="attach-add9">
                                    <i class="icon-plus"></i>&nbsp;เพิ่ม
                                </button>
                                <div class="button_remove95"></div>
                            </div> 
                        </div>
                    </div>
                </div>
             </div>
           </div>
        </div>
    </div>
</div>
@push('js')

    <script>
        $(document).ready(function () {
            //เพิ่มไฟล์แนบ
            $('#attach-add9').click(function(event) {
                $('.other_attach_item9:first').clone().appendTo('#other_attach-box9');

                $('.other_attach_item9:last').find('input').val('');
                $('.other_attach_item9:last').find('a.fileinput-exists').click();
                $('.other_attach_item9:last').find('a.view-attach').remove();
                $('.other_attach_item9:last').find('button.attach-add9').remove();
                $('.other_attach_item9:last').find('.button_remove95').html('<button class="btn btn-danger btn-sm attach-remove9" type="button"> <i class="icon-close"></i>  </button>');
                // ShowHideRemoveBtn95();
                check_max_size_file();
            });

            //ลบไฟล์แนบ
            $('body').on('click', '.attach-remove9', function(event) {
                $(this).parent().parent().parent().remove();
                // ShowHideRemoveBtn95();
            });

            // ShowHideRemoveBtn95();
        });

        // function ShowHideRemoveBtn95() { //ซ่อน-แสดงปุ่มลบ

        //     if ($('.other_attach_item9').length > 1) {
        //         $('.attach-remove9').show();
        //     } else {
        //         $('.attach-remove9').hide();
        //     }

        // }
    </script>
    <script>
        $(document).ready(function () {

            //เพิ่มตำแหน่งงาน
            $('#test_program_add').click(function() {

                let newBox = $('#test_program_box').children(':first').clone(); //Clone Element
                newBox.find('input.mydatepicker').datepicker({
                    autoclose: true,
                    todayHighlight: true,
                    format: 'dd/mm/yyyy',
                    orientation: 'bottom'
                });
                newBox.find('input').val('');
                newBox.appendTo('#test_program_box');

                var last_new = $('#test_program_box').children(':last');
                {!! $key95+=1 !!}
                //Change Button
                $(last_new).find('button').removeClass('btn-success');
                $(last_new).find('button').addClass('btn-danger test_program_remove');
                $(last_new).find('button').html('<i class="icon-close"></i> ลบ');
                reOrderTestProgram();

            });

            //ลบตำแหน่ง
            $('body').on('click', '.test_program_remove', function() {

                $(this).parent().parent().parent().parent().remove();

                reOrderTestProgram();

            });


        });


    </script>
@endpush
