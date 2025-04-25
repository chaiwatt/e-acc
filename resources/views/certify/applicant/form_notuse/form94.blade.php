<?php $key94=0?>
<div class="row form-group">
    <div class="col-md-12">
        <div class="white-box" style="border: 2px solid #e5ebec;">
            <legend><h4>8. วัสดุอ้างอิง/วัสดุอ้างอิงรับรอง (Reference material / certified reference material) 
                  {{-- <span class="text-danger" style="font-size: 13px;"> ขนาดไฟล์ต้องไม่เกิน 4 MB</span> --}}
            </h4></legend>

        <div id="material_ref_box">
            <div class="row">
                <div class="col-md-12 ">
                    <div id="other_attach-box8">
                        <div class="form-group other_attach_item8">
                            <div class="col-md-4 text-light">
                                {{-- {!! Form::text('attachs_desc8[]', null, ['class' => 'form-control m-t-10', 'placeholder' => 'ชื่อไฟล์']) !!} --}}
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
                                        {{-- {!! Form::file('attachs_sec8[]', null,['class'=>'check_max_size_file']) !!} --}}
                                        <input type="file" name="attachs_sec8[]"    class="check_max_size_file" >
                                    </span>
                                    <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
                                </div>
                                {!! $errors->first('attachs', '<p class="help-block">:message</p>') !!}
                            </div>
                            <div class="col-md-2 text-left">
                                <button type="button" class="btn btn-sm btn-success attach-add8" id="attach-add8">
                                    <i class="icon-plus"></i>&nbsp;เพิ่ม
                                </button>
                                <div class="button_remove94"></div>
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
    <script src="{{ asset('js/jasny-bootstrap.js') }}"></script>

    <script>
        $(document).ready(function () {
            //เพิ่มไฟล์แนบ
            $('#attach-add8').click(function(event) {
                $('.other_attach_item8:first').clone().appendTo('#other_attach-box8');

                $('.other_attach_item8:last').find('input').val('');
                $('.other_attach_item8:last').find('a.fileinput-exists').click();
                $('.other_attach_item8:last').find('a.view-attach').remove();
                $('.other_attach_item8:last').find('button.attach-add8').remove();
                $('.other_attach_item8:last').find('.button_remove94').html('<button class="btn btn-danger btn-sm attach-remove8" type="button"> <i class="icon-close"></i>  </button>');
                // ShowHideRemoveBtn94();
                check_max_size_file();
            });

            //ลบไฟล์แนบ
            $('body').on('click', '.attach-remove8', function(event) {
                $(this).parent().parent().parent().remove();
                // ShowHideRemoveBtn94();
            });

            // ShowHideRemoveBtn94();
        });

        // function ShowHideRemoveBtn94() { //ซ่อน-แสดงปุ่มลบ

        //     if ($('.other_attach_item8').length > 1) {
        //         $('.attach-remove8').show();
        //     } else {
        //         $('.attach-remove8').hide();
        //     }

        // }
    </script>

@endpush
