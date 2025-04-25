<div class="row form-group">
    <div class="col-md-12">
        <div class="white-box" style="border: 2px solid #e5ebec;">
            <legend><h4> 
                        2. คู่มือคุณภาพและขั้นตอนการดำเนินงานของหน่วยงานตรวจสอบที่สอดคล้องตามข้อกำหนดมาตรฐานเลขที่ มอก.17020 (Inspection body implementations which are conformed with TIS 17020)
                          {{-- <span class="text-danger" style="font-size: 13px;"> ขนาดไฟล์ต้องไม่เกิน 4 MB</span> --}}
                   </h4>
             </legend>

            <div class="row hide_attach">
                <div class="col-md-12 ">
                    <div id="other_attach-box">
                        <div class="form-group other_attach_item">
                            <div class="col-md-4 text-light">
                                {{-- {!! Form::text('attach_filenames[]', null, ['class' => 'form-control m-t-10', 'placeholder' => 'ชื่อไฟล์']) !!} --}}
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
                                        <input type="file"  name="attachs_sec1[]" class="check_max_size_file">
                                    </span>
                                    <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
                                </div>
                                {!! $errors->first('attachs', '<p class="help-block">:message</p>') !!}
                            </div>
                            <div class="col-md-2 text-left">
                                <button type="button" class="btn btn-sm btn-success attach-add" id="attach-add">
                                    <i class="icon-plus"></i>&nbsp;เพิ่ม
                                </button>
                                <div class="button_remove88"></div>
                            </div> 
                         </div>
                       </div>
                 </div>
            </div>
            <div class="clearfix"></div>
            @if (isset($certi_ib) && $certi_ib->FileAttach1->count() > 0)
            <div class="row">
                @foreach($certi_ib->FileAttach1 as $data)
                  @if ($data->file)
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="col-md-4 text-light"> </div>
                            <div class="col-md-6 text-light">
                                <a href="{{url('certify/check/file_ib_client/'.$data->file.'/'.( !empty($data->file_client_name) ? $data->file_client_name :  basename($data->file)  ))}}" target="_blank">
                                    {!! HP::FileExtension($data->file)  ?? '' !!}
                                 {{  !empty($data->file_client_name) ? $data->file_client_name :  basename($data->file)   }}
                                </a>
                            </div>
                            <div class="col-md-2 text-left">
                                <a href="{{url('certify/certi_ib/delete/'.basename($data->file).'/'.$data->token)}}" class="hide_attach btn btn-danger btn-sm" 
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
@push('js')
    <script src="{{asset('js/jasny-bootstrap.js')}}"></script>
    <script>
        $(document).ready(function () {
            //เพิ่มไฟล์แนบ
            $('#attach-add').click(function(event) {
                $('.other_attach_item:first').clone().appendTo('#other_attach-box');
                $('.other_attach_item:last').find('input').val('');
                $('.other_attach_item:last').find('a.fileinput-exists').click();
                $('.other_attach_item:last').find('a.view-attach').remove();
                $('.other_attach_item:last').find('button.attach-add').remove();
                $('.other_attach_item:last').find('.button_remove88').html('<button class="btn btn-danger btn-sm attach-remove" type="button"> <i class="icon-close"></i>  </button>');
                check_max_size_file();
            });

            //ลบไฟล์แนบ
            $('body').on('click', '.attach-remove', function(event) {
                $(this).parent().parent().parent().remove();
            });

        });

    </script>
@endpush
