<?php $key92=0?>
<div id="viewForm92" style="display: none">
    <div class="row form-group">
        <div class="col-md-12">
            <div class="white-box" style="border: 2px solid #e5ebec;">
                <legend><h4><span class="text-danger">*</span> 7.เครื่องมือ (Equipment) 
                      {{-- <span class="text-danger" style="font-size: 13px;"> ขนาดไฟล์ต้องไม่เกิน 4 MB</span> --}}
                    </h4></legend>

                <input type="hidden" name="calibrateAddSize" id="calibrateAddSize" value="1">
                <div id="other_attach-box72">
                    <div class="form-group other_attach_item72">
                        <div class="col-md-4  text-light">
                        {!! Form::label('attachs_sec72', 'กรุณาแนบไฟล์เครื่องมือ', ['class' => 'col-md-12 label_attach text-light  control-label ']) !!}
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
                                    <input type="file" name="attachs_sec72[]" class="attachs_sec72 check_max_size_file">
                                </span>
                                <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
                            </div>
                        </div>

                        <div class="col-md-2" >
                            <button type="button" class="btn btn-sm btn-success attach-add72" id="attach-add72">
                                <i class="icon-plus"></i>&nbsp;เพิ่ม
                            </button>
                            <div class="button_remove72"></div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                @if ($certi_lab_attach_all72->count() > 0)
                <div class="row">
                    @foreach($certi_lab_attach_all72 as $data)
                      @if ($data->file)
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="col-md-4 text-light"> </div>
                                <div class="col-md-6 text-light">
                                    <a href="{{url('certify/check/file_client/'.$data->file.'/'.( !is_null($data->file_client_name) ? $data->file_client_name : basename($data->file)  ))}}" target="_blank">
                                           {!! HP::FileExtension($data->file)  ?? '' !!}
                                           {{  !empty($data->file_client_name) ? $data->file_client_name :  basename($data->file)   }}
                                    </a>
                                </div>
                                <div class="col-md-2 text-left">
                                    <a href="{{url('certify/applicant/delete/file_certiLab').'/'.basename($data->file).'/'.$data->token}}" class="btn btn-danger btn-xs" 
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
</div>
@push('js')
    <script>

        $(document).ready(function () {
            //เพิ่มไฟล์แนบ
            $('#attach-add72').click(function(event) {
                $('.other_attach_item72:first').clone().appendTo('#other_attach-box72');
                $('.other_attach_item72:last').find('input').val('');
                $('.other_attach_item72:last').find('a.fileinput-exists').click();
                $('.other_attach_item72:last').find('a.view-attach').remove();
                $('.other_attach_item72:last').find('.label_attach').remove();
                $('.other_attach_item72:last').find('button.attach-add72').remove();
                $('.other_attach_item72:last').find('.button_remove72').html('<button class="btn btn-danger btn-sm attach-remove72" type="button"> <i class="icon-close"></i>  </button>');
                check_max_size_file();
            });

            //ลบไฟล์แนบ
            $('body').on('click', '.attach-remove72', function(event) {
                $(this).parent().parent().parent().remove();
            });
        });

    </script>

@endpush