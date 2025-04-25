<?php $key93=0?>
<div id="viewForm93" style="display: none;">
    <div class="row form-group">
        <div class="col-md-12">
            <div class="white-box" style="border: 2px solid #e5ebec;">
                <legend><h4><span class="text-danger">*</span> 7.เครื่องมือ (Equipment)</h4></legend>

                <div class="clearfix"></div>
                @if ($certi_lab_attach_all71->count() > 0)
                <div class="row">
                    @foreach($certi_lab_attach_all71 as $data)
                    @if ($data->file)
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="col-md-12 text-light">
                                    <a href="{{url('certify/check/file_client/'.$data->file.'/'.( !is_null($data->file_client_name) ? $data->file_client_name :   basename($data->file) ))}}" target="_blank">
                                        {!! HP::FileExtension($data->file)  ?? '' !!}
                                        {{  !empty($data->file_client_name) ? $data->file_client_name :  basename($data->file)   }}
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
    <script src="{{ asset('plugins/components/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>

    <script>

        $(document).ready(function () {

            //เพิ่มไฟล์แนบ
            $('#attach-add71').click(function(event) {
                $('.other_attach_item71:first').clone().appendTo('#other_attach-box71');

                $('.other_attach_item71:last').find('input').val('');
                $('.other_attach_item71:last').find('a.fileinput-exists').click();
                $('.other_attach_item71:last').find('a.view-attach').remove();

                ShowHideRemoveBtn93();

            });

            //ลบไฟล์แนบ
            $('body').on('click', '.attach-remove71', function(event) {
                $(this).parent().parent().remove();
                ShowHideRemoveBtn93();
            });

            ShowHideRemoveBtn93();
        });

        function ShowHideRemoveBtn93() { //ซ่อน-แสดงปุ่มลบ

            if ($('.other_attach_item71').length > 1) {
                $('.attach-remove71').show();
            } else {
                $('.attach-remove71').hide();
            }

        }
    </script>

    <script>
        $(document).ready(function () {
            //ปฎิทิน
            $('.mydatepicker').datepicker({
                autoclose: true,
                todayHighlight: true,
                format: 'dd/mm/yyyy',
                orientation: 'bottom'
            });

            //เพิ่มตำแหน่งงาน
            $('#test_tools_add').click(function() {

                $('.div_test_name_trader:first').clone().insertAfter(".div_test_name_trader:last");
                var last_new = $(".div_test_name_trader:last");
                $('.div_test_name_trader:last > label').text(''); 
                  $(last_new).find('input[type="text"]').val('');
                // resetOrder();
                ShowHideTestNameTrader();
                {!! $key93+=1 !!}
    
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
                $(el).find('.test_tools_no').val((index+1));
             });
            }

    </script>
@endpush
