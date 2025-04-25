<?php $key93=0?>
<div id="viewForm93" style="display: none;">
    <div class="row form-group">
        <div class="col-md-12">
            <div class="white-box" style="border: 2px solid #e5ebec;">
                <legend><h4><span class="text-danger">*</span> 7. เครื่องมือ (Equipment)  
                     {{-- <span class="text-danger" style="font-size: 13px;"> ขนาดไฟล์ต้องไม่เกิน 4 MB</span> --}}
                </h4></legend>
                <div id="other_attach-box71">
                    <div class="form-group other_attach_item71">
                        <div class="col-md-4  text-light">
                        {!! Form::label('attachs_sec71', 'กรุณาแนบไฟล์เครื่องมือ', ['class' => 'col-md-12 label_attach text-light  control-label ']) !!}
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
                                    <input type="file" name="attachs_sec71[]" class="attachs_sec71 check_max_size_file">
                                </span>
                                <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
                            </div>
                        </div>

                        <div class="col-md-2" >
                            <button type="button" class="btn btn-sm btn-success attach-add71" id="attach-add71">
                                <i class="icon-plus"></i>&nbsp;เพิ่ม
                            </button>
                            <div class="button_remove71"></div>
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
            $('#attach-add71').click(function(event) {
                $('.other_attach_item71:first').clone().appendTo('#other_attach-box71');

                $('.other_attach_item71:last').find('input').val('');
                $('.other_attach_item71:last').find('a.fileinput-exists').click();
                $('.other_attach_item71:last').find('a.view-attach').remove();
                $('.other_attach_item71:last').find('.label_attach').remove();
                $('.other_attach_item71:last').find('button.attach-add71').remove();
                $('.other_attach_item71:last').find('.button_remove71').html('<button class="btn btn-danger btn-sm attach-remove71" type="button"> <i class="icon-close"></i>  </button>');
                // ShowHideRemoveBtn93();
                check_max_size_file();
            });

            //ลบไฟล์แนบ
            $('body').on('click', '.attach-remove71', function(event) {
                $(this).parent().parent().parent().remove();
                // ShowHideRemoveBtn93();
            });

            // ShowHideRemoveBtn93();
        });

        // function ShowHideRemoveBtn93() { //ซ่อน-แสดงปุ่มลบ

        //     if ($('.other_attach_item71').length > 1) {
        //         $('.attach-remove71').show();
        //     } else {
        //         $('.attach-remove71').hide();
        //     }

        // }
    </script>

    <script>
        $(document).ready(function () {

            //เพิ่มตำแหน่งงาน
            $('#test_tools_add').click(function() {

                $('.div_test_name_trader:first').clone().insertAfter(".div_test_name_trader:last");
                var last_new = $(".div_test_name_trader:last");
                $('.div_test_name_trader:last > label').text(''); 
                  $(last_new).find('input[type="text"]').val('');
                // resetOrder();
                ShowHideTestNameTrader();
                {!! $key93+=1 !!}
      
                // let newBox = $('#test_tools_box').children(':first').clone(); //Clone Element
                // newBox.find('input.mydatepicker').datepicker({
                //     autoclose: true,
                //     todayHighlight: true,
                //     format: 'dd/mm/yyyy',
                //     orientation: 'bottom'
                // });
                // newBox.find('input').val('');
                // newBox.appendTo('#test_tools_box');

                // var last_new = $('#test_tools_box').children(':last');
                // {!! $key93+=1 !!}
                // //Change Button
                // $(last_new).find('button').removeClass('btn-success');
                // $(last_new).find('button').addClass('btn-danger test_tools_remove');
                // $(last_new).find('button').html('<i class="icon-close"></i> ลบ');
                // reOrderLabTest();

            });

            //ลบตำแหน่ง
            $('body').on('click', '.test_tools_remove', function() {

                $(this).parent().parent().parent().parent().parent().remove();

                // reOrderLabTest();
                ShowHideTestNameTrader();
            });
            ShowHideTestNameTrader();

        });
        function ShowHideTestNameTrader() { //ซ่อน-แสดงปุ่มลบ
            var rows = $('div.div_test_name_trader').children(); //แถวทั้งหมด
             rows.each(function(index, el) {
                 if(index > 0){
                    $(el).find('.test_tools_remove').show();
                 }else{
                     $(el).find('.test_tools_remove').hide();
                 }
                $(el).find('label.label_last_new').first().html((index+1)+'.  รายการ (ชื่อและเครื่องหมายการค้า): ');
                // $(el).find('.test_tools_no').val((index+1));
             });
            }
        // function reOrderLabTest(){//รีเซตลำดับของตำแหน่ง 
        //     $('#test_tools_box').children().each(function(index, el) {
        //         $(el).find('input[name="test_tools_no[]"]').val(index+1)
        //     });
        // }
    </script>
@endpush
