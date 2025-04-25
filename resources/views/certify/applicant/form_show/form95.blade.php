<?php $key95=0?>

<div class="row form-group">
    <div class="col-md-12">
        <div class="white-box" style="border: 2px solid #e5ebec;">
            <legend><h4><span class="text-danger">*</span> 9. การเข้าร่วมการทดสอบความชำนาญ / การเปรียบเทียบผลระหว่างห้องปฏิบัติการ (Participation in Proficiency testing program / Interlaboratory comparison) </h4></legend>


  <div class="clearfix"></div>
  <div class="clearfix"></div>
  @if ($certi_lab_attach_all9->count() > 0)
  <div class="row">
      @foreach($certi_lab_attach_all9 as $data)
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
@push('js')
    <script src="{{ asset('plugins/components/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            //เพิ่มไฟล์แนบ
            $('#attach-add9').click(function(event) {
                $('.other_attach_item9:first').clone().appendTo('#other_attach-box9');

                $('.other_attach_item9:last').find('input').val('');
                $('.other_attach_item9:last').find('a.fileinput-exists').click();
                $('.other_attach_item9:last').find('a.view-attach').remove();

                ShowHideRemoveBtn95();

            });

            //ลบไฟล์แนบ
            $('body').on('click', '.attach-remove9', function(event) {
                $(this).parent().parent().remove();
                ShowHideRemoveBtn95();
            });

            ShowHideRemoveBtn95();
        });

        function ShowHideRemoveBtn95() { //ซ่อน-แสดงปุ่มลบ

            if ($('.other_attach_item9').length > 1) {
                $('.attach-remove9').show();
            } else {
                $('.attach-remove9').hide();
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
            $('#test_program_add').click(function() {

                let newBox = $('#test_program_box').children(':first').clone(); //Clone Element
                newBox.find('input.mydatepicker').datepicker({
                    autoclose: true,
                    todayHighlight: true,
                    format: 'dd/mm/yyyy',
                    orientation: 'bottom'
                });
                newBox.find('input').val('');
                newBox.appendTo('#test_program_box');

                var last_new = $('#test_program_box').children(':last');
                {!! $key95+=1 !!}
                //Change Button
                $(last_new).find('button').removeClass('btn-success');
                $(last_new).find('button').addClass('btn-danger test_program_remove');
                $(last_new).find('button').html('<i class="icon-close"></i> ลบ');
                reOrderTestProgram();

            });

            //ลบตำแหน่ง
            $('body').on('click', '.test_program_remove', function() {

                $(this).parent().parent().parent().parent().remove();

                reOrderTestProgram();

            });


        });

        function reOrderTestProgram(){//รีเซตลำดับของตำแหน่ง
            $('#test_program_box').children().each(function(index, el) {
                $(el).find('input[name="test_program_no[]"]').val(index+1)
            });
        }
    </script>
@endpush
