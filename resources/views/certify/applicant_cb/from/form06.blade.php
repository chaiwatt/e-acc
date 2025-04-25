
<div class="row form-group">
    <div class="col-md-12">
        <div class="white-box" style="border: 2px solid #e5ebec;">
            <legend><h4><span class="text-danger">*</span> 3. ขอบข่ายที่ยื่นขอรับการรับรอง (Scope of Accreditation Sought) 
                         <span class="text-danger">ไฟล์แนบ Word</span>
                         <span class="text-danger" style="font-size: 13px;"> (doc,docx)</span>
                         {{-- <span class="text-danger" style="font-size: 13px;"> ขนาดไฟล์ต้องไม่เกิน 4 MB</span> --}}
                    </h4>
            </legend>
                <div class="row hide_attach">
                    <div class="col-md-12 ">
                        <div id="other_attach-box3">
                            <div class="form-group other_attach_item3">
                                <div class="col-md-4 text-right">
                                    <label for="#" class="col-md-12 text-right label_other_attach">กรุณาแนบไฟล์ขอบข่ายที่ต้องการยื่นขอการรับรอง</label>       
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
                                            <input type="file" accept=".doc,.docx" name="attachs_sec3[]" class="attachs_sec3 check_max_size_file"    {{ (isset($certi_cb) && $certi_cb->FileAttach3->count() == 0 ) ? 'required' : ''}}>
                                        </span>
                                        <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
                                    </div>
                                    {!! $errors->first('attachs', '<p class="help-block">:message</p>') !!}
                                </div>
                                <div class="col-md-2 text-left">
                                    <button type="button" class="btn btn-sm btn-success attach-add3" id="attach-add3">
                                        <i class="icon-plus"></i>&nbsp;เพิ่ม
                                    </button>
                                    <div class="button_remove89"></div>
                                </div> 
                             </div>
                           </div>
                     </div>
                </div>

                <div class="clearfix"></div>
                @if (isset($certi_cb) && $certi_cb->FileAttach3->count() > 0)
                <div class="row">
                    @foreach($certi_cb->FileAttach3 as $data)
                      @if ($data->file)
                       <div class="col-md-12" id="deleteFlie{{$data->id}}">
                            <div class="form-group">
                                <div class="col-md-4 text-light"> </div>
                                <div class="col-md-6 text-light">
                                    <a href="{{url('certify/check/file_cb_client/'.$data->file.'/'.( !empty($data->file_client_name) ? $data->file_client_name :   basename($data->file) ))}}" target="_blank">
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
        
      </div>  
    </div>
</div>
@push('js')

<script>

    $(document).ready(function () {

        AttachFile3();
        check_max_size_file();
        //เพิ่มไฟล์แนบ
        $('#attach-add3').click(function(event) {
            $('.other_attach_item3:first').clone().appendTo('#other_attach-box3');
            $('.other_attach_item3:last').find('input').val('');
            $('.other_attach_item3:last').find('a.fileinput-exists').click();
            $('.other_attach_item3:last').find('a.view-attach').remove();
            $('.other_attach_item3:last').find('.label_other_attach').remove();
            $('.other_attach_item3:last').find('button.attach-add3').remove();
            $('.other_attach_item3:last').find('.button_remove89').html('<button class="btn btn-danger btn-sm attach-remove3" type="button"> <i class="icon-close"></i>  </button>');
            AttachFile3();
            check_max_size_file();
        });
        
        //ลบไฟล์แนบ
        $('body').on('click', '.attach-remove3', function(event) {
            $(this).parent().parent().parent().remove();
        });

    });


            //  Attach File
        function  AttachFile3(){
            $('.attachs_sec3').change( function () {
                    var fileExtension = ['docx','doc'];
                    if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1 && $(this).val() != '') {
                        Swal.fire(
                        'ไม่ใช่หลักฐานประเภทไฟล์ที่อนุญาต .doc หรือ .docx',
                        '',
                        'info'
                        )
                    this.value = '';
                    return false;
                    }
                });
        }

        function  CheckFile(){
            $('.check_max_size_file').bind('change', function() {
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
