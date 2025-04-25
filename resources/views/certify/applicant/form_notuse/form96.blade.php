<div class="row form-group">
    <div class="col-md-12">
        <div class="white-box" style="border: 2px solid #e5ebec;">
            <legend><h4>10. เอกสารอื่นๆ (Others)  
                 {{-- <span class="text-danger" style="font-size: 13px;"> ขนาดไฟล์ต้องไม่เกิน 4 MB</span> --}}
            </h4></legend>
    <div class="row">
       <div class="col-md-12 form-group" style="margin-bottom: 10px">

                <div id="another_attach_files-box">
                    <div class="form-group another_attach_files">
                        <div class="col-md-4 text-light">
                            {!! Form::text('another_attach_files_desc[]', null, ['class' => 'form-control', 'placeholder' => 'กรุณากรอกชื่อไฟล์']) !!}
                        </div>
                        <div class="col-md-6">
                            <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                <div class="form-control" data-trigger="fileinput">
                                    <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                    <span class="fileinput-filename"></span>
                                </div>
                                <span class="input-group-addon btn btn-default btn-file">
                                    <span class="fileinput-new">เลือกไฟล์</span>
                                    <span class="fileinput-exists">เปลี่ยน</span>
                                    <input type="file" name="another_attach_files[]" class="check_max_size_file">
                                </span>
                                <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-sm btn-success another_attach-add" id="another_attach-add">
                                <i class="icon-plus"></i>&nbsp;เพิ่ม
                            </button>
                            <div class="button_remove_files"></div>
                        </div>
                    </div>
                </div>

            </div>
       </div>

       </div>
   </div>
</div>

<div class="row form-group">
    <div class="col-md-12">
        <div class="checkbox checkbox-success">
            <input id="checkbox_confirm" class="checkbox_confirm" type="checkbox" name="checkbox_confirm"  required
                   value="1" >
            <label for="checkbox_confirm"> &nbsp; ห้องปฏิบัติการทดสอบและสอบเทียบขอรับรองว่า (LAB hereby affirms certify that)
                <button type="button" class="btn btn-link" data-toggle="modal" data-target="#myModal"><b>คลิก</b> </button>
            </label>
        </div>
    </div>
</div>


        <div class="col-md-12 text-center">
                <div id="status_btn"></div>
                <button type="button"class="btn btn-default m-l-5" value="ส่งข้อมูล"  name="save" onclick="submit_form('1');return false" disabled>ส่งข้อมูล</button>
                <button type="button" class="btn btn-warning text-white m-l-5" id="draft" name="draft" value="ฉบับร่าง" onclick="submit_form_draft('0');return false">ฉบับร่าง</button>
                <a href="{{url('certify/applicant')}}" class="btn btn-danger text-white m-l-5" id="cancel_edit_calibrate">ยกเลิก</a>
        </div>

@push('js')
<script src="{{asset('plugins/components/sweet-alert2/sweetalert2.all.min.js')}}"></script>
    <script src="{{asset('js/jasny-bootstrap.js')}}"></script>
    <script>
        $(document).ready(function () {
          check_max_size_file();
            //เพิ่มไฟล์แนบ
            $('#another_attach-add').click(function(event) {
                $('.another_attach_files:first').clone().appendTo('#another_attach_files-box');
                $('.another_attach_files:last').find('input').val('');
                $('.another_attach_files:last').find('a.fileinput-exists').click();
                $('.another_attach_files:last').find('a.view-attach').remove();
                $('.another_attach_files:last').find('.label_attach').remove();
                $('.another_attach_files:last').find('button.another_attach-add').remove();
                $('.another_attach_files:last').find('.button_remove_files').html('<button class="btn btn-danger btn-sm another_attach_remove" type="button"> <i class="icon-close"></i>  </button>');
                // ShowHideRemoveBtn();
                check_max_size_file();
            });

            //ลบไฟล์แนบ
            $('body').on('click', '.another_attach_remove', function(event) {
                $(this).parent().parent().parent().remove();
                // ShowHideRemoveBtn();
            });

            $('#checkbox_confirm').click(function(){
                $('button[name="save"]').toggleClass('btn-primary btn-default', 'btn-default btn-primary');
                    if($(this).prop('checked')){
                        $('button[name="save"]').attr('disabled',false);
                    }else{
                        $('button[name="save"]').attr('disabled',true);
                    }
            });

            // ShowHideRemoveBtn();
        });

        // function ShowHideRemoveBtn() { //ซ่อน-แสดงปุ่มลบ

        //     if ($('.another_attach_files').length > 1) {
        //         $('.another_attach_remove').show();
        //     } else {
        //         $('.another_attach_remove').hide();
        //     }

        // }
    </script>
    <script>
        function submit_form(status) {

            var  number =  1;
                var max_size = "{{ ini_get('post_max_size') }}";
                var res = max_size.replace("M", "");
                $('#app_certi_form').find('input[type="file"]').each(function(index, el) {
                       if(checkNone($(el).val()) && $(el).prop("tagName")=="INPUT" && $(el).prop("type")=="file"   ){
                          number +=  (el.files[0].size /1024/1024);
                       }
                 });

            var row = $("input[name=lab_ability]:checked").val();
            if(row == 'test'){ // ห้องปฏิบัติการ (ทดสอบ)
                var test_scope_branch_id = $(".test_scope_branch_id").length;
                if(test_scope_branch_id > 0){
                        if(number < res){
                             $('#status_btn').html('<input type="text" name="save" value="' + status + '" hidden>');
                             $('#app_certi_form').submit();
                        }else{
                            Swal.fire(
                                'ขนาดไฟล์รวม '+number.toFixed(2)+' MB ไม่สามารถบันทึกได้ ต้องไม่เกิน ' + res + ' MB',
                                '',
                                'warning'
                              )
                         }
                }else{
                    Swal.fire(
                        'กรุณาเลือก ขอบข่ายที่ยื่นขอรับการรับรองห้องปฏิบัติการ (ทดสอบ)',
                        '',
                        'info'
                     )
                }
            }else{  //ห้องปฏิบัติการ (สอบเทียบ)
                var calibrate_branch_id = $(".calibrate_branch_id").length;
                if(calibrate_branch_id > 0){
                       if(number < res){
                            $('#status_btn').html('<input type="text" name="save" value="' + status + '" hidden>');
                             $('#app_certi_form').submit();
                        }else{
                            Swal.fire(
                                'ขนาดไฟล์รวม '+number.toFixed(2)+' MB ไม่สามารถบันทึกได้ ต้องไม่เกิน ' + res + ' MB',
                                '',
                                'warning'
                              )
                         }
                }else{
                    Swal.fire(
                        'กรุณาเลือก อบข่ายที่ยื่นขอรับการรับรองห้องปฏิบัติการ (สอบเทียบ)',
                        '',
                        'info'
                     )
                }
            }
        }
        //ฉบับร่าง
        function  submit_form_draft(status){
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
                            $('#status_btn').html('<input type="text" name="draft" value="' + status + '" hidden>');
                            $('#app_certi_form').submit();
                        }else{
                                Swal.fire(
                                            'ขนาดไฟล์รวม '+number.toFixed(2)+' MB ไม่สามารถบันทึกได้ ต้องไม่เกิน ' + res + ' MB',
                                            '',
                                            'warning'
                                         )
                        }
                    }
                })
        }
          //Validate
         $('#app_certi_form').parsley().on('field:validated', function() {
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
        </script>
@endpush
