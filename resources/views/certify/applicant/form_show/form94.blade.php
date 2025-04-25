<?php $key94=0?>
<div class="row form-group">
    <div class="col-md-12">
        <div class="white-box" style="border: 2px solid #e5ebec;">
            <legend><h4>8. วัสดุอ้างอิง/วัสดุอ้างอิงรับรอง (Reference material / certified reference material)</h4></legend>

<div id="material_ref_box">
<div class="clearfix"></div>
@if ($certi_lab_attach_all8->count() > 0)
<div class="row">
    @foreach($certi_lab_attach_all8 as $data)
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
    <script src="{{ asset('js/jasny-bootstrap.js') }}"></script>
    <script src="{{ asset('plugins/components/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            //เพิ่มไฟล์แนบ
            $('#attach-add8').click(function(event) {
                $('.other_attach_item8:first').clone().appendTo('#other_attach-box8');

                $('.other_attach_item8:last').find('input').val('');
                $('.other_attach_item8:last').find('a.fileinput-exists').click();
                $('.other_attach_item8:last').find('a.view-attach').remove();

                ShowHideRemoveBtn94();

            });

            //ลบไฟล์แนบ
            $('body').on('click', '.attach-remove8', function(event) {
                $(this).parent().parent().remove();
                ShowHideRemoveBtn94();
            });

            ShowHideRemoveBtn94();
        });

        function ShowHideRemoveBtn94() { //ซ่อน-แสดงปุ่มลบ

            if ($('.other_attach_item8').length > 1) {
                $('.attach-remove8').show();
            } else {
                $('.attach-remove8').hide();
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
            $('#material_ref_add').click(function() {

                let newBox = $('#material_ref_box').children(':first').clone(); //Clone Element
                newBox.find('input.mydatepicker').datepicker({
                    autoclose: true,
                    todayHighlight: true,
                    format: 'dd/mm/yyyy',
                    orientation: 'bottom'
                });
                newBox.find('input[type=file]').val('');
                newBox.find('div.fileinput-exists').removeClass('fileinput-exists').addClass('fileinput-new');
                newBox.find('span.fileinput-filename').text('');
                newBox.find('input').val('');
                newBox.appendTo('#material_ref_box');

                var last_new = $('#material_ref_box').children(':last');
                {!! $key94+=1 !!}
                //Change Button
                $(last_new).find('button').removeClass('btn-success');
                $(last_new).find('button').addClass('btn-danger material_ref_remove');
                $(last_new).find('button').html('<i class="icon-close"></i> ลบ');
                reOrderMaterial();

            });

            //ลบตำแหน่ง
            $('body').on('click', '.material_ref_remove', function() {

                $(this).parent().parent().parent().parent().remove();

                reOrderMaterial();

            });


        });

        function reOrderMaterial(){//รีเซตลำดับของตำแหน่ง
            $('#material_ref_box').children().each(function(index, el) {
                $(el).find('input[name="material_ref_no[]"]').val(index+1)
            });
        }
    </script>
@endpush
