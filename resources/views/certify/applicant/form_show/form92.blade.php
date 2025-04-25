<?php $key92=0?>
<div id="viewForm92" style="display: none">
    <div class="row form-group">
        <div class="col-md-12">
            <div class="white-box" style="border: 2px solid #e5ebec;">
                <legend><h4><span class="text-danger">*</span> 7.เครื่องมือ (Equipment)</h4></legend>

            
                <div class="clearfix"></div>
                @if ($certi_lab_attach_all72->count() > 0)
                <div class="row">
                    @foreach($certi_lab_attach_all72 as $data)
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
            $('#attach-add72').click(function(event) {
                $('.other_attach_item72:first').clone().appendTo('#other_attach-box72');

                $('.other_attach_item72:last').find('input').val('');
                $('.other_attach_item72:last').find('a.fileinput-exists').click();
                $('.other_attach_item72:last').find('a.view-attach').remove();

                ShowHideRemoveBtn92();

            });

            //ลบไฟล์แนบ
            $('body').on('click', '.attach-remove72', function(event) {
                $(this).parent().parent().remove();
                ShowHideRemoveBtn92();
            });

            ShowHideRemoveBtn92();
        });

        function ShowHideRemoveBtn92() { //ซ่อน-แสดงปุ่มลบ

            if ($('.other_attach_item72').length > 1) {
                $('.attach-remove72').show();
            } else {
                $('.attach-remove72').hide();
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

           $("#add-debt").click(function() {
                $('.div_last_new:first').clone().insertAfter(".div_last_new:last");
                var last_new = $(".div_last_new:last");
                $('.div_last_new:last > label').text(''); 
                  $(last_new).find('input[type="text"]').val('');
                // resetOrder();
                ShowHideRemoveRow();
                {!! $key92+=1 !!}
            });
            ShowHideRemoveRow();
     
            //ลบตำแหน่ง
            $('body').on('click', '.tools-remove', function() {
                $(this).parent().parent().parent().parent().parent().remove();
                // resetOrder();
                ShowHideRemoveRow();
            });
        });
        function ShowHideRemoveRow() { //ซ่อน-แสดงปุ่มลบ
            var rows = $('div.div_last_new').children(); //แถวทั้งหมด

              (rows.length==1)?  $('#calibrateAddSize').val('1'):  $('#calibrateAddSize').val(rows.length);
              
            // (rowss.length==1)?$('.tools-remove').hide():$('.tools-remove').show();
             rows.each(function(index, el) {
                 if(index > 0){
                    $(el).find('.tools-remove').show();
                 }else{
                     $(el).find('.tools-remove').hide();
                 }
                $(el).find('label.div_last_new1').first().html((index+1)+'.  รายการ (ชื่อและเครื่องหมายการค้า): ');
             });
            }

    </script>
@endpush