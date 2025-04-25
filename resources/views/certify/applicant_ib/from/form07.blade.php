
<div class="row form-group">
    <div class="col-md-12">
        <div class="white-box" style="border: 2px solid #e5ebec;">
            <legend><h4>
                <span class="text-danger">*</span> 5. เครื่องมือ (Equipment)   
                 {{-- <span class="text-danger" style="font-size: 13px;"> ขนาดไฟล์ต้องไม่เกิน 4 MB</span> --}}
            </h4></legend>
                <div class="row hide_attach">
                    <div class="col-md-12 ">
                        <div id="other_attach-box4">
                            <div class="form-group other_attach_item4">
                                <div class="col-md-4 text-light">
                                    <label for="#" class="col-md-12 text-right label_other_attach">ไฟล์แนบเครื่องมือ</label>
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
                                            <input type="file" name="attachs_sec4[]" class="check_max_size_file" {{ (isset($certi_ib) && $certi_ib->FileAttach4->count() == 0 ) ? '' : ''}}>
                                        </span>
                                        <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
                                    </div>
                                    {!! $errors->first('attachs', '<p class="help-block">:message</p>') !!}
                                </div>
                                <div class="col-md-2 text-left">
                                    <button type="button" class="btn btn-sm btn-success attach-add4" id="attach-add4">
                                        <i class="icon-plus"></i>&nbsp;เพิ่ม
                                    </button>
                                    <div class="button_remove89"></div>
                                </div>
                             </div>
                           </div>
                     </div>
                </div>

                <div class="clearfix"></div>
                @if (isset($certi_ib) && $certi_ib->FileAttach4->count() > 0)
                <div class="row">
                    @foreach($certi_ib->FileAttach4 as $data)
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
                                    <a href="{{url('certify/certi_ib/delete').'/'.basename($data->id).'/'.$data->token}}" class="hide_attach btn btn-danger btn-sm"
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

<script>

    $(document).ready(function () {
        //เพิ่มไฟล์แนบ
        $('#attach-add4').click(function(event) {
            $('.other_attach_item4:first').clone().appendTo('#other_attach-box4');
            $('.other_attach_item4:last').find('input').val('');
            $('.other_attach_item4:last').find('a.fileinput-exists').click();
            $('.other_attach_item4:last').find('a.view-attach').remove();
            $('.other_attach_item4:last').find('.label_other_attach').remove();
            $('.other_attach_item4:last').find('button.attach-add4').remove();
            $('.other_attach_item4:last').find('.button_remove89').html('<button class="btn btn-danger btn-sm attach-remove4" type="button"> <i class="icon-close"></i>  </button>');
            check_max_size_file();
        });

        //ลบไฟล์แนบ
        $('body').on('click', '.attach-remove4', function(event) {
            $(this).parent().parent().parent().remove();
        });

    });


</script>
@endpush
