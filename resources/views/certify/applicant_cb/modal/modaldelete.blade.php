<!-- Modal เลข 4 Delete -->
<div class="modal fade" id="modalDelete{{$id}}" tabindex="-1" role="dialog" aria-labelledby="addBrand">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel1">ยกเลิกคำขอ</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            {!! Form::open(['url' => 'certify/certi_cb/update_delete', 
                            'class' => 'form-horizontal',
                            'files' => true]) !!}

            <div class="modal-body">
                <input  type="hidden" name="token"  value="{{ $token ?? null}}">
                <label for="reason"><span class="text-danger">*</span> ระบุเหตุผล :</label>
                <textarea name="reason" id="reason" cols="30" rows="5" class="form-control" required></textarea>
                <div class="clearfix"></div>
                <div class="col-md-12  form-group" style="margin-bottom: 10px;margin-top: 50px">
                    {!! Form::label('another_attach_files_del', 'ไฟล์แนบอื่นๆ:', ['class' => 'm-t-5']) !!}
                    <button type="button" class="btn btn-sm btn-success m-l-10" id="attach_add_from_cb{{$id}}">
                        <i class="icon-plus"></i>&nbsp;เพิ่ม
                    </button>
                    <div class="clearfix"></div>
                    <div id="another_attach_files_box_cb{{$id}}">
                        <div class="form-group another_attach_files_cb{{$id}}">
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
                                            {!! Form::file('another_attach_files_del[]', null) !!}
                                        </span>
                                    <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
                                </div>
                                {!! $errors->first('another_attach_files_del', '<p class="help-block">:message</p>') !!}

                            </div>
                            <div class="col-md-2 text-left m-t-15" style="margin-top: 3px">
                                <div class="another_attach_cb{{$id}}"></div>
                                {{-- <button class="btn btn-danger btn-sm another_attach_remove_del{{$id}}" type="button"> <i class="icon-close"></i></button> --}}
                            </div>
                        </div>
                    </div>
                </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
                <button type="submit" class="btn btn-success" >บันทึก</button>
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
                $('#attach_add_from_cb{{$id}}').click(function(event) {

                    $('.another_attach_files_cb{{$id}}:first').clone().appendTo('#another_attach_files_box_cb{{$id}}');

                    $('.another_attach_files_cb{{$id}}:last').find('input').val('');
                    $('.another_attach_files_cb{{$id}}:last').find('a.fileinput-exists').click();
                    $('.another_attach_files_cb{{$id}}:last').find('a.view-attach').remove();
                    $('.another_attach_files_cb{{$id}}:last').find('.another_attach_cb{{$id}}').html('<button class="btn btn-danger btn-sm another_attach_remove_cb{{$id}}" type="button"> <i class="icon-close"></i>  </button>');
                    ShowHideRemoveBtn();

                });

                //ลบไฟล์แนบ
                $('body').on('click', '.another_attach_remove_cb{{$id}}', function(event) {
                    $(this).parent().parent().parent().remove();
                    ShowHideRemoveBtn();
                });

                ShowHideRemoveBtn();
            });

            function ShowHideRemoveBtn() { //ซ่อน-แสดงปุ่มลบ
     
                if ($('.another_attach_files_cb{{$id}}').length > 1) {
                    $('.another_attach_remove_cb{{$id}}').show();
                } else {
                    $('.another_attach_remove_cb{{$id}}').hide();
                }

            }
        </script>

    @endpush
