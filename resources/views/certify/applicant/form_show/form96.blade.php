<div class="row form-group">
    <div class="col-md-12">
        <div class="white-box" style="border: 2px solid #e5ebec;">
            <legend><h4>10. เอกสารอื่นๆ (Others)</h4></legend>
<div class="row">
    <div class="clearfix"></div>
    @if ($certi_lab_attach_more->count() > 0)
    <div class="row">
        @foreach($certi_lab_attach_more as $data)
        @if ($data->file)
            <div class="col-md-12">
                <div class="form-group">
                    <div class="col-md-12 text-light">
                        {{ @$data->file_desc }}
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
 
<div class="row form-group">
    <div class="col-md-12">
        <div class="checkbox checkbox-success">
            <input id="checkbox_confirm" class="checkbox_confirm" type="checkbox" name="checkbox_confirm"  
                   value="1"  checked  disabled>
            <label for="checkbox_confirm"> &nbsp;    ห้องปฏิบัติการทดสอบและสอบเทียบขอรับรองว่า (LAB hereby affirms certify that) 
                <button type="button" class="btn btn-link" data-toggle="modal" data-target="#myModal"><b>คลิก</b> </button>
            </label>
        </div>
    </div>
</div>

 

@if($certi_lab->desc_delete != '' && !is_null($certi_lab->desc_delete))
<div class="row form-group">
    <div class="col-md-12">
        <div class="white-box" style="border: 2px solid #e5ebec;">
            <legend><h4>ยกเลิกคำขอ</h4></legend>
<div class="row">
    <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <div class="col-md-12 text-light"> ระบุเหตุผล :    <label for="#">{{ !empty($certi_lab->desc_delete)? $certi_lab->desc_delete : null }}</label> </div>
                </div>
            </div>
    </div>

    <div class="clearfix"></div>
    @if ($CertiLabDeleteFile->count() > 0)
    <div class="row">
        @foreach($CertiLabDeleteFile as $data)
        @if ($data->path)
            <div class="col-md-12">
                <div class="form-group">
                    <div class="col-md-12 text-light">
                            {{ @$data->name }}
                        <a href="{{url('certify/check/files/'.$data->path)}}" target="_blank">
                            {!! HP::FileExtension($data->path)  ?? '' !!}
                                {{ basename($data->path) }}
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


@endif
@push('js')
    <script src="{{asset('js/jasny-bootstrap.js')}}"></script>
    <script>
        $(document).ready(function () {
            //เพิ่มไฟล์แนบ
            $('#another_attach-add').click(function(event) {
                $('.another_attach_files:first').clone().appendTo('#another_attach_files-box');

                $('.another_attach_files:last').find('input').val('');
                $('.another_attach_files:last').find('a.fileinput-exists').click();
                $('.another_attach_files:last').find('a.view-attach').remove();

                ShowHideRemoveBtn();

            });

            //ลบไฟล์แนบ
            $('body').on('click', '.another_attach_remove', function(event) {
                $(this).parent().parent().remove();
                ShowHideRemoveBtn();
            });

            ShowHideRemoveBtn();
        });

        function ShowHideRemoveBtn() { //ซ่อน-แสดงปุ่มลบ

            if ($('.another_attach_files').length > 1) {
                $('.another_attach_remove').show();
            } else {
                $('.another_attach_remove').hide();
            }

        }
    </script>
@endpush