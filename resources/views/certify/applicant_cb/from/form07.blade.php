<div class="row form-group">
    <div class="col-md-12">
        <div class="white-box" style="border: 2px solid #e5ebec;">
            <legend><h4>
                4. เอกสารอื่นๆ (Others)    
                {{-- <span class="text-danger" style="font-size: 13px;"> ขนาดไฟล์ต้องไม่เกิน 4 MB</span> --}}
            </h4></legend>
            <div class="row ">
                <div class="col-md-12 form-group" style="margin-bottom: 10px">
                        @if (isset($certi_cb) && $certi_cb->FileAttach4->count() > 0)
                        <div class="row">
                            @foreach($certi_cb->FileAttach4 as $data)
                            @if ($data->file)
                                <div class="col-md-12" id="deleteFlie{{$data->id}}">
                                    <div class="form-group">
                                        <div class="col-md-4 text-light"> </div>
                                        <div class="col-md-6 text-light">
                                            {{  @$data->file_desc }}
                                            <a href="{{url('certify/check/file_cb_client/'.$data->file.'/'.( !empty($data->file_client_name) ? $data->file_client_name :  basename($data->file)  ))}}" target="_blank">
                                                    {{  !empty($data->file_client_name) ? $data->file_client_name :  basename($data->file)   }}
                                            </a>
                                        </div>
                                        <div class="col-md-2 text-left">
                                            <button class="hide_attach btn btn-danger btn-sm"  type="button"  onclick="deleteFlie({{ $data->id }})">
                                                <i class="icon-close"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            @endforeach
                        </div>
                        @endif
                        <div id="other_attach-box7" class="hide_attach">  </div>
                         <div class="form-group other_attach_item7 hide_attach">
                                 <div class="col-md-5  text-light">
                                    {!! Form::text('attachs_text4[]', null, ['class' => 'form-control', 'placeholder' => 'ระบุชื่อเอกสาร']) !!}
                                 </div>
                                 <div class="col-md-5">
                                     <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                         <div class="form-control" data-trigger="fileinput">
                                             <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                             <span class="fileinput-filename"></span>
                                         </div>
                                         <span class="input-group-addon btn btn-default btn-file">
                                             <span class="fileinput-new">เลือกไฟล์</span>
                                             <span class="fileinput-exists">เปลี่ยน</span>
                                             <input type="file" name="attachs_sec4[]" class="check_max_size_file">
                                         </span>
                                         <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
                                     </div>
                                 </div>
                                 <div class="col-md-2">
                                     <button type="button" class="btn btn-sm btn-success attach-add7" id="attach-add7">
                                         <i class="icon-plus"></i>&nbsp;เพิ่ม
                                     </button>
                                     <div class="button_remove7"></div>
                                 </div>
                         </div>

                   </div>
            </div>




      </div>
   </div>
</div>


@if (isset($certi_cb) && !is_null($certi_cb->desc_delete))
<div class="row form-group">
    <div class="col-md-12">
        <div class="white-box" style="border: 2px solid #e5ebec;">
            <legend><h4>ยกเลิกคำขอ</h4></legend>

            <div class="col-md-12">
                <div class="col-md-4 text-right"> สาเหตุ :</div>
                <div class="col-md-6 text-light">
                        <p> {{  !empty($certi_cb->desc_delete)  ? $certi_cb->desc_delete : '-' }}</p>
                </div>
            </div>

            <div class="clearfix"></div>
            @if (isset($certi_cb) && $certi_cb->FileAttach5->count() > 0)
            <div class="row">
                @foreach($certi_cb->FileAttach5 as $data)
                  @if ($data->file)
                    <div class="col-md-12 form-group">
                        <div class="col-md-4 text-light"> </div>
                        <div class="col-md-6 text-light">
                                {{  @$data->file_desc }}
                                <a href="{{url('certify/check/file_cb_client/'.$data->file.'/'.( !empty($data->file_client_name) ? $data->file_client_name :  basename($data->file)  ))}}" target="_blank">
                                        {{  !empty($data->file_client_name) ? $data->file_client_name :  basename($data->file)   }}
                                </a>
                        </div>
                    </div>
                    @endif
                 @endforeach
              </div>
            @endif

      </div>
   </div>
</div>
@endif

<div class="row form-group">
    <div class="col-md-12">
        <div class="checkbox checkbox-success">
            <input id="checkbox_confirm" class="checkbox_confirm" type="checkbox" name="checkbox_confirm"  required
                   value="1"  {{ (isset($certi_cb) && $certi_cb->checkbox_confirm  == 1) ? 'checked': '' }}>
            <label for="checkbox_confirm"> &nbsp;  หน่วยรับรองขอรับรองว่า (CB hereby affirms certify that)
                <button type="button" class="btn btn-link" data-toggle="modal" data-target="#myModal"><b>คลิก</b> </button>
            </label>
        </div>
    </div>
</div>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog  modal-lg" role="document">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-body">
          <p>
            {{-- - ข้อมูลตามที่ระบุไว้ในคำขอ รวมทั้งเอกสารและหลักฐานที่แนบประกอบการพิจารณาทั้งหมดเป็นความจริง
            (All information as specified in the application forms, including the documents and evidences attached are true) --}}
            (1) ข้าพเจ้ารับทราบและให้คำมั่นจะปฏิบัติตามพระราชบัญญัติการมาตรฐานแห่งชาติ พ.ศ. 2551 รวมถึงกฎกระทรวง ประกาศ หลักเกณฑ์ วิธีการ และเงื่อนไข มาตรฐานข้อกำหนดสำหรับการรับรองระบบงาน ข้อกำหนดอื่น ๆ และ/หรือ ที่จะมีการกำหนด แก้ไขเพิ่มเติมในภายหลังด้วย 
            <br>
            I have acknowledged and committed to continually fulfil the requirements for accreditation and the other obligations of the conformity assessment body, and to comply with National Standardization Act, B.E.2551 (2008) including ministerial regulations, notification, criteria methods and conditions according to the act, standard requirement, conditions determined by TISI and/or any changes in future
          </p>
          <p>
            {{-- - จะปฏิบัติตามหลักเกณฑ์ วิธีการ และเงื่อนไขในการรับรองระบบงานที่เกี่ยวข้อง รวมทั้งที่อาจมีการแก้ไข หรือกำหนดเพิ่มเติมในภายหลัง
            (CB shall perform according to the criteria methods and conditions relevant for accreditation including those that may be corrected or added afterwards) --}}
            (2) ข้าพเจ้าจะชำระค่าธรรมเนียมคำขอรับใบรับรองและใบรับรองทันทีที่ได้รับใบแจ้งการชำระเงินจากสำนักงานมาตรฐานผลิตภัณฑ์อุตสาหกรรม 
            <br>
            I will pay application fee, and certificate document fee upon receiving the Pay-in Slip from TISI without delays.
          </p>
        </div>
      </div>
    </div>
  </div>
@push('js')
    <script src="{{asset('js/jasny-bootstrap.js')}}"></script>
    <script>
        $(document).ready(function () {
         
           
            //เพิ่มไฟล์แนบ
            $('#attach-add7').click(function(event) {
                $('#other_attach-box7').append($('.other_attach_item7:first').clone());
                let row =  $('#other_attach-box7').find('.other_attach_item7:last');
                row.find('input').val('');
                row.find('a.fileinput-exists').click();
                row.find('a.view-attach').remove();
                row.find('.label_attach').remove();
                row.find('button.attach-add7').remove();
                row.find('.button_remove7').html('<button class="btn btn-danger btn-sm attach-remove7" type="button"> <i class="icon-close"></i>  </button>');
                check_max_size_file();
            });

            //ลบไฟล์แนบ
            $('body').on('click', '.attach-remove7', function(event) {
                $(this).parent().parent().parent().remove();
            });

            $('#checkbox_confirm').click(function(){
                $('#send_data').toggleClass('btn-primary btn-default', 'btn-default btn-primary');
                    if($(this).prop('checked')){
                        $('#send_data').attr('disabled',false);
                    }else{
                        $('#send_data').attr('disabled',true);
                    }
            });

        });
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
                Swal.fire({
                    title: 'ยืนยันการทำรายงาน !',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'บันทึก',
                    cancelButtonText: 'ยกเลิก'
                    }).then((result) => {
                        if (result.value) {
                            console.log(number);
                            if(number < res){
                                    $('#status_btn').html('<input type="text" name="status" value="' + status + '" hidden>');
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
                            console.log(number);
                            if(number < res){
                                $('#checkbox_confirm').attr('required',false);
                                $('#status_btn').html('<input type="text" name="status" value="' + status + '" hidden>');
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

                function  deleteFlie(id){

                Swal.fire({
                        icon: 'error',
                        title: 'ยื่นยันการลบไฟล์แนบ !',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'บันทึก',
                        cancelButtonText: 'ยกเลิก'
                        }).then((result) => {
                            if (result.value) {
                            $.ajax({
                                    url: "{!! url('certify/certi_cb/delete_file') !!}"  + "/" + id
                                }).done(function( object ) {
                                    if(object == 'true'){
                                        $('form').find('#deleteFlie'+id).remove();
                                    }else{
                                        Swal.fire('ข้อมูลผิดพลาด');
                                    }
                                });

                            }
                        })
               }
               function checkNone(value) {
                      return value !== '' && value !== null && value !== undefined;
                 }

            </script>
@endpush
