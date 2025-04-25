<div class="row form-group">
    <div class="col-md-12">
        <div class="white-box" style="border: 2px solid #e5ebec;">
            <legend><h4>10. เอกสารอื่นๆ (Others)   
                {{-- <span class="text-danger" style="font-size: 13px;"> ขนาดไฟล์ต้องไม่เกิน 4 MB</span> --}}
            </h4></legend>
            <div class="row">
                <div class="col-md-12 form-group" style="margin-bottom: 10px">
                        <div id="another_attach_files-box">   </div>
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

            <div class="clearfix"></div>
            @if ($certi_lab_attach_more->count() > 0)
            <div class="row">
                @foreach($certi_lab_attach_more as $data)
                @if ($data->file)
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="col-md-4 text-light">
                              
                            </div>
                            <div class="col-md-6 text-light">
                                {{  @$data->file_desc }}
                                <a href="{{url('certify/check/file_client/'.$data->file.'/'.( !is_null($data->file_client_name) ? $data->file_client_name : basename($data->file)  ))}}" target="_blank">
                                    {!! HP::FileExtension($data->file)  ?? '' !!}
                                    {{  !empty($data->file_client_name) ? $data->file_client_name :  basename($data->file)   }}
                                </a>
                            </div>
                            <div class="col-md-2 text-left">
                                <a href="{{url('certify/applicant/delete/file_certiLab_more').'/'.basename($data->file).'/'.$data->token}}" class="btn btn-danger btn-xs" 
                                    onclick="return confirm('ต้องการลบไฟล์นี้ใช่หรือไม่ ?')" >
                                    <i class="fa fa-remove"></i>
                                </a>
                            </div> 
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>
            @endif
      </div>
   </div>
</div>

<div class="row form-group">
    <div class="col-md-12">
        <div class="checkbox checkbox-success">
            <input id="checkbox_confirm" class="checkbox_confirm" type="checkbox" name="checkbox_confirm"  required
                   value="1"  {{ (isset($certi_lab) && $certi_lab->checkbox_confirm  == 1) ? 'checked': '' }}>
            <label for="checkbox_confirm"> &nbsp;    ห้องปฏิบัติการทดสอบและสอบเทียบขอรับรองว่า (LAB hereby affirms certify that) 
                <button type="button" class="btn btn-link" data-toggle="modal" data-target="#myModal"><b>คลิก</b> </button>
            </label>
        </div>
    </div>
</div>


<div class="col-md-12 text-center">
    <div id="status_btn"></div>
      <button type="button"class="btn btn-primary m-l-5" onclick="submit_form('1');return false">ส่งข้อมูล</button>
      @if($certi_lab->status == 0)
         <button   type="button" class="btn btn-warning text-white m-l-5 " onclick="submit_form_draft('0');return false">ฉบับร่าง</button>
      @endif
      <a href="{{url('certify/applicant')}}" class="btn btn-danger text-white m-l-5" id="cancel_edit_calibrate">ยกเลิก</a>
</div>
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog  modal-lg" role="document">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-body">
 
          <p>
            {{-- - ข้อมูลตามที่ระบุไว้ในคำขอรวมทั้งเอกสารและหลักฐานที่แนบประกอบการพิจารณาทั้งหมดเป็นความจริง <br>
                (All information as specified in the application forms, including the documents and evidences attached are true) --}}
                (1) ข้าพเจ้ารับทราบและให้คำมั่นจะปฏิบัติตามพระราชบัญญัติการมาตรฐานแห่งชาติ พ.ศ. 2551 รวมถึงกฎกระทรวง ประกาศ หลักเกณฑ์ วิธีการ และเงื่อนไข มาตรฐานข้อกำหนดสำหรับการรับรองระบบงาน ข้อกำหนดอื่น ๆ และ/หรือ ที่จะมีการกำหนด แก้ไขเพิ่มเติมในภายหลังด้วย 
                <br>
                I have acknowledged and committed to continually fulfil the requirements for accreditation and the other obligations of the conformity assessment body, and to comply with National Standardization Act, B.E.2551 (2008) including ministerial regulations, notification, criteria methods and conditions according to the act, standard requirement, conditions determined by TISI and/or any changes in future
          </p>
          <p>
             {{-- - จะปฏิบัติตามหลักเกณฑ์ วิธีการ และเงื่อนไขในการรับรองระบบงานที่เกี่ยวข้องรวมทั้งที่อาจมีการแก้ไขหรือกำหนดเพิ่มเติมในภายหลัง
                (LAB shall perform according to the criteria methods and conditions relevant for accreditation including those that may be corrected or added afterwards) --}}
                (2) ข้าพเจ้าจะชำระค่าธรรมเนียมคำขอรับใบรับรองและใบรับรองทันทีที่ได้รับใบแจ้งการชำระเงินจากสำนักงานมาตรฐานผลิตภัณฑ์อุตสาหกรรม 
                <br>
                I will pay application fee, and certificate document fee upon receiving the Pay-in Slip from TISI without delays.
          </p>
        </div>
      </div>
    </div>
  </div>
@push('js')
<script src="{{asset('plugins/components/sweet-alert2/sweetalert2.all.min.js')}}"></script>
    <script src="{{asset('js/jasny-bootstrap.js')}}"></script>
    <script>
        $(document).ready(function () {
             check_max_size_file();
            //เพิ่มไฟล์แนบ
            $('#another_attach-add').click(function(event) {
                $('#another_attach_files-box').append($('.another_attach_files:first').clone());
                let row =  $('#another_attach_files-box').find('.another_attach_files:last');
                row.find('input').val('');
                row.find('a.fileinput-exists').click();
                row.find('a.view-attach').remove();
                row.find('.label_attach').remove();
                row.find('button.another_attach-add').remove();
                row.find('.button_remove_files').html('<button class="btn btn-danger btn-sm another_attach_remove" type="button"> <i class="icon-close"></i>  </button>');
                check_max_size_file();
            });

            //ลบไฟล์แนบ
            $('body').on('click', '.another_attach_remove', function(event) {
                $(this).parent().parent().parent().remove();
            });

        });
    </script>  
        <script>
            function submit_form(status) {
                var row = $("input[name=lab_type]:checked").val();
                if(row == '3'){ // ห้องปฏิบัติการ (ทดสอบ)
                    var test_scope_branch_id = $(".test_scope_branch_id").length;
                    if(test_scope_branch_id > 0){
                        $('#status_btn').html('<input type="text" name="save" value="' + status + '" hidden>');
                         $('#app_certi_form').submit();
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
                        $('#status_btn').html('<input type="text" name="save" value="' + status + '" hidden>');
                         $('#app_certi_form').submit();
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
                            $('#status_btn').html('<input type="text" name="draft" value="' + status + '" hidden>');
                            $('#app_certi_form').submit();
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